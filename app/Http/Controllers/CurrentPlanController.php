<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; 
use Validator;
use App\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CurrentPlanController extends Controller
{
    public function getCurrentSubsPlan()
    {
        $user = Auth::user();
        $id=$user->user_id;
        $subscription_details=DB::table('subscription')
        ->select('sub_start_date','sub_end_date','subs_status','user_id')
        ->where("user_id", "=",$id)
        ->get();

        foreach($subscription_details as $user_subscription_details)
        {
          $user_subscription_details_array['sub_start_date']=$user_subscription_details->sub_start_date;
          $user_subscription_details_array['sub_end_date']=$user_subscription_details->sub_end_date;
          $user_subscription_details_array['subs_status']=$user_subscription_details->subs_status;
          $user_subscription_details_array['user_id']=$user_subscription_details->user_id;
        }
        $plan_details=DB::table('subscription')
      ->select('subscription.plan_id','plan.plan_name','plan.plan_description','plan.time_period_months','plan.actual_price','plan.discount_price','plan.is_hd_available','plan.is_uhd_available','plan.can_download','plan.number_of_device')
      ->join('plan','plan.plan_id','=','subscription.plan_id')
      ->where("subscription.user_id", "=",$id)
      ->get();

      foreach($plan_details as $user_plan_details){
        $user_plan_details_array['plan_id']=$user_plan_details->plan_id;
        $user_plan_details_array['plan_name']=$user_plan_details->plan_name;
        $user_plan_details_array['plan_description']=$user_plan_details->plan_description;
        $user_plan_details_array['time_period_months']=$user_plan_details->time_period_months;
        $user_plan_details_array['actual_price']=$user_plan_details->actual_price;
        $user_plan_details_array['discount_price']=$user_plan_details->discount_price;
        $user_plan_details_array['is_hd_available']=boolval($user_plan_details->is_hd_available);
        $user_plan_details_array['is_uhd_available']=boolval($user_plan_details->is_uhd_available);
        $user_plan_details_array['can_download']=boolval($user_plan_details->can_download);
        $user_plan_details_array['number_of_device']=$user_plan_details->number_of_device;


      }
      $user_plan_status=DB::table('subscription')
      ->select('subscription.sub_id')
      ->join('plan','plan.plan_id','=','subscription.plan_id')
      ->where("subscription.user_id", "=",$id)
      ->get();

      return response()->json(['subscription' =>$user_subscription_details_array,'plan'=>$user_plan_details_array,'status'=>$user_plan_status]);

    }
}
