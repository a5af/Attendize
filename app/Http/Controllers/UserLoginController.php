<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Redirect;
use View;
use Hash;
use App\Models\Account;
use App\Models\User;
use App\Models\Role;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Log;

class UserLoginController extends Controller
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest');
    }

    /**
     * Shows login form.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function showLogin(Request $request)
    {
        /*
         * If there's an ajax request to the login page assume the person has been
         * logged out and redirect them to the login page
         */
        if ($request->ajax()) {
            return response()->json([
                'status'      => 'success',
                'redirectUrl' => route('login'),
            ]);
        }

        return View::make('Public.LoginAndRegister.Login');
    }

    /**
     * Handles the login request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        if (empty($email) || empty($password)) {
            return Redirect::back()
                ->with(['message' => 'Please fill in your email and password', 'failed' => true])
                ->withInput();
        }

        if ($this->auth->attempt(['email' => $email, 'password' => $password], true) === false) {
            return Redirect::back()
                ->with(['message' => 'Your username/password combination was incorrect', 'failed' => true])
                ->withInput();
        }

        return redirect()->intended(route('showSelectOrganiser'));
    }

    public function handleSSO(Request $request)
    {
        $userName = $request->query('user');
        $token = $request->query('token');
        $client = new Client();

        try {
            $response = $client->get(config('app.bns_url').'/api/myprofile?include=userDetail',[
                'headers' => ['Authorization' => 'Bearer '.$token]
            ])->getBody();
        }catch (RequestException $e) {
            session()->flush();
            return redirect()->route('login')
                ->with(['message' => $e->getMessage(), 'failed' => true]);
        }
        $data = json_decode($response)->data;
        if($data->username != $userName || $data->email == null)
            return redirect()->route('login');

        $user = User::where('email', $data->email)->first();
        if($user == null) {
            $account = Account::take(1)->get();
            $role = '';
            if($data->userDetail->is_admin == '1') {
                $role = 'admin';
            } else if($data->userDetail->is_agent == '1') {
                $role = 'agent';
            }
            $userRole = Role::where('name', $role)->first();
            $user = new User();
//            $temp_password = str_random(8);
            $temp_password = 'password';

            $user->email = $data->email;
            $user->agentcode = $data->username;
            $user->first_name = $data->first_name;
            $user->last_name = $data->last_name;
            $user->password = Hash::make($temp_password);
            $user->account_id = $account[0]->id;
            $user->profile_image = $data->userDetail->profile_image;
            $user->phone = $data->userDetail->phone;
            $user->save();
            $user->attachRole($userRole);
        }
        if($user->profile_image !== $data->userDetail->profile_image) {
            $user->profile_image = $data->userDetail->profile_image;
            $user->save();
        }
        session()->flush();
        session()->set('sso_token', $token);
        $this->auth->login($user);

        return redirect()->intended(route('showSelectOrganiser'));
    }
}
