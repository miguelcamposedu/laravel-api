<?php

namespace App\Http\Controllers;

use App\Models\Secuencia;
use Illuminate\Http\Request;

class SecuenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return Secuencia::all();
        return Secuencia::where('user_id', auth()->id())->get();
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Secuencia $secuencia)
    {
        return response([
            'secuencia' => $secuencia,
            'user' => auth()->user()
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Secuencia $secuencia)
    {
        //
        return $secuencia;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Secuencia $secuencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Secuencia $secuencia)
    {
        //
        return Secuencia::destroy($secuencia->id);
    }
}
