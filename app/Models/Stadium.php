<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'stadiums'; // Add this line to specify the correct table name

    public function subscription()
    {
       return $this->hasMany(Subscription::class,'stadium_id');
    }
    public function booking()
    {
       return $this->hasMany(Booking::class,'stadium_id');
    }
}
