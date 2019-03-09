<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
                        'sid',
                        'trans-id',
                        'status',
                        'base-price-point',
                        'msisdn',
                        'keyword',
                        'Validity',
                        'next_renewal_date',
                        'Shortcode',
                        'billed-price-point',
                        'trans-status',
                        'chargeCode',
                        'datetime',
                        'event-type',
                        'channel'
    ];
}
