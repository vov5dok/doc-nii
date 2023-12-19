<?php

namespace App\Policies;

use App\Models\MoonshineUser;
use App\Models\StatementFile;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatementFilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\MoonshineUser  $moonshineUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(MoonshineUser $moonshineUser)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\MoonshineUser  $moonshineUser
     * @param  \App\Models\StatementFile  $statementFile
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(MoonshineUser $moonshineUser, StatementFile $statementFile)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\MoonshineUser  $moonshineUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(MoonshineUser $moonshineUser)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\MoonshineUser  $moonshineUser
     * @param  \App\Models\StatementFile  $statementFile
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(MoonshineUser $moonshineUser, StatementFile $statementFile)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\MoonshineUser  $moonshineUser
     * @param  \App\Models\StatementFile  $statementFile
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(MoonshineUser $moonshineUser, StatementFile $statementFile)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\MoonshineUser  $moonshineUser
     * @param  \App\Models\StatementFile  $statementFile
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(MoonshineUser $moonshineUser, StatementFile $statementFile)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\MoonshineUser  $moonshineUser
     * @param  \App\Models\StatementFile  $statementFile
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(MoonshineUser $moonshineUser, StatementFile $statementFile)
    {
        //
    }
}
