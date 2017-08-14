<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcAfiliado extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_afiliados';
    protected $fillable = ['id', 'cedula', 'nombre', 'apellido', 'fecha_nacimiento', 'email', 'sexo', 'val_user', 'tipo_afiliado', 'telefono', 'cedula_titular', 'deleted_at'];
    protected $dates = ['fecha_nacimiento'];

     /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d';
    
    function setFechaNacimientoAttribute($date) {
        $this->attributes['fecha_nacimiento'] = new Carbon($date);
    }
    
    public function acTipoAfiliado() {
        return $this->belongsTo(\App\Models\AcTipoAfiliado::class, 'tipo_afiliado', 'id');
    }
    
    /**
     * Get the contratos for the Afiliado.
     */
    public function contratos()
    {
        return $this->hasMany(\App\Models\AcContrato::class,'cedula_afiliado','cedula');
    }

}
