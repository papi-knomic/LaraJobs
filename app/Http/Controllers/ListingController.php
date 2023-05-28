<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateListingRequest;
use App\Http\Requests\UpdateListingStatusRequest;
use App\Models\Listing;
use App\Repositories\ListingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListingController extends Controller
{
    private ListingRepository $listingRepository;


    public function __construct(ListingRepository $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateListingRequest $request
     * @return JsonResponse
     */
    public function store(CreateListingRequest $request) : JsonResponse
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Listing $listing
     * @return JsonResponse
     */
    public function show(Listing $listing) : JsonResponse
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Listing $listing
     * @return JsonResponse
     */
    public function update(Request $request, Listing $listing) : JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Listing $listing
     * @return JsonResponse
     */
    public function destroy(Listing $listing) : JsonResponse
    {
        //
    }

    /**
     * Update status of listing
     *
     * @param Listing $listing
     * @param UpdateListingStatusRequest $request
     * @return JsonResponse
     */
    public function updateStatus(Listing $listing, UpdateListingStatusRequest $request ) : JsonResponse
    {

    }
}
