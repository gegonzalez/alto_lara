<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'modules';
    protected $fillable = ['id', 'description', 'url', 'order', 'icon', 'deleted_at'];

    /**
     * Get the Submodules for the TIpo Afiliado.
     */
    public function submodules()
    {
        return $this->hasMany(\App\Models\Submodule::class,'modules_id','id');
    }

}
