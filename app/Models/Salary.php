<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "salary";
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
