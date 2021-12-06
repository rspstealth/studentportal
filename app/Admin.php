<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Admin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'admins';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'photo_id',
    ];

}
