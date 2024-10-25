<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;
    protected $fillable = ['client_id','payment','subscription_name'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

}
