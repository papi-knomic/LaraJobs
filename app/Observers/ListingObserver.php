<?php

namespace App\Observers;

use App\Models\Listing;

class ListingObserver
{

    /**
     * Handle the Listing "creating" event.
     *
     * @param Listing $listing
     * @return void
     */
    public function creating(Listing $listing)
    {
        $listing->slug = generateListingSlug($listing->title);
    }

    /**
     * Handle the Listing "created" event.
     *
     * @param Listing $listing
     * @return void
     */
    public function created(Listing $listing)
    {
        //
    }

    /**
     * Handle the Listing "updating" event.
     *
     * @param Listing $listing
     * @return void
     */
    public function updating(Listing $listing)
    {
        if ($listing->isDirty('title')) {
            $listing->slug = generateListingSlug($listing->title);
        }
    }

    /**
     * Handle the Listing "updated" event.
     *
     * @param Listing $listing
     * @return void
     */
    public function updated(Listing $listing)
    {
        //
    }

    /**
     * Handle the Listing "deleted" event.
     *
     * @param Listing $listing
     * @return void
     */
    public function deleted(Listing $listing)
    {
        //
    }

    /**
     * Handle the Listing "restored" event.
     *
     * @param Listing $listing
     * @return void
     */
    public function restored(Listing $listing)
    {
        //
    }

    /**
     * Handle the Listing "force deleted" event.
     *
     * @param Listing $listing
     * @return void
     */
    public function forceDeleted(Listing $listing)
    {
        //
    }
}
