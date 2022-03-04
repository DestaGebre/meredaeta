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
<font size="2"  ><h2><u>ቅፅዓታት ኣመራርሓ ዞባ ኮሚቴ </u></h2></font>
<table border="1" width="100%" cellpadding="2"  >
<thead>
<tr>
  <th rowspan="2">ዞባ/ወረዳ</th>
  <th colspan="3"> ፆታ</th>
  <th colspan="4">ዓይነት ቅፅዓት</th>
  <th colspan="3"> ምኽንያት ቅፅዓት  </th> 
  <th rowspan="2"> ተወሳኺ መብርሂ</th>
  
</tr>
<tr>
      <th>ተባ</th>
      <th>ኣነ</th>
      <th>ድምር</th>
      <th>መጠንቀቅታ</th>
      <th>ደረጃ ምቅናስ </th>
      <th>ካብ ሓላፍነት ምውራድ </th>
      <th>ካብ ሓላፍነትን ኣባልነትን ምብራር </th>
      <th>ግቡእ ዘይምፍፃም </th>
      <th>ናይ ስነ ምግባር ጉድለት </th>
      <th>ምንኣስ ዓቕሚ  </th>
</tr>
<tbody> 
  
  <?php $i = 1; $mulueC= 0 ; $hitsuyC = 0 ; $dimir1 = 0; $age1C = 0; $age2C = 0; $age3C = 0; $edu1C = 0; 
  $edu2C = 0; $edu3C = 0; $edu4C = 0; $edu5C = 0; $edu6C = 0; $edu7C = 0; $edu8C = 0; $edusumC = 0;?> <?php $s = " "; ?>
  @foreach($zobatat as $zob)

  
<tr >
<td >{{$zob->zoneName}}</td>
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ተባ')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
    echo $count?></td>
<td ><?php $count1 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ኣን')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
    echo $count1?></td>
<td ><?php echo $count + $count1 ?> </td>
        <?php $userss = DB::select('SELECT COUNT(*) FROM hitsuys WHERE hitsuyID LIKE 01 ');?>
        <?php // // $users = DB::select('select COUNT(*) from hitsuys where   (YEAR(NOW()) - YEAR(dob)) BETWEEN 24 AND 34');?>
        <?php // $from = new DateTime((date('Y:M:D') - 100)); $to= new DateTime('today'); 
        
        // $age1 = DB::table('hitsuys') ->whereBetween('hitsuys.dob', [$from, $to]) ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
        // $z = DB::select(DB::raw("select COUNT(*) from hitsuys where hitsuyID LIKE 01 and  (YEAR(NOW()) - YEAR(dob)) BETWEEN 18 AND 100"))
        ?>
       <td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count2 = DB::table('approved_hitsuys')->join('siltenas', 'approved_hitsuys.hitsuyID', '=', 'siltenas.hitsuyID') 
  ->where('siltenas.trainingLevel', '=', 'ላዕለዋይ ኣመራርሓ') 
  ->whereBetween('siltenas.created_at', [$now,  $then])
  ->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
  ->count(); 
  echo $count2?></td>

<td><?php echo $count2?> </td>
    
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count3 = DB::table('approved_hitsuys')->join('siltenas', 'approved_hitsuys.hitsuyID', '=', 'siltenas.hitsuyID') 
  ->where('siltenas.trainingLevel', '=', 'ላዕለዋይ ኣመራርሓ') 
  ->whereBetween('siltenas.created_at', [$now,  $then])
  ->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
  ->count(); 
  echo $count3?></td>
    
    
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count4 = DB::table('approved_hitsuys')->join('siltenas', 'approved_hitsuys.hitsuyID', '=', 'siltenas.hitsuyID') 
  ->where('siltenas.trainingLevel', '=', 'ላዕለዋይ ኣመራርሓ') 
  ->whereBetween('siltenas.created_at', [$now,  $then])
  ->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
  ->count(); 
  echo $count4?></td>

