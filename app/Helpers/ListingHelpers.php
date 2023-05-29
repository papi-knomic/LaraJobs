<?php

use App\Models\Listing;
use Illuminate\Support\Str;

if (!function_exists('generateListingSlug')) {
    function generateListingSlug(string $title) : string
    {
        $slug = Str::slug($title);
        $count = Listing::where('slug', 'LIKE', "%$slug%")->count();

        if ( $count ){
            return "$slug-{$count}";
        }
        return $slug;
    }
}
