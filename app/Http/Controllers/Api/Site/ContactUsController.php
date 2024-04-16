<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\CreateContactUsRequest;
use App\Http\Resources\ContactUsResource;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function __invoke(CreateContactUsRequest $createContactUsRequest): ContactUsResource
    {
        $contactUs= ContactUs::create($createContactUsRequest->validated());
        if($createContactUsRequest->hasFile('file') && $createContactUsRequest->file('file')->isValid()){
            $contactUs->addMediaFromRequest('file')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(ContactUs::MEDIA_COLLECTION_NAME);
        }
        return $contactUs->getResource($contactUs);
    }
}
