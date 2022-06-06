<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
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
        $users = User::paginate(15);
        return view("Users.index", compact('users', 'status', 'msg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUsersRequest $request)
    {
        try{
            DB::beginTransaction();
            $fullName = $request->fname . " " . $request->lname;
            $profilePhoto = self::getProfilePhoto($fullName);
            $request->merge(['status'=>1,
                'password'=>bcrypt($request->password),
                'profile_photo'=>$profilePhoto
            ]);
            User::create($request->all());
            session(['status'=>'success',
                'msg'=>__('New user has been added successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('users.index');
    }

    public function getProfilePhoto($username)
    {
        $url = 'https://ui-avatars.com/api/?name='. $username .'&color=FFFFFF&background=02a4e1';
        $image = file_get_contents($url);
        $file_name = time() . '.png';
        Storage::disk('profile_photos')->put($file_name, $image);
        return "storage/profilePhotos/". $file_name;
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
    public function edit(User $user)
    {
        return view("Users.edit", compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUsersRequest $request, User $user)
    {

        try{
            DB::beginTransaction();
            if(!$request->password)
                $user->update($request->except(['password']));
            else
                $user->update($request->all());
            session(['status'=>'success',
                'msg'=>__('The user has been updated successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            DB::beginTransaction();
            $user->delete();
            session(['status'=>'success',
                'msg'=>__('The user has been deleted successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('users.index');
    }


    public function findUser(Request $request){
        $search = $request->search;
        $response = array();
        if(!$search){
            $response[] = [
                'id' => 0,
                'text' => __('words.choose_username'),
                'busNo' => null
            ];
        }
        $users = User::select('id', DB::raw("CONCAT(fname, ' ', lname) as name"), 'busNo')
            ->where("fname" , 'like' , "%$search%")
            ->orWhere("lname" , 'like' , "%$search%")
            ->limit(7)
            ->get();
//            return $users;
        if($users){
            foreach($users as $user){
                $response[] = [
                    'id' => $user->id,
                    'text' => $user->name,
                    'busNo' => $user->busNo,
                ];
            }
        }

        return response()->json($response);
    }

    public function findBus(Request $request){
        $search = $request->search;
        $response = array();
        if(!$search){
            $response[] = [
                'id' => 0,
                'text' => __('words.choose_busNo'),
                'user' => null
            ];
        }
        $users = User::select('id', DB::raw("CONCAT(fname, ' ', lname) as name"), 'busNo')
            ->where("busNo" , 'like' , "%$search%")
            ->limit(7)
            ->get();
//            return $users;
        if($users){
            foreach($users as $user){
                $response[] = [
                    'id' => $user->id,
                    'text' => $user->busNo,
                    'user' => $user->name,
                ];
            }
        }

        return response()->json($response);
    }
}
