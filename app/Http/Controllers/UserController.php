<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Mail;
use App\Mail\User\AfterRegister;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.user.login');
    }

    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            DB::beginTransaction();

            $callback = Socialite::driver('google')->stateless()->user();

            $data = [
                'name' => $callback->getName(),
                'email' => $callback->getEmail(),
                'avatar' => $callback->getAvatar(),
                'email_verified_at' => date('Y-m-d H:i:s', time()),
            ];

            $user = User::where(['email' => $data['email']])->first();

            if (empty($user)) {
                $user = User::create($data);
                Mail::to($user->email)->send(new AfterRegister($user));
            }

            Auth::login($user, true);
            DB::commit();
            return redirect()->route('welcome');
        } catch (Exception $error) {
            DB::rollBack();

            dd( 'error', $error );
        }
    }
}
