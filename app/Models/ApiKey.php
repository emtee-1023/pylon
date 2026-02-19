<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $fillable = [
        'app_name',
        'key_hash',
        'scopes',
        'active',
    ];

    protected $casts = [
        'scopes' => 'array',
        'active' => 'boolean',
        'last_used_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
