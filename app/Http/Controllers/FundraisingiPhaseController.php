<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFundraisingPhaseRequest;
use App\Models\Fundraising;
use App\Models\FundraisingiPhase;
use App\Models\FundraisingiWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FundraisingiPhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundraisingPhaseRequest $request, Fundraising $fundraising)
    {
        //
        DB::transaction(function () use ($request, $fundraising){
            
            $validated = $request->validated();

            if($request->hasFile('photo')){
                $photoPath = $request->file('photo')->store('photos','public');
                $validated['photo'] = $photoPath;
            } 

            $validated['fundraising_id']  = $fundraising->id;

            $fundraisingPhase = FundraisingiPhase::create($validated);

            $withdrawalToUpdate = FundraisingiWithdrawal::where('fundraising_id', $fundraising->id)
            ->latest()
            ->first();

            $withdrawalToUpdate->update(['has_received' => true]);

            $fundraising->update(['has_finished' => true]);

        });

        return redirect()->route('admin.my-withdrawals');
    }

    /**
     * Display the specified resource.
     */
    public function show(FundraisingiPhase $fundraisingiPhase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FundraisingiPhase $fundraisingiPhase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FundraisingiPhase $fundraisingiPhase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FundraisingiPhase $fundraisingiPhase)
    {
        //
    }
}
