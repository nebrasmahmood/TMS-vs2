<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAbsenceseRequest;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Requests\UpdateJobsRequest;
use App\Models\AbsentUser;
use App\Models\Place;
use App\Models\WorkingDatesPlaces;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    public function weekJobs(){
        $status = session()->pull('status', null);
        $msg = session()->pull('msg', null);

        $dateNow = date('Y-m-d');
        $date = request()->query('from') ?? $dateNow;
        $date2 = request()->query('to') ?? date('Y-m-d', strtotime($dateNow . ' +7 days'));
        $numberofWantedWeeks = request()->query('NumOfWeeks') ?? 1;

        $places = Place::orderBy('id')->get();

        $days = [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thersday",
            "Friday",
            "Saturday",
            "Sunday",
        ];
        $weekNo1 = date('W',strtotime($date));
        $weekNo2 = date('W',strtotime($date2));
        $diff = abs($weekNo2 - $weekNo1);
        $WeeksWithDates = [];
        $startDate = new DateTime;
        $startDate->setISODate(date('Y',strtotime($date)),
            date('W',strtotime($date)), 1);
        $startDate = $startDate->format('Y-m-d');
        $wantedWeeks = $numberofWantedWeeks <= $diff ? $numberofWantedWeeks : $diff + 1;
        for($i = 0; $i < $wantedWeeks; $i++){
            $theDate = date('Y-m-d',strtotime("$startDate +" . $i*7 . "days"));
            $WeeksWithDates[date('W',strtotime($theDate))] = self::getDaysOfWeek($theDate);
        }

        $result = [];
        foreach ($WeeksWithDates as $weekNo => $dates) {
            $result[$weekNo] = [];
            foreach ($dates as $date){
                $result[$weekNo][$date] = [];
                foreach($places as $place){
                    $row = WorkingDatesPlaces::select("id", 'busNo', 'user_id')
                        ->where('date', $date)
                        ->where('place_id', $place['id'])
                        ->with(["user"=>function ($q){
                            $q->select("id", 'fname', 'busNo');
                        }])
                        ->first();
                    $status = $row ? $row : [];
                    $result[$weekNo][$date][strval($place['id'])][] = $status;
                }
                $absent = AbsentUser::select('id', 'user_id')->where('date', $date)->where('reason', 0)->with(['user'=>function($q){
                    $q->select('id', 'fname');
                }])->get();
                $sick = AbsentUser::select('id', 'user_id')->where('date', $date)->where('reason', 1)->with(['user'=>function($q){
                    $q->select('id', 'fname');
                }])->get();

                $result[$weekNo][$date]['absencese'][] = $absent;
                $result[$weekNo][$date]['sickness'][] = $sick;
            }
        }
        return view("Jobs.WeeksTable", compact('result', 'places', 'days',
            'status', 'msg'));
    }

    public function getDaysOfWeek($selected_date){
        $date = new DateTime;
        $year = date('Y',strtotime($selected_date));
        $week = date('W',strtotime($selected_date));
        $dates = [];
        for ($i = 1; $i <= 7; $i++){
            $dates[] = $date->setISODate($year, $week, $i)->format('Y-m-d');
        }
        return $dates;
    }

    public function dailyJobs($date){
        $jobs = WorkingDatesPlaces::where('date', $date)->with(['user'=>function($q){
            $q->select('id', DB::raw("CONCAT(fname, ' ', lname) as name"), 'busNo');
        }])->get();
        return view('Jobs.dailyTable' , compact('jobs'));
    }

    public function store(CreateJobRequest $request){
        try{
            DB::beginTransaction();
            WorkingDatesPlaces::create($request->all());
            session(['status'=>'success',
                'msg'=>__('New job has been added successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('jobs.index');
    }

    public function absenceseStore(CreateAbsenceseRequest $request){
        try{
            DB::beginTransaction();
            AbsentUser::create($request->all());
            session(['status'=>'success',
                'msg'=>__('New absencese record has been added successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('jobs.index');
    }

    public function storeAbsencese(CreateAbsenceseRequest $request){
        try{
            DB::beginTransaction();
            WorkingDatesPlaces::create($request->all());
            session(['status'=>'success',
                'msg'=>__('New job has been added successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('jobs.index');
    }

    public function updateAll(UpdateJobsRequest $request){
        try{
            DB::beginTransaction();
            foreach($request->jobs as $job_id => $data)
                WorkingDatesPlaces::find($job_id)->update($data);
            session(['status'=>'success',
                'msg'=>__('The jobs has been approved successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('jobs.index');
    }

    public function update(UpdateJobRequest $request, WorkingDatesPlaces $job){
//        dd($request->all());
        try{
            DB::beginTransaction();
            $job->update($request->all());
            session(['status'=>'success',
                'msg'=>__('The job has been updated successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('jobs.index');
    }

    public function absenceseUpdate(CreateAbsenceseRequest $request, AbsentUser $absent){
        try{
            DB::beginTransaction();
            $absent->update($request->all());
            session(['status'=>'success',
                'msg'=>__('The absent record has been updated successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('jobs.index');
    }

    public function getData(Request $request){
        $job = WorkingDatesPlaces::where('id', $request->job_id)
        ->with(['user'=>function($q){
            $q->select('id', DB::raw("CONCAT(fname, ' ', lname) as text"), 'busNo');
        }, 'helper'=>function($q){
            $q->select('id', DB::raw("CONCAT(fname, ' ', lname) as text"));
        }])->first();
        return response()->json($job);
    }

    public function absenceseGetData(Request $request){
        $job = AbsentUser::where('id', $request->absencese_id)
        ->with(['user'=>function($q){
            $q->select('id', DB::raw("CONCAT(fname, ' ', lname) as text"));
        }])->first();
        return response()->json($job);
    }

    public function destroy(WorkingDatesPlaces $job){
        try{
            DB::beginTransaction();
            $job->delete();
            session(['status'=>'success',
                'msg'=>__('The job has been deleted successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('jobs.index');
    }

    public function absenceseDestroy(AbsentUser $absent){
        try{
            DB::beginTransaction();
            $absent->delete();
            session(['status'=>'success',
                'msg'=>__('The absencese record has been deleted successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('jobs.index');
    }

    public function getWeekJobs(){
        $start = explode('T', request()->query('start'))[0];
        $end = explode('T', request()->query('end'))[0];
        $jobs = WorkingDatesPlaces::select('id', 'date as start', 'place_id')
            ->where('user_id', auth()->id())
            ->whereBetween('date', [$start, $end])
            ->with(['place' => function($q){
                $q->select('id', 'name');
            }])
            ->get();
        return response()->json($jobs);
    }

    public function weekJobsIndex(){
        return view('Jobs.WorkerJobs.weekView');
    }

    public function dayJobsIndex(){
        $job = WorkingDatesPlaces::where('user_id', auth()->id())
            ->where('date', date('Y-m-d'))
            ->with(['place'=>function($q){
                $q->select('id', 'name');
            }, 'user'=>function($q){
                $q->select('id', 'busNo');
            }])
            ->first();
        return view('Jobs.WorkerJobs.dayView', compact('job'));
    }

}
