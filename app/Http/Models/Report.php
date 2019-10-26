<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * @var string
     */
    protected $table = 'reports';

    /**
     * @var array
     */
    protected $fillable = [
        'client_id', 'donation_request_id', 'title', 'details'
    ];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Http\Models\Client');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function donationRequest()
    {
        return $this->belongsTo('App\Http\Models\DonationRequest');
    }

}
