<?php

namespace App\Http\Middleware;

use App\Transaction;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\DB;

class CheckUserActivation
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->is_activate == false) {
            return redirect('/plan');
        } else {
            $trans = Transaction::where('user_id', $request->user()->id)->first();
            if ($trans !== null) {
                $end_date = $trans->end_date;
                $now = Carbon::now()->format('Y-m-d h:m:s');
                if ($end_date !== null && $end_date <= $now) {
                    DB::table('users')
                        ->where('id', $request->user()->id)
                        ->update(['is_activate' => 0]);
                    return redirect('/plan');
                }
            } else {
                DB::table('users')
                    ->where('id', $request->user()->id)
                    ->update(['is_activate' => 0]);
                return redirect('/plan');
            }

        }

        return $next($request);
    }
}
