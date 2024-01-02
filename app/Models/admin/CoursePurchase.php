<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoursePurchase extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'course_id',
        'addon_id',
        'addon_amount',
        'total_amount',
        'grand_amount',
        'transaction_id',
        'payment_status',
		'total_module',
        'status',
        'stripe_response',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function get_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'student_id');
    }
	
	public function get_course()
    {
        return $this->hasOne('App\Models\admin\Course', 'id', 'course_id');
    }

    public function get_addons()
    {
        return $this->hasMany('App\Models\admin\CourseAddonPurchase', 'course_purchase_id', 'id');
    }
}
