@extends('layouts.app')

@section('content')
    @if($userExpiry->end_date === null)
        <div class="alert alert-info float-right mr-3 text-center position-fixed shadow">
            <strong>حساب کاربری شما</strong> همیشگی است!
        </div>
    @else
        @php
            $yeardate = date("Y", strtotime($userExpiry->end_date));
            $monthdate = date("m", strtotime($userExpiry->end_date));
            $daydate = date("d", strtotime($userExpiry->end_date));
            $dt = \Carbon\Carbon::createMidnightDate($yeardate, $monthdate, $daydate);
        @endphp
        <div class="alert alert-warning float-right mr-3 text-center position-fixed shadow">
            <strong>حساب کاربری شما</strong>
            تا {{ $dt->diffInDays() }} روز
            دیگر فعال است!
        </div>
    @endif
    <dashboard></dashboard>
@endsection
