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
<?php


use Carbon\Carbon;
use Carbon\CarbonInterval; ?>
<body>

 <div style="font-family:DejaVu Sans, sans-serif;" style='page-break-after:always;'>
   
</div>
<font size="2"  ><h2><u>ህልዊ ኣባል ኣሃዛዊ መረዳእታ ገጠርን ከተማን </u></h2></font>
	<table border="1" width="100%" cellpadding="2"  >
  <thead>
  <tr>
    <th rowspan="3">ዞባ/ወረዳ</th>
    <th rowspan="3">መበገሲ ኣባል</th>
    <th colspan="4"> ምኽንያት ወሰኽ</th>
    <th colspan="10">ምኽንያት ጉድለት</th>
    <th rowspan="3"> ሚዛን</th>
    <th rowspan="3"> ሐዚ ዘሎ በዝሒ ኣባል</th>
  </tr>
  <tr>
        <th rowspan="2">ብምልመላ</th>
        <th rowspan="2">ብዝውውር</th>
        <th rowspan="2">ተኣጊዱ ዝነበረ</th>
        <th rowspan="2">ድምር ወሰኽ</th>
        <th rowspan="2">ብሞት</th>
        <th rowspan="2">ብምብራር</th>
        <th rowspan="2">ብምእጋድ</th>
        <th colspan="4" >ብዝውውር ናብ</th>
        <th rowspan="2">ብስንብት</th>
        <th rowspan="2">ድምር ጉድለት</th>
  </tr>
  <tr>
        <th >ዩኒቨርስቲ</th>
        <th >ኣብ  ዞባ ውሽጢ</th>
        <th >  ክልል ውሽጢ</th>
        <th >ካብ ክልልና ወፃኢ</th>

  </tr>
  <tbody>

  <?php $count = DB::table('hitsuys') ->where('hitsuys.gender', '=', 'female') ->count();?>
    <?php $i = 1; ?> <?php $s = " "; ?>
  @foreach($Tabias as $key => $tabia)
<tr >
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td>
      
        
            <td > </td>
            <td ></td>
          
 
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td> 
      <td ></td>
      <td ></td>
      <td ></td>
      <td > </td>   
      <td ></td>
      <td ></td>  
  </tr>
    <?php $i++; ?>
  @endforeach 
  <tr >
      <th>ድምር</th>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td></td>
      <td > </td>
      <td > </td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td> 
      <td ></td>
      <td ></td>  
      <td ></td>
      <td ></td> 
  </tr>
  <tr >
      <th >%</th>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td></td>
      <td > </td>
      <td > </td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td> 
      <td ></td>
      <td ></td> 
      <td ></td>
      <td ></td>  
  </tr>
  </tbody>
  
</table>
. ወሰኽ    --%.       ጉድለት  --%      . ሚዛን --%
</font>
</body>
</html>