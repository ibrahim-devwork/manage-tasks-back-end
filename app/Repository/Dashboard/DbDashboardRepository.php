<?php

namespace App\Repository\Dashboard;

use App\Models\Task;
use App\Services\DashboardServices;

class DbDashboardRepository implements InterfaceDashboardRepository{

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
