<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Http\Resources\ListingResource;
use App\Models\Listing;
use App\Repositories\ListingRepository;
use App\Traits\Response;
use Illuminate\Http\JsonResponse;

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
        $filters = [
            'tag' => request('tag'),
            'search' => request('search'),
            'remote' => request('remote', 0)
        ];

        $listings = $this->listingRepository->findMany($filters, 'published');
        $listings = ListingResource::collection($listings);

        return Response::successResponseWithData($listings);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateListingRequest $request
     * @return JsonResponse
     */
    public function store(CreateListingRequest $request) : JsonResponse
    {
        $fields = $request->validated();
        $listing = $this->listingRepository->create($fields);
        $listing = new ListingResource($listing);

        return Response::successResponseWithData($listing);
    }

    /**
     * Display the specified resource.
     *
     * @param Listing $listing
     * @return JsonResponse
     */
    public function show(Listing $listing) : JsonResponse
    {
        $listing = new ListingResource($listing);

        return Response::successResponseWithData($listing);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateListingRequest $request
     * @param Listing $listing
     * @return JsonResponse
     */
    public function update(UpdateListingRequest $request, Listing $listing) : JsonResponse
    {
        $fields = $request->validated();
        $update = $this->listingRepository->update($listing, $fields);

        if (!$update) {
            return Response::errorResponse();
        }
        $listing = new ListingResource($listing);

        return Response::successResponseWithData($listing);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Listing $listing
     * @return JsonResponse
     */
    public function destroy(Listing $listing) : JsonResponse
    {
        $this->listingRepository->delete($listing);

        return Response::successResponse('Listing has been successfully deleted');
    }
}
