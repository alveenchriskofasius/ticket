<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'name', 
        'description', 
        'user_id', 
        'status', 
        'priority'
    ];

    /**
     * The user who owns the ticket.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
