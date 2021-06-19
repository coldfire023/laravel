<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='provinces';
    protected $fillable=['name','status','created_by','updated_by'];

    function districts()
    {
        return $this->hasMany(District::class);
    }
}
