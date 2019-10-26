<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $timestamps = true;
    protected $table = 'tokens';
    protected $fillable = ['client_id','token','os'];
    protected $dates = ['deleted_at'];

    public function client()
    {
        return $this->belongsTo('App\Http\Models\Client');
    }
}
