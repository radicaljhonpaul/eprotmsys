<?php

namespace App\Http\Controllers\Documents;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\DocumentsTbl;
use App\Models\DocumentsParticularsTbl;
use App\Models\DocumentsStatusLogTbl;
use App\Models\UsersDetails;
use App\Models\ImgLogsTbl;
use App\Models\NotificationEventsTbl;
use App\Models\NotificationsTbl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Division;
use App\Models\Section;
use App\Models\Cluster;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // My Documents
        return Inertia::render('Documents/MyDocuments', [
            'incomingDocuments' => DocumentsTbl::with('DocumentsParticularsTbl')
                ->with(['DocumentsStatusLogTbl' => function($docsStat){
                    return $docsStat->with('ImgLogsTbl')->orderByDesc('id')->get();
                    // ->orderByDesc('id')->limit(2)
                }])
                ->with(['UsersDetails' => function($query){
                    return $query->select('id','fname','mname','lname','position','contact','cluster','section','division','user_id_fk')
                        ->with(['Division' => function($div){
                            return $div->select('id','name');
                        }])
                        ->with(['Section' => function($sec){
                            return $sec->select('id','name');
                        }])
                        ->with(['Cluster' => function($clus){
                            return $clus->select('id','name');
                        }]);
                }])
                ->where('doc_end_user',Auth::id())
                ->paginate(10),
                
            'UsersDetails' => UsersDetails::where('user_id_fk',Auth::id())->get(),
        ]);
    }

    // Custom funct - Display docs
    public function docshistory(Request $request)
    {
        // return Inertia::render('Documents/DocumentsHistory', [
        //     'incomingDocuments' => DocumentsTbl::with('DocumentsParticularsTbl','DocumentsStatusLogTbl')->paginate(10)
        // ]);
    }

    // Custom funct - Incoming
    public function incoming(Request $request)
    {
        $UsersDetails = UsersDetails::select('id','division','section','cluster')->where('user_id_fk',Auth::id())->get();
        $origin = $UsersDetails[0]->division.','.$UsersDetails[0]->section.','.$UsersDetails[0]->cluster;

        return Inertia::render('Documents/Incoming', [
            'LoggedDocuments' => DocumentsTbl::with('DocumentsParticularsTbl')
                ->with(['DocumentsStatusLogTbl' => function($docsStat){
                    return $docsStat->with('ImgLogsTbl')->orderByDesc('id')->limit(2)->get();
                }])
                ->with(['UsersDetails' => function($query){
                    return $query->select('id','fname','mname','lname','position','contact','cluster','section','division','user_id_fk')->get();
                }])
                ->where('is_received',1)
                ->where('doc_current_location',$origin)
                ->paginate(10),
                
            'incomingDocuments' => DocumentsTbl::with('DocumentsParticularsTbl')
            ->with(['DocumentsStatusLogTbl' => function($docsStat){
                return $docsStat->with('ImgLogsTbl')->orderByDesc('id')->limit(2)->get();
            }])
            ->with(['UsersDetails' => function($query){
                return $query->select('id','fname','mname','lname','position','contact','cluster','section','division','user_id_fk')
                    ->with(['Division' => function($div){
                        return $div->select('id','name');
                    }])
                    ->with(['Section' => function($sec){
                        return $sec->select('id','name');
                    }])
                    ->with(['Cluster' => function($clus){
                        return $clus->select('id','name');
                    }]);
            }])
            ->where('is_received',0)
            ->where('forwarded_to',$origin)
            ->get(),

            'UsersDetails' => UsersDetails::where('user_id_fk',Auth::id())->get(),
        ]);
    }

    // Custom funct - Log/Received Document
    public function logdoc(Request $request)
    {
        DB::beginTransaction();
        try {
            // For SMS
            $for_sms_Current_Loc = [];
            $for_sms = DocumentsTbl::where('dtrack_no', $request->logDtrackNo)->get();
            array_push($for_sms_Current_Loc, $for_sms[0]->doc_current_location);
            $split = explode(",", $for_sms_Current_Loc[0]);

            $UsersDetails = UsersDetails::select('id','division','section','cluster')->where('user_id_fk',Auth::id())->get();
            $location = $UsersDetails[0]->division.','.$UsersDetails[0]->section.','.$UsersDetails[0]->cluster;
            // Update Document
            DocumentsTbl::where('dtrack_no', $request->logDtrackNo)->update(['doc_current_location' => $location, 'is_received' => 1, 'forwarded_to' => null]);

            // Documents Logs
            $documentsStatusLogs = new DocumentsStatusLogTbl;
            $documentsStatusLogs->dtrack_id_fk = $request->logDtrackNo;
            $documentsStatusLogs->division = $UsersDetails[0]->division;
            $documentsStatusLogs->section = $UsersDetails[0]->section;
            $documentsStatusLogs->cluster = $UsersDetails[0]->cluster;
            $documentsStatusLogs->status = "received";
            $documentsStatusLogs->save();
            
            DB::commit();

            $document = DocumentsTbl::select('id','dtrack_no','doc_type','updated_at')->where('dtrack_no', $request->logDtrackNo)->get();
            $gender = null;
            if($UsersDetails[0]->gender == 'Male'){
                $gender = 'Mr.';
            }else{
                $gender = 'Ms.';
            }

            $DivHolder = null;
            $SecHolder = null;
            $ClusHolder = null;
            if($UsersDetails[0]->section > 0){
                $Div = Division::where('id', $UsersDetails[0]->division)->get();
                $DivHolder = $Div[0]->name;
            }else;

            if($UsersDetails[0]->section > 0){
                $Sec = Section::where('id', $UsersDetails[0]->section)->get();
                $SecHolder = $Sec[0]->name;
            }else{
                $SecHolder = "N/A";
            }

            if($UsersDetails[0]->cluster > 0){
                $Clus = Cluster::where('id', $UsersDetails[0]->cluster)->get();
                $ClusHolder = $Clus[0]->name;
            }else{
                $ClusHolder = "N/A";
            }
            
            $Contact_Prev = UsersDetails::select('id','contact')->where('division',$split[0])->where('section',$split[1])->where('cluster',$split[2])->get();

            // Send SMS Notification to Current and Receiving
            $semaphore_apicode = "31c97d12e6675e28b4cef6f2dca15546";
            $message = "Greetings ".$gender." ".$UsersDetails[0]->lname .", the document with the DTRAK No. ".$request->logDtrackNo." has been received by Division: " .$DivHolder."\n Section: ".$SecHolder."\n Cluster: ".$ClusHolder."\n Received Date: ".Carbon::parse($document[0]->updated_at)->format('Y-m-d h:i:s')."\n\n A message from - doh.eprotrailmis.co";
            $phone = $Contact_Prev[0]->contact;
            $this->semaphoreAPI($phone,$message,$semaphore_apicode);
            // Fire Event
            return Redirect::route('office.incoming');
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        
    }

    // Custom funct - Route Document
    public function routedoc(Request $request)
    {
        DB::beginTransaction();
        try {

            $UsersDetails = UsersDetails::select('id','division','section','cluster','fname','lname','contact','gender')->where('user_id_fk',Auth::id())->get();
            $location = $UsersDetails[0]->division.','.$UsersDetails[0]->section.','.$UsersDetails[0]->cluster;
            $forwarded_to = $request->ForwardDocDivisionData.','.$request->ForwardDocSectionData.','.$request->ForwardDocClusterData;
            
            $current_id = DocumentsStatusLogTbl::select('id')->where('dtrack_id_fk', $request->DtrakNoHolder)->orderByDesc('id')->limit(1)->get();
            
            // Update Document
            DocumentsTbl::where('dtrack_no', $request->DtrakNoHolder)->update(['doc_current_location' => $location, 'is_received' => 0, 'doc_current_status' => $request->ForwardDocAction, 'forwarded_to' => $forwarded_to]);
            
            // Documents Logs
            DocumentsStatusLogTbl::where('id', $current_id[0]->id)->update(['document_status' => $request->ForwardDocAction, 'doc_notes' => $request->ForwardDocNote, 'forwarded_to' => $forwarded_to, 'status' => 'forwarded']);

            if(sizeof($request->CreateDocfile) > 0){
                // Img Logs
                foreach ($request->CreateDocfile as $key) {
                    // time_Auth(id)_DtrackNo
                    $file_name = $key->getClientOriginalName();
                    $folder_name = Auth::id();

                    $fileUpload = new ImgLogsTbl;
                    $fileUpload->filename = $file_name;
                    $fileUpload->path = "profile/$location/$folder_name/Img_Logs/$file_name";
                    $fileUpload->document_status_logs_id_fk = $current_id[0]->id;
                    Storage::disk("public")->put("profile/$location/$folder_name/Img_Logs/$file_name",file_get_contents($key));
                    $fileUpload->save();
                }
            }else;
            
            $document = DocumentsTbl::select('id','dtrack_no','doc_type','updated_at')->where('dtrack_no', $request->DtrakNoHolder)->get();
            $gender = null;
            if($UsersDetails[0]->gender == 'Male'){
                $gender = 'Mr.';
            }else{
                $gender = 'Ms.';
            }

            // Notifications
            $notifEvent = new NotificationEventsTbl;
            $notifEvent->event_type = "Receive and Route";
            $notifEvent->event_text = "Received & Routed a document with DTRAK No: ".$request->DtrakNoHolder;
            $notifEvent->save();

            $noti = new NotificationsTbl;
            $noti->from = Auth::id();
            $noti->to = $forwarded_to;
            $noti->event_id_fk = $notifEvent->id;
            $noti->save();

            // Send SMS Notification to Current and Receiving
            $semaphore_apicode = "31c97d12e6675e28b4cef6f2dca15546";
            $message = "Greetings ".$gender." ".$UsersDetails[0]->lname .", you have a pending documemt to be received.\n Document:" .$document[0]->doc_type."\n DTRAK No:" .$document[0]->dtrack_no."\n Date Received:" .Carbon::parse($document[0]->updated_at)->format('Y-m-d h:i:s')."\n\n A message from - doh.eprotrailmis.co";
            $phone = $UsersDetails[0]->contact;
            $this->semaphoreAPI($phone,$message,$semaphore_apicode);
            
            DB::commit();
            return Redirect::route('office.incoming');
            
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        
    }

    // Custom funct - Incoming
    public function outgoing(Request $request)
    {
        $UsersDetails = UsersDetails::select('id','division','section','cluster')->where('user_id_fk',Auth::id())->get();
        $origin = $UsersDetails[0]->division.','.$UsersDetails[0]->section.','.$UsersDetails[0]->cluster;

        // Get all 
        return Inertia::render('Documents/Outgoing', [
            'OutgoingDocuments' => DocumentsStatusLogTbl::with('DocumentsTbl')
                ->with(['DocumentsTbl' => function($query){
                    return $query->with(['UsersDetails' => function($udetails){
                        $udetails->select('id','fname','mname','lname','position','contact','cluster','section','division','user_id_fk')->get();
                    }])
                    ->with(['DocumentsStatusLogTbl' => function($docsStat){
                        return $docsStat->with('ImgLogsTbl')->orderByDesc('id')->get();
                        // ->limit(2)
                    }])
                    ->with('DocumentsParticularsTbl')
                    ->get();
                }])
                ->where('division',$UsersDetails[0]->division)
                ->where('section',$UsersDetails[0]->section)
                ->where('cluster',$UsersDetails[0]->cluster)
                ->where('status', "forwarded")
                ->paginate(10),

            'UsersDetails' => UsersDetails::where('user_id_fk',Auth::id())->get(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            $UsersDetails = UsersDetails::select('id','division','section','cluster')->where('user_id_fk',Auth::id())->get();
            $origin = $UsersDetails[0]->division.'_'.$UsersDetails[0]->section.'_'.$UsersDetails[0]->cluster;
            // Documents
            $documents = new DocumentsTbl;
            $documents->dtrack_no = $request->CreateDtrackNo;
            $documents->doc_type = $request->CreateDocType;
            $documents->doc_end_user = Auth::id();
            $documents->doc_current_status = $request->CreateDocAction;
            // get location (div,sec,clus)
            $documents->doc_current_location = $UsersDetails[0]->division.','.$UsersDetails[0]->section.','.$UsersDetails[0]->cluster;
            $documents->forwarded_to = $request->CreateDocDivisionData.','.$request->CreateDocSectionData.','.$request->CreateDocClusterData;
            $documents->save();

            // Documents Logs
            $documentsStatusLogs = new DocumentsStatusLogTbl;
            $documentsStatusLogs->document_status = $request->CreateDocAction;
            $documentsStatusLogs->dtrack_id_fk = $request->CreateDtrackNo;
            $documentsStatusLogs->doc_notes = $request->CreateDocNote;
            $documentsStatusLogs->division = $UsersDetails[0]->division;
            $documentsStatusLogs->section = $UsersDetails[0]->section;
            $documentsStatusLogs->cluster = $UsersDetails[0]->cluster;
            $documentsStatusLogs->forwarded_to = $request->CreateDocDivisionData.','.$request->CreateDocSectionData.','.$request->CreateDocClusterData;
            $documentsStatusLogs->status = "origin";
            $documentsStatusLogs->save();

            // Notifications
            $notifEvent = new NotificationEventsTbl;
            $notifEvent->event_type = "Create";
            $notifEvent->event_text = "Created a ".$request->CreateDocType." Document with DTRAK No: " .$request->CreateDtrackNo;
            $notifEvent->save();

            $noti = new NotificationsTbl;
            $noti->from = Auth::id();
            $noti->to = $request->CreateDocDivisionData.','.$request->CreateDocSectionData.','.$request->CreateDocClusterData;
            $noti->event_id_fk = $notifEvent->id;
            $noti->save();
            
            if(sizeof($request->CreateDocfile) > 0){
                // Img Logs
                foreach ($request->CreateDocfile as $key) {
                    // time_Auth(id)_DtrackNo
                    $file_name = $key->getClientOriginalName();
                    $folder_name = Auth::id();

                    $fileUpload = new ImgLogsTbl;
                    $fileUpload->filename = $file_name;
                    $fileUpload->path = "profile/$origin/$folder_name/Img_Logs/$file_name";
                    $fileUpload->document_status_logs_id_fk = $documentsStatusLogs->id;
                    Storage::disk("public")->put("profile/$origin/$folder_name/Img_Logs/$file_name",file_get_contents($key));
                    $fileUpload->save();
                }
            }else;

            if($request->CreateDocType == "Purchase Request"){
                foreach ($request->CreateParticularsArray as $key) {
                    $particulars = new DocumentsParticularsTbl;
                    $particulars->Item = $key['item'];
                    $particulars->item_qty = $key['qty'];
                    $particulars->item_unit = $key['unit'];
                    $particulars->item_amount = $key['amt'];
                    $particulars->purpose = $key['purpose'];
                    $particulars->dtrack_id_fk = $request->CreateDtrackNo;
                    $particulars->save();

                }
            }else;

            DB::commit();

            
            return Redirect::route('office.mydocs');

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function semaphoreAPI($number,$message,$apicode){
        $ch = curl_init();
        $parameters = array(
            'apikey' => $apicode, //Your API KEY
            'number' => $number,
            'message' => $message,
            'sendername' => 'SEMAPHORE'
        );
        curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);
    }
}
