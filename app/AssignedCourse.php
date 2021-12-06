<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class AssignedCourse extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'assigned_courses';
    protected $fillable = [
        'student_id',
        'course_id',
        'tutor_id',
        'course_discount',
        'join_date',
        'expiry_date',
        'payment_method',
    ];

}
