<?php 

namespace App\Repository\Tasks;

use App\Repository\AllFnCrudInterfaces\CrudInterface;

interface InterfaceTaskRepository extends CrudInterface {
    public function changeStatut($id, $data);
}
?>