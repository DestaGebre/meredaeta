@extends('layouts.app')

@section('htmlheader_title')
    ሓዱሽ ፋይል
@endsection

@section('contentheader_title')
    ሓዱሽ ፋይል
@endsection

@section('header-extra')

@endsection

@section('main-content')
<div class="col-xs-12 col-md-8">
    <div class="box box-primary">
        <div class="box-body">
            <form action="{{ url('newdocumentupload') }}" method="post" enctype="multipart/form-data">
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

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="ሽም ፋይል" name="title" value=""/>
                </div>

                <div class="form-group has-feedback">
                    <textarea class="form-control" placeholder="መብርሂ" name="description"></textarea>
                </div>
                <div class="form-group has-feedback">
                    <input type="file" class="form-control" name="file" />
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-flat">ፋይል ኣእትው</button>
            </form>
        </div>
    </div>
</div>       
@endsection
@section('scripts-extra')

@endsection