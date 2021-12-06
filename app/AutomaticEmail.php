<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class AutomaticEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'automatic_emails';
    protected $fillable = [
        'subject',
        'description',
        'title',
        'is_active',
    ];

}
