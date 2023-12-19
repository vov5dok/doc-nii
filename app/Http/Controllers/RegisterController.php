<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Mail\VerifyMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\MoonshineUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function create(RegisterRequest $request)
    {

        $data = $request->validated();

        $user = MoonshineUser::create([
            'email'                      => $data['email'],
            'name'                       => $data['name'],
            'password'                   => Hash::make($data['password']),
            'second_name'                => $data['second_name'],
            'last_name'                  => $data['last_name'],
            'organization_id'            => $data['organization'] === '0' ? null : $data['organization'],
            'data_processing_permission' => $data['data_processing_permission'],
            'position'                   => $data['position'],
            'phone'                      => $data['phone'],
            'phone_additional'           => $data['phone_additional'],
            'moonshine_user_role_id'     => MoonshineUser::ROLE_ID_INACTIVE,
            'verify_token'               => Str::random(),
        ]);

        Mail::to($user->email)->send(new VerifyMail($user));

        return response()->json(
            ['success' => 'На указанный e-mail отправлено письмо для подтверждения почтового адреса. Тема письма «МГЭК. Регистрация пользователя». Если не найдете письмо в папке «Входящие», то проверьте папку «Спам». Следуйте инструкции в письме.']
        );
    }

    public function verify(string $token): RedirectResponse|JsonResponse
    {
        $result = MoonshineUser::where('verify_token', $token)->update([
            'moonshine_user_role_id' => MoonshineUser::ROLE_ID_APPLICANT,
            'verify_token'           => null,
            'email_verified_at'      => Carbon::now(),
        ]);

        if (0 === $result) {
            return response()->json(['message' => 'Ваша ссылка недействительна.'], 422);
        }

        return redirect()->route('home');
    }
}
