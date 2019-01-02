@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{ __('اشتراک خبر نامه') }}</div>

                    <div class="card-body">
                        @if (\Session::has('failure'))
                            <div class="alert alert-danger text-right">
                                <p class="text-right">{{ \Session::get('failure') }}</p>
                            </div><br/>
                        @endif
                        <form method="post" action="{{ route('subscribe')  }}">
                            @csrf
                            <div class="form-group">
                                <label for="Email" class="text-right float-right">ایمیل :</label>
                                <input type="text" id="Email" class="form-control" name="email">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-success btn-block">ثبت</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
