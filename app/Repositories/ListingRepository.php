<?php

namespace App\Repositories;

use App\Interfaces\ListingInterface;
use App\Models\Listing;

class ListingRepository implements ListingInterface
{

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(Listing $listing, array $data)
    {
        // TODO: Implement update() method.
    }

    public function updateStatus(Listing $listing, string $status)
    {
        // TODO: Implement updateStatus() method.
    }

    public function findMany()
    {
        // TODO: Implement findMany() method.
    }

    public function delete(Listing $listing)
    {
        // TODO: Implement delete() method.
    }
}
