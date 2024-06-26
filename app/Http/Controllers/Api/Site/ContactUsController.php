<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\CreateContactUsRequest;
use App\Http\Resources\ContactUsResource;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function store(Request $createContactUsRequest): ContactUsResource
    {
        $data = $createContactUsRequest->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string'],
            'file' => ['nullable', 'file'],
        ]);

        $contactUs = ContactUs::create($data);
        if ($createContactUsRequest->hasFile('file') && $createContactUsRequest->file('file')->isValid()) {
            $contactUs->addMediaFromRequest('file')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(ContactUs::MEDIA_COLLECTION_NAME);
        }
        return new ContactUsResource($contactUs);
    }
}
