<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\DocumentsTbl;
use App\Models\DocumentsMutationLogTbl;
use App\Models\DocumentsMutationStatusLogTbl;
use App\Models\DocumentsMutationTbl;
use App\Models\DocumentsParticularsTbl;
use App\Models\DocumentsStatusLogTbl;
use App\Models\UsersDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\OfficesDivision;
use App\Models\OfficesCluster;
use App\Models\OfficesOffice;
use PhpOption\Option;

class DashboardController extends Controller
{
    public function getMostReceivedDocs(Request $request)
    {
        ob_start('ob_gzhandler');
        $UsersDetails = UsersDetails::select('id','division','office','cluster')->where('user_id_fk',Auth::id())->get();
        // return $UsersDetails;
        $err = DocumentsStatusLogTbl::leftJoin('documents', 'documents_status_logs.doc_id', '=', 'documents.id')
            ->select('documents_status_logs.*','documents.doc_type',)
            ->where('division', $UsersDetails[0]->division)
            ->where('cluster', $UsersDetails[0]->cluster)
            ->where('office', $UsersDetails[0]->office)
            ->get()
            ->groupBy('doc_type');

            // take top 3 Received Documents
        return $err->take(3);
        ob_end_flush();
    }

    public function getUtilitiesCounts(Request $request)
    {
        ob_start('ob_gzhandler');
        $UsersDetails = UsersDetails::select('id','division','office','cluster')->where('user_id_fk',Auth::id())->get();
        // Approved PR over Received

        $receivedPR = DocumentsTbl::where('doc_type', 'Purchase Request')
        ->where('is_received', 1)
        ->whereIn('dtrack_no',$this->getMyAllDocsDtrakNo())
        ->get()->count();
        
        $approvedPR = DocumentsTbl::where('doc_type', 'Purchase Request')
            ->where('doc_current_status', 'Accomplished PR - Processing for PO')
            ->whereIn('dtrack_no',$this->getMyAllDocsDtrakNo())
            ->get()->count();

        $receivedPO = DocumentsTbl::where('doc_type', 'Purchase Order')
        ->where('is_received', 1)
        ->whereIn('dtrack_no',$this->getMyAllDocsDtrakNo())
        ->get()->count();

        $approvedPO = DocumentsTbl::where('doc_type', 'Purchase Order')
            ->where('doc_current_status', 'Accomplished PO')
            ->whereIn('dtrack_no',$this->getMyAllDocsDtrakNo())
            ->get()->count();


        return [$receivedPR,$approvedPR,$receivedPO,$approvedPO];
        ob_end_flush();
    }

    public function getAPTAllReceivedDocs(){
        ob_start('ob_gzhandler');
        $UsersDetails = UsersDetails::select('id','division','office','cluster')->where('user_id_fk',Auth::id())->get();
        return DocumentsStatusLogTbl::leftJoin('documents', 'documents_status_logs.doc_id', '=', 'documents.id')
            ->select('documents_status_logs.*','documents.doc_type')
            ->where('division', $UsersDetails[0]->division)
            ->where('cluster', $UsersDetails[0]->cluster)
            ->where('office', $UsersDetails[0]->office)
            ->get();
        ob_end_flush();
    }

    public function getMyAllDocsDtrakNo(){
        $UsersDetails = UsersDetails::select('id','division','office','cluster')->where('user_id_fk',Auth::id())->get();

        $data = DocumentsStatusLogTbl::where('division', $UsersDetails[0]->division)
        ->where('cluster', $UsersDetails[0]->cluster)
        ->where('office', $UsersDetails[0]->office)
        ->distinct()
        ->get(['dtrack_id_fk']);

        $dtrack_id_arr = array();
        foreach ($data as $key) {
            array_push($dtrack_id_arr, $key->dtrack_id_fk);
        }
        return $dtrack_id_arr;
    }
    
    public function getAPTperDocs(){

    }
}
