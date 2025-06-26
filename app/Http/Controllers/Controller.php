<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
