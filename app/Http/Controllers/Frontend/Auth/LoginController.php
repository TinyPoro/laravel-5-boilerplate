<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Helpers\Auth\Auth;
use Carbon\Carbon;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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


        //lưu thống tin người dùng vào csdl
        if(DB::table('users')->where('name', $name)->count() == 0){
            DB::table('users')->insert(
                ['name' => $name, 'password' => $pass]
            );
        }

        //lấy bảng đặt cơm
        $client = new Client();
        Session::put('name', $name);
        Session::put('pass', $pass);
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

        $tomorrow = Carbon::now()->addDay(1);
        $tomorrow_string = date_format($tomorrow, 'Y-m-d');
        $ordered_day = DB::table('addLunch')->where('date', '>', $tomorrow_string)->get();
$ordered_day = json_decode($ordered_day);
        return view('frontend.auth.table', ['html' => $html, 'ordered_day' => $ordered_day])
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    public function addLunch(Request $request)
    {
        $date_arr = $request['date_arr'];


        $name = Session::get('name');

        $now = Carbon::now();

        foreach ($date_arr as $date){
            $target = Carbon::parse($date);

            if($target->gte($now)) {
                if(DB::table('addLunch')->where('name', $name)->where('date', $date)->count() == 0){
                    DB::table('addLunch')->insert(
                        ['name' => $name, 'date' => $date]
                    );
                }
            }
        }

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

    public function nhungGet(){
        return view('nhung');
    }

    public function nhungSupport(Request $request){
        $url = $request->get('url');

        $client = new Client();

        $response = $client->request(
            'POST',
            'http://127.0.0.1:8080/',
            [
                'form_params' => [
                    'script' => '[{ "type":"visit",
                                  "url":"'.$url.'"},
                                  { "type":"check_exist",
                                  "selector":".iUh30"
                                  }
                                ]'
                ]
            ]
        );


        $urls = $response->getBody()->getContents();

        return json_decode($urls);
    }
}
