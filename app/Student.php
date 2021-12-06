<?php

namespace App;
use App\User;
use App\Course;
use App\Tutor;

use Illuminate\Database\Eloquent\Model;
class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'students';
    protected $fillable = [
        //'user_id',
        'student_number',
        'first_name',
        'last_name',
        //'username',
        //'password',
        'email',
        'phone_number',
        'mobile_number',
        'address',
        'join_date',
        //'current_course_id',
        //'secondary_course_id',
        //'current_course_tutor_id',
        //'secondary_course_tutor_id',
        'photo_id',
        //'join_date',
        //'fast_track',
        //'discounted_student',
//        'reseller',
//        'SEN',
//        'SEN_notes',
//        'payment_method',
    ];
}
