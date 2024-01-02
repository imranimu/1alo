<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoursesResult extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exam_id',
        'user_id',
        'yes_ans',
        'no_ans',
        'result_json',
        'total_question',
        'question_percentage',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
