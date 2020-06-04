<?php

namespace App\Http\Controllers;

use App\Ban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('welcome');
    }

    public function accountSettings(Request $request)
    {
        $user = $request->user();

        return view('auth.account-settings', [
            'user' => $user
        ]);
    }

    public function accountSettingsUpdate(Request $request)
    {
        $user = $request->user();
        $form = $request->form;

        if ($form === 'password') {
            $request->validate([
                'password' => 'required|min:8',
                'password_confirmation' => 'required'
            ]);

            if ($request->password !== $request->password_confirmation) {
                return back()->withErrors('Passwords must match.');
            }

            $user->update([
                'password' => bcrypt($request->password)
            ]);

            return back()->withSuccess('Password sucessfully updated!');
        } else if ($form === 'email') {
            $request->validate([
                'email' => 'required',
                'email_confirm' => 'required'
            ]);

            if ($request->email !== $request->email_confirm) {
                return back()->withErrors('Emails must match.');
            }

            $user->update([
                'email' => $request->email
            ]);

            return back()->withSuccess('Email sucessfully updated!');
        }
    }

    public function sessionStore(Request $request)
    {
        Validator::make($request->all(), [
            'email' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (Ban::where('email', 'ilike', $value)->exists()) {
                        $fail('This email has been banned');
                    }
                },
            ],
        ])->validate();

        $secret = env('RECAPTCHA_SECRET');
        $remote = $_SERVER['REMOTE_ADDR'];
        $captchaId = $request->input('g-recaptcha-response');

        $responseCaptcha = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $captchaId . '&remoteip=' . $remote));
        $responseCaptcha = $responseCaptcha->success;

        if (!$responseCaptcha) {
            return back()->withErrors('Please check the RECAPTCHA.');
        }

        $request->session()->put('user_email', $request->email);
        $request->session()->put('human', true);
    }
}
