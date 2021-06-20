<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='products';
    protected $fillable=['category_id','subcategory_id','title','slug','price','discount','stock','quantity','unit_id','short_description','specification','description','meta_title','meta_keyword','meta_description','feature_product','flash_product','status','created_by','updated_by'];
}
