<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class TaskMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'conversations';
    protected $fillable = [
        'task_id',
        'initiator',
        'assigned_to',
        'message',
    ];

}
