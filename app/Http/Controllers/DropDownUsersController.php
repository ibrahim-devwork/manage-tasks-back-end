<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as FacadesRequest;

class DropDownUsersController extends Controller
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
                return User::whereIn('id_role', [2,3])->get(['id', 'username']);
        
            return  response()->json(['message' => 'Unauthorized action.'], 403);

        }catch(\Exception $errors){
            Log::error("Error *__invoke DropDownUsersController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }
}
