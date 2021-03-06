@extends('layouts.app')

@section('htmlheader_title')
    ተጠቀምቲ
@endsection

@section('contentheader_title')
    ተጠቀምቲ ኣባላት ህወሓት ምሕደራ ሶፍትዌር
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>ሽም</th>
                            <th>ሽም ኣቦ</th>
                            <th>ኢሜይል</th>
                            <th width="1">ሓላፍነት</th>
                            <th width="1"></th>
                        </tr>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="label label-primary">User</span></td>
                                <td>
                                    <a href="/profile/{{ $user->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                {{--<div class="box-footer clearfix">--}}
                    {{--<ul class="pagination pagination-sm no-margin pull-right">--}}
                        {{--<li><a href="#">«</a></li>--}}
                        {{--<li><a href="#">1</a></li>--}}
                        {{--<li><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li><a href="#">»</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@section('scripts-extra')
{{--<script>--}}
    {{--$('.btn-danger').on('click', function() {--}}
        {{--swal(--}}
                {{--'Good job!',--}}
                {{--'You clicked the button!',--}}
                {{--'success'--}}
        {{--)--}}
    {{--});--}}
{{--</script>--}}
@endsection