<?php

namespace App\Services;

use App\Enums\PaginationEnum;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class TaskServices
{
    public function filterTasks($query, $filter)
    {
        $user = Auth::user();
        if(Helper::isAdmin()){
            $query = $query->where('id_user', $user->id);
        }
        
        if(isset($filter['id_project']) && $filter['id_project'] > 0) {
            $query = $query->where('id_project', $filter['id_project']);
        }

        if(isset($filter['statut']) && $filter['statut'] > 0) {
            $query = $query->where('statut', $filter['statut']);
        }

        if(isset($filter['search']) && $filter['search'] != "" ) {
            $query = $query->search($filter['search']);
        }

        $count_per_page = PaginationEnum::Count_per_page;
        if(isset($filter['count_per_page']) && $filter['count_per_page'] > 0 ) {
            $count_per_page = $filter['count_per_page'];
        }

        return $query->with('tasks_users')->orderBy('created_at', 'DESC')->paginate($count_per_page);
    }
}
?>