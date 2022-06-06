<?php

namespace App\Http\Controllers;

use App\Models\AbsentUser;
use App\Models\Place;
use App\Models\User;
use App\Models\WorkingDatesPlaces;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    public function weekJobs(){
//        return date('Y-m-d');
        $dateNow = date('Y-m-d');
        $date = request()->query('from') ?? $dateNow;
        $date2 = request()->query('to') ?? date('Y-m-d', strtotime($dateNow . ' +7 days'));
        $numberofWantedWeeks = request()->query('NumOfWeeks') ?? 1;

//        return [$date, $date2, $numberofWantedWeeks];
        $places = Place::orderBy('id')->get();

//        return $places;
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

//        return $WeeksWithDates;
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
                            $q->select("id", 'fname');
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
//
//        foreach ($result as $weekNo => $dates){
////            return $dates;
//            foreach ($dates as $date => $placesId){
////                return $placesId;
//                foreach($placesId as $placeId => $jobData){
//                    if($placeId == 'absencese'){
//                        foreach($jobData[0] as $absentUser){
//                            return $absentUser;
////                            return $jobData[0]->reason;
//                        }
//                    }
//                }
//            }
//        }
//        return $result;
        return view("Jobs.WeeksTable", compact('result', 'places', 'days'));
    }

    function getDaysOfWeek($selected_date){
        $date = new DateTime;
        $year = date('Y',strtotime($selected_date));
        $week = date('W',strtotime($selected_date));
        $dates = [];
        for ($i = 1; $i <= 7; $i++){
            $dates[] = $date->setISODate($year, $week, $i)->format('Y-m-d');
        }
        return $dates;
    }
}
