<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = "bookings";

    protected $fillable = [
        'name',
        'email',
        'country_code',
        'phone_number',
        'check_in',
        'check_out',
        'days',
        'price',
        'user_id',
        'room_name',
        'hotel_name',
        'status',
    ];

    public $timestamps = true;
}
