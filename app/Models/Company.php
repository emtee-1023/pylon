<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'branding',
        'api_config',
    ];

    protected $casts = [
        'branding' => 'array',
        'api_config' => 'array',
    ];
}