<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count5 = DB::table('approved_hitsuys')->join('siltenas', 'approved_hitsuys.hitsuyID', '=', 'siltenas.hitsuyID') 
  ->where('siltenas.trainingLevel', '=', 'ላዕለዋይ ኣመራርሓ') 
  ->whereBetween('siltenas.created_at', [$now,  $then])
  ->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
  ->count(); 
  echo $count5?></td>

    
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count6 = DB::table('approved_hitsuys')->join('siltenas', 'approved_hitsuys.hitsuyID', '=', 'siltenas.hitsuyID') 
  ->where('siltenas.trainingLevel', '=', 'ላዕለዋይ ኣመራርሓ') 
  ->whereBetween('siltenas.created_at', [$now,  $then])
  ->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
  ->count(); 
  echo $count6?></td>


    
    
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count7 = DB::table('approved_hitsuys')->join('siltenas', 'approved_hitsuys.hitsuyID', '=', 'siltenas.hitsuyID') 
  ->where('siltenas.trainingLevel', '=', 'ላዕለዋይ ኣመራርሓ') 
  ->whereBetween('siltenas.created_at', [$now,  $then])
  ->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
  ->count(); 
  echo $count7?></td>
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count8= DB::table('approved_hitsuys')->join('siltenas', 'approved_hitsuys.hitsuyID', '=', 'siltenas.hitsuyID') 
  ->where('siltenas.trainingLevel', '=', 'ላዕለዋይ ኣመራርሓ') 
  ->whereBetween('siltenas.created_at', [$now,  $then])
  ->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
  ->count(); 
  echo $count8?></td>   
  
</tr>
  <?php $i++; $mulueC= $mulueC + $count ; $hitsuyC = $hitsuyC + $count1; $dimir1 = $mulueC + $hitsuyC; $age1C = $age1C + $count2; $age2C = $age2C + $count3; $age3C = $age3C + $count4; $ageC = $age1C + $age2C + $age3C;$edu1C = $edu1C + $count7; 
  $edu2C = $edu2C + $count7; $edu3C = $edu3C + $count7; $edu4C = $edu4C + $count7 ; $edu5C = $edu5C + $count7; $edu6C = $edu6C + $count7; $edu7C = $edu7C + $count7; $edu8C = $edu8C + $count7; $edusumC = $edusumC + $count7;?>
 
@endforeach

<tr >
    <th>ድምር</th>
    <td ><?php echo $mulueC;?></td>
    <td ><?php echo $hitsuyC;?></td>
    <td ><?php echo $dimir1;?></td>
    <td ><?php echo $age1C;?></td>
    <td ><?php echo $age2C;?></td>
    <td><?php echo $age3C;?></td>
    <td ><?php echo $edu1C;?> </td>
    <td ><?php echo $edu2C;?> </td>
    <td ><?php echo $edu3C;?></td>
    <td ><?php echo $edu4C;?></td>
    <td ><?php echo $edu5C;?></td>
    
    
     
</tr>
<tr >
    <th >ሚኢታዊ(%)</th>
    

       <?php if($dimir1 == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($mulueC / $dimir1)*100;?></td>
        <?php endif; ?>
        <?php if($dimir1 == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($hitsuyC /$dimir1)*100;?></td>
        <?php endif; ?>
        <?php if($dimir1 == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($dimir1 / $dimir1)*100;?></td>
        <?php endif; ?>
        <?php $ageC = $age1C + $age2C + $age3C;?>
        <?php if($ageC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($age1C / $ageC)*100;?></td>
        <?php endif; ?>
        <?php if($ageC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($age2C / $ageC)*100;?></td>
        <?php endif; ?>
        <?php if($ageC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($age3C / $ageC)*100;?></td>
        <?php endif; ?>
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edu1C/ $edusumC)*100;?></td>
        <?php endif; ?>
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edu2C/ $edusumC)*100;?></td>
        <?php endif; ?>
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edu3C/ $edusumC)*100;?></td>
        <?php endif; ?>
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edu4C/ $edusumC)*100;?></td>
        <?php endif; ?>
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edu5C/ $edusumC)*100;?></td>
        <?php endif; ?>
       
        
        
</tr>
</tbody>

</table>
</br>
</font>
</body>
</html>