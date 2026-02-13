<?php

namespace App\Models;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title','body','image'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
