<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; 
use Validator;
use App\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UpgradePlanController extends Controller
{
    public function upgradeplan(Request $request)
    {   $user = Auth::user();
        $dt =now();
        $validator = Validator::make($request->all(), [ 
            'user_id' => 'required|numeric',
            'plan_id'=>'required|numeric', 
  ]);   
if ($validator->fails()) {          
     return response()->json(['error'=>$validator->errors()], 401);  
}  
    $input = $request->all(); 
    $id=$user->user_id;
    $upgrade_plan['user_id']=$input['user_id'];
    $upgrade_plan['plan_id']=$input['plan_id'];
    $new_plan_id=$input['plan_id'];
    $upgrade_plan['sub_start_date']=$dt;
    $sql="select plan_id,plan_name,actual_price,discount_price from plan where plan_id=$new_plan_id";
    $user_new_plan = DB::select($sql);
   
   foreach ($user_new_plan as $user_new_plan) {
                
      $plan_name= $user_new_plan->plan_name;
      $actual_price= $user_new_plan->actual_price;
      $plan_id= $user_new_plan->plan_id;
      $discount_price= $user_new_plan->discount_price;



   }
   DB::table('subscription')
   ->where('user_id',$id)
   ->update(array('plan_id'=>$plan_id,'sub_start_date'=>$dt,'actual_price'=>$actual_price,'discount_price'=>$discount_price));
    $response = array("code"=>200,'message'=>'Your Plan Has Been Upgraded to '.$plan_name);

      return response()->json(['success' =>$response]); 
    }
}
