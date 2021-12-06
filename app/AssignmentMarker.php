<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class AssignmentMarker extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'assignment_markers';
    protected $fillable = [
        'course_id',
        'student_id',
        'assignment_id',
        'marker',
    ];

}
