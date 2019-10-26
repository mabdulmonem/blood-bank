<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{

    use SoftDeletes,Notifiable;

    protected $guarded = 'client';

    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * @var string
     */
    protected $table = 'clients';
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * @var array
     */
    protected $fillable = ['name', 'phone', 'email', 'password', 'date_of_birth', 'last_donation_date', 'rest_code', 'status',
        'api_token','is_verified', 'blood_type_id', 'city_id','lang'];
    /**
     * @var array
     */
    protected $hidden = ['password','api_token'];




    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notifications()
    {
        return $this->belongsToMany('App\Http\Models\Notification');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function governorates()
    {
        return $this->belongsToMany('App\Http\Models\Governorate');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bloodTypes()
    {
        return $this->belongsToMany('App\Http\Models\BloodType');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donationRequests()
    {
        return $this->hasMany('App\Http\Models\DonationRequest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo('App\Http\Models\City');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\Http\Models\Post','client_post','client_id','post_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bloodType()
    {
        return $this->belongsTo('App\Http\Models\BloodType');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens()
    {
        return $this->hasMany('App\Http\Models\Token');
    }

    public function reports()
    {
        return $this->hasMany('App\Http\Models\Report');
    }

}
