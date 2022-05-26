<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repository\DashboardRepository;
use App\Http\Resources\DashboardResource;
use Illuminate\Support\Facades\Request as FacadesRequest;

class DashboardController extends Controller
{
    protected $dashboardRepository;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function getByFilter(Request $request)
    {
        try{
            $filter = $request->only('search', 'count_per_page');
            return DashboardResource::collection($this->dashboardRepository->getByFilter($filter));
        }catch(\Exception $errors){
            Log::error("Error *getByFilter DashboardController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }
}
