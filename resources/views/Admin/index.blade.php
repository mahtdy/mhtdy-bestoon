@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-right">
                        <h4>لیست کاربران</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center table-responsive-lg">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>نام و نام خانوادگی</th>
                                <th>ایمیل</th>
                                <th>وضعیت</th>
                                <th>عملیات ها</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i = 0; @endphp
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->is_activate }}</td>
                                    <td>
                                        <div class="custom-control-inline">
                                            <a href="/admin/user/{{ $user->id }}/edit"
                                               class="btn btn-outline-primary btn-sm">ویرایش</a>
                                            <form action="{{ route('deleteUser') }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" value="{{ $user->id }}" name="id">
                                                <button type="submit" class="btn btn-outline-danger btn-sm mr-3">حذف</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header text-right">
                        <h4>لیست تراکنش ها</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-responsive-lg text-center">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ایمیل</th>
                            <th>شماره تراکنش</th>
                            <th>مبلغ</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $ii = 0; @endphp
                        @foreach($transs as $trans)
                            <tr>
                                <td>{{ $ii++ }}</td>
                                <td>{{ $trans->user->email }}</td>
                                <td>{{ $trans->transId }}</td>
                                <td>{{ $trans->amount }}</td>
                                <td>{{ $trans->status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        {{ $transs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
