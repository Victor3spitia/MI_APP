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
            'password_changed',
            'avatar', // Agregar esta línea
            'role_id', // Asegúrate de que este campo exista en tu tabla users
            'profile_photos' // Agregar esta línea si usas profile_photo en la migración
    ];

    

    protected $casts = [
    'password_changed' => 'boolean',
    'password_changed_at' => 'datetime',
];

// Método para marcar contraseña como cambiada
public function markPasswordAsChanged()
{
    $this->update([
        'password_changed' => true,
        'password_changed_at' => now()
    ]);
}

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
