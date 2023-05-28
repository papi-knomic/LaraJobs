<?php

namespace App\Repositories;

use App\Interfaces\ListingInterface;
use App\Models\Listing;

class ListingRepository implements ListingInterface
{

    public function create(array $data)
    {
        if ( !auth()->user() ) {
            $data['status'] = 'draft';
        }

        return Listing::create($data);
    }

    public function update(Listing $listing, array $data)
    {
        // TODO: Implement update() method.
    }

    public function updateStatus(Listing $listing, string $status)
    {
        return $listing->update(['status' => $status]);
    }

    public function findMany()
    {
        // TODO: Implement findMany() method.
    }

    public function delete(Listing $listing)
    {
       return $listing->delete();
    }
}
