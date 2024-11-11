<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pengguna;

class Peranan extends Model
{
    use HasFactory;

    protected $table = 'peranan';

    // Define the inverse relationship to Pengguna using 'peranan' as the local key
    public function Pengguna()
    {
        return $this->hasMany(Pengguna::class, 'peranan', 'id');
    }
}
