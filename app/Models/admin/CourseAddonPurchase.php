<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseAddonPurchase extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_purchase_id',
        'student_id',
        'course_id',
        'addon_id',
        'name',
        'amount',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
