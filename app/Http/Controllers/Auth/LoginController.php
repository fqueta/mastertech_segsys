<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Qlib\Qlib;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo()
    {


        $ret = Qlib::redirectLogin();
        //REGISTRAR EVENTO
        // $regev = Qlib::regEvent([
        //     'action' => 'login', 'tab' => 'user', 'config' => [
        //         'obs' => 'Usuario logado',
        //         'link' => $ret,
        //     ]
        // ]);

        return $ret;
    }
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
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // dd($this->guard()->validate($this->credentials($request)),$this->credentials($request));
        // dd(User::all());
        // if ($this->guard()->validate($this->credentials($request))) {
            $key = 'email';
            if (is_numeric($request->get('email'))) {
                $key = 'mobile_no';
            }
            // DB::setDefaultConnection('tenant');
            $credentials = [$key => $request->email, 'password' => $request->password, 'ativo' => 's', 'excluido' => 'n'];
            $logar = Auth::guard('web')->attempt($credentials, $request->filled('remember'));
            // $logar = (new UserController)->login([$key => $request->email, 'password' => $request->password, 'ativo' => 's', 'excluido' => 'n']);
            // $databaseName = \DB::connection('tenant')->getDatabaseName();
            // dump($databaseName);
            if ($logar) {
                $dUser =  Auth::user();
                session()->push('user_l', $dUser); //usuario logado
                // dd($dUser);
                $id_cliente = 10;
                if($request->has('r')){
                    //nesse caso redirect ulr
                    return redirect($request->get('r'));
                }

                if (isset($dUser['id_permission']) && $dUser['id_permission'] < $id_cliente) {

                    //login do administrado
                    // return redirect()->route('home');
                    // dump($dUser);
                    // dd(url('/home'));
                    return redirect()->route('home.admin');
                } else {
                    //login do cliente
                    return redirect()->route('internautas.index');
                }
            } else {
                $this->incrementLoginAttempts($request);

                Session::flash('message', 'Esta conta está desativada!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        // } else {

        //     $this->incrementLoginAttempts($request);

        //     Session::flash('message', 'Cadastro não encontrado!');
        //     Session::flash('alert-class', 'alert-danger');
        //     return redirect()->back();
        // }
    }

    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return ['mobile_no' => $request->get('email'), 'password' => $request->get('password')];
        }
        return $request->only($this->username(), 'password');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
}
