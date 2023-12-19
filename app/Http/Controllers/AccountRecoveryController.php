<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRecoveryRequest;
use App\Http\Requests\VerifyRecoveryTokenRequest;
use App\Mail\RecoverMail;
use App\Models\MoonshineUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccountRecoveryController extends Controller
{
    public function create(AccountRecoveryRequest $request)
    {
        $data = $request->validated();
        $user = MoonshineUser::where('email', $data['email'])
            ->first() ?? false;
        if ($user) {
            $user->remember_token = Str::random();
            Mail::to($user->email)
                ->send(new RecoverMail($user));
            $user->save();
            return response()->json(['success' => 'На указанный e-mail отправлено письмо со ссылкой для сброса пароля.']);
        }
        return response()->json();
    }

    public function change(string $token)
    {
        return view('recovery.change', ['token' => $token, 'success' => false]);
    }

    public function verify(VerifyRecoveryTokenRequest $request)
    {
        $data = $request->validated();
        $user = MoonshineUser::where('remember_token', $data['token'])->firstOrFail();
        if ($user) {
            $user->remember_token = null;
            $user->password = Hash::make($data['password']);
            $user->save();
            return view('recovery.change', ['token' => $user->remember_token, 'success' => 'Пароль успешно изменен.']);
        }

        return view('recovery.change', ['token' => $data['token'], 'success' => false]);

    }
}
