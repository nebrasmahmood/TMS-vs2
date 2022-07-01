<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class EventsController extends Controller
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
//        dd(request()->query('user_id'));
        $user_id = request()->query('user_id') ?? null;
        if(is_null($user_id)){
            if(auth()->user()->role == 0){
                $user_id = auth()->id();
                return view('Events.index', compact('status', 'msg', 'user_id'));
            }else{
                return view('Events.index', compact('status', 'msg'));
            }
        }
        elseif($user_id && $user_id > 0 && auth()->user()->role != 0){

            $user = User::select('id', DB::raw("CONCAT(fname, ' ', lname) as text"))
                ->where('id', $user_id)->first();
            return view('Events.index', compact('user','status', 'msg'));
        }
        return redirect()->route('events.index');

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
    public function store(CreateEventRequest $request)
    {
        try{
            DB::beginTransaction();
            $date = $request->date;
            $startTime = self::changeTimeFormat($request->start);
            $endTime = self::changeTimeFormat($request->end);
            $request->merge(['start'=>$date . " " . $startTime,
                'end'=>$date . " " . $endTime]);
            Event::create($request->all());
            session(['status'=>'success',
                'msg'=>__('New event has been added successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('events.index');
    }


    public function changeTimeFormat($time){ // 8:12 AM 12:30 PM
        $hour = explode(":", explode(' ', $time)[0])[0]; // 8
        $min = explode(":", explode(' ', $time)[0])[1]; // 12
        $sec = '00';
        if(strlen($hour) == 1)
            $hour = '0' . $hour;
        if(explode(' ',$time)[1] == 'PM' && intval($hour) > 12){
            $hour = intval($hour) + 12;
        }
        $final_time = $hour . ':' . $min . ':' . $sec;
        if($final_time == '24:00:00'){
            $final_time = '23:59:59';
        }
        return $final_time;
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
        $event = Event::with(['user'=>function($q){
            $q->select('id', DB::raw("CONCAT(fname, ' ', lname) as text"));
        }, 'place'=>function($q){
            $q->select('id', 'name as text');
        }, 'bus'=>function($q){
            $q->select('id', 'busNo as text');
        }])->where('id', $id)->first();
        return view('Events.index', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateEventRequest $request, Event $event)
    {
//        dd($request->all());
        try{
            DB::beginTransaction();
            $date = $request->date;
            $startTime = self::changeTimeFormat($request->start);
            $endTime = self::changeTimeFormat($request->end);
            $request->merge(['start'=>$date . " " . $startTime,
                'end'=>$date . " " . $endTime]);
            $event->update($request->all());
            session(['status'=>'success',
                'msg'=>__('The event has been updated successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            dd($ex);
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        try{
            DB::beginTransaction();
            $event->delete();
            session(['status'=>'success',
                'msg'=>__('The event has been deleted successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->back();
    }

    public function getEvents($id){
        $start = explode('T', request()->query('start'))[0];
        $end = explode('T', request()->query('end'))[0];
//        dd($start, $end);
        $events = Event::select('id', 'title', 'start', 'end')
            ->where('start', '<=', $end)
            ->where('end', '>=', $start)
            ->where('user_id', $id)
            ->get();
//        dd($events);
        return response()->json($events);
    }

    public function getData($id){
        $event = Event::with('place')
            ->where('id', $id)->first();
        return response()->json($event);
    }
}
