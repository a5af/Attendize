<?php

namespace app\Http\Controllers\API;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Log;

class UsersApiController extends ApiBaseController
{
    public function store(Request $request) {
        $data = $request->json()->all();
        try {
            $user = User::where('email', $data['email'])->first();
            if(!$user) {
                if($data['isadmin'] == '1') {
                    $role = 'admin';
                } else if($data['isagent'] == '1') {
                    $role = 'agent';
                } else {
                    return response()->json([
                        'status'      => 'fail',
                        'message' => 'This user has no role.'
                    ]);
                }

                $userRole = Role::where('name', $role)->first();
                $user = new User();
                $user->email = $data['email'];
                $user->agentcode = $data['agentcode'];
                $user->first_name = $data['firstname'];
                $user->last_name = $data['lastname'];
                $user->password = $data['password'];
                $user->phone = $data['phone'];
                $user->account_id = $this->account_id;
                $user->save();
                $user->attachRole($userRole);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'status'   => 'error'
            ]);
        }

        return response()->json([
            'status'      => 'success',
        ]);
    }
}