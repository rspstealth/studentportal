<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Revenue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'revenue';
    protected $fillable = [
        'tutor_id',
        'student_number',
        'description',
        'entry_type',
        'cost',
        'running_total',
        'date',
    ];
}
