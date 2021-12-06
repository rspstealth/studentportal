<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Resource extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'resources';
    protected $fillable = [
        'course_specific',
        'resource_file',
        'description',
    ];

}
