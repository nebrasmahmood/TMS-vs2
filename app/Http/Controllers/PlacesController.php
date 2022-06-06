<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlacesRequest;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = session()->pull('status', null);
        $msg = session()->pull('msg', null);
        $places = Place::paginate(15);
        return view("Places.index", compact('places', 'status', 'msg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Places.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePlacesRequest $request)
    {
        try{
            DB::beginTransaction();
            Place::create($request->only(['name', 'number']));
            session(['status'=>'success',
                'msg'=>__('New place has been added successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('places.index');
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
    public function edit(Place $place)
    {
        return view("Places.edit", compact('place'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePlacesRequest $request, Place $place)
    {
        try{
            DB::beginTransaction();
            $place->update($request->only(['name', 'number']));
            session(['status'=>'success',
                'msg'=>__('Place has been updated successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('places.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        try{
            DB::beginTransaction();
            $place->delete();
            session(['status'=>'success',
                'msg'=>__('Place has been deleted successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('places.index');
    }

    public function findPlace(Request $request){
        $search = $request->search;
        $response = array();
        if(!$search){
            $response[] = [
                'id' => 0,
                'text' => __('words.choose_username'),
            ];
        }
        $places = Place::select('id', 'name')
            ->where("name" , 'like' , "%$search%")
            ->limit(7)
            ->get();
        if($places){
            foreach($places as $place){
                $response[] = [
                    'id' => $place->id,
                    'text' => $place->name,
                ];
            }
        }

        return response()->json($response);
    }
}
