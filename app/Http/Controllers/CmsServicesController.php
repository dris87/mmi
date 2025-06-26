<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutusRequest;
use App\Models\CmsServices;
use Doctrine\DBAL\Driver\AbstractDB2Driver;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;

class CmsServicesController extends AppBaseController
{
    public function index(Request $request)
    {
        $cmsServices = CmsServices::pluck('value', 'key')->toArray();

        return view('cms_services.index', compact('cmsServices'));
    }

    /**
     * @param  Request  $request
     *
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function aboutUsService(Request $request)
    {

        $cmsServices = CmsServices::pluck('value', 'key')->toArray();

        return view('cms_services.about-us', compact('cmsServices'));
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $inputArr = Arr::except($input, ['_token']);
        foreach ($inputArr as $key => $value) {
            /** @var CmsServices $cmsServices */
            $cmsServices = CmsServices::where('key', $key)->first();
            if (! $cmsServices) {
                continue;
            }

            if (in_array($key, ['home_banner']) && ! empty($value)) {
                $this->fileUpload($cmsServices, $value);
                continue;
            }

            $cmsServices->update(['value' => $value]);
        }
        Flash::success('CMS Services updated successfully.');

        return Redirect::back();
    }

    public function aboutUsUpdate(AboutusRequest $request)
    {
        $input = $request->all();
        $inputArr = Arr::except($input, ['_token']);
        foreach ($inputArr as $key => $value) {
            /** @var CmsServices $cmsServices */
            $cmsServices = CmsServices::where('key', $key)->first();
            if (! $cmsServices) {
                continue;
            }

            if (in_array($key, ['about_image_one']) && ! empty($value)) {
                $this->fileUpload($cmsServices, $value);
                continue;
            }
            if (in_array($key, ['about_image_two']) && ! empty($value)) {
                $this->fileUpload($cmsServices, $value);
                continue;
            }
            if (in_array($key, ['about_image_three']) && ! empty($value)) {
                $this->fileUpload($cmsServices, $value);
                continue;
            }

            $cmsServices->update(['value' => $value]);
        }
        Flash::success('About us updated successfully.');

        return Redirect::back();
    }

    public function fileUpload($cmsServices, $file)
    {
        $cmsServices->clearMediaCollection(CmsServices::PATH);
        $media = $cmsServices->addMedia($file)->toMediaCollection(CmsServices::PATH, config('app.media_disc'));
        $cmsServices->update(['value' => $media->getFullUrl()]);

        return $cmsServices;
    }
}
