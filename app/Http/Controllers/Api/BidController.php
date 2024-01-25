<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\BidException;
use App\Facades\BidFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bid\CreateBidRequest;
use App\Models\Bid;

class BidController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => BidFacade::index(),
        ]);
    }

    public function store(CreateBidRequest $request)
    {
        try {
            return response()->json([
                'data' => BidFacade::setRequestData($request->validated())->store()->show(),
                'message' => 'Successfully created bid',
            ], 201);
        } catch (BidException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function show(Bid $bid)
    {
        return response()->json([
            'data' => BidFacade::setBid($bid)->show(),
        ]);
    }
}
