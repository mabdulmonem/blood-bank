<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{

    protected $table = 'settings';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['site_name', 'logo', 'icon', 'email','phone', 'description', 'keywords', 'status', 'fb', 'tw', 'youtube', 'in', 'whats_app', 'notification_settings_text','android_app_link','ios_app_link','paginate'];

}
