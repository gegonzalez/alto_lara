<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcTipoProveedor extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_tipo_proveedor';
    protected $fillable = ['id', 'descripcion', 'deleted_at'];

    /**
     * Get the Proveedor Extraner for the Tipo Proveedor.
     */
    public function proveedores()
    {
        return $this->hasMany(\app\Models\AcProveedoresExtranet::class,'tipo_proveedor','id');
    }

}