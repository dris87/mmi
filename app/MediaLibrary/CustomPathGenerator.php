<?php

namespace App\MediaLibrary;

use App\Models\BrandingSliders;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\CompanyAward;
use App\Models\CompanyVideo;
use App\Models\FrontSetting;
use App\Models\HeaderSlider;
use App\Models\ImageSlider;
use App\Models\JobCategory;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Class CustomPathGenerator
 */
class CustomPathGenerator implements PathGenerator
{
    /**
     * @param  Media  $media
     *
     * @return string
     */
    public function getPath(Media $media): string
    {
        $path = '{PARENT_DIR}'.DIRECTORY_SEPARATOR.$media->id.DIRECTORY_SEPARATOR;
        switch ($media->collection_name) {
            case Setting::PATH:
                return str_replace('{PARENT_DIR}', 'settings', $path);
            case Candidate::RESUME_PATH:
                return str_replace('{PARENT_DIR}', Candidate::RESUME_PATH, $path);
            case Candidate::CANDIDATE_DOCUMENT_PATH:
                return str_replace('{PARENT_DIR}', Candidate::CANDIDATE_DOCUMENT_PATH, $path);
            case Testimonial::PATH:
                return str_replace('{PARENT_DIR}', 'testimonials', $path);
            case User::PROFILE:
                return str_replace('{PARENT_DIR}', 'profile-pictures', $path);
            case Post::PATH:
                return str_replace('{PARENT_DIR}', Post::PATH, $path);
            case ImageSlider::PATH:
                return str_replace('{PARENT_DIR}', ImageSlider::PATH, $path);
            case HeaderSlider::PATH:
                return str_replace('{PARENT_DIR}', HeaderSlider::PATH, $path);
            case BrandingSliders::PATH:
                return str_replace('{PARENT_DIR}', BrandingSliders::PATH, $path);
            case FrontSetting::PATH:
                return str_replace('{PARENT_DIR}', FrontSetting::PATH, $path);
            case JobCategory::PATH:
                return str_replace('{PARENT_DIR}', JobCategory::PATH, $path);
            case Company::LOGO:
                return str_replace('{PARENT_DIR}', 'company_logos', $path);
            case Company::COVER_PHOTO:
                return str_replace('{PARENT_DIR}', 'company_covers', $path);
            case Company::WORKPLACE_PHOTO:
                return str_replace('{PARENT_DIR}', 'company_workplace', $path);
            case Company::GALLERY_PATH:
                return str_replace('{PARENT_DIR}', Company::GALLERY_PATH, $path);
            case CompanyVideo::VIDEO_THUMBNAIL:
                return str_replace('{PARENT_DIR}', CompanyVideo::VIDEO_THUMBNAIL, $path);
            case CompanyAward::AWARD_PATH:
                return str_replace('{PARENT_DIR}', CompanyAward::AWARD_PATH, $path);

            case 'default':
                return '';
        }
    }

    /**
     * @param  Media  $media
     *
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'thumbnails/';
    }

    /**
     * @param  Media  $media
     *
     * @return string
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'rs-images/';
    }
}
