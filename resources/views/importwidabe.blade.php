@extends('layouts.app')

@section('htmlheader_title')
     መሰረታዊ ውዳበን ዋህዮ ካብ ኤክሴል ኣእትው
@endsection

@section('contentheader_title')
    መሰረታዊ ውዳበን ዋህዮ ካብ ኤክሴል ኣእትው
@endsection

@section('header-extra')

@endsection
@section('main-content')
<body>
    <div class="box box-primary">
        <div class="box-header with-border">
            <?php $cnt = (count($errors) > 0); ?>
            @if (count($errors) > 0)
                 <div class = "alert alert-danger">
                    <h3>እዞም ዝስዕቡ ፀገማት ስለዝተረኸቡ ኤክሴል ፋይል ናብ ዳታ ቤዝ ኣይተወን</h3>
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{!! $error !!}</li>
                       @endforeach
                    </ul>
                 </div>
              @endif
            <form action="{{ url('importwidabeexcel') }}" method="post" enctype="multipart/form-data">
                <!-- <label class="col-md-2" for="excelfile">ኤክሴል ፋይል ምረፅ</label>
                <div class="form-group has-feedback col-md-4">
                    <input type="file" class="form-control" name="excelfile" id="excelfile" />
                    <span class="fa fa-picture-o form-control-feedback"></span>
                </div> -->
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-md-2 control-label" for="excelfile">ኤክሴል ፋይል ምረፅ</label>
                    <div class="form-group has-feedback col-md-5">
                        <input id="excelfile" name="excelfile" type="file" placeholder="" class="form-control" required="" value="">
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
                    <button type="submit" class="btn btn-block btn-success">ኣእትው</button>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection