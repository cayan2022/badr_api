<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\CreateContactUsRequest;
use App\Http\Resources\ContactUsResource;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateContactUsRequest  $request
     * @return ContactUsResource
     */
    public function store(CreateContactUsRequest $request)
    {
        $contactUs= ContactUs::create($request->validated());
        if($request->hasFile('file') && $request->file('file')->isValid()){
            $contactUs->addMediaFromRequest('file')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(ContactUs::MEDIA_COLLECTION_NAME);
        }
        return $contactUs->getResource();
    }
}
