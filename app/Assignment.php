<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Assignment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'standard_courses_uploads';
    protected $fillable = [
        'course_id',
        'student_id',
        'assignment_file',
        'assignment_number',
        'status',
    ];

}
