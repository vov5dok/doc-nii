<?php

namespace App\Http\Controllers;

use App\Models\MoonshineUser;
use App\Services\UserActivateService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApplicantsController extends Controller
{
    private const SORT = [
        'created' => 'created_at',
        'fio'     => 'name',
        'org'     => 'organization_id',
        'status'  => 'status'
    ];

    public function index(Request $request)
    {
        $sortBy = self::SORT[$request->query('sort')] ?? '';
        $statuses = $request->query('pick-status') ?? [];
        $users = MoonshineUser::where('verify_token', '=', null)
            ->whereIn(
                'moonshine_user_role_id',
                [MoonshineUser::ROLE_ID_INACTIVE, MoonshineUser::ROLE_ID_APPLICANT] // Исключаем пользователей с moonshine_user_role_id = 1
            )
            ->when(in_array(MoonshineUser::STATUS_ID_NEW ?? [], $statuses), function (Builder $query) use ($statuses) {
                $query->orWhere(function ($query) {
                    $query->where('active', '=', false)
                        ->where('deactivation_date', '=', null)
                        ->where('description_rejection', '=', null)
                        ->where('moonshine_user_role_id', '<>', MoonshineUser::ROLE_ID_ADMIN);
                });
            })
            ->when(in_array(MoonshineUser::STATUS_ID_CONFIRMED ?? [], $statuses), function (Builder $query) use ($statuses) {
                $query->orWhere(function ($query) {
                    $query->where('active', '=', true)
                        ->where('deactivation_date', '=', null)
                        ->where('description_rejection', '=', null)
                        ->where('moonshine_user_role_id', '<>', MoonshineUser::ROLE_ID_ADMIN);
                });
            })
            ->when(in_array(MoonshineUser::STATUS_ID_REFUSED ?? [], $statuses), function (Builder $query) use ($statuses) {
                $query->orWhere(function ($query) {
                    $query->where('active', '=', false)
                        ->where('deactivation_date', '=', null)
                        ->where('description_rejection', '<>', null)
                        ->where('moonshine_user_role_id', '<>', MoonshineUser::ROLE_ID_ADMIN);
                });
            })
            ->when(in_array(MoonshineUser::STATUS_ID_DEACTIVATE ?? [], $statuses), function (Builder $query) use ($statuses) {
                $query->orWhere(function ($query) {
                    $query->where('active', '=', false)
                        ->where('deactivation_date', '<>', null)
                        ->where('description_rejection', '=', null)
                        ->where('moonshine_user_role_id', '<>', MoonshineUser::ROLE_ID_ADMIN);
                });
            })
            ->when(in_array($sortBy, ['created_at', 'name']) ?? false, function (Builder $query) use ($sortBy) {
                $query->orderByDesc($sortBy);
            })
            ->when($sortBy === 'organization_id', function (Builder $query) {
                $query
                    ->select('moonshine_users.organization_id')
                    ->join('organizations', 'organizations.id', '=', 'moonshine_users.organization_id')
                    ->select('organizations.*')
                    ->orderBy('organizations.name', 'DESC');
            })
            ->when($sortBy === '', function (Builder $query) {
                $query->orderByDesc('id');
            })
            ->select(
                'moonshine_users.id',
                'moonshine_users.created_at',
                'active',
                'organization_id',
                'moonshine_users.name',
                'second_name',
                'last_name',
                'verify_token',
                'description_rejection',
                'deactivation_date',
                'moonshine_user_role_id'
            )
            ->when($request->query('q'), function (Builder $query, $q) {
                $q = explode(' ', $q);
                array_walk($q, function ($searchElem) use ($query) {
                    $query
                        ->where('name', 'like', '%' . $searchElem . '%')
                        ->orWhere('last_name', 'like', '%' . $searchElem . '%')
                        ->orWhere('second_name', 'like', '%' . $searchElem . '%');
                });
            })
            ->paginate(20)
            ->appends(
                [
                    'q'           => $request->query('q'),
                    'sort'        => $request->query('sort'),
                    'pick-status' => $request->query('pick-status')
                ]
            );
        return view('profile.applicants.list', ['users' => $users]);
    }

    public function show(int $id): View|Factory|string|Application
    {
        $userInfo = MoonshineUser::where('id', '=', $id)
            ->select(
                'moonshine_users.id',
                'moonshine_users.created_at',
                'active',
                'organization_id',
                'moonshine_users.name',
                'second_name',
                'last_name',
                'verify_token',
                'description_rejection',
                'deactivation_date',
                'phone',
                'phone_additional',
                'position',
                'email'
            )
            ->where('verify_token', '=', null)
            ->whereIn(
                'moonshine_user_role_id',
                [MoonshineUser::ROLE_ID_INACTIVE, MoonshineUser::ROLE_ID_APPLICANT]
            )
            ->firstOrFail();
        if (!$userInfo) {
            return route('applicants.list');
        }
        return view('profile.applicants.item', ['user' => $userInfo]);
    }

    public function verify(int $id)
    {
        $user = new MoonshineUser();
        $user->verifyUser($id, 'id');
        return redirect()
            ->route('applicants.list');
    }

    public function activate(int $id, UserActivateService $userActivateService): RedirectResponse
    {
        $userActivateService->activate($id);
        return redirect()->route('applicants.list');
    }

    public function deactivate(int $id)
    {
        $user = new MoonshineUser();
        $user->deactivateUser($id, 'id');
        return redirect()
            ->route('applicants.list');
    }

    public function renew(int $id)
    {
        MoonshineUser::whereId($id)->renew();
        return redirect()
            ->route('applicants.list');
    }

    public function reject(Request $request)
    {
        $data = $request->all();
        $user = new MoonshineUser();
        $user->rejectUser($data['user_id'], $data['reject-text'], 'id');
        return response()->json(
            ['success' => 'Деактивация пользователя совершена.']
        );
    }

}
