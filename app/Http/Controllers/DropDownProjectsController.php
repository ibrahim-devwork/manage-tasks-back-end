<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class DropDownProjectsController extends Controller
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
            if(Helper::isSuperAdmin())
                return Project::all(['id', 'name']);
            
            if(Helper::isAdmin())
                return Project::where('id_user', Auth::user()->id)->get(['id', 'name']);
            
            return  response()->json(['message' => 'Unauthorized action.'], 403);

        }catch(\Exception $errors){
            Log::error("Error *__invoke DropDownProjectsController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }
}
