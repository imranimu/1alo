<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentExam extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'module_id',
		'courses_id',
        'exam_id',
        'exam_status',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
		'completed_at'
    ];
}
