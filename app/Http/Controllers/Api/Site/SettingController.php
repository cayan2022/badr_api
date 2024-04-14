<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Requests\Api\Site\ClickRegisterRequest;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Setting  $setting
     * @return SettingResource
     */
    public function __invoke(Setting $setting): SettingResource
    {
        return $setting->getResource();
    }

    /**
     * Handle the incoming request.
     *
     * @param  ClickRegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clickRegister(ClickRegisterRequest $request)
    {
        $settings = Setting::first();

        if ($request->type == 'whatsapp') {
            $settings->whatsapp_clicks = $settings->whatsapp_clicks + 1;
        } elseif ($request->type == 'phone') {
            $settings->phone_clicks = $settings->phone_clicks + 1;
        } elseif ($request->type == 'mail') {
            $settings->mail_clicks = $settings->mail_clicks + 1;
        }

        $settings->save();

        return response()->json(['success' => true, 'message' => __('auth.success_operation')]);
    }
}