<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Http\Resources\ListingResource;
use App\Models\Listing;
use App\Repositories\ListingRepository;
use App\Traits\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        if ( ($listing->trashed() || !$listing->is_published ) && !auth()->check()) {
            throw new NotFoundHttpException();
        }

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

    public function getListings(Request $request) : JsonResponse
    {
        $status = request('status', 'published');

        if ( $status !== 'deleted' ) {
            $listings = $this->listingRepository->findMany([], $status);
        } else{
            $listings = Listing::onlyTrashed()->get();
        }
        $listings = ListingResource::collection($listings);

        return Response::successResponseWithData($listings);
    }

    public function restore(Listing $listing) : JsonResponse
    {
        $listing->restore();
        $listing = new ListingResource($listing);

        return Response::successResponseWithData($listing);
    }

    public function bulkDelete(Request $request) : JsonResponse
    {
        $listingIds = $request->input('listing_ids', []);

        $this->listingRepository->deleteMultiple($listingIds);

        return Response::successResponse('Listings have been deleted');
    }

    public function bulkRestore(Request $request): JsonResponse
    {
        $listingIds = $request->input('listing_ids', []);

        $this->listingRepository->restoreMultiple($listingIds);

        return Response::successResponse('Listings have been restored');
    }

    public function bulkPublish(Request $request): JsonResponse
    {
        $listingIds = $request->input('listing_ids', []);

        $this->listingRepository->changeStatusMultiple($listingIds, 'published');

        return Response::successResponse('Listings have been published');
    }

    public function bulkDraft(Request $request): JsonResponse
    {
        $listingIds = $request->input('listing_ids', []);

        $this->listingRepository->changeStatusMultiple($listingIds, 'draft');

        return Response::successResponse('Listings have been drafted');
    }
}
