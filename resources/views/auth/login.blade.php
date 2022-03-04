@extends('layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}">ሶፍትዌር ምሕደራ ኣባላት ህዝባዊ ወያነ ሓርነት ትግራይ</a>
        </div><!-- /.login-logo -->

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="login-box-body">
    <!-- <p class="login-box-msg">Sign in to start your session</p> -->
    <form action="{{ url('/login') }}" method="post">

        {!! csrf_field() !!}

        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="ኢሜይል" name="email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="ፓስዎርድ" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <!-- <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div> -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">እቶ</button>
            </div><!-- /.col -->
        </div>
    </form>

    
    <!-- <a href="{{ url('/register') }}" class="text-center"><span class="glyphicon glyphicon-user"></span> Register New Member</a><br> -->
    <!-- <a href="{{ url('/password/reset') }}"><span class="glyphicon glyphicon-info-sign"></span> I forgot my password</a><br> -->
    

</div><!-- /.login-box-body -->

</div><!-- /.login-box -->

    @include('layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
