
@extends('layouts.app')

@section('htmlheader_title')
ማህደር
@endsection

@section('contentheader_title')
ማህደር ቀወምቲ ደገፍቲ
@endsection

@section('header-extra')
<!-- <script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
 -->
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<style type="text/css">
    @media print{
        #excelbtn{
            display: none;
        }
    }
</style>

@endsection
@section('main-content')
<?php $bezhi = 0;?>
@foreach ($data as $mydata)                                     
                            <?php $bezhi +=1; ?>
         @endforeach
     <div class="pull-right">                      
            <span style="bold"በዝሒ ኣባላት: {{ $bezhi }}&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
        </div> 
	<div class="row">
		<!-- <div class="col-md-6 col-sm-6 col-xs-6">
				<div class="form-group col-md-12 col-sm-12 col-xs-12">			                
					<div class="col-md-6 col-sm-6 col-xs-6">    
						<select name="zone" id="zone" class="form-control" >
							<option value=""selected disabled>~ዞባ ምረፅ~</option>
						
						</select>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6">    
						<select name="woreda" id="woreda" class="form-control">
							<option value="">~ወረዳ ምረፅ~</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
			</div> -->	
	</div>
    <form method="get" action="{{ url('corelistexcel') }}">
        <button class="btn btn-success" type="submit" id="excelbtn"><span class="fa fa-download"></span>ኤክሴል ኣውርድ</button>
    </form>
	<div class="box box-primary">
		<div class="box-header with-border">			
			<div class="">
				{{ csrf_field() }}
				<div class="table-responsive text-center">
					<table class="table table-borderless" id="table2">
						<thead>
							<tr>
								<th class="text-center">መ.ቑ</th>
								<th class="text-center">ሽም ቀዋሚደጋፊ</th>
								<th class="text-center">ፆታ</th>
								<th class="text-center">ዕድመ</th>
								<th class="text-center">ትውልዲ ቦታ</th>
								<th class="text-center">ኣባልነት ዘመን</th>								
								<th class="text-center">ደራጃ ት/ቲ</th>
								<th class="text-center">ምድብ ስራሕ</th>
								<th class="text-center">ዝተወደበሉ ውዳበ</th>
								<th class="text-center">ዝተሳተፈሉ ብርኪ ኮሚቴ</th>
								<th class="text-center">ኣብ ኮሚቴ ዘለዎ ተሳትፎ</th>
								<th class="text-center">ኣድራሻ</th>								
								<!-- <th class="text-center">ተግባር</th> -->
								
							</tr>					
						</thead>
						<tbody>
							@foreach ($data as $mydata)										
							<tr>
								<td>{{ $mydata->id }}</td>	
								<td>{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }}</td>                          
								<td>{{ $mydata->gender }}</td>
								<td>{{ (date('Y') - date('Y',strtotime($mydata->dob))) }}</td>
								<td>{{ $mydata->birthPlace }}</td>
								<td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->coreDegafiregDate))) }}</td>
								<td>{{ $mydata->position }}</td>
								<td>{{ $mydata->occupation }}</td>
								<td>{{ $mydata->assignedWidabe }}</td>
								<td>{{ $mydata->participatedCommittee}}</td>
								<td>{{ $mydata->degafiparticipationinCommittee }}</td>
								<td>{{ $mydata->address }}</td>
								<!-- <td><button class="add-modal btn btn-success" data-info="{{ $mydata->hitsuyID }},{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }},{{ $mydata->tabiaID }}">
									<span class="glyphicon glyphicon-tick"></span>ኣባልነት ይፅድቕ</button>
									@if($mydata->hitsuy_status=='ሕፁይ')
									<button class="edit-modal btn btn-success" data-info="{{ $mydata->hitsuyID }},{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }},{{ $mydata->tabiaID }}">
									<span class="glyphicon glyphicon-plus"></span>ይናዋሕ</button>
									@endif
									<button class="delete-modal btn btn-warning" data-info="{{ $mydata->hitsuyID }},{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }},{{ $mydata->tabiaID }}">
									<span class="glyphicon glyphicon-minus"></span>ይሰረዝ</button>
								</td> -->									
						   </tr>
							@endforeach
							</tbody>
						</table>
						</div>
                        {{ $data->links() }}
						</div>						
	
	 </div>
    </div>
	
@endsection

@section('scripts-extra')
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script>
 
 
	 $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
     });
     $('select[name="zone"]').on('change', function() {
            var stateID = $(this).val();				
            //instead of ዞባ ምረፅ => ኩለን ዞባታት value="" selected,
               if(stateID) {
                $.ajax({
                    url: 'myform/ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="woreda"]').empty();
						$('select[name="woreda"]').append('<option value="'+ " " +'" selected disabled>'+ "~ወረዳ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="woreda"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else{
                $('select[name="woreda"]').empty();
            }
            $('#table2').DataTable().column(0).search('^'+stateID,true,false).draw();
        });
     $('select[name="woreda"]').on('change', function() {
            var stateID = $(this).val();
			$('#table2').DataTable().column(0).search('^[0-9]{2}'+stateID,true,false).draw();
        });
    //
	
</script>

@endsection

