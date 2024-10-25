<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'details', 'price', 'stadium_id','subscriptionFrequency','booking_choice'];

    public function client()
    {
       return $this->hasMany(Client::class,'subscription_id');
    }
    public function stadium()
    {
        return $this->belongsTo(Stadium::class, 'stadium_id');
    }
}
