<?php

namespace App\Models;

use App\Models\Peranan;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Make sure to use Authenticatable

class Pengguna extends Authenticatable // Change this line
{
    use HasRoles;
    use HasPermissions;
    use HasFactory;
    use Notifiable;
    use CanResetPassword;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'kad_pengenalan',
        'bahagian',
        'jawatan',
        'peranan',
        'email',
        'no_tel',
        'status',
        'kata_laluan'
    ];
    
    public $timestamps = true;

    // Define the relationship to the Peranan model
    public function Peranan()
    {
        return $this->belongsTo(Peranan::class, 'peranan', 'id');
    }

    public function getAuthPassword()
    {
        return $this->kata_laluan; 
    }
}
