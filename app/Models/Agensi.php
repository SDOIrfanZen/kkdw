<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agensi extends Model
{
    use HasFactory;

    protected $table = 'agensi';

    public function Pengguna()
    {
        return $this->hasMany(Pengguna::class, 'bahagian_id', 'id');
    }
}
