<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseLicense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'license',
        'license_status',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
