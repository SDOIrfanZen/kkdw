<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectedPengguna extends Model
{
    use HasFactory;

    protected $table = 'rejected_pengguna';

    protected $fillable = [
        'nama',
        'kad_pengenalan',
        'email',
        'bahagian',
        'no_tel',
        'jawatan',
        'remark',
        'rejected_at',
    ];
}
