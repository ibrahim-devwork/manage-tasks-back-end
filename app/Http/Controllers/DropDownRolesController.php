<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as FacadesRequest;

class DropDownRolesController extends Controller
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
                return Role::whereIn('id', [2,3])->get(['id', 'role']);
        
            return  response()->json(['message' => 'Unauthorized action.'], 403);

        }catch(\Exception $errors){
            Log::error("Error *__invoke DropDownRolesController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }
}
