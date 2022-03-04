<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
	* { font-family: BZar_0, gfzemenu, sans-serif; }
	table {
    border-collapse: collapse;
}
td, th {
    border: 1px solid black;
}
	</style>
</head>
<body>
<h2>ወረዳ:<u>  </u>  <h2> 
 <div style="font-family:DejaVu Sans, sans-serif;" style='page-break-after:always;'>
   
</div>
<font size="2"  ><h2><u>ናይ መሰረታዊ ዉዳበን ዋህዮን ጠርነፍቲ መምልኢ ማህደር ብመልክዕ ንኡስ ኦርኔል </u></h2></font>
	<table border="1" width="100%" cellpadding="2"  >
	<thead>
	<tr>
		<th rowspan="2"> ተ.ቁ</th>
		<th rowspan="2"> ሙሉእ ሽም</th>
		<th rowspan="2">ፆታ</th>
		<th rowspan="2"> ዕድመ</th>
		<th  rowspan="2" > ትምህርቲ</th>
		<th rowspan="2"> ዝነብረሉ ጣብያ/ቀበሌ</th>
		<th colspan="2"> ዓይነት ኣባል</th>
		<th rowspan="2"> ዘለዎ ሓላፊነት</th>
		<th  rowspan="2"> ኣባልነት ዘመን</th>
		<th colspan="3" > ውፅኢት ገምጋም</th>
		<th colspan="2" > ስልጠና ዝምልከት</th>
		<th rowspan="2" > ሪኢቶን ፌርማን በዓል ዋና</th>
	</tr>
	<tr>
				<th>ሞዴል</th>
				<th>ዘይሞዴል</th>
				<th>A</th>
				<th>B</th>
				<th>C</th>
				<th>ዝሰልጠነ</th>
				<th>ዘይሰልጠነ</th>
	</tr>
	<tbody>
		<?php $i = 1; ?> <?php $s = " "; ?>
	@foreach($Tabias as $key => $tabia)
<tr >
			<td ><?php echo $i; ?></td>
			<td ><?php echo $tabia->name.$s.$tabia->fname.$s.$tabia->gfname ?></td>
			<td >{{$tabia->gender}}</td>
			<td ><?php $from = new DateTime($tabia->dob); $to= new DateTime('today'); echo $from->diff($to)->y;?></td>
			<td >{{$tabia->position}}</td>
			<td >{{$tabia->tabiaID}}</td>
			
					<?php if(!empty($tabia->tabiaID)) : ?>
						<td style="font-family:DejaVu Sans, sans-serif;">&#10004</td>
						<td > </td>
					<?php else : ?>
						<td > </td>
						<td >&#10004</td>
					<?php endif; ?>
 
			<td >{{$tabia->deraja}}</td>
			<td >{{$tabia->regDate}}</td>
			<td >{{$tabia->tabiaID}}</td>
			<td >{{$tabia->tabiaID}}</td> 
			<td >{{$tabia->tabiaID}}</td>
			<td >{{$tabia->tabiaID}}</td>
			<td >{{$tabia->tabiaID}}</td>
			<td > </td>		
	</tr>
		<?php $i++; ?>
	@endforeach 
	</tbody>
</table>
</font>
<br/> <br/> <br/> <br/>
<table cellspacing="3" cellpadding="5" width="100%">
				<tr>

					<td width="25%">
						<div class="form-group">
							<a href="{{ route('DownloadPDF') }}" class="btn btn-primary">Download Sample PDF</a>
						</div>
					</td>

					<td width="25%">
						<div class="form-group">
							<a href="{{ route('HtmlToPDF') }}" class="btn btn-primary">Html To PDF</a>
						</div>
					</td>

				</tr>
			</table>
</body>
</html>