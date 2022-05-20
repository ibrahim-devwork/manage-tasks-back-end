<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as FacadesRequest;

class DropDownActionsnController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try{
            if(Helper::isSuperAdmin() || Helper::isAdmin())
                return Action::all(['id', 'action']);
        
            return  response()->json(['message' => 'Unauthorized action.'], 403);

        }catch(\Exception $errors){
            Log::error("Error *__invoke DropDownActionsnController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }
}
