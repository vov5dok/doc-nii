<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeAvatarRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileEditFormRequest;
use App\Models\Organization;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(): Factory|View|Application
    {
        $userOrganizationID = auth('moonshine')->user()->organization_id;
        $organizations = Organization::all('id', 'name');
        return view(
            'profile.index',
            ['organizations' => $organizations, 'user_organization_id' => $userOrganizationID]
        );
    }

    public function changeProfile(ProfileEditFormRequest $request): JsonResponse
    {
        $user = auth('moonshine')
            ->user();

        $dataUpdate = [
            'second_name' => $request->second_name,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'password' => auth('moonshine')->user()->getAuthPassword()
        ];

        if ($request->email) {
            $dataUpdate['email'] = $request->email;
        }

        if (!$user->hasAnyRole(['participant', 'employee'])) {
            $dataUpdate['position'] = $request->position;
            $dataUpdate['organization_id'] = $request->organization;
        }

        $update = $user->update($dataUpdate);
        return $update
            ? response()->json()
            : response()->json(['message' => 'Ошибка отправки формы, попробуйте перезагрузить страницу.'], 422);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $newPassword = $request->new_password;
        $user = auth('moonshine')
            ->user()
            ->update(['password' => Hash::make($newPassword)]);
        return $user
            ? response()->json()
            : response()->json(['message' => 'Неправильный логин или пароль.'], 422);
    }

    public function changeAvatar(ChangeAvatarRequest $request): JsonResponse
    {
        if (!$request->hasFile('avatar')) {
            return response()->json(['message' => 'Ошибка сохранения, попробуйте перезагрузить страницу.'], 422);
        }

        $user = auth('moonshine')
            ->user();
        $avatar = $request->file('avatar');
        $path = $avatar->store('avatars/'. $user->id, 'public');
        $user->avatar = $path;
        return $user->save()
            ? response()->json(['path' => $path])
            : response()->json(['message' => 'Ошибка сохранения, попробуйте перезагрузить страницу.'], 422);;
    }
}
