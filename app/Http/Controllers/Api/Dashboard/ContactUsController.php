<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactUsResource;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContactUsController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ContactUsResource::collection(ContactUs::latest()->paginate());
    }
    /**
     * Display the specified resource.
     *
     * @param  ContactUs $contactUs
     * @return ContactUsResource
     */
    public function show(ContactUs $contactUs)
    {
        return $contactUs->getResource();
    }
}
