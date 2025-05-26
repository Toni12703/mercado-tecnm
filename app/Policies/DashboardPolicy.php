<?php

namespace App\Policies;

use App\Models\Usuario;

class DashboardPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAdminDashboard(Usuario $user): bool
    {
        return $user->role === 'admin';
    }
}
