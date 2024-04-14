<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DoctorController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        return DoctorResource::collection(Doctor::whereIsActive()->filter()->orderBy('order', 'DESC')->get());
    }
}