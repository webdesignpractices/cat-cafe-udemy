<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Cat;
use App\Http\Requests\Admin\UpdateBlogRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$blogs = Blog::latest('updated_at')->paginate(10);
        $blogs = Blog::latest('updated_at')->simplePaginate(10);
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
    public function edit(Blog $blog)
    {
        $cats = Cat::all();
        $categories = Category::all();
        //$blog = Blog::findOrFail($id);
        return view('admin.blogs/edit',['blog' => $blog,'categories' => $categories,'cats' => $cats]);
    }

    //ブログの更新処理
    public function update(UpdateBlogRequest $request, string $id)
    {
        $blog = Blog::findOrFail($id);
        $updateData = $request->validated();
        if($request->has('image')){
            //変更前の画像を削除
            Storage::disk('public')->delete($blog->image);
            //変更後の画像をアップロード、保存パスを変更対象データにセット
            $updateData['image'] = $request->file('image')->store('blogs','public');
            //Log::debug($updateData);
        }
        $blog->category()->associate($updateData['category_id']);
        $blog->update($updateData);
        $blog->cats()->sync($updateData['cats'] ?? []);
        return to_route('admin.blogs.index')->with(['success' => 'ブログを更新しました']);
    }


    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        Storage::disk('public')->delete($blog->image);

        return to_route('admin.blogs.index')->with(['success'=>'ブログを削除しました']);
    }
}
