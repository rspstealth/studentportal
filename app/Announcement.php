<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Announcement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'announcements';
    protected $fillable = [
        'id',
        'headline',
        'message',
        'created_by',
    ];

}
