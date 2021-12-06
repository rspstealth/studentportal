<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class AssignmentNote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'assignment_notes';
    protected $fillable = [
        'course_id',
        'student_id',
        'assignment_id',
        'note',
    ];

}
