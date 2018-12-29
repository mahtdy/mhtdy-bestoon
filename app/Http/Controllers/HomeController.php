<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Income;
use foo\bar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
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

        $final = array('totalIncomes' => $incomes->sum('amount') , 'totalExpenses' => $expenses->sum('amount'));
        return $final;
    }

    public function iandeList()
    {
        $incomes = Income::latest()->where('user_id', Auth::id())->take(10)->get();
        $expenses = Expense::latest()->where('user_id', Auth::id())->take(10)->get();

        $res = array('incomes' => $incomes, 'expenses' => $expenses);

        return$res;
    }
}