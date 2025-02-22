<?php

namespace App\Http\Controllers;

use App\Models\assets;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = assets::all();

        return view('assets.index', compact('assets'));
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
        assets::create($request->all());
        return back()->with('success', 'Asset Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(units $units)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(units $units)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $asset = assets::find($id);
        $asset->update($request->only('name', 'location', 'qty'));
        return back()->with('success', "Asset Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
