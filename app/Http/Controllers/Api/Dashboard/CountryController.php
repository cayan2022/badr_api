<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        return CountryResource::collection(Country::filter()->latest()->get());
    }
}
