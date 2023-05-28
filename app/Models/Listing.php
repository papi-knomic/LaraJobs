<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query) use ($filters) {
            $query->where(function ($query) use ($filters) {
                $query->where('tags', 'like', '%' . $filters['tag'] . '%')
                    ->orWhere('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('tags', 'like', '%' . $filters['search'] . '%');
            });
        });
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->where('slug', $value)->orWhere('id', $value)->firstOrFail();
    }
}
