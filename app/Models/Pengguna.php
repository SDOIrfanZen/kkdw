<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Make sure to use Authenticatable
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Peranan;

class Pengguna extends Authenticatable // Change this line
{
    use HasFactory;
    use Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'kad_pengenalan',
        'bahagian',
        'jawatan',
        'peranan',
        'emel',
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
}
