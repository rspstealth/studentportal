<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class AutomaticSMS extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'automatic_sms';
    protected $fillable = [
        'title',
        'sms',
        'is_active',
    ];

}
