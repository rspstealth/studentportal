<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class CourseMarker extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'course_markers';
    protected $fillable = [
        'marker_title',
        'marker_description',
        'student_id',
        'course_id',
        'tutor_id',
    ];

}
