<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['team_name','reference','reservation_confirmed','session_number', 'phone_number', 'price','start_subs','end_subs','created_by','edited_by','subscription_id'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public function fund()
    {
       return $this->hasMany(fund::class,'client_id');
    }
    public function booking()
    {
       return $this->hasMany(Booking::class,'subscription_id');
    }
    public function useradd()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function useredit()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
