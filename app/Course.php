<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'courses';
    protected $fillable = [
        'name',
        'description',
        'type',
        'full_price',
        'deposit',
        'instalment_price',
        'support_price',
        'sale_price',
        'course_advert',
        'number_of_assignments',
    ];

}
