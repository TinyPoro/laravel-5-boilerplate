<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Helpers\Auth\Auth;
use GuzzleHttp\Client;
use Cache;
use Illuminate\Http\Request;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Helpers\Frontend\Auth\Socialite;
use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\Frontend\Auth\UserSessionRepository;

/**
 * Class LoginController.
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('frontend.auth.login')
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    public function login(Request $request)
    {
        $name = $request['name'];
        $pass = $request['password'];

        $client = new Client();
        Cache::forever('name', $name);
        Cache::forever('pass', $pass);
        $response = $client->request(
            'POST',
            'http://127.0.0.1:8080/',
//            'http://vnp.idist.me:81/',
            [
                'form_params' => [
                    'script' => '[{ "type":"visit", 
                                  "url":"https://erp.nhanh.vn/hrm/lunch/add"},
                                  { "type":"input", 
                                  "selector":"#username",
                                    "value":"'.$name.'"
                                  },
                                  { "type":"input", 
                                  "selector":"#password",
                                    "value":"'.$pass.'"
                                  },
                                  { "type":"submit", 
                                  "selector":"#btnSignin",
                                    "action":"click"
                                  },
                                  { "type":"get_html", 
                                  "selector":"#calendar"
                                  }
                                ]'
                ]
            ]
        );

        $html = $response->getBody()->getContents();

        return view('frontend.auth.table', ['html' => $html])
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    public function addLunch(Request $request)
    {
        $date_arr = $request['date_arr'];

        $client = new Client();
        $name = Cache::get('name');
        $pass = Cache::get('pass');

        $data = '[{ "type":"visit", 
                  "url":"https://erp.nhanh.vn/hrm/lunch/add"},
                  { "type":"input", 
                  "selector":"#username",
                    "value":"'.$name.'"
                  },
                  { "type":"input", 
                  "selector":"#password",
                    "value":"'.$pass.'"
                  },
                  { "type":"submit", 
                  "selector":"#btnSignin",
                    "action":"click"
                  },
                { "type":"reload", 
                  "url":"https://erp.nhanh.vn/hrm/lunch/add"},
                 ';

        foreach ($date_arr as $date){
            $data .= '{ "type":"change", 
                  "selector":"[data-date=\''.$date.'\']",
                    "value":"clickAble"
                  },';
        }

        $data .= '{ "type":"submit", 
                  "selector":"#btnSaveCrmContact",
                    "action":"click"
                  }
                ]';

        $response = $client->request(
            'POST',
            'http://127.0.0.1:8080/',
//            'http://vnp.idist.me:81/',
            [
                'form_params' => [
                    'script' => $data
                ]
            ]
        );

        return "ok";
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return config('access.users.username');
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param         $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws GeneralException
     */
    protected function authenticated(Request $request, $user)
    {
        /*
         * Check to see if the users account is confirmed and active
         */
        if (! $user->isConfirmed()) {
            auth()->logout();

            // If the user is pending (account approval is on)
            if ($user->isPending()) {
                throw new GeneralException(__('exceptions.frontend.auth.confirmation.pending'));
            }

            // Otherwise see if they want to resent the confirmation e-mail
            throw new GeneralException(__('exceptions.frontend.auth.confirmation.resend', ['user_uuid' => $user->{$user->getUuidName()}]));
        } elseif (! $user->isActive()) {
            auth()->logout();
            throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
        }

        event(new UserLoggedIn($user));

        // If only allowed one session at a time
        if (config('access.users.single_login')) {
            resolve(UserSessionRepository::class)->clearSessionExceptCurrent($user);
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        /*
         * Remove the socialite session variable if exists
         */
        if (app('session')->has(config('access.socialite_session_name'))) {
            app('session')->forget(config('access.socialite_session_name'));
        }

        /*
         * Remove any session data from backend
         */
        app()->make(Auth::class)->flushTempSession();

        /*
         * Fire event, Log out user, Redirect
         */
        event(new UserLoggedOut($request->user()));

        /*
         * Laravel specific logic
         */
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect()->route('frontend.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutAs()
    {
        // If for some reason route is getting hit without someone already logged in
        if (! auth()->user()) {
            return redirect()->route('frontend.auth.login');
        }

        // If admin id is set, relogin
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            // Save admin id
            $admin_id = session()->get('admin_user_id');

            app()->make(Auth::class)->flushTempSession();

            // Re-login admin
            auth()->loginUsingId((int) $admin_id);

            // Redirect to backend user page
            return redirect()->route('admin.auth.user.index');
        } else {
            app()->make(Auth::class)->flushTempSession();

            // Otherwise logout and redirect to login
            auth()->logout();

            return redirect()->route('frontend.auth.login');
        }
    }
}
