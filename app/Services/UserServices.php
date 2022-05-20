<?php

namespace App\Services;

use App\Helpers\Helper;

class UserServices
{
    public function filterUsers($query, $filter)
    {
        if(isset($filter['search']) && $filter['search'] != "" ){
            $query = $query->search($filter['search']);
        }

        $count_per_page = Helper::count_per_page;
        if(isset($filter['count_per_page']) && $filter['count_per_page'] > 0 ){
            $count_per_page = $filter['count_per_page'];
        }

        return $query->where('id_role', 2)->orderBy('created_at', 'DESC')->paginate($count_per_page);
    }
}
?>