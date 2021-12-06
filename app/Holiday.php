<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Holiday extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'staff_holidays';
    protected $dates = ['from_date', 'end_date'];
    protected $fillable = [
        'tutor_id',
        'message',
        'from_date',
        'end_date',
        'created_by',//assigner admin
    ];

}
