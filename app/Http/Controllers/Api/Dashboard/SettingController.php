<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Http\Requests\Api\Dashboard\UpdateSettingRequest;

class SettingController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Setting  $setting
     * @return SettingResource
     */
    public function show(Setting $setting)
    {
        return $setting->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSettingRequest  $request
     * @param  Setting  $setting
     * @return SettingResource
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $setting->clearMediaCollection(Setting::MEDIA_COLLECTION_NAME);
            $setting->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Setting::MEDIA_COLLECTION_NAME);
        }

        return $setting->getResource();
    }

}
