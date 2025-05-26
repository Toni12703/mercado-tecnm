<?php
namespace App\Providers;

use App\Models\Boucher;
use App\Models\Venta;
use App\Models\Usuario;
use App\Policies\BoucherPolicy;
use App\Policies\VentaPolicy;
use App\Policies\UserPolicy;
use App\Policies\DashboardPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Boucher::class => BoucherPolicy::class,
        Venta::class => VentaPolicy::class,
        Usuario::class => UserPolicy::class,
        // Si Dashboard no es modelo, registra para Usuario
        Usuario::class => DashboardPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}