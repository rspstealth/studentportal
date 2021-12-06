<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Assessment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'assessments';
    protected $fillable = [
        'course_id',
        'unit_id',
        'detail',
        'units_required',
    ];

}
