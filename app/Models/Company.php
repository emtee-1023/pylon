<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'company_id',
    ];

    public function apps()
    {
        return $this->hasManyThrough(ApiKey::class, CompanyApp::class, 'company_id', 'id', 'id', 'app_id');
    }
}
