<?php

namespace App\Http\Controllers;

use App\Models\HealthPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $healthPlans = HealthPlan::where('user_id', $user_id)->get();
        return view('reports', compact('healthPlans'));
    }

    public function getPlanDetails(Request $request)
    {
        $plan_id = $request->plan_id;
        $healthPlan = HealthPlan::find($plan_id);
        
        if ($healthPlan && $healthPlan->user_id == Auth::id()) {
            return response()->json([
                'plan_id' => $healthPlan->id,
                'plan_details' => $healthPlan->plan_details,
                'created_date' => $healthPlan->created_at->format('Y-m-d H:i:s')
            ]);
        }
        
        return response()->json(['error' => 'Plan not found'], 404);
    }
}