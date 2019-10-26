<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Governorate extends Model
{

    protected $table = 'governorates';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name'];

    public function cities()
    {
        return $this->hasMany('App\Http\Models\City');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Http\Models\Client');
    }

}
