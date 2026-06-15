<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KetuaJurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jurusan_id', 'nama', 'nip', 'foto', 'jabatan', 'periode', 'sambutan', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
