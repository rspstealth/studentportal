<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class StaffResource extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'staff_resources';
    protected $fillable = [
        'shared_with',
        'course',
        'resource_file',
        'description',
        'created_by',
    ];

}
