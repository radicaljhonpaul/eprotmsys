<?php

namespace App\Http\Controllers\Offices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Division;
use App\Models\Section;
use App\Models\Cluster;

class DivSecClusController extends Controller
{
    public function getDivision()
    {
        $data = Division::get();
        return $data;
    }

    public function getSection(Request $request)
    {
        $data = Section::where('division_id_fk', $request->division_id)->get();
        return $data;
    }
    
    public function getCluster(Request $request)
    {
        $data = Cluster::where('section_id_fk', $request->section_id)->get();
        return $data;
    }
}
