<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class CourseNotes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'course_notes';
    protected $fillable = [
        'notes_title',
        'notes_description',
        'student_id',
        'course_id',
        'page_var',
    ];

}
