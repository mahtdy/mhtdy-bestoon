<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Income;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckUserActivation;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(CheckUserActivation::class)->except(['plan', 'buyPlan', 'verifyPay', 'verify']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::where('id', '=', auth()->id())->first();
        $userExpiry = $user->hasExpiry();
        $userExpiryType = $userExpiry->type;
        return view('home', compact('userExpiry', 'userExpiryType'));
    }

    public function newIncome(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'amount' => 'required'
        ]);

        $income = new Income();
        $income->title = $request->title;
        $income->amount = $request->amount;
        $income->user_id = Auth::id();
        $income->save();

        return back();

    }

    public function newExpense(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'amount' => 'required'
        ]);

        $expense = new Expense();
        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->user_id = Auth::id();
        $expense->save();

        return back();

    }

    public function Getiande()
    {
        $date = \Carbon\Carbon::today()->subDays(30);

        $incomes = Income::where(
            [
                ['user_id', auth()->id()],
                ['created_at', '>=', $date]
            ]
        )->get();
        $expenses = Expense::where(
            [
                ['user_id', auth()->id()],
                ['created_at', '>=', $date]
            ]
        )->get();

        $final = array('totalIncomes' => $incomes->sum('amount'), 'totalExpenses' => $expenses->sum('amount'));
        return $final;
    }

    public function iandeList()
    {
        Carbon::setLocale('fa');
        $incomes = Income::latest()->where('user_id', Auth::id())->take(10)->get();
        $incomes = $incomes->map(function ($incomes) {
            $incomes->created_diff = $incomes->created_at->diffForHumans();
            return $incomes;
        });
        $expenses = Expense::latest()->where('user_id', Auth::id())->take(10)->get();
        $expenses = $expenses->map(function ($expenses) {
            $expenses->created_diff = $expenses->created_at->diffForHumans();
            return $expenses;
        });
        $res = array('incomes' => $incomes, 'expenses' => $expenses);

        return $res;
    }

    public function editIncome(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'title' => 'required',
            'amount' => 'required'
        ]);

        $income = Income::find($request->id);
        $income->title = $request->title;
        $income->amount = $request->amount;
        if ($income->save()) {
            return back();
        } else {
            return response([], 403);
        }

    }

    public function editExpense(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'title' => 'required',
            'amount' => 'required'
        ]);

        $expense = Expense::find($request->id);
        $expense->title = $request->title;
        $expense->amount = $request->amount;
        if ($expense->save()) {
            return back();
        } else {
            return response([], 403);
        }

    }

    public function deleteIncome(Request $request)
    {
        $income = Income::find($request->id);
        $income->delete();

        return back();
    }

    public function deleteExpense(Request $request)
    {
        $expense = Expense::find($request->id);
        $expense->delete();
        return back();
    }

    public function plan()
    {
        return view('plan.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function buyPlan(Request $request)
    {
        $trans = Transaction::where('user_id', $request->user()->id)->first();
        if ($trans !== null) {
            $end_date = $trans->end_date;
            $now = Carbon::now()->format('Y-m-d h:m:s');
            if ($end_date === null && $end_date > $now) {

                $this->validate($request, [
                    'type' => 'required'
                ]);
                $amount = null;
                $description = null;
                $price1 = 20000;
                $price2 = 220000;
                $price3 = 600000;
                if ($request->type == 1) {
                    $amount = $price1;
                    $description = 1;
                } elseif ($request->type == 2) {
                    $amount = $price2;
                    $description = 2;
                } elseif ($request->type == 3) {
                    $amount = $price3;
                    $description = 3;
                } else {
                    return back();
                }
                $api = 'test';
                $factorNumber = str_random(15);
                $redirect = 'http://localhost:8000/verifyPay';
                $result = $this->sendPay($api, $amount, $redirect, null, $factorNumber, $description);
                Session::put('plantype', $request->type);
                $result = json_decode($result);
                if ($result->status) {
                    $go = "https://pay.ir/pg/$result->token";
                    return redirect($go);
                } else {
                    return $result->errorMessage;
                }
            } else {
                return back()->with('fail', 'حساب کاربری شما داری اعتبار می باشد!');
            }
        } else {
            $this->validate($request, [
                'type' => 'required'
            ]);
            $amount = null;
            $description = null;
            $price1 = 20000;
            $price2 = 220000;
            $price3 = 600000;
            if ($request->type == 1) {
                $amount = $price1;
                $description = 1;
            } elseif ($request->type == 2) {
                $amount = $price2;
                $description = 2;
            } elseif ($request->type == 3) {
                $amount = $price3;
                $description = 3;
            } else {
                return back();
            }
            $api = 'test';
            $factorNumber = str_random(15);
            $redirect = 'http://localhost:8000/verifyPay';
            $result = $this->sendPay($api, $amount, $redirect, null, $factorNumber, $description);
            Session::put('plantype', $request->type);
            $result = json_decode($result);
            if ($result->status) {
                $go = "https://pay.ir/pg/$result->token";
                return redirect($go);
            } else {
                return $result->errorMessage;
            }
        }
    }

    public function verifyPay(Request $request)
    {

        $api = 'test';
        $token = $request->token;
        $result = json_decode($this->verify($api, $token));
        if (isset($result->status)) {
            $trans = new Transaction();
            $trans->user_id = Auth::id();
            $trans->factorNumber = $result->factorNumber;
            $trans->transId = $result->transId;
            $trans->cardNumber = $result->cardNumber;
            $trans->amount = $result->amount;
            $trans->status = $result->status;
            $trans->type = intval(Session::get('plantype'));
            if ($result->amount == 20000) {
                $trans->end_date = Carbon::now()->addMonth(1);
            } elseif ($result->amount == 220000) {
                $trans->end_date = Carbon::now()->addYear(1);
            } elseif ($result->amount == 600000) {
                $trans->end_date = null;
            }
            $trans->save();
            if ($result->status == 1) {
                $res = $result;
                $user = User::find(Auth::id());
                $user->is_activate = true;
                $user->save();
                return view('plan.success', compact('res'));
            } else {
                return 'no 1';
            }
        } else {
            if ($request->status == 0) {
                return 'no 2';
            }
        }
    }

    /**
     * @param $api
     * @param $amount
     * @param $redirect
     * @param null $mobile
     * @param null $factorNumber
     * @param null $description
     * @return mixed
     */
    private function sendPay($api, $amount, $redirect, $mobile = null, $factorNumber = null, $description = null)
    {
        return $this->curl_post('https://pay.ir/pg/send', [
            'api' => $api,
            'amount' => $amount,
            'redirect' => $redirect,
            'mobile' => $mobile,
            'factorNumber' => $factorNumber,
            'description' => $description,
        ]);
    }

    private function verify($api, $token)
    {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api' => $api,
            'token' => $token,
        ]);
    }

    /**
     * @param $url
     * @param $params
     * @return bool|string
     */
    private function curl_post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }
}
