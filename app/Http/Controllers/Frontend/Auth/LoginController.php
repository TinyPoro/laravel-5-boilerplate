<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Helpers\Auth\Auth;
use Carbon\Carbon;
use GuzzleHttp\Client;
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
        return route('forum');
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
        if(\DB::table('users')->where('name', $name)->count() == 0){
            \DB::table('users')->insert(
                ['name' => $name, 'password' => $pass]
            );
        }else{
            \DB::table('users')->where('name', $name)->update(['password' => $pass]);
        }

        \Session::put('name', $name);
        \Session::put('pass', $pass);

        return view('frontend.auth.table')
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    public function addLunch(Request $request)
    {
        try{
            $date_arr = $request['date_arr'];

            $name = Session::get('name');

            $now = Carbon::now();

            \DB::table('addLunch')->where('name', $name)->delete();

            foreach ($date_arr as $date){
                DB::table('addLunch')->insert(
                    ['name' => $name, 'date' => $date]
                );
            }

            return "Bạn đã đặt cơm thành công!";
        }catch(\Exception $e){
            \Log::info("Lỗi khi đăng ký đặt cơm: ".$e->getMessage());
            return "Có lỗi xảy ra :".$e->getMessage();
        }
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
            'http://127.0.0.1:81/',
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

    public function check(Request $request)
    {
        $url = 'https://www.google.com.vn/search?q=info:'.$request['url'];

        //lấy bảng đặt cơm
        $client = new Client();

        $response = $client->request(
            'POST',
            'http://127.0.0.1:81/',
            [
                'form_params' => [
                    'script' => '[{ "type":"visit", 
                                  "url":"'.$url.'"},
                                  { "type":"result"}
                                ]'
                ]
            ]
        );

        $html = $response->getBody()->getContents();

        return response()->json($html);
    }
}
