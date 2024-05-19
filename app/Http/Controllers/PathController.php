<?php

namespace App\Http\Controllers;

use App\Models\Path;
use Illuminate\Http\Request;

class PathController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Path::all();
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
    public function show(Path $path)
    {
        return $path;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Path $path)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Path $path)
    {
        //
    }

    public function route($id)
    {
        return Path::where("route_id", $id)->get();
    }
}
