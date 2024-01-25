<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\AdvertisementException;
use App\Facades\AdvertisementFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Advertisement\CreateAdvertisementRequest;
use App\Http\Requests\Advertisement\UpdateAdvertisementRequest;
use App\Models\Advertisement;

class AdvertisementController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Advertisement::class, 'advertisement');
    }

    public function index()
    {
        return response()->json([
            'data' => AdvertisementFacade::index(),
        ]);
    }

    public function store(CreateAdvertisementRequest $request)
    {
        try {
            return response()->json([
                'data' => AdvertisementFacade::setRequestData($request->validated())->store()->show(),
                'message' => 'Successfully created advertisement',
            ], 201);
        } catch (AdvertisementException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function show(Advertisement $advertisement)
    {
        return response()->json([
            'data' => AdvertisementFacade::setAdvertisement($advertisement)->show(),
        ]);
    }

    public function activate(Advertisement $advertisement)
    {
        $this->authorize('activate', $advertisement);

        try {
            return response()->json([
                'data' => AdvertisementFacade::setAdvertisement($advertisement)->activate()->show(),
                'message' => 'Successfully moderated advertisement',
            ]);
        } catch (AdvertisementException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement)
    {
        try {
            return response()->json([
                'data' => AdvertisementFacade::setAdvertisement($advertisement)->setRequestData($request->validated())->update()->show(),
                'message' => 'Successfully updated advertisement',
            ]);
        } catch (AdvertisementException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function destroy(Advertisement $advertisement)
    {
        try {
            AdvertisementFacade::setAdvertisement($advertisement)->destroy();

            return response()->json([
                'message' => 'Successfully deleted advertisement',
            ]);
        } catch (AdvertisementException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
