<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KontakPesan extends Model
{
    use HasFactory;

    protected $table = 'kontak_pesans';

    protected $fillable = ['nama', 'email', 'subjek', 'pesan', 'is_read', 'ip_address'];

    protected function casts(): array
    {
        return ['is_read' => 'boolean'];
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
