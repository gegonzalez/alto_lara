<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable{

    use SoftDeletes;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'email', 'password', 'department', 'type', 'user', 'active', 'proveedor', 'remember_token', 'deleted_at', 'salt'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $login_validation_rules = [
        'user' => 'required|exists:users',
        'password' => 'required'
    ];

    public static $create_validation_rules = [
        'name' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required',
        'department' => 'required',
        'type' => 'required',
        'user' => 'required|unique:users'
    ];
    
    /**
     * Get the Type User.
     */
    public function userType() {
        return $this->belongsTo(\App\Models\UserType::class, 'type', 'id');
    }
    
    /**
     * Get Proveedor.
     */
    public function acProveedor() {
        return $this->belongsTo(\App\Models\AcProveedoresExtranet::class, 'proveedor', 'codigo_proveedor');
    }
    
    /**
     * Get Claves.
     */
    public function claves() {
        return $this->hasMany(\App\Models\AcProveedoresExtranet::class, 'id', 'creador');
    }
}
