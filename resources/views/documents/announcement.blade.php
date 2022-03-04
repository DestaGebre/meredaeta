@extends('layouts.app')

@section('htmlheader_title')
    ሓበሬታ
@endsection

@section('contentheader_title')
    <span style="display: block; text-align: center;">ሓበሬታ</span>
@endsection

@section('header-extra')

@endsection

@section('main-content')
<div class="col-xs-12 col-md-10 col-md-offset-1">
    <div class="box box-primary">
        <div class="box-body">
            <form action="{{ url('addnewannouncement') }}" method="post">
                <input type="hidden" name="_method" value="PATCH">
                {{ csrf_field() }}
                <?php $cnt = (count($errors) > 0); ?>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="ርእሲ" name="title" value=""/>
                </div>

                <div class="form-group has-feedback">
                    <textarea class="form-control" placeholder="ዝርዝር ሓበሬታ" name="description" rows="10"></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-flat">ሓበሬታ መዝግብ</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts-extra')

@endsection