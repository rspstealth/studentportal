<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Feedback extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'feedback_templates';
    protected $fillable = [
        'assignment_number',
        'comments',
        'grades_awarded',
        'further_actions',
        'further_actions_refer',
        'assignment_type',
    ];

}
