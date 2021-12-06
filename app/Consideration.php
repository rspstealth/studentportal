<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Consideration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'student_consideration';
    protected $fillable = [
        'id',
        'student_id',
        'title',
        'notes',
    ];

}
