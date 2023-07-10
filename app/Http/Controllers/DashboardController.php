<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\DashboardResource;
use App\Repository\Dashboard\InterfaceDashboardRepository;
use Illuminate\Support\Facades\Request as FacadesRequest;

class DashboardController extends Controller
{
    protected $interfaceDashboardRepository;

    public function __construct(InterfaceDashboardRepository $interfaceDashboardRepository)
    {
        $this->interfaceDashboardRepository = $interfaceDashboardRepository;
    }

    public function getByFilter(Request $request)
    {
        try{
            $filter = $request->only('search', 'count_per_page');
            return DashboardResource::collection($this->interfaceDashboardRepository->getByFilter($filter));
        }catch(\Exception $errors){
            Log::error("Error *getByFilter DashboardController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }
}
