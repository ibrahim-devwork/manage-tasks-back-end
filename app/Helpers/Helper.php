<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class Helper
{
    // Constants
    const count_per_page    = 10;

    const SUPER_ADMIN_ROLE  = 'Super admin';
    const ADMIN_ROLE        = 'Admin';
    const USER_ROLE         = 'User';


    // Functions
    public static function isSuperAdmin()
    {
        $user = Auth::user();
        return $user->role->role == Helper::SUPER_ADMIN_ROLE;
    }

    public static function isAdmin()
    {
        $user = Auth::user();
        return $user->role->role == Helper::ADMIN_ROLE;
    }

    public static function isUser()
    {
       $user = Auth::user();
        return $user->role->role == Helper::USER_ROLE;
    }

     public static function saveFile($image, $folder_name = '') {
        if(isset($image) && is_file($image)) {
            $imageName  = now()->format('Ymd-His-u-') . Str::random(3);
            $imageName  = $imageName .'.'. $image->getClientOriginalExtension();
            if($folder_name) {
                $destinationPath = public_path('images/'. $folder_name .'/');
            } else {
                $destinationPath = public_path('images/');
            }
            $image->move($destinationPath, $imageName);
            return $imageName;
        }

        return null;
    }

}
