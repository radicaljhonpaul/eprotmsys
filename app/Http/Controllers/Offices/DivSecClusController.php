<?php

namespace App\Http\Controllers\Offices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OfficesOffice;
use App\Models\OfficesCluster;
use App\Models\OfficesDivision;

class DivSecClusController extends Controller
{
    
    public function getOfficesDivision()
    {
        $data = OfficesDivision::get();
        return $data;
    }

    public function getOfficesCluster(Request $request)
    {
        // return $request;
        $data = OfficesCluster::where('offices_division_id_fk', $request->division_id)->get();
        return $data;
    }
    
    public function getOffices(Request $request)
    {
        $q = OfficesOffice::query();

        if($request->has('division_id'))
        {
            $q->where('offices_division_id_fk', $request->division_id);
        }
      
        if ($request->has('cluster_id'))
        {
            // return "sulod";
            $q->where('offices_cluster_id_fk', $request->cluster_id);
        }
        return $q->get();
    }
}
