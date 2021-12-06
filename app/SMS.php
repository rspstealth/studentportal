<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class SMS extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'sms';
    protected $fillable = [
        'id',
        'sms',
        'sender_id',
        'recievers_ids',
    ];

}