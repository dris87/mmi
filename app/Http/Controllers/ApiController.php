<?php

namespace App\Http\Controllers;

use App\Helpers\Layout;
use App\Helpers\Video;
use App\Models\Factories\CityFactory;
use App\Models\Factories\JobChangeFactory;
use App\Models\Factories\JobFactory;
use App\Models\Factories\JobRequirementTypeFactory;
use App\Models\Factories\PostalCodeFactory;
use App\Rules\YoutubeOrVimeoUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends AppBaseController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getCity(Request $request){

        $post = $request->post();

        $validator = Validator::make($post, [
            'postcode' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->getMessageBag()->getMessages()['name'][0]);
        }

        $postalCodeFactory = new PostalCodeFactory();

        $objPostalCode = $postalCodeFactory->getByPostalCode($post['postcode']);

        if($objPostalCode){
            $cityFactory = new CityFactory();
            $objCity = $cityFactory->getById($objPostalCode->getCityId());
            if($objCity){
                return $this->sendResponse(['city' => $objCity->name]);
            }
        }
        return $this->sendError('Invalid Postal Code');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getJobRequirements(Request $request){
        $post = $request->post();

        $validator = Validator::make($post, [
            'jobId' => 'numeric|exists:jobs,id',
        ]);

        if ($validator->fails()) {
            $this->ajaxResponse('error', $validator->getMessageBag()->getMessages()['name'][0]);
        }

        $jobFactory = new JobFactory();
        $objJob = $jobFactory->getById($post['jobId']);

        if(!$objJob){
            $this->ajaxResponse('error', 'Invalid Job');
        }

        $jobRequirementTypeFactory = new JobRequirementTypeFactory();
        $arrJobRequirementType = $jobRequirementTypeFactory->getAll();

        $jobRequirementData = $objJob->getJobRequirements();

        $jobChangeFactory = new JobChangeFactory();

        $objPendingJobChange = $jobChangeFactory->getPendingChangeByJob($objJob);

        $html = '';

        if($objPendingJobChange){
            $fields = json_decode($objPendingJobChange->getFormData(),1);
            foreach ($arrJobRequirementType as $objJobRequirementType) {

                $i = 0;
                if (isset($fields['jobRequirements'][$objJobRequirementType->getViewKey()]) && !empty($fields['jobRequirements'][$objJobRequirementType->getViewKey()])) {
                    $relevantData = $fields['jobRequirements'][$objJobRequirementType->getViewKey()];
                    foreach ($relevantData as $requirement) {
                        $view = 'employer/jobs/partials/' . $objJobRequirementType->getViewKey() . '_field';
                        if (view()->exists($view)) {
                            $html .= Layout::getJobRequirementItemHtml($objJobRequirementType, $i, $requirement);
                        }
                        $i++;
                    }
                }
            }
        }
        else {
            foreach ($arrJobRequirementType as $objJobRequirementType) {
                $relevantData = $jobRequirementData[$objJobRequirementType->getViewKey()];
                $i = 0;
                if (isset($relevantData) && !empty($relevantData->get())) {
                    foreach ($relevantData->get()->toArray() as $requirement) {
                        $view = 'employer/jobs/partials/' . $objJobRequirementType->getViewKey() . '_field';
                        if (view()->exists($view)) {
                            $html .= Layout::getJobRequirementItemHtml($objJobRequirementType, $i, $requirement);
                        }
                        $i++;
                    }
                }
            }
        }

        $this->ajaxResponse('success', '', ['view' => $html]);

    }

    /**
     * @param Request $request
     * @return void
     */
    public function getRequirementLayout(Request $request){

        $post = $request->post();

        $validator = Validator::make($post, [
            'type' => 'required',
            'iterator' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $this->ajaxResponse('error', $validator->getMessageBag()->getMessages()['name'][0]);
        }

        $jobRequirementTypeFactory = new JobRequirementTypeFactory();
        $objJobRequirementType = $jobRequirementTypeFactory->getById($post['type']);

        if(!$objJobRequirementType){
            $this->ajaxResponse('error', 'Invalid Job Requirement Type');
        }

        $view = 'employer/jobs/partials/'.$objJobRequirementType->getViewKey().'_field';

        if(view()->exists($view)){

            $this->ajaxResponse('success', '', ['view' => Layout::getJobRequirementItemHtml($objJobRequirementType, $post['iterator'])]);
        }
        else{
            $this->ajaxResponse('error', 'There was an error getting the layout for the selected requirement type.');
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getVideoLayout(Request $request){
        $post = $request->post();

        $validator = Validator::make($post, [
            'iterator' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $this->ajaxResponse('error', $validator->getMessageBag()->getMessages()['name'][0]);
        }

        $this->ajaxResponse('success', '', ['view' => view('companies/video_layout', ['data' => [], 'iterator' => intval($post['iterator']), 'videoNum' => $post['iterator']+1])->render()]);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getVideoDetails(Request $request)
    {
        $post = $request->post();

        $validator = Validator::make($post, [
            'url' => ['required', new YoutubeOrVimeoUrl()],
        ]);

        if ($validator->fails()) {
            $this->ajaxResponse('error', $validator->getMessageBag()->getMessages()['name'][0]);
        }

        $videoData = Video::getVideoDetails($post['url']);

        if(empty($videoData)){
            $this->ajaxResponse('error', trans('messages.company.video_fetch_error'));
        }

        $this->ajaxResponse('success', '', $videoData);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getCompanySiteLayout(Request $request){

        $post = $request->post();

        $validator = Validator::make($post, [
            'iterator' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $this->ajaxResponse('error', $validator->getMessageBag()->getMessages()['name'][0]);
        }

        $this->ajaxResponse('success', '', ['view' => view('companies/site_layout', ['data' => [], 'iterator' => intval($post['iterator'])])->render()]);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getCompanyAwardLayout(Request $request){

        $post = $request->post();

        $validator = Validator::make($post, [
            'iterator' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $this->ajaxResponse('error', $validator->getMessageBag()->getMessages()['name'][0]);
        }

        $this->ajaxResponse('success', '', ['view' => view('companies/award_layout', ['data' => [], 'isEdit' => false, 'iterator' => intval($post['iterator'])])->render()]);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getCompanyGalleryLayout(Request $request){

        $post = $request->post();

        $validator = Validator::make($post, [
            'iterator' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $this->ajaxResponse('error', $validator->getMessageBag()->getMessages()['name'][0]);
        }

        $this->ajaxResponse('success', '', ['view' => view('companies/gallery_layout', ['data' => [], 'isEdit' => false, 'iterator' => intval($post['iterator'])])->render()]);
    }
}
