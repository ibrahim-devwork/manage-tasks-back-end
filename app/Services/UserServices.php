<?php

namespace App\Services;

use App\Enums\PaginationEnum;
use App\Helpers\Helper;

class UserServices
{
    public function filterUsers($query, $filter)
    {
        if(isset($filter['search']) && $filter['search'] != "" ){
            $query = $query->search($filter['search']);
        }

        $count_per_page = PaginationEnum::Count_per_page;
        if(isset($filter['count_per_page']) && $filter['count_per_page'] > 0 ){
            $count_per_page = $filter['count_per_page'];
        }

        return $query->whereIn('id_role', [2, 3])->with('allowed_actions')->orderBy('created_at', 'DESC')->paginate($count_per_page);
    }
}
?>