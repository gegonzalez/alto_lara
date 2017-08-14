<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypesProfile extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'types_profile';
    protected $fillable = ['id', 'id_type', 'id_module', 'deleted_at'];


    public function userType() {
        return $this->belongsTo(\App\Models\UserType::class, 'id_type', 'id');
    }

    public function submodule() {
        return $this->belongsTo(\App\Models\Submodule::class, 'id_module', 'id');
    }


}
