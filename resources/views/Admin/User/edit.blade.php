@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-right">
                        <h4>ویرایش کاربر</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('editUser') }}" method="post" class="text-right">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="form-group">
                                <label for="name">نام و نام خانوادگی :</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">ایمیل :</label>
                                <input type="text" id="email" name="email" class="form-control"
                                       value="{{ $user->email }}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>وضعیت :</label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="status"
                                           class="custom-control-input p-3" value="1" @if($user->is_activate === 1) checked @endif>
                                    <label class="custom-control-label pr-4" for="customRadioInline1">فعال</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="status"
                                           class="custom-control-input p-3" value="0" @if($user->is_activate === 0) checked @endif>
                                    <label class="custom-control-label pr-4" for="customRadioInline2" >غیر فعال</label>
                                </div>
                            </div>
                            <button class="btn btn-success btn-block" type="submit">ثبت</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
