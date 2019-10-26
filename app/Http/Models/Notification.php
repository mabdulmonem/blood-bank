<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{

    protected $table = 'notifications';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['title', 'content', 'donation_request_id', 'client_id'];

    public function clients()
    {
        return $this->belongsToMany('App\Http\Models\Client');
    }

    public function donationRequest()
    {
        return $this->belongsTo('App\Http\Models\Donationrequest');
    }

}
