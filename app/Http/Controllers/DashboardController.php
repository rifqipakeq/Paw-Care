<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Donatur;
use App\Models\Fundraiser;
use App\Models\Fundraising;
use App\Models\FundraisingiWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function apply_fundraiser(){

        $user = Auth::user();

        DB::transaction(function () use ($user) {
            $validated['user_id'] = $user->id;
            $validated['is_active'] = false;

            Fundraiser::create($validated);
        });

        return redirect()->route('admin.fundraisers.index');
    }

    public function my_withdrawals(){
        $user = Auth::user();
        $fundraiserId = $user->fundraiser->id;

        $withdrawals = FundraisingiWithdrawal::where('fundraiser_id', $fundraiserId)->orderByDesc('id')->get();

        return view('admin.my_withdrawals.index', compact('withdrawals'));
    }

    public function my_withdrawals_details(FundraisingiWithdrawal $fundraisingiWithdrawal){
        return view('admin.my_withdrawals.details', [
            'fundraisingWithdrawal' => $fundraisingiWithdrawal
        ]);
    }


    public function index(){
        $user = Auth::user();

        $fundraisingiQuery = Fundraising::query();
        $withdrawalsQuery = FundraisingiWithdrawal::query();
        
        if($user->hasRole('Fundraiser')){
            $fundraiserId = $user->fundraiser->id;

            $fundraisingiQuery->where('fundraiser_id',$fundraiserId);
            $withdrawalsQuery->where('fundraiser_id',$fundraiserId);

            $fundraisingIds = $fundraisingiQuery->pluck('id');

            $donaturs = Donatur::whereIn('fundraising_id', $fundraisingIds)
            ->where('is_paid',true)
            ->count();
        } else {
            $donaturs = Donatur::where('is_paid', true)
            ->count();

        }
        $fundraisings = $fundraisingiQuery->count();
        $withdrawals = $withdrawalsQuery->count();
        $categories = Category::count();
        $fundraisers = Fundraiser::count();

        return view('dashboard', compact('donaturs','fundraisings','categories','withdrawals','fundraisers'));
    }
}