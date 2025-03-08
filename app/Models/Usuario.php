<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Usar la clase base para autenticación
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    protected $table = 'users'; // Asegúrate de que la tabla sea 'users' si has decidido usar ese nombre
    protected $primaryKey = 'id_user'; // Si tu clave primaria es 'id_user'
    public $timestamps = false; // Si no estás usando las marcas de tiempo

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_role',  // Si tienes roles
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relaciones con otros modelos
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_role');
    }

    public function encuestas()
    {
        return $this->hasMany(Encuesta::class, 'id_user');
    }

    public function historial()
    {
        return $this->hasMany(HistorialEncuesta::class, 'id_user');
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'id_user');
    }

}