<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\MoonshineUser;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MessagePolicy
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
     * @param Message $message
     * @return Response|bool
     */
    public function view(MoonshineUser $moonshineUser, Message $message): Response|bool
    {
        if ($moonshineUser->hasAnyRole(['applicant'])){
            return !$message->moonshineUser->hasAnyRole(['participant']);
        }
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param MoonshineUser $moonshineUser
     * @return Response|bool
     */
    public function create(MoonshineUser $moonshineUser)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param MoonshineUser $moonshineUser
     * @param Message $message
     * @return Response|bool
     */
    public function update(MoonshineUser $moonshineUser, Message $message)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param MoonshineUser $moonshineUser
     * @param Message $message
     * @return Response|bool
     */
    public function delete(MoonshineUser $moonshineUser, Message $message)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param MoonshineUser $moonshineUser
     * @param Message $message
     * @return Response|bool
     */
    public function restore(MoonshineUser $moonshineUser, Message $message)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param MoonshineUser $moonshineUser
     * @param Message $message
     * @return Response|bool
     */
    public function forceDelete(MoonshineUser $moonshineUser, Message $message)
    {
        //
    }
}
