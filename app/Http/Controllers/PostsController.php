<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
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
        $cat_id = request()->query('category_id') ?? null;
        if($cat_id)
            $posts = Post::where('category_id', $cat_id)->paginate(15);
        else
            $posts = Post::paginate(15);
        $cats = Category::select('id', 'name')->where('status', 1)->get();
        return view("Posts.index", compact('posts','cats', 'status', 'msg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Posts.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        try{
            if ($request->image && $request->hasFile('image')){
                $myFile = $request->file('image');
                $extention = strtolower($myFile->getClientOriginalExtension());
                $file_name = time() . '.' . $extention;
                Storage::disk('posts_imgs')->put($file_name, file_get_contents($myFile));
                $filePath = "storage/postsImages/". $file_name;
                $request->merge(['post_img'=>$filePath]);
            }
            DB::beginTransaction();
            Post::create($request->all());
            session(['status'=>'success',
                'msg'=>__('New post has been added successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('Posts.details', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $cat = Category::select('id', 'name as text')
            ->where('id', $post->category_id)->first();
        return view("Posts.edit", compact('post', 'cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePostRequest $request, Post $post)
    {
        try{
            if($request->oldImgChanged && $request->image){ // old image was renewed
                Storage::disk('posts_imgs')->delete(explode('/', $post->post_img)[2]);
                if ($request->image && $request->hasFile('image')){
                    $myFile = $request->file('image');
                    $extention = strtolower($myFile->getClientOriginalExtension());
                    $file_name = time() . '.' . $extention;
                    Storage::disk('posts_imgs')->put($file_name, file_get_contents($myFile));
                    $filePath = "storage/postsImages/". $file_name;
                    $request->merge(['post_img'=>$filePath]);
                }
            }elseif ($request->oldImgChanged && !$request->image){ // old image was changed without renewing
                Storage::disk('posts_imgs')->delete(explode('/', $post->post_img)[2]);
            }
            DB::beginTransaction();
            $post->update($request->all());
            session(['status'=>'success',
                'msg'=>__('The post has been updated successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try{
            DB::beginTransaction();
            Storage::disk('posts_imgs')->delete(explode('/', $post->post_img)[2]);
            $post->delete();
            session(['status'=>'success',
                'msg'=>__('The post has been deleted successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('posts.index');
    }
}
