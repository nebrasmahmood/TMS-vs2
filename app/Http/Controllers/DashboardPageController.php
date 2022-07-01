<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use App\Models\Post;
use App\Models\User;
use App\Models\WorkingDatesPlaces;
use Illuminate\Http\Request;

class DashboardPageController extends Controller
{
    public function index(){
        if(auth()->user()->role == 0){
            $job = WorkingDatesPlaces::where('user_id', auth()->id())->where('date', date('Y-m-d'))->first();
            return view('welcome', compact('job'));
        }else{
            $usersCount = User::where('status', 1)->count();
            $placesCount = Place::count();
            $categoriesCount = Category::where('status', 1)->count();
            $postsCount = Post::where('status', 1)->count();

            $recentUsers = User::select('id', 'fname', 'lname', 'email', 'role', 'busNo')
                ->where('status', 1)
                ->latest()
                ->limit(5)
                ->get();

            $recentPosts = Post::select('id', 'title', 'category_id', 'details')
                ->where('status', 1)
                ->whereHas('category', function($q){
                    $q->where('categories.status', 1);
                })
                ->with(['category' => function($q){
                    $q->select('id', 'name');
                }])
                ->latest()
                ->limit(5)
                ->get();


            $recentCats = Category::select('id', 'name', 'description')
                ->where('status', 1)
                ->latest()
                ->limit(5)
                ->get();

            $recentPlaces = Place::latest()
                ->limit(5)
                ->get();
            return view('welcome', compact('usersCount', 'placesCount', 'categoriesCount', 'postsCount',
                'recentUsers', 'recentPlaces', 'recentCats', 'recentPosts'));
        }
    }
}
