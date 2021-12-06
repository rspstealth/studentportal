<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Evidence extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'evidences';
    protected $fillable = [
        'unit_parent',
        'course_id',
        'main_parent',
        'unit_number',
        'unit_name',
        'evidence_description',
        'evidence_documents_required',
    ];

}
