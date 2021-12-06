<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class Email extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'emails';
    protected $fillable = [
        'id',
        'subject',
        'email_body',
        'sender_id',
        'recievers_ids',
    ];

}