<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Tutor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tutors';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'address',
        'employment_status',
        'signature',
        'assigned_courses',
    ];

}
