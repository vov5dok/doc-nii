<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatementFileRequest;
use App\Http\Requests\UpdateStatementFileRequest;
use App\Models\StatementFile;

class StatementFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStatementFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatementFileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StatementFile  $statementFile
     * @return \Illuminate\Http\Response
     */
    public function show(StatementFile $statementFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StatementFile  $statementFile
     * @return \Illuminate\Http\Response
     */
    public function edit(StatementFile $statementFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatementFileRequest  $request
     * @param  \App\Models\StatementFile  $statementFile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatementFileRequest $request, StatementFile $statementFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatementFile  $statementFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatementFile $statementFile)
    {
        //
    }
}
