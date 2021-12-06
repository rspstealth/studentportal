<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class IV extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'iv';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'photo_id',
        'address',
        'signature',
        'assigned_courses',
    ];

}
