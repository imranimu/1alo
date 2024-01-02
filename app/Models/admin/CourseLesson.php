<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseLesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
		'module_id',
        'title',
        'lesson_type',
        'video',
        'audio',
        'text_pdf',
        'sort',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
	
	public function get_module()
    {
        return $this->hasMany('App\Models\admin\CoursesModule', 'id', 'module_id');
    }
}
