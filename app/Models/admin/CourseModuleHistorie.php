<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseModuleHistorie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'courses_id',
        'module_id',
        'total_lession',
        'complete_lession',
		'ongoing_lession',
        'examination_status',
        'module_status',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
