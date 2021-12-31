<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nim',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * This user belongs to a Role
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Check multiple roles
     * @param array $roles
     */
    public function hasAnyRole($roles)
    {
        return in_array($this->role->name, $roles);
    }

    /**
     * Check one role
     * @param string $role
     */
    public function hasRole($role)
    {
        return $this->role->name === $role;
    }

    /**
     * Check if user is an Admin
     */
    public function isAdmin()
    {
        return $this->hasAnyRole(['admin', 'superadmin']);
    }

    /**
     * Check if user is a Superadmin
     */
    public function isSuperadmin()
    {
        return $this->role->name === 'superadmin';
    }

    /**
     * Check if user can vote
     */
    public function isUserCanVote()
    {
        $validStatuses = ["rejected", "notyet"];
        return in_array($this->vote_status, $validStatuses);
    }
}
