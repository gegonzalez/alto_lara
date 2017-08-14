<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submodule extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'submodules';
    protected $fillable = ['id', 'description', 'modules_id', 'url', 'order', 'deleted_at'];


    public function module() {
        return $this->belongsTo(\App\Models\Module::class, 'modules_id', 'id');
    }


}
