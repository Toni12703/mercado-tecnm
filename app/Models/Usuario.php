<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
    public function role()
    {
        return $this->belongsTo(Role::class, 'role');
    }

     public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'id_usuario');
    }

    public function ventasComoComprador(): HasMany
    {
        return $this->hasMany(Venta::class, 'id_comprador');
    }

}