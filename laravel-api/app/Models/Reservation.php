<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id', 'date', 'time', 'description'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
