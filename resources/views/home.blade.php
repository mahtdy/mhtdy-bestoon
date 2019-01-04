@extends('layouts.app')

@section('content')
    <!--  Container -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header text-right">
                        <h4 class="h4">وضعیت حساب کاربری</h4>
                    </div>
                    <div class="card-body">
                        @if($userExpiry->end_date === null)
                            <div class="alert text-center alert-info float-right w-100 shadow">
                                <strong>حساب کاربری شما</strong> همیشگی است!
                            </div>
                        @else
                            @php
                                $yeardate = date("Y", strtotime($userExpiry->end_date));
                                $monthdate = date("m", strtotime($userExpiry->end_date));
                                $daydate = date("d", strtotime($userExpiry->end_date));
                                $dt = \Carbon\Carbon::createMidnightDate($yeardate, $monthdate, $daydate);
                            @endphp
                            <div class="alert text-center alert-warning float-right w-100 shadow">
                                <strong>حساب کاربری شما</strong>
                                تا {{ $dt->diffInDays() }} روز
                                دیگر فعال است!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <dashboard></dashboard>
            </div>
        </div>
    </div>
@endsection
