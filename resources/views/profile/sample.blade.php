@extends('layouts.app')

@section('htmlheader_title')
ሙከራ
@endsection

@section('contentheader_title')
Sample Table
@endsection

@section('header-extra')

@endsection

@section('main-content')
	<div>
		<table class="table" id="tableId">			

			<hr style="border:groove 1px #79D57E;"/>
			<thead>
				<tr>
					<th >Name</th>
					<th >Age</th>
					<th >Gender</th>
					<th >Mobile</th>
					<th >Address</th>																											
				</tr>

			</thead>

			<tbody>

				<tr>
					<td>Tewodros</td>
					<td>24</td>
					<td>M</td>
					<td>0914</td>
					<td>Mekelle</td>																											
				</tr>
				<tr>
					<td>Hana</td>
					<td>26</td>
					<td>F</td>
					<td>0922</td>
					<td>Aksum</td>																											
				</tr>
				<tr>
					<td>Mehari</td>
					<td>34</td>
					<td>M</td>
					<td>0924</td>
					<td>Adigrat</td>																											
				</tr>							
			</tbody>
		</table>
	</div>
@endsection
@section('scripts-extra')
<link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />      
<script type="text/javascript" src="js/jquery.dataTables.min.js" ></script>
<script type="text/javascript">
	$(document).ready(function(){	
	// starting dataTables
	$('#tableId').DataTable();
	});
</script>

@endsection