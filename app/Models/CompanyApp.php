<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyApp extends Model
{
    protected $fillable = [
        'company_id',
        'app_id',
        'branding',
        'api_config',
    ];

    protected $casts = [
        'branding' => 'array',
        'api_config' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function app()
    {
        return $this->belongsTo(ApiKey::class, 'app_id');
    }
}
