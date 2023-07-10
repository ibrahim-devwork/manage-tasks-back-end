<?php 

namespace App\Repository\Profile;

interface InterfaceProfileRpository {

    public function getProfile();
    public function changeInfos($data);
    public function changeEmail($data);
    public function changeUsername($data);
    public function changePassword($data);
    
}
?>