<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcEstado extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_estados';
    protected $fillable = ['es_id', 'es_desc', 'deleted_at'];



}
