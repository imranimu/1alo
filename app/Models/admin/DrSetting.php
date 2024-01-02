<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrSetting extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'mobile_no',
        'phone_no',
        'email',
        'address',
        'footer_about_us',
        'facebook_link',
        'instagram_link',
        'pinterest_link',
        'linkedin_link',
        'twitter_link',
        'youtube_link',
        'created_at',
        'updated_at'
    ];


}
