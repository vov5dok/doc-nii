<?php

namespace App\Policies;

use App\Models\MoonshineUser;
use App\Models\Statement;
use App\Models\StatementStatus;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class StatementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param MoonshineUser $moonshineUser
     * @return Response|bool
     */
    public function viewAny(MoonshineUser $moonshineUser)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param MoonshineUser $moonshineUser
     * @param Statement $statement
     * @return Response|bool
     */
    public function view(MoonshineUser $moonshineUser, Statement $statement)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param MoonshineUser $moonshineUser
     * @return Response|bool
     */
    public function create(MoonshineUser $moonshineUser): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param MoonshineUser $moonshineUser
     * @param Statement $statement
     * @return Response|bool
     */
    public function update(MoonshineUser $moonshineUser, Statement $statement): Response|bool
    {
        return match (true){
            $moonshineUser->hasAnyRole(['participant']) => false,
            $moonshineUser->hasAnyRole(['applicant']) && $statement->history()->whereIn('statement_status_id', [StatementStatus::UNDER_CONSIDERATION, StatementStatus::TAKEN_INTO_CONSIDERATION])->exists() => false,
            default => true,
        };
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param MoonshineUser $moonshineUser
     * @param Statement $statement
     * @return Response|bool
     */
    public function delete(MoonshineUser $moonshineUser, Statement $statement)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param MoonshineUser $moonshineUser
     * @param Statement $statement
     * @return Response|bool
     */
    public function restore(MoonshineUser $moonshineUser, Statement $statement)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param MoonshineUser $moonshineUser
     * @param Statement $statement
     * @return Response|bool
     */
    public function forceDelete(MoonshineUser $moonshineUser, Statement $statement)
    {
        //
    }
}
