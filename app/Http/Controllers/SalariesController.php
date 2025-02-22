<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\salaries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalariesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salaries = salaries::orderby('id', 'desc')->get();
        $accounts = accounts::business()->get();
        return view('Finance.salary.index', compact('salaries', 'accounts'));
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
    public function store(Request $request)
    {
        try
        {
            DB::beginTransaction();
            $ref = getRef();
            salaries::create(
                [
                    'accountID' => $request->accountID,
                    'name' => $request->name,
                    'designation' => $request->designation,
                    'month' => $request->month,
                    'amount' => $request->amount,
                    'date' => $request->date,
                    'notes' => $request->notes,
                    'refID' => $ref,
                ]
            );

            createTransaction($request->accountID, $request->date, 0, $request->amount, "Salary of $request->name for the month of $request->month", $ref);

            DB::commit();
            return back()->with('success', 'Salary Saved');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(salaries $salaries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(salaries $salaries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, salaries $salaries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(salaries $salaries)
    {
        //
    }
}
