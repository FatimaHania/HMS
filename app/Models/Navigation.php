<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Navigation extends Model
{

    public static function getMenu()
    {

        $hospital_id = session('hospital_id');
        $branch_id = session('branch_id');
        $user_details_arr = session('user_details');
        $user_usergroups_arr = $user_details_arr[$branch_id]['usergroup_id'];

        $query_user_module = DB::table('module_usergroup')
            ->join('modules', 'modules.id', '=', 'module_usergroup.module_id')
            ->select('modules.*')
            ->distinct('modules.id')
            ->whereIn('module_usergroup.usergroup_id', $user_usergroups_arr)
            ->where('modules.isActive','1')
            ->orderBy('modules.sort_order', 'ASC')
            ->get();

        return $query_user_module;

    }

}
