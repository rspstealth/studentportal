<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class CannedResponse extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'canned_responses';
    protected $fillable = [
        'user_id',
        'comments',
        'type',
    ];

}
