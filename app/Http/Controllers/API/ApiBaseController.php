<?php

namespace app\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class ApiBaseController extends Controller
{
    protected $account_id;

    public function __construct()
    {
        $account = Account::take(1)->get();
        $this->account_id = $account[0]->id;
    }


}