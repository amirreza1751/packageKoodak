<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table ='logs';
    protected $fillable = [
        'msisdn', 'client_input', 'server_response'
    ];
}
