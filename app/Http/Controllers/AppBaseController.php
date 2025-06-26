<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Factories\CandidateFactory;
use App\Models\Factories\CompanyFactory;
use App\Utils\ResponseUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function isCandidate(){
       return Auth::user()->hasRole('Candidate');
    }

    public function isAdmin(){
        return Auth::user()->hasRole('Admin');
    }

    public function isCompany(){
        return Auth::user()->hasRole('Employer');
    }

    /**
     * @return mixed|Candidate
     */
    public function getCandidate(){
        return (new CandidateFactory())->getByUser(Auth::user());
    }

    public function getCompany(){
        return (new CompanyFactory())->getObjByUser(Auth::user());
    }

    public function sendResponse($result, $message = 'success')
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 422)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message,
        ], 200);
    }
    /**
     * method for the standardisation of ajax responses
     *
     * @param string $strStatus
     * @param string|null $strMessage
     * @param array $arrData
     */
    protected function ajaxresponse(string $strStatus, string $strMessage = null, array $arrData = [])
    {
        switch ($strStatus) {
            case "error":
                $inStatus = 0;
                $strMessage = ($strMessage) ? $strMessage : 'There was an error with your request';
                break;
            case "success":
                $inStatus = 1;
                $strMessage = ($strMessage) ? $strMessage : 'Your request was successful';
                break;
            case "no-permission":
                $inStatus = 2;
                $strMessage = ($strMessage) ? $strMessage : 'You do not have permission to make this request';
                break;
            default:
                $inStatus = 0;
                $strMessage = ($strMessage) ? $strMessage : 'There was an error with your request';
        }

        echo json_encode(['status' => $inStatus, 'message' => $strMessage, 'data' => $arrData]);
        exit;
    }

    /**
     * @param string $strStatus
     * @param string|null $strMessage
     * @param array $arrData
     * @return JsonResponse
     */
    protected function jsonResponse(string $strStatus, string $strMessage = null, array $arrData = []): JsonResponse
    {
        switch ($strStatus) {
            case "error":
                $inStatus = 0;
                $strMessage = ($strMessage) ? $strMessage : 'A feladat elvégzése során hiba lépett fel';
                break;
            case "success":
                $inStatus = 1;
                $strMessage = ($strMessage) ? $strMessage : 'A kérés sikeres volt';
                break;
            case "no-permission":
                $inStatus = 2;
                $strMessage = ($strMessage) ? $strMessage : 'Nincs meg a szükséges jogosultsága a feladat elvégzéséhez';
                break;
            default:
                $inStatus = 0;
                $strMessage = ($strMessage) ? $strMessage : 'A feladat elvégzése során hiba lépett fel';
        }

        return response()->json(["status" => $inStatus, "message" => $strMessage,'data' => $arrData]);
    }

}
