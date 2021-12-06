<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ContactReason extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'contact-reasons';
    protected $fillable = [
        'reason',
        'priority',
        'assigned_staff',
    ];

}
