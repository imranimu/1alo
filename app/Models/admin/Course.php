<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'discussions',
        'course_level',
        'course_duration',
        'price',
        'image',
        'sort',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
