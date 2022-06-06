<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index(){
//        return self::getProfilePhoto('Talal Said');
//        return view("font");
        User::create([
            'fname' => "Talal",
            'lname' => "Said",
            'email' => "talal@test.com",
            'password' => Hash::make("123456789"),
            'role' => 1,
            'status' => 1,
        ]);
    }

    public function getProfilePhoto($username)
    {
        $url = 'https://ui-avatars.com/api/?name='. $username .'&color=FFFFFF&background=02a4e1';
        $image = file_get_contents($url);
        $file_name = time() . '.png';
//        return $image;
        Storage::disk('profile_photos')->put($file_name, $image);
//        $image->move('uploads/', $file_name);
        return "storage/". $file_name;
    }
}
