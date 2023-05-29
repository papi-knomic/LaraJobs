<?php

namespace App\Interfaces;

use App\Models\Listing;

interface ListingInterface
{
    /**
     * Find and filter listings
     * @return mixed
     */
    public function findMany(array $filters, string $status);

    /**
     * Create listing
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update Listing
     * @param Listing $listing
     * @param array $data
     * @return mixed
     */
    public function update(Listing $listing, array $data);

    /**
     * Update Listing Status
     * @param Listing $listing
     * @param string $status
     * @return mixed
     */
    public function updateStatus(Listing $listing, string $status);

    /**
     * Delete listing
     * @param Listing $listing
     * @return mixed
     */
    public function delete(Listing $listing);
}
