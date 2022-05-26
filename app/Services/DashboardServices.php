<?php

namespace App\Services;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class DashboardServices
{
    public function filterDashboard($query, $filter)
    {
        $user = Auth::user();
        
        if(isset($filter['search']) && $filter['search'] != "" ) {
            $query = $query->search($filter['search']);
        }

        $count_per_page = Helper::count_per_page;
        if(isset($filter['count_per_page']) && $filter['count_per_page'] > 0 ) {
            $count_per_page = $filter['count_per_page'];
        }

        return $query->whereHas('tasks_users', function (Builder $query) {
            $user = Auth::user();
            $query->where('id_user', '=', $user->id);
        })->orderBy('created_at', 'DESC')->paginate($count_per_page);
    }
}
?>