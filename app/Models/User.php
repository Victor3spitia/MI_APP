<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;




class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar en masa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'foto_perfil',
    ];

    /**
     * Los atributos que deben ocultarse al serializar.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben convertirse automáticamente.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con la tabla de roles.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Notificación personalizada para restablecer contraseña.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        
        return null; // o una imagen por defecto
    }
}
