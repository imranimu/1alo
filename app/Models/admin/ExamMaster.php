<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamMaster extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'courses_id',
        'module_id',
        'title',
		'limit_number',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function get_course()
    {
        return $this->hasOne('App\Models\admin\Course', 'id', 'courses_id');
    }

    public function get_module()
    {
        return $this->hasOne('App\Models\admin\CoursesModule', 'id', 'module_id');
    }
}
