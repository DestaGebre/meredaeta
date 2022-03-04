@extends('layouts.app')

@section('htmlheader_title')
    ሓዱሽ ተጠቃሚ መዝግብ
@endsection

@section('contentheader_title')
    <center>ሓዱሽ ተጠቃሚ መዝግብ</center>
@endsection

@section('header-extra')
@endsection
@section('main-content')

    <body class="hold-transition">
    <div class="register-box" style="margin-top: -10px;">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <!-- <strong>Whoops!</strong> There were some problems with your input.<br><br> -->
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="register-box-body">
            <!-- <p class="login-box-msg">Register a new membership</p> -->
            <form action="{{ url('/registerUser') }}" method="post" id="registrationForm">

                {!! csrf_field() !!}

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="ሽም" name="firstname" value="{{ old('firstname') }}"/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="ሽም ኣቦ" name="lastname" value="{{ old('lastname') }}"/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="ኢሜይል" name="email" value="{{ old('email') }}"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="ፓስዎርድ" id="password_disp"/>
                        <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
                        <span class="input-group-btn">
                            <a id="generate" class="btn btn-info">ሓዱሽ</a>
                        </span>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <input type="hidden" class="form-control" placeholder="ፓስዎርድ ኣረጋግፅ" name="password" id="password"/>
                    <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
                </div>
                <div class="form-group has-feedback">
                    <select class="form-control" name="usertype">
                        <option selected disabled>~ሓላፍነት ምረፅ</option>
                        @if (Auth::user()->usertype == 'admin')
                            <!-- <option value="admin">ኣድሚንስትሬተር</option> -->
                            <option value="zoneadmin">ዞባ ኣድሚንስትሬተር</option>
                            <option value="management">ማኔጅመንት</option>
                        @endif
                        @if (array_search(Auth::user()->usertype, ['admin', 'zoneadmin'])!==false)
                            <option value="zone">ዞባ ስታፍ</option>
                            <option value="woredaadmin">ወረዳ ኣድሚንስትሬተር</option>
                        @endif
                        <option value="woreda">ወረዳ ስታፍ</option>
                    </select>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control fade" placeholder="" name="area" id="area" />
                </div>
                <div class="row">
                    <div class="col-xs-4 pull-right">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">መዝግብ</button>
                    </div><!-- /.col -->
                </div>
            </form>

            <!-- <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using Facebook</a>
                <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using Google+</a>
            </div> -->

            <!-- <a href="{{ url('/login') }}" class="text-center">I already have a membership</a> -->
        </div><!-- /.form-box -->
    </div><!-- /.register-box -->

@endsection
@section('scripts-extra')
    <script>
        $('select[name="usertype"]').on('change', function(e){
            if($(this).val() == "zone" || $(this).val() == "zoneadmin")
                $('#area').prop('placeholder', 'ዞባ ኮድ');
            if($(this).val() == "woreda" || $(this).val() == "woredaadmin")
                $('#area').prop('placeholder', 'ወረዳ ኮድ');
            if($(this).val() == "zone" || $(this).val() == "woreda" || $(this).val() == "zoneadmin" || $(this).val() == "woredaadmin")
                $('#area').removeClass('fade');
            else
                $('#area').addClass('fade');
        });
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });

        $('#registrationForm').submit(function(e){
            e.preventDefault();
            $('#password').val($('#password_disp').val());
            $('#registrationForm')[0].submit();
        });

        $('#generate').on('click',function(e){
          generatePassword();
        });

        $(document).on('ready', function(e){
            generatePassword();
        });

        function generatePassword(){
          var password = randomPassword([1,3],[1,3],[0,0],[0,1],7);
          $('#password_disp').val(password);
          $('#password').val(password);
        }

        String.prototype.pick = function(min,max){
          var n,chars = '';
          if(typeof(max)=='undefined')
            n = min;
          else
            n = min+Math.floor(Math.random()*(max-min+1));
          for(var q=0;q<n;q++)
            chars += this.charAt(Math.floor(Math.random()*this.length));
          return chars;
        };
        String.prototype.shuffle = function(){
          var a = this.split("");
          n = a.length;
          for(var i=n-1;i>0;i--){
            var j = Math.floor(Math.random()*(i+1));
            var tmp = a[i];
            a[i] = a[j];
            a[j] = tmp;
          }
          return a.join("");
        };
        function randomPassword(upper,lower,sp,num,total){
          var specials = ''//'!@#$%^&*()_+{}<>?[],./-';
          var lowercase = 'abcdefghijklmnopqrstuvwxyz';
          var uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          var numbers = '0123456789';
          var all = specials+lowercase+uppercase;
          var password = '';
          password += specials.pick(sp[0],sp[1]);
          password += uppercase.pick(upper[0],upper[1]);
          password += lowercase.pick(lower[0],lower[1]);
          password += numbers.pick(num[0],num[1]);
          password += all.pick(total-password.length);
          password = password.shuffle();
          return password;
        }
    </script>
</body>

@endsection
