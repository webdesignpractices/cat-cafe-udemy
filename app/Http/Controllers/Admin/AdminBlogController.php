<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Models\Blog;
//use Illuminate\Support\Facades\Log;

class AdminBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();
        return view('admin.blogs.index',['blogs' => $blogs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        //この書き方でもOK　その場合fillableに'image'の追加も
        // $validated = $request->validated();
        // $validated['image'] = $request->file('image')->store('blogs','public');
        // Blog::create($validated);
    
        $savedImagePath = $request->file('image')->store('blogs','public');
        //Log::debug($savedImagePath);
        $blog = new Blog($request->validated());
        $blog->image = $savedImagePath;
        $blog->save();

        return to_route('admin.blogs.index')->with(['success'=> 'ブログを更新しました']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    //指定したIDのブログの編集画面
    public function edit(string $id)
    {
        $blog = Blog::find(id);
        return view('admin.blogs/edit',['blog' => $blog]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
