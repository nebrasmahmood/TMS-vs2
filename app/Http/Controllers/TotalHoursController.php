<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TotalHoursController extends Controller
{
    public function index(){
        return view('TotalHours.index');
    }

    public function getStartAndEndDate($week_num){
        $week_dates = [];
        $date = new DateTime();
        $date->setISODate($date->format('Y'), $week_num);
        $week_dates[] = $date->format('Y-m-d');
        for($i = 0; $i < 6; $i++){
            $date->modify('+1 days');
            $week_dates[] = $date->format('Y-m-d');
        }
        return $week_dates;
    }

    public function sumOfHoursInWeek(Request $request){
        if(!$request->user_id){
            return redirect()->route('totalHours.index');
        }
//        dd($request->all());
        $week_dates = self::getStartAndEndDate($request->week_num ?? 1);
        $sumOfHours = Event::selectRaw('sec_to_time(sum(time_to_sec(timediff(end, start)))) as totalTime')
            ->whereRaw("date(start) IN ('" . implode("','", $week_dates)."')")
            ->where('user_id', $request->user_id)
            ->get();
        $data['user'] = $user = User::select('id', DB::raw("CONCAT(fname, ' ', lname) as text"))
            ->where('id', $request->user_id)->first();
        $data['totalHours'] = $sumOfHours[0]->totalTime ?? '00:00:00';
        $data['week_num'] = $request->week_num ?? 1;
        return view('TotalHours.index', compact('data'));
    }

}
