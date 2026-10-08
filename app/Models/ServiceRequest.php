<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    // Reuse the Laboratory 2 table instead of Laravel's guessed "service_requests"
    protected $table = 'requests';

    // Explicit allowlist of columns that may be mass-assigned.
    // Never add is_admin or role here.
    protected $fillable = [
        'user_id',
        'requester_name',
        'requester_email',
        'item_name',
        'quantity',
        'purpose',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}