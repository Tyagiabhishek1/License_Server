<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; 
use Validator;
use App\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class PlanListController extends Controller
{
    public function getplanlist()
    {
        $user = Auth::user();
        $get_plan_list=DB::table('plan')
      ->select('plan.plan_id','plan.plan_name','plan.plan_description','plan.time_period_months','plan.actual_price','plan.discount_price','plan.is_hd_available','plan.is_uhd_available','plan.number_of_device','plan.can_download')
      ->get();
      return response()->json(['plan' =>$get_plan_list]);
}
}