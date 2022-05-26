<?php

namespace App\Repository;

use App\Helpers\Helper;
use App\Models\Task;
use App\Services\DashboardServices;
use Illuminate\Support\Facades\Auth;

class DashboardRepository {

    protected $task;
    protected $dashboardServices;

    public function __construct(Task $task, DashboardServices $dashboardServices)
    {
        $this->task               = $task;
        $this->dashboardServices  = $dashboardServices;
    }

    public function getByFilter($filter)
    {
        return $this->dashboardServices->filterDashboard($this->task, $filter);
    }
}
?>
