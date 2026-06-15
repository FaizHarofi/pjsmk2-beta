<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'model_type', 'model_id', 'details'];

    protected function casts(): array
    {
        return ['details' => 'array'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
