<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
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
        $cats = Category::paginate(15);
        return view("Categories.index", compact('cats', 'status', 'msg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
//        dd($request->all());
        try{
            DB::beginTransaction();
            Category::create($request->all());
            session(['status'=>'success',
                'msg'=>__('New category has been added successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('categories.index');
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
    public function edit(Category $category)
    {
        return view("Categories.edit", compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateCategoryRequest $request, Category $category)
    {
        try{
            DB::beginTransaction();
            $category->update($request->all());
            session(['status'=>'success',
                'msg'=>__('The category has been updated successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try{
            DB::beginTransaction();
            $category->delete();
            session(['status'=>'success',
                'msg'=>__('The category has been deleted successfully!')]);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            session(['status'=>'Error',
                'msg'=>__('Something went wrong! Try again later.')]);
        }
        return redirect()->route('categories.index');
    }

    public function findCategory(Request $request){
        $search = $request->search;
        $response = array();
        if(!$search){
            $response[] = [
                'id' => 0,
                'text' => __('words.choose_category'),
            ];
        }
        $cats = Category::select('id', 'name')
            ->where("name" , 'like' , "%$search%")
            ->limit(7)
            ->get();
//            return $users;
        if($cats){
            foreach($cats as $cat){
                $response[] = [
                    'id' => $cat->id,
                    'text' => $cat->name,
                ];
            }
        }

        return response()->json($response);
    }
}
