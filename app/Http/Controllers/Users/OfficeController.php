<?php

namespace App\Http\Controllers\Users;

use App\Events\UsersEvents;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\UsersDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Inertia::render('Dashboards/OfficeDash',[
            'UsersDetails' => UsersDetails::select('id','fname','lname','contact','cluster','section','division','position','gender')->where('id', Auth::id())->get(),
        ]);
    }

    public function getSpecificUser(Request $request)
    {
        $data = UsersDetails::select('id','fname','lname')->where('division', $request->division_id)
        ->where('section', $request->section_id)
        ->where('cluster', $request->cluster_id)
        ->get();
        return $data;
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
        ])->validate();
  
        Article::create($request->all());
  
        return redirect()->back()
                    ->with('message', 'Article Created Successfully.');
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
