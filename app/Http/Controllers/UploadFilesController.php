<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUploadedFileRequest;
use App\Models\UploadedFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class UploadFilesController extends Controller
{
    public function index(){
        $status = session()->pull('status', null);
        $msg = session()->pull('msg', null);
        $files = UploadedFile::select('id', 'user_id', 'file_path', 'file_name')
            ->with(['user'=>function ($q){
                $q->select('id', DB::raw("CONCAT(fname, ' ', lname) as name"));
            }])->paginate(15);
        return view('Uploadedfiles.index', compact('files', 'status', 'msg'));
    }

    public function selectUser()
    {
        $users = User::select('id', 'fname', 'lname')->paginate(15);
        return view("Uploadedfiles.selectUser", compact('users'));
    }

    public function uploadToUser(){
        $user_id =  Route::current()->parameter('user');
        return view('Uploadedfiles.upload', compact('user_id'));
    }

    public function store(CreateUploadedFileRequest $request){
        try{
            if ($request->file && $request->hasFile('file')){
                $myFile = $request->file('file');
                $extention = strtolower($myFile->getClientOriginalExtension());
                $file_name = time() . '.' . $extention;
                Storage::disk('uploaded_files')->put($file_name, file_get_contents($myFile));
                $filePath = "storage/uploadedFiles/". $file_name;
                $request->merge(['file_path'=>$filePath]);
            }
            DB::beginTransaction();
            UploadedFile::create($request->all());
            session(['status'=>'success',
                'msg'=>__('New file has been uploaded successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('uploadfiles.index');
    }

    public function destroy(UploadedFile $file)
    {
        try{
            DB::beginTransaction();
            Storage::disk('uploaded_files')->delete(explode('/', $file->file_path)[2]);
            $file->delete();
            session(['status'=>'success',
                'msg'=>__('The file has been deleted successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('uploadfiles.index');
    }

    public function getUserFiles(){
        $status = session()->pull('status', null);
        $msg = session()->pull('msg', null);
        $files = UploadedFile::select('id', 'file_path', 'file_name')
            ->where('user_id', auth()->id())
            ->paginate(15);
        return view('Uploadedfiles.userView', compact('files', 'status', 'msg'));
    }
}
