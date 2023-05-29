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
        return $listing->update($data);
    }

    public function updateStatus(Listing $listing, string $status)
    {
        return $listing->update(['status' => $status]);
    }

    public function findMany(array $filters, string $status)
    {
        $remote = $filters['remote'];
        return Listing::whereStatus($status)->filter($filters, $remote)->paginate(10);
    }

    public function delete(Listing $listing)
    {
       return $listing->delete();
    }
}
