<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audits';

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    protected $appends = ['user_name'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getUserNameAttribute()
    {
        if (isset($this->user->name)) {
            return $this->user->name;
        } else {
            return;
        }
    }
}
