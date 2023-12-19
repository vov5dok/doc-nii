<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatementStatusRequest;
use App\Http\Requests\UpdateStatementStatusRequest;
use App\Models\StatementStatus;

class StatementStatusController extends Controller
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
     * @param  \App\Http\Requests\StoreStatementStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatementStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StatementStatus  $statementStatus
     * @return \Illuminate\Http\Response
     */
    public function show(StatementStatus $statementStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StatementStatus  $statementStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(StatementStatus $statementStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatementStatusRequest  $request
     * @param  \App\Models\StatementStatus  $statementStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatementStatusRequest $request, StatementStatus $statementStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatementStatus  $statementStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatementStatus $statementStatus)
    {
        //
    }
}
