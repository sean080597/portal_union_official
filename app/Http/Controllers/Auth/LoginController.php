<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Student;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // Check validation
        $this->validate($request, [
            'stuid' => 'required|regex:/[0-9]{10}/|digits:10',
        ]);

        // Get user record
        $stud = Student::where('id', $request->get('stuid'))->first();

        // Check Condition Mobile No. Found or Not
        if($request->get('stuid') != $stud->id) {
            \Session::put('errors', 'Your input not match in our system..!!');
            return back();
        }

        // Set Auth Details
        \Auth::login($stud->user);

        // Redirect home page
        return redirect()->action('HomeController@index', '/');
    }
}
