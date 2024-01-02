<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseCertificate extends Model
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
		'license_id',
        'is_type',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
	
	public function get_license()
    {
        return $this->hasOne('App\Models\admin\CourseLicense', 'id', 'license_id');
    }
	
	public function get_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'student_id');
    }
}
