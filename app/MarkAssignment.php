<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class MarkAssignment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'marked_assignments';
    protected $fillable = [
        'course_id',
        'student_id',
        'assignment_id',
        'feedback_content',
        'comments',
        //'status',
    ];

}
