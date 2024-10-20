<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audits';

    protected $appends = ['user_name'];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
        ];
    }

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

    public function getModelNameAttribute()
    {
        if (isset($this->auditable_type)) {
            return str_replace('App\\Models\\', '', $this->auditable_type);
        } else {
            return;
        }
    }

    public function scopeFiltered($query, $filters)
    {   //initialize comparison operators to equals
        $created_at_operator = '=';
        //while not the most efficient - I want to get the comparison operators first so I can assign them to variables to use
        foreach ($filters->query as $filter => $value) {
            switch ($filter) {
                case 'created_at_operator':
                    $created_at_operator = ! empty($value) ? $value : '=';
                    break;
            }
        }

        foreach ($filters->query as $filter => $value) {
            if ($filter == 'user_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'created_at' && ! empty($value)) {
                $created_at = Carbon::parse($value);
                $query->where($filter, $created_at_operator, $created_at);
            }

            if ($filter == 'auditable_id' && isset($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'event' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'auditable_type' && ! empty($value)) {
                $new_value = str_replace('\\', '\\\\', $value);
                $query->where($filter, 'LIKE', '%'.$new_value.'%');
            }

            if ($filter == 'url' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }

            if ($filter == 'tags' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }

            if ($filter == 'old_values' && ! empty($value)) {
                $query->whereRaw("JSON_SEARCH($filter,'all','%$value%') IS NOT NULL");
            }

            if ($filter == 'new_values' && ! empty($value)) {
                $query->whereRaw("JSON_SEARCH($filter,'all','%$value%') IS NOT NULL");
            }
        }

        return $query;
    }
}
