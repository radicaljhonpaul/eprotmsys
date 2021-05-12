<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\DocumentsTbl;
use App\Models\DocumentsMutationLogTbl;
use App\Models\DocumentsMutationStatusLogTbl;
use App\Models\DocumentsMutationTbl;
use App\Models\DocumentsParticularsTbl;
use App\Models\DocumentsStatusLogTbl;
use App\Models\UsersDetails;
use App\Models\ImgLogsTbl;
use App\Models\NotificationEventsTbl;
use App\Models\NotificationsTbl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\OfficesDivision;
use App\Models\OfficesCluster;
use App\Models\OfficesOffice;
// Events
use App\Events\CreateDocument;
use App\Events\LogDocument;
use App\Events\RouteDocument;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mydocs(Request $request)
    {
        ob_start('ob_gzhandler');
        // My Documents
        return Inertia::render('Documents/MyDocuments', [
            'Documents' => DocumentsTbl::with('DocumentsParticularsTbl')
                ->with(['DocumentsStatusLogTbl' => function($docsStat){
                    return $docsStat->with('ImgLogsTbl')->orderByDesc('id')->get();
                }])
                ->with('DocumentsMutationLogTbl')
                ->with(['UsersDetails' => function($query){
                    return $query->select('id','fname','mname','lname','position','contact','cluster','office','division','user_id_fk')
                        ->with(['OfficesDivision' => function($div){
                            return $div->select('id','name');
                        }])
                        ->with(['OfficesCluster' => function($sec){
                            return $sec->select('id','name');
                        }])
                        ->with(['OfficesOffice' => function($clus){
                            return $clus->select('id','name');
                        }]);
                }])
                ->orderBy('updated_at','desc')
                ->where('doc_end_user',Auth::id())
                ->paginate(5),
                
            'UsersDetails' => UsersDetails::where('user_id_fk',Auth::id())->get(),
        ]);
        ob_end_flush();
    }

    public function getMutatedDocument(Request $request)
    {
        return DocumentsMutationTbl::with('DocumentsParticularsTbl')
        ->with(['DocumentsMutationStatusLogTbl' => function($docsStat){
            return $docsStat->with('ImgLogsTbl')->orderByDesc('id')->get();
            // ->orderByDesc('id')->limit(2)
        }])
        ->with('DocumentsMutationLogTbl')
        ->with(['UsersDetails' => function($query){
            return $query->select('id','fname','mname','lname','position','contact','cluster','office','division','user_id_fk')
                ->with(['OfficesDivision' => function($div){
                    return $div->select('id','name');
                }])
                ->with(['OfficesCluster' => function($clus){
                    return $clus->select('id','name');
                }])
                ->with(['OfficesOffice' => function($off){
                    return $off->select('id','name');
                }]);
        }])
        ->where('dtrack_no',$request->DtrackNo)
        ->get();
    }

    // Custom funct - Logged
    public function logged(Request $request)
    {
        ob_start('ob_gzhandler');
        $UsersDetails = UsersDetails::select('id','division','office','cluster')->where('user_id_fk',Auth::id())->get();
        $origin = $UsersDetails[0]->division.','.$UsersDetails[0]->cluster.','.$UsersDetails[0]->office;

        return Inertia::render('Documents/Incoming', [
            'Documents' => DocumentsTbl::with('DocumentsParticularsTbl')
                ->with(['DocumentsStatusLogTbl' => function($docsStat){
                    return $docsStat->with('ImgLogsTbl')->orderBy('id', 'desc')->get();
                }])
                ->with('DocumentsMutationLogTbl')
                ->with(['UsersDetails' => function($query){
                    return $query->select('id','fname','mname','lname','position','contact','cluster','office','division','user_id_fk')
                        ->with(['User' => function($user){
                            return $user->select('id','profile_photo_path');
                        }])
                        ->get();
                }])
                ->orderBy('updated_at','desc')
                ->where('is_received',1)
                ->where('doc_current_location',$origin)
                ->paginate(5),

            'UsersDetails' => UsersDetails::where('user_id_fk',Auth::id())->get(),

            'IncomingDocuments' => DocumentsTbl::with('DocumentsParticularsTbl')
            ->with(['DocumentsStatusLogTbl' => function($docsStat){
                return $docsStat->with('ImgLogsTbl')->orderByDesc('id')->limit(2)->get();
            }])
            ->with(['UsersDetails' => function($query){
                return $query->select('id','fname','mname','lname','position','contact','cluster','office','division','user_id_fk')
                    ->with(['OfficesDivision' => function($div){
                        return $div->select('id','name');
                    }])
                    ->with(['OfficesCluster' => function($clus){
                        return $clus->select('id','name');
                    }])
                    ->with(['OfficesOffice' => function($off){
                        return $off->select('id','name');
                    }]);
            }])
            ->where('is_received',0)
            ->where('forwarded_to',$origin)
            ->get(),
        ]);
        ob_end_flush();
    }

    // Custom funct - Log/Received Document
    public function logdoc(Request $request)
    {
        DB::beginTransaction();
        try {
            // Save Latest Document Status Before Receiving
            $DocumentsStatusLogTbl_Previous = DocumentsStatusLogTbl::where('dtrack_id_fk',$request->logDtrackNo)->latest()->limit(1)->get();
            // Get Users Details
            $Current_User = UsersDetails::select('id','division','cluster','office','fname','lname')->where('user_id_fk',Auth::id())->get();

            $location = $Current_User[0]->division.','.$Current_User[0]->cluster.','.$Current_User[0]->office;
            
            $document = DocumentsTbl::select('id','dtrack_no','doc_type','updated_at')->where('dtrack_no', $request->logDtrackNo)->latest()->get();
            // Update Document Table
            DocumentsTbl::where('dtrack_no', $request->logDtrackNo)->where('final_status', 'Processing')->update(['doc_current_location' => $location, 'is_received' => 1, 'forwarded_to' => null]);
            // Update Document Logs Table
            $documentsStatusLogs = new DocumentsStatusLogTbl;
            $documentsStatusLogs->doc_id = $document[0]->id;
            $documentsStatusLogs->dtrack_id_fk = $request->logDtrackNo;
            $documentsStatusLogs->division = $Current_User[0]->division;
            $documentsStatusLogs->cluster = $Current_User[0]->cluster;
            $documentsStatusLogs->office = $Current_User[0]->office;
            $documentsStatusLogs->status = "received";
            $documentsStatusLogs->save();
    
            // SMS & Notification for Origin
            $SMS_Origin = DocumentsTbl::where('dtrack_no', $request->logDtrackNo)->get();
            $Origin_UsersDetails = UsersDetails::select('id','contact','fname','lname','gender')->where('id',$SMS_Origin[0]->doc_end_user)->get();

            $Origin_data = [
                "id" => $Origin_UsersDetails[0]->id,
                'type' => "Logged a Document",
                "message" => "Greetings ".$this->retGender($Origin_UsersDetails[0]->gender)." ". ucwords($Origin_UsersDetails[0]->lname) .", the document with the DTRAK No. ".$request->logDtrackNo." has been received by Division: ".$this->retDivClusOff($Current_User[0]->division,$Current_User[0]->cluster,$Current_User[0]->office)."\n Received Date: ".Carbon::parse($document[0]->updated_at)->format('Y-m-d h:i:s'),
            ];

            $event_type = "Logged a Document";
            $this->storeNotification($event_type, $Origin_data['message'], Auth::id(), $SMS_Origin[0]->doc_end_user, $request->logDtrackNo);
            broadcast(new LogDocument($Origin_data))->toOthers();
            
            $semaphore_apicode = "31c97d12e6675e28b4cef6f2dca15546";
            $message = $Origin_data['message']. "\n\n A message from - doh.eprotrailmis.co";
            $phone = $Origin_UsersDetails[0]->contact;
            // $this->semaphoreAPI($phone,$message,$semaphore_apicode);
            
            // SMS & Notification for Previous User
            // Get the Previous User
            $Prev_UsersDetails = UsersDetails::select('id','contact','fname','lname','gender')->where('division', $DocumentsStatusLogTbl_Previous[0]->division)->where('cluster', $DocumentsStatusLogTbl_Previous[0]->cluster)->where('office', $DocumentsStatusLogTbl_Previous[0]->office)->get();
            $Prev_data = [
                "id" => $Prev_UsersDetails[0]->id,
                'type' => "Logged a Document",
                "message" => "Greetings ".$this->retGender($Prev_UsersDetails[0]->gender)." ". ucwords($Prev_UsersDetails[0]->lname) .", the document with the DTRAK No. ".$request->logDtrackNo." has been received by Division: ".$this->retDivClusOff($Current_User[0]->division,$Current_User[0]->cluster,$Current_User[0]->office)."\n Received Date: ".Carbon::parse($document[0]->updated_at)->format('Y-m-d h:i:s'),
            ];
            $this->storeNotification($event_type, $Prev_data['message'], Auth::id(), $Prev_UsersDetails[0]->id, $request->logDtrackNo);
            broadcast(new LogDocument($Prev_data))->toOthers();

            DB::commit();
            return Redirect::route('office.logged');
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
            // Check if FOR PO na
            $UsersDetails = UsersDetails::select('id','division','cluster','office','fname','lname','contact','gender')->where('user_id_fk',Auth::id())->get();
            $location = $UsersDetails[0]->division.','.$UsersDetails[0]->cluster.','.$UsersDetails[0]->office;
            $forwarded_to = $request->ForwardDocDivisionData.','.$request->ForwardDocClusterData.','.$request->ForwardDocOfficeData;
            
            $current_id = DocumentsStatusLogTbl::select('id')->where('dtrack_id_fk', $request->DtrakNoHolder)->orderByDesc('id')->limit(1)->get();
            $EndUser = DocumentsTbl::select('id','doc_end_user')->where('dtrack_no',$request->DtrakNoHolder)->get();
            // If PO Numbering na
            if($request->DocumentMutationTo != null){

                // Set PR to Completed
                DocumentsTbl::where('dtrack_no', $request->DtrakNoHolder)->update(['doc_current_location' => $location, 'doc_current_status' => 'Accomplished PR - Processing for PO', 'forwarded_to' => $forwarded_to, 'final_status' => 'Completed']);

                // Update DocumentsMutationLogTbl
                // DocumentsMutationLogTbl::where('dtrack_id_fk', $request->DtrakNoHolder)->update(['doc_to' => $request->DocumentMutationTo, 'doc_type_to' => 'Purchase Order']);
                $documents = new DocumentsTbl;
                $documents->dtrack_no = $request->DtrakNoHolder;
                $documents->doc_type = 'Purchase Order';
                $documents->doc_end_user = $EndUser[0]->doc_end_user;
                $documents->doc_current_status = 'For Purchase Order (PO)';
                $documents->doc_current_location = $location;
                $documents->forwarded_to = $forwarded_to;
                $documents->save();

                $documentsStatusLogs = new DocumentsStatusLogTbl;
                $documentsStatusLogs->doc_id = $documents->id;
                $documentsStatusLogs->document_status = $request->ForwardDocAction;
                $documentsStatusLogs->dtrack_id_fk = $request->DtrakNoHolder;
                $documentsStatusLogs->doc_notes = $request->ForwardDocNote;
                $documentsStatusLogs->division = $UsersDetails[0]->division;
                $documentsStatusLogs->cluster = $UsersDetails[0]->cluster;
                $documentsStatusLogs->office = $UsersDetails[0]->office;
                $documentsStatusLogs->forwarded_to = $forwarded_to;
                $documentsStatusLogs->receiver_id = $request->SpecificUserData;
                $documentsStatusLogs->status = "forwarded";
                $documentsStatusLogs->save();


                if($request->CreateDocfile != null && sizeof($request->CreateDocfile) > 0){
                    // Img Logs
                    $this->storeDocAttachements($request->CreateDocfile, $location, $documentsStatusLogs->id, $request->DtrakNoHolder);
                }else;
            }else{
            // If dili pa PO Numbering
                
                $document = DocumentsTbl::select('id','dtrack_no','doc_type','updated_at')->where('dtrack_no', $request->DtrakNoHolder)->latest()->get();
                // Check if PO and if Naa na sa RD or ARD
                if($location == '1,0,1' || $location == '1,0,2' && $document[0]->doc_type == 'Purchase Order'){
                    // Update Document
                    DocumentsTbl::where('id', $document[0]->id)->where('dtrack_no', $request->DtrakNoHolder)->update(['doc_current_location' => $location, 'is_received' => 0, 'doc_current_status' => 'Accomplished PO', 'forwarded_to' => $forwarded_to, 'final_status' => 'Completed']);
                }else{
                    // Update Document
                    DocumentsTbl::where('id', $document[0]->id)->where('dtrack_no', $request->DtrakNoHolder)->update(['doc_current_location' => $location, 'is_received' => 0, 'doc_current_status' => $request->ForwardDocAction, 'forwarded_to' => $forwarded_to]);
                }
                
                // Documents Logs
                DocumentsStatusLogTbl::where('id', $current_id[0]->id)->update(['document_status' => $request->ForwardDocAction, 'doc_notes' => $request->ForwardDocNote, 'forwarded_to' => $forwarded_to, 'receiver_id' => $request->SpecificUserData, 'status' => 'forwarded']);
                
                if($request->DocumentMutationTo == null && $request->CreateDocfile != null && sizeof($request->CreateDocfile) > 0){
                    // Img Logs
                    $this->storeDocAttachements($request->CreateDocfile, $location, $current_id[0]->id, $request->DtrakNoHolder);
                }else;
                
                // If PR Numbering na
                if($request->DocumentMutationFrom != null){
                    $documentsMutationLogTbl = new DocumentsMutationLogTbl;
                    $documentsMutationLogTbl->dtrack_id_fk = $request->DtrakNoHolder;
                    $documentsMutationLogTbl->doc_from = $request->DocumentMutationFrom;
                    $documentsMutationLogTbl->doc_type_from = 'Purchase Request';
                    $documentsMutationLogTbl->save();
                }

            }

            $document = DocumentsTbl::select('id','dtrack_no','doc_type','updated_at')->where('dtrack_no', $request->DtrakNoHolder)->get();
            // Notifications
            // For Origin of Document
            $Origin_End_User = DocumentsTbl::select('id','dtrack_no','doc_end_user')->where('dtrack_no', $request->DtrakNoHolder)->get();
            $Origin_End_UsersDetails = UsersDetails::select('id','cluster','fname','lname')->where('user_id_fk',$Origin_End_User[0]->doc_end_user)->get();
            $gender = null;
            if($Origin_End_UsersDetails[0]->gender == 'Male'){
                $gender = 'Mr.';
            }else{
                $gender = 'Ms.';
            }

            $data = [
                "id" => $Origin_End_User[0]->doc_end_user,
                'type' => "Received and Route a Document",
                "message" => "Greetings ".$gender." ". ucwords($Origin_End_UsersDetails[0]->lname) .", the document with the DTRAK No. ".$request->DtrakNoHolder." has been forwarded to ".$this->retDivClusOff($request->ForwardDocDivisionData,$request->ForwardDocClusterData,$request->ForwardDocOfficeData)."\n Forward Date: ".Carbon::parse($document[0]->updated_at)->format('Y-m-d h:i:s'),
            ];

            $event_type = "Received and Route a Document";
            $this->storeNotification($event_type, $data['message'], Auth::id(), $Origin_End_User[0]->doc_end_user, $request->DtrakNoHolder);
            broadcast(new LogDocument($data))->toOthers();

            $Receiver_End_UsersDetails = UsersDetails::select('id','cluster','fname','lname','gender')->where('user_id_fk',$request->SpecificUserData)->get();
            $receiver_gender = null;
            if($Receiver_End_UsersDetails[0]->gender == 'Male'){
                $receiver_gender = 'Mr.';
            }else{
                $receiver_gender = 'Ms.';
            }

            // For Receiver
            $receiver_data = [
                "id" => $request->SpecificUserData,
                'type' => "Received and Route a Document",
                "message" => "Greetings ".$receiver_gender." ". ucwords($Receiver_End_UsersDetails[0]->lname) .", the document with the DTRAK No. ".$request->DtrakNoHolder." has been forwarded to you. From: ".$gender." ". ucwords($UsersDetails[0]->lname).", ".$this->retDivClusOff($request->ForwardDocDivisionData,$request->ForwardDocClusterData,$request->ForwardDocOfficeData)."\n Forward Date: ".Carbon::parse($document[0]->updated_at)->format('Y-m-d h:i:s'),
            ];
            $this->storeNotification($event_type, $data['message'], Auth::id(), $request->SpecificUserData, $request->DtrakNoHolder);
            broadcast(new RouteDocument($receiver_data))->toOthers();

            // Send SMS Notification to Current and Receiving
            $semaphore_apicode = "31c97d12e6675e28b4cef6f2dca15546";
            $message = "Greetings ".$receiver_gender." ". ucwords($Receiver_End_UsersDetails[0]->lname) .", you have a pending document to be received.\n Document:" .$document[0]->doc_type."\n DTRAK No:" .$document[0]->dtrack_no."\n Date Forwarded:" .Carbon::parse($document[0]->updated_at)->format('Y-m-d h:i:s')."\n\n A message from - doh.eprotrailmis.co | powered by: KM-ICT";
            $phone = $UsersDetails[0]->contact;
            // $this->semaphoreAPI($phone,$message,$semaphore_apicode);

            DB::commit();
            return Redirect::route('office.logged');
            
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        
    }

    // Custom funct - Forwarded
    public function outgoing(Request $request)
    {
        
        ob_start('ob_gzhandler');
        $UsersDetails = UsersDetails::select('id','division','office','cluster')->where('user_id_fk',Auth::id())->get();
        $origin = $UsersDetails[0]->division.','.$UsersDetails[0]->cluster.','.$UsersDetails[0]->office;

        // Get all 
        return Inertia::render('Documents/Outgoing', [
            'Documents' => DocumentsStatusLogTbl::with('DocumentsTbl')
                ->with(['DocumentsTbl' => function($query){
                    return $query->with(['UsersDetails' => function($udetails){
                        $udetails->select('id','fname','mname','lname','position','contact','cluster','office','division','user_id_fk')
                        ->with(['User' => function($user){
                            return $user->select('id','profile_photo_path');
                        }])
                        ->get();
                    }])
                    ->with(['DocumentsStatusLogTbl' => function($docsStat){
                        return $docsStat->with('ImgLogsTbl')->orderByDesc('id')->get();
                    }])
                    ->with('DocumentsParticularsTbl')
                    ->get();
                }])
                ->orderBy('id','desc')
                ->where('division',$UsersDetails[0]->division)
                ->where('cluster',$UsersDetails[0]->cluster)
                ->where('office',$UsersDetails[0]->office)
                ->where('status', "forwarded")
                ->paginate(5),

            'UsersDetails' => UsersDetails::where('user_id_fk',Auth::id())->get(),
        ]);
        ob_end_flush();

    }
    /**
     * Show the form for creating a new Document
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $UsersDetails = UsersDetails::select('id','division','cluster','office','fname','lname')->where('user_id_fk',Auth::id())->get();
            // Origin - Path of Attachment
            $DocOrigin = $UsersDetails[0]->division.','.$UsersDetails[0]->cluster.','.$UsersDetails[0]->office;
            $ForwardedTo =  $request->CreateDocDivisionData.','.$request->CreateDocClusterData.','.$request->CreateDocOfficeData;
            // Insert Documents Tbl
            $documents = new DocumentsTbl;
            $documents->dtrack_no = $request->CreateDtrackNo;
            $documents->doc_type = $request->CreateDocType;
            $documents->doc_end_user = Auth::id();
            $documents->doc_current_status = $request->CreateDocAction;
            // get location (div,clus,office)
            $documents->doc_current_location = $DocOrigin;
            $documents->forwarded_to = $ForwardedTo;
            $documents->save();
            
            $current_doc = $documents->id;
            // Documents Logs
            $documentsStatusLogs = new DocumentsStatusLogTbl;
            $documentsStatusLogs->doc_id = $current_doc;
            $documentsStatusLogs->document_status = $request->CreateDocAction;
            $documentsStatusLogs->dtrack_id_fk = $request->CreateDtrackNo;
            $documentsStatusLogs->doc_notes = $request->CreateDocNote;
            $documentsStatusLogs->division = $UsersDetails[0]->division;
            $documentsStatusLogs->cluster = $UsersDetails[0]->cluster;
            $documentsStatusLogs->office = $UsersDetails[0]->office;
            $documentsStatusLogs->forwarded_to = $ForwardedTo;
            $documentsStatusLogs->receiver_id = $request->SpecificUserData;
            $documentsStatusLogs->status = "origin";
            $documentsStatusLogs->save();

            if($request->CreateDocfile != null && sizeof($request->CreateDocfile) > 0){
                $this->storeDocAttachements($request->CreateDocfile, $DocOrigin, $documentsStatusLogs->id, $request->CreateDtrackNo);
            }else;

            if($request->CreateDocType == "Purchase Request"){
                $this->storeDocParticulars($request->CreateParticularsArray, $request->CreateDtrackNo);
            }else;

            // Notifications
            $data = [
                "id" => $request->SpecificUserData,
                'type' => "Created a Document",
                "message" => ucwords($UsersDetails[0]->fname).' '.ucwords($UsersDetails[0]->lname). " created a ". $request->CreateDocType ." Document forwarded to you. Subject for: ". $request->CreateDocAction,
            ];
            $event_type = "Created a Document";
            $this->storeNotification($event_type, $data['message'], Auth::id(), $request->SpecificUserData, $request->CreateDtrackNo);
            DB::commit();

            // Fire Notification
            broadcast(new CreateDocument($data))->toOthers();
            return Redirect::route('office.mydocs');

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    
    public function searchDocuments(Request $request)
    {
        ob_start('ob_gzhandler');
        // 3 Props
        if($request->RedirectComponent == 'Documents/Incoming'){
            $UsersDetails = UsersDetails::select('id','division','office','cluster')->where('user_id_fk',Auth::id())->get();
            $origin = $UsersDetails[0]->division.','.$UsersDetails[0]->cluster.','.$UsersDetails[0]->office;
            return Inertia::render('Documents/Incoming', [
                'Documents' => DocumentsTbl::with('DocumentsParticularsTbl')
                    ->with(['DocumentsStatusLogTbl' => function($docsStat){
                        return $docsStat->with('ImgLogsTbl')->orderBy('id', 'desc')->get();
                        // ->where('status','received')
                    }])
                    ->with(['UsersDetails' => function($query){
                        return $query->select('id','fname','mname','lname','position','contact','cluster','office','division','user_id_fk')
                            ->with(['User' => function($user){
                                return $user->select('id','profile_photo_path');
                            }])
                            ->get();
                    }])
                    ->where(function($q) use ($request) {
                        if ($request) {
                            return $q->orWhere('dtrack_no', 'LIKE', '%' . $request->SearchDoc . '%')
                            ->orWhere('doc_type', 'LIKE', '%' . $request->SearchDoc . '%')
                            ->get();
                        }
                    })
                    ->where('is_received',1)
                    ->where('doc_current_location',$origin)
                    ->paginate(5),
                    
                'UsersDetails' => UsersDetails::where('user_id_fk',Auth::id())->get(),

                'IncomingDocuments' => DocumentsTbl::with('DocumentsParticularsTbl')
                ->with(['DocumentsStatusLogTbl' => function($docsStat){
                    return $docsStat->with('ImgLogsTbl')->orderByDesc('id')->limit(2)->get();
                }])
                ->with(['UsersDetails' => function($query){
                    return $query->select('id','fname','mname','lname','position','contact','cluster','office','division','user_id_fk')
                        ->with(['OfficesDivision' => function($div){
                            return $div->select('id','name');
                        }])
                        ->with(['OfficesCluster' => function($clus){
                            return $clus->select('id','name');
                        }])
                        ->with(['OfficesOffice' => function($off){
                            return $off->select('id','name');
                        }]);
                }])
                ->where('is_received',0)
                ->where('forwarded_to',$origin)
                ->get()
            ]);

        };
        
        // 2 Props
        if($request->RedirectComponent == 'Documents/MyDocuments'){
            
            return Inertia::render($request->RedirectComponent, [
                'Documents' => DocumentsTbl::with('DocumentsParticularsTbl')
                    ->with(['DocumentsStatusLogTbl' => function($docsStat){
                        return $docsStat->with('ImgLogsTbl')->orderByDesc('id')->get();
                    }])
                    ->with(['UsersDetails' => function($query){
                        return $query->select('id','fname','mname','lname','position','contact','cluster','office','division','user_id_fk')
                            ->with(['OfficesDivision' => function($div){
                                return $div->select('id','name');
                            }])
                            ->with(['OfficesCluster' => function($clus){
                                return $clus->select('id','name');
                            }])
                            ->with(['OfficesOffice' => function($off){
                                return $off->select('id','name');
                            }]);
                    }])
                    ->where(function($q) use ($request) {
                        if ($request) {
                            return $q->orWhere('dtrack_no', 'LIKE', '%' . $request->SearchDoc . '%')
                            ->orWhere('doc_type', 'LIKE', '%' . $request->SearchDoc . '%')
                            ->where('doc_end_user',Auth::id())
                            ->get();
                        }
                    })
                    ->paginate(5),
                    
                'UsersDetails' => UsersDetails::where('user_id_fk',Auth::id())->get(),
            ]);
        };

        // 2 Props
        if($request->RedirectComponent == 'Documents/Outgoing'){
            $UsersDetails = UsersDetails::select('id','division','office','cluster')->where('user_id_fk',Auth::id())->get();
            $origin = $UsersDetails[0]->division.','.$UsersDetails[0]->cluster.','.$UsersDetails[0]->office;
    
            // Get all 
            return Inertia::render($request->RedirectComponent, [
                'Documents' => DocumentsStatusLogTbl::with('DocumentsTbl')
                    ->with(['DocumentsTbl' => function($query){
                        return $query->with(['UsersDetails' => function($udetails){
                            $udetails->select('id','fname','mname','lname','position','contact','cluster','office','division','user_id_fk')
                            ->with(['User' => function($user){
                                return $user->select('id','profile_photo_path');
                            }])
                            ->get();
                        }])
                        ->with(['DocumentsStatusLogTbl' => function($docsStat){
                            return $docsStat->with('ImgLogsTbl')->orderByDesc('id')->get();
                        }])
                        ->with('DocumentsParticularsTbl')
                        ->get();
                    }])
                    ->where('dtrack_id_fk', 'LIKE', '%' . $request->SearchDoc . '%')
                    ->where('division',$UsersDetails[0]->division)
                    ->where('cluster',$UsersDetails[0]->cluster)
                    ->where('office',$UsersDetails[0]->office)
                    ->where('status', "forwarded")
                    ->paginate(5),
    
                'UsersDetails' => UsersDetails::where('user_id_fk',Auth::id())->get(),
            ]);
        };
        ob_end_flush();
    }

    public function storeNotification($event_type, $event_text, $from, $to, $dtrack_no)
    {
        /** Create Document 
         * "Created a Document"
         * Receive Document
         * "Received a document you forwarded"
         * Route Document
         * "Forwarded a document for you to received"
         * Update Document
         * "Made changes to a document"
        */
        DB::beginTransaction();
        try {
            $notif = new NotificationsTbl;
            $notif->from = $from;
            $notif->to = $to;
            $notif->dtrack_id_fk = $dtrack_no;
            $notif->save();

            $notif_event = new NotificationEventsTbl;
            $notif_event->event_type = $event_type;
            $notif_event->event_text = $event_text;
            $notif_event->event_id_fk = $notif->id;
            $notif_event->save();
            DB::commit();
            return 1;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

    }

    public function storeDocAttachements($img_data, $origin, $documentsStatusLogs_id, $dtrack_no)
    {
        // Img Logs
        foreach ($img_data as $key) {
            $file_name = $key->getClientOriginalName();
            $folder_name = Auth::id();

            $fileUpload = new ImgLogsTbl;
            $fileUpload->filename = $file_name;
            $fileUpload->path = "profile/attachments/$origin/$dtrack_no/$folder_name/Img_Logs/$file_name";
            $fileUpload->document_status_logs_id_fk = $documentsStatusLogs_id;
            Storage::disk("public")->put("profile/attachments/$origin/$dtrack_no/$folder_name/Img_Logs/$file_name",file_get_contents($key));
            $fileUpload->save();
        }
    }

    public function storeDocParticulars($particulars_data, $dtrack_no)
    {
        foreach ($particulars_data as $key) {
            $particulars = new DocumentsParticularsTbl;
            $particulars->Item = $key['item'];
            $particulars->item_qty = $key['qty'];
            $particulars->item_unit = $key['unit'];
            $particulars->item_amount = $key['amt'];
            $particulars->purpose = $key['purpose'];
            $particulars->dtrack_id_fk = $dtrack_no;
            $particulars->save();
        }
    }

    public function retDivClusOff($div,$clus,$off)
    {
        $DivHolder = null;
        $ClusHolder = null;
        $OffHolder = null;
        if($div > 0){
            $Div = OfficesDivision::where('id', $div)->get();
            $DivHolder = $Div[0]->name;
        }else;
        
        if($clus > 0){
            $Clus = OfficesCluster::where('id', $clus)->get();
            $ClusHolder = $Clus[0]->name;
        }else{
            $ClusHolder = "N/A";
        }

        if($off > 0){
            $Off = OfficesOffice::where('id', $off)->get();
            $OffHolder = $Off[0]->name;
        }else{
            $OffHolder = "N/A";
        }

        return "Division: " .$DivHolder."\n Cluster: ".$ClusHolder."\n Office: ".$OffHolder;
    }

    public function retGender($gender)
    {
        if($gender == 'Male'){
            return $gender = 'Mr.';
        }else{
            return $gender = 'Ms.';
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
