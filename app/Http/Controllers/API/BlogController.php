<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Blog;

class BlogController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::latest('updated_at')->get();;
        return response()->json(
            [
                'blog' => $blog
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $blog = request()->validate([
            'title'         =>  'required',
            'description'   =>  'required'
        ]);

        if(request()->photo == null){
            $name = "";
        }else{
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1]; 
            \Image::make($request->photo)->save(public_path('/storage/img/').$name);
        }

        Blog::create([
            'image' => $name
        ]+$blog);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        return response()->json([
            'blog' => $blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $blog = request()->validate([
            'title'         =>  'required',
            'description'   =>  'required'
        ]);
        
        $blogImage = Blog::find($id);
        
        if(request()->photo == $blogImage->image){
            $name = $blogImage->image;
        }else{
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1]; 
            \Image::make($request->photo)->save(public_path('/storage/img/').$name);
        }

        Blog::find($id)->update([
            'image' => $name
        ]+$blog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blog::find($id)->delete();
    }

    public function deleted(){
        return Blog::onlyTrashed()->get();
    }

    public function restore($id){
        Blog::withTrashed()->find($id)->restore();
    }

    public function search(){
        $blog = Blog::where('title','like','%'.request()->keyWord.'%')->get();
        return response()->json(
            [
                'blog' => $blog
            ]
        );
    }
}
