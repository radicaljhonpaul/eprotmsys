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
use Rap2hpoutre\FastExcel\FastExcel;

class DocumentExportImportController extends Controller
{
    public function ExportDocuments(Request $request)
    {
        // Load users
        $xx = DocumentsTbl::all();
        // Export all users
        return (new FastExcel($xx))->download('DocumentsTbl.xlsx');
    }

    // Exports All Documents Data
    public function exportAllDocuments(Request $request)
    {
        ob_start('ob_gzhandler');
        // Documents History
            $UsersDetails = UsersDetails::select('id','division','office','cluster')->where('user_id_fk',Auth::id())->get();
            return DocumentsStatusLogTbl::leftJoin('documents', 'documents_status_logs.doc_id', '=', 'documents.id')
            ->select('documents_status_logs.*','documents.doc_type',)
            ->with('DocumentsTbl')
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
                ->withCount('DocumentsParticularsTbl')
                ->get();
            }])
            ->orderBy('id','desc')
            ->where('division',$UsersDetails[0]->division)
            ->where('cluster',$UsersDetails[0]->cluster)
            ->where('office',$UsersDetails[0]->office)
            ->get();
        ob_end_flush();
    }
}
