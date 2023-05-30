<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters, bool $remote = false)
    {
        $query->when( $remote, function ($query){
            $query->where('remote', true);
        },  function ($query) {
            $query->latest('created_at');
        });

        $query->when($filters['tag'] ?? false, function ($query) use($filters) {
            $query->where('tags', 'like', '%' . $filters['tag'] . '%');
        });

        $query->when($filters['search'] ?? false, function ($query) use($filters) {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                ->orWhere('tags', 'like', '%' . $filters['search'] . '%');
        });
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->where('slug', $value)->orWhere('id', $value)->firstOrFail();
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->status === "published";
    }
}
