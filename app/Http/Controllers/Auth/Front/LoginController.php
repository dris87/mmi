<?php

namespace App\Http\Controllers\Auth\Front;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Company;
use App\Providers\RouteServiceProvider;
use Auth;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return Factory|View
     */
    protected function showAdminLoginForm()
    {
        return view('auth.login');
    }

    /**
     * @return Factory|View
     */
    protected function showLoginForm()
    {
        return view('web.auth.login');
    }

    /**
     * @return Factory|View
     */
    protected function employeeLogin()
    {
        return view('web.auth.employer_login');
    }

    /**
     * @return Factory|View
     */
    protected function candidateLogin()
    {
        return view('web.auth.candidate_login');
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $type = $request->get('type');
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if (Auth::user()->hasRole('Employer') && $type == Company::COMPANY_LOGIN_TYPE) {
            $this->redirectTo = RouteServiceProvider::EMPLOYER_HOME;

            $activity_log_text = "Munkáltatói belépés";
            activity()
                ->inLog("custom")
                ->performedOn(Auth::user())
                ->log($activity_log_text)
                ->causer(Auth::user());

        } else {
            if (Auth::user()->hasRole('Candidate') && $type == Candidate::CANDIDATE_LOGIN_TYPE) {
                $this->redirectTo = RouteServiceProvider::CANDIDATE_HOME;

                $activity_log_text = "Munkavállalói belépés";
                activity()
                    ->inLog("custom")
                    ->performedOn(Auth::user())
                    ->log($activity_log_text)
                    ->causer(Auth::user());

            } else {
                Auth::logout();
                return $this->sendFailedLoginResponse();
            }
        }
        activity('UserActivity')->causedBy(\Illuminate\Support\Facades\Auth::user())->log('login');

        if (isset($request->remember)) {
            \Cookie::make('email', $request->email, 3600);
            \Cookie::make('password', $request->password, 3600);
            \Cookie::make('remember', 1, 3600);

        }
        else {
            \Cookie::forget('email');
            \Cookie::forget('password');
            \Cookie::forget('remember');
        }

        $objUser = \Illuminate\Support\Facades\Auth::user();

        $objUser->setLastLogin(date('Y-m-d H:i:s'));

        if(!$objUser->save()) {
            throw new Exception('There was an error updating the user\'s login timestamp');
        }

        return $this->authenticated($request, $this->guard()->user())
            ?: $this->jsonResponse('success', null, ['redirectTo' => $this->redirectPath()]);
    }

    /**
     * @param Request|null $request
     * @return JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request = null)
    {
        session()->regenerate();
        return $this->jsonResponse('error', 'Hibás felhasználónév / jelszó.', ['token' => csrf_token()]);
    }
}
