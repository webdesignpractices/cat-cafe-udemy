<?php

namespace App\Models;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cat;

class Blog extends Model
{
    protected $fillable = ['title','body','image'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function cats(){
        return $this->belongsToMany(Cat::class);
    }
}
