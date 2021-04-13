<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\DocumentsTbl;
use App\Models\DocumentsParticularsTbl;
use App\Models\DocumentsStatusLogTbl;
use App\Models\UsersDetails;
use App\Models\ImgLogsTbl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            $UsersDetails = UsersDetails::select('id','division','section','cluster')->where('user_id_fk',Auth::id())->get();
            $location = $UsersDetails[0]->division.','.$UsersDetails[0]->section.','.$UsersDetails[0]->cluster;

            // Update Document
            DocumentsTbl::where('dtrack_no', $request->logDtrackNo)->update(['doc_current_location' => $location, 'is_received' => 1, 'forwarded_to' => null]);

            // Documents Logs
            $documentsStatusLogs = new DocumentsStatusLogTbl;
            // $documentsStatusLogs->document_status = $request->CreateDocAction;
            $documentsStatusLogs->dtrack_id_fk = $request->logDtrackNo;
            // $documentsStatusLogs->doc_notes = $request->CreateDocNote;
            $documentsStatusLogs->division = $UsersDetails[0]->division;
            $documentsStatusLogs->section = $UsersDetails[0]->section;
            $documentsStatusLogs->cluster = $UsersDetails[0]->cluster;
            // $documentsStatusLogs->forwarded_to = $request->CreateDocDivisionData.','.$request->CreateDocSectionData.','.$request->CreateDocClusterData;
            $documentsStatusLogs->save();

            DB::commit();
            return Redirect::route('office.incoming');
            
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        
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
            // return $file_path;
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
            // $documents->id;

            // Documents Logs
            $documentsStatusLogs = new DocumentsStatusLogTbl;
            $documentsStatusLogs->document_status = $request->CreateDocAction;
            $documentsStatusLogs->dtrack_id_fk = $request->CreateDtrackNo;
            $documentsStatusLogs->doc_notes = $request->CreateDocNote;
            $documentsStatusLogs->division = $UsersDetails[0]->division;
            $documentsStatusLogs->section = $UsersDetails[0]->section;
            $documentsStatusLogs->cluster = $UsersDetails[0]->cluster;
            $documentsStatusLogs->forwarded_to = $request->CreateDocDivisionData.','.$request->CreateDocSectionData.','.$request->CreateDocClusterData;
            $documentsStatusLogs->save();

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
}
