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
    <th rowspan="2">ዞባ</th>
    <th colspan="3"> ደረጃ ኣባልነት</th>
    <th colspan="3">ደረጃ ዕድመ</th>
    <th colspan="9"> ደረጃ ትምህርቲ</th>
  </tr>
  <tr>
        <th>ሙሉእ</th>
        <th>ሕፁይ</th>
        <th>ድምር</th>
        <th>18-35</th>
        <th>36-60</th>
        <th>ልዕሊ 61</th>
        <th>ት/ቲ ዘይብሉ</th>
        <th>1-8</th>
        <th>9-12</th>
        <th>ሰርቲፊኬት</th>
        <th>ዲፕሎማ</th>
        <th>ዲግሪ</th>
        <th>MS</th>
        <th>ዶክተር</th>
        <th>ድምር </th>
  </tr>
  <tbody> 
    
    <?php $i = 1; $mulueC= 0 ; $hitsuyC = 0 ; $dimir1 = 0; $age1C = 0; $age2C = 0; $age3C = 0; $edu1C = 0; 
    $edu2C = 0; $edu3C = 0; $edu4C = 0; $edu5C = 0; $edu6C = 0; $edu7C = 0; $edu8C = 0; $edusumC = 0;?> <?php $s = " "; ?>
    @foreach($zobatat as $zob)
  
    
<tr >

      <td >{{$zob->zoneName}}</td>
      
      
      <td ><?php $count = DB::table('hitsuys') ->where('hitsuys.hitsuy_status', '=', 'ሙሉእ') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $count?></td>
    <td ><?php $count1 = DB::table('hitsuys') ->where('hitsuys.hitsuy_status', '=', 'ሕፁይ') 
    ->where('hitsuyID','LIKE','0'.$i.'%')
    ->count(); 
      echo $count1?></td>
    <td ><?php echo $count + $count1 ?> </td>
    <?php $userss = DB::select('SELECT COUNT(*) FROM hitsuys WHERE hitsuyID LIKE 01 ');?>
    <?php // // $users = DB::select('select COUNT(*) from hitsuys where   (YEAR(NOW()) - YEAR(dob)) BETWEEN 24 AND 34');?>
    <?php // $from = new DateTime((date('Y:M:D') - 100)); $to= new DateTime('today'); 
    
    // $age1 = DB::table('hitsuys') ->whereBetween('hitsuys.dob', [$from, $to]) ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
    // $z = DB::select(DB::raw("select COUNT(*) from hitsuys where hitsuyID LIKE 01 and  (YEAR(NOW()) - YEAR(dob)) BETWEEN 18 AND 100"))
    ?>
<?php
// explode the range and set as follows
$minAge1 = 18;
$maxAge1 = 35;
// prepare dates for comparison
$minDate1 = Carbon::today()->subYears($maxAge1); // make sure to use Carbon\Carbon in the class
$maxDate1 = Carbon::today()->subYears($minAge1);
// then add to the query
$age1 = DB::table('hitsuys') ->whereBetween('hitsuys.dob', [$minDate1, $maxDate1]) ->where('hitsuyID','LIKE','0'.$i.'%')->count();
?>

    <td><?php echo $age1?> </td>
      
    <?php
// explode the range and set as follows
$minAge2 = 36;
$maxAge2 = 60;
// prepare dates for comparison
$minDate2 = Carbon::today()->subYears($maxAge2); // make sure to use Carbon\Carbon in the class
$maxDate2 = Carbon::today()->subYears($minAge2);
// then add to the query
$age2 = DB::table('hitsuys') ->whereBetween('hitsuys.dob', [$minDate2, $maxDate2]) ->where('hitsuyID','LIKE','0'.$i.'%')->count();
?>
      <td ><?php echo $age2; ?></td>
      
      
      <?php
// explode the range and set as follows
$minAge3 = 61;
$maxAge3 = 1000;
// prepare dates for comparison
$minDate3 = Carbon::today()->subYears($maxAge3); // make sure to use Carbon\Carbon in the class
$maxDate3 = Carbon::today()->subYears($minAge3);
// then add to the query
$age3 = DB::table('hitsuys') ->whereBetween('hitsuys.dob', [$minDate3, $maxDate3]) ->where('hitsuyID','LIKE','0'.$i.'%')->count();
?>
      <td ><?php echo $age3; ?></td>
      <td ><?php $edu1 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ት/ቲ ዘይብሉ') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu1?></td>
      <td ><?php $edu2 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', '1-8') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu2?></td>
      
      <td ><?php $edu3 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', '9-12 ') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu3?></td>
      <td ><?php $edu4 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ሰርቲፊኬት') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu4?></td>
 
 <td ><?php $edu5 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ዲፕሎማ') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu5?></td>
      <td ><?php $edu6 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ዲግሪ') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu6?></td>
      <td ><?php $edu7 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'MS') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu7?></td>
      <td ><?php $edu8 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ዶክተር') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu8?></td> 
      <td ><?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; echo $edusum?> </td>  
  </tr>
    <?php $i++; $mulueC= $mulueC + $count ; $hitsuyC = $hitsuyC + $count1; $dimir1 = $mulueC + $hitsuyC; $age1C = $age1C + $age1; $age2C = $age2C + $age2; $age3C = $age3C + $age3; $ageC = $age1C + $age2C + $age3C;$edu1C = $edu1C + $edu1; 
    $edu2C = $edu2C + $edu2; $edu3C = $edu3C + $edu3; $edu4C = $edu4C + $edu4 ; $edu5C = $edu5C + $edu5; $edu6C = $edu6C + $edu6; $edu7C = $edu7C + $edu7; $edu8C = $edu8C + $edu8; $edusumC = $edusumC + $edusum;?>
   
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
      <td ><?php echo $edu6C;?></td>
      <td ><?php echo $edu7C;?></td> 
      <td ><?php echo $edu8C;?></td>
      <td ><?php echo $edusumC;?></td>   
  </tr>
  <tr >
      <th >%</th>
      

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
          <?php if($edusumC == 0): ?>
            <td > <?php echo 0?></td>
          <?php else : ?>
            <td > <?php echo ($edu6C/ $edusumC)*100;?></td>
          <?php endif; ?>
          <?php if($edusumC == 0): ?>
            <td > <?php echo 0?></td>
          <?php else : ?>
            <td > <?php echo ($edu7C/ $edusumC)*100;?></td>
          <?php endif; ?>
          <?php if($edusumC == 0): ?>
            <td > <?php echo 0?></td>
          <?php else : ?>
            <td > <?php echo ($edu8C/ $edusumC)*100;?></td>
          <?php endif; ?>
          <?php if($edusumC == 0): ?>
            <td > <?php echo 0?></td>
          <?php else : ?>
            <td > <?php echo ($edusumC/ $edusumC)*100;?></td>
          <?php endif; ?> 
  </tr>
  </tbody>
  
</table>
</font>
</body>
</html>