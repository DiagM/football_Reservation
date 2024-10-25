<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['reservation_date','reservation_date_end','reservation_time','reservation_time_end', 'client_id','stadium_id'];
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function stadium()
    {
        return $this->belongsTo(Stadium::class, 'stadium_id');
    }

}
