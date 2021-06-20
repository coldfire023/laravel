<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='subcategories';
    protected $fillable=['category_id','name','slug','short_description','description','image','meta_title','meta_keyword','meta_description','status','created_by','updated_by'];
}
