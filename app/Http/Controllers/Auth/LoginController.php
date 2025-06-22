<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Get the post-login redirect path.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return '/dashboard';
    }

    /**
     * Override the login method to add custom validation
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Check if user account is active (status = 1)
        $user = \App\Models\User::where('email', $request->email)->first();
        
        // Debug information
        if ($user) {
            \Log::info('Login attempt for user: ' . $user->email . ', Status: ' . $user->status . ', Status type: ' . gettype($user->status) . ', Is Active: ' . ($user->isActive() ? 'Yes' : 'No'));
        } else {
            \Log::info('Login attempt failed: User not found with email: ' . $request->email);
        }
        
        if ($user && !$user->isActive()) {
            \Log::warning('Login blocked: Inactive account for user: ' . $user->email);
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.inactive_account')],
            ]);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Custom authentication logic to handle both hashed and unhashed passwords
        if ($user) {
            $password = $request->password;
            $storedPassword = $user->password;
            
            // Check if stored password is hashed (starts with $2y$)
            if (str_starts_with($storedPassword, '$2y$')) {
                // Password is already hashed, use normal Laravel authentication
                if (Hash::check($password, $storedPassword)) {
                    \Log::info('Login successful for user: ' . $request->email . ' (hashed password)');
                    auth()->login($user);
                    if ($request->hasSession()) {
                        $request->session()->put('auth.password_confirmed_at', time());
                    }
                    return $this->sendLoginResponse($request);
                }
            } else {
                // Password is plain text, compare directly and then hash it
                if ($password === $storedPassword) {
                    \Log::info('Login successful for user: ' . $request->email . ' (plain text password - now hashing)');
                    
                    // Hash the password and save it
                    $user->password = $request->input('password'); 
                    $user->save();

                    // Refresh user instance
                    $user->refresh();

                    auth()->login($user);
                    if ($request->hasSession()) {
                        $request->session()->put('auth.password_confirmed_at', time());
                    }
                    return $this->sendLoginResponse($request);
                }
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        \Log::warning('Login failed for email: ' . $request->email . ' - Invalid credentials');
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // You can add custom logic here after successful authentication
        // For example, logging user activity, updating last login time, etc.
        
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new \Illuminate\Http\JsonResponse([], 204)
            : redirect('/login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}