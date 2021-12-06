<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class HelpCentre extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'help-centre';
    protected $fillable = [
        'subject',
        'description',
        'status',
        'created_by',
        'assigned_to',
        'priority',
        'start_date',
        'estimated_completion_date',
    ];

}
