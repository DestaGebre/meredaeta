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
<font size="2"  ><h2><u>ጠርነፍቲ  ዋህዮ ተምሃሮን መ/ሰራሕተኛን ገጠርን ከተማን </u></h2></font>
<table border="1" width="100%" cellpadding="2"  >
  <thead>
  <tr>
  <th rowspan="2">ተ/ቁ</th>
    <th rowspan="2">ዞባ/ወረዳ</th>
    <th colspan="4"> ብፆታ</th>
    <th colspan="2">ብደረጃ ዕድመ</th>
    <th colspan="2"> ብደረጃ ትምህርቲ </th>
    <th colspan="3"> ደረጃ ስርርዕ  </th>
    <th rowspan="2"> በዝሒ ክፍቲ </th>
    <th rowspan="2"> መብርሂ</th>
  </tr>
  <tr>
        <th>ተባ</th>
        <th>ኣነ</th>
        <th>ድምር</th>
        <th>ኣ%</th>
        <th>18-35</th>
        <th>≥36</th>
        
        <th>≤12 ክፍሊ </th>
        <th>≥ሰርተፊኬት</th>
        <th>A</th>
        <th>B</th>
        <th>C</th>
        
        
  </tr>
  <tbody> 
    
    <?php $i = 1; $mulueC= 0 ; $hitsuyC = 0 ; $dimir1 = 0; $age1C = 0; $age2C = 0; $age3C = 0; $edu1C = 0; 
    $edu2C = 0; $edu3C = 0; $edu4C = 0; $edu5C = 0; $edu6C = 0; $edu7C = 0; $edu8C = 0; $edusumC = 0;?> <?php $s = " "; ?>
    @foreach($zobatat as $zob)
  
    
<tr >
<td ><?php echo $i?></td>
<td >{{$zob->zoneName}}</td>
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ወረዳ ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ተባ')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $count?></td>
<td ><?php $count1 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ወረዳ ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ኣን')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $count1?></td>
<td ><?php echo $count + $count1 ?> </td>
<td ><?php echo $count + $count1 ?> </td>
          <?php $userss = DB::select('SELECT COUNT(*) FROM hitsuys WHERE hitsuyID LIKE 01 ');?>
          <?php // // $users = DB::select('select COUNT(*) from hitsuys where   (YEAR(NOW()) - YEAR(dob)) BETWEEN 24 AND 34');?>
          <?php // $from = new DateTime((date('Y:M:D') - 100)); $to= new DateTime('today'); 
          
          // $age1 = DB::table('hitsuys') ->whereBetween('hitsuys.dob', [$from, $to]) ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
          // $z = DB::select(DB::raw("select COUNT(*) from hitsuys where hitsuyID LIKE 01 and  (YEAR(NOW()) - YEAR(dob)) BETWEEN 18 AND 100"))
          ?>
          <?php
          $minAge1 = 18;
          $maxAge1 = 35;
          $minDate1 = Carbon::today()->subYears($maxAge1); 
          $maxDate1 = Carbon::today()->subYears($minAge1);
          $age1 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
          -> where('membershipType', '=', 'ወረዳ ኣመራርሓ')
          ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
          ->whereBetween('hitsuys.dob', [$minDate1, $maxDate1]) ->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count();
          ?>

<td><?php echo $age1?> </td>
      
                <?php
            $minAge2 = 36;
            $maxAge2 = 50;
            $minDate2 = Carbon::today()->subYears($maxAge2); 
            $maxDate2 = Carbon::today()->subYears($minAge2);
            $age2 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
            -> where('membershipType', '=', 'ወረዳ ኣመራርሓ') 
            ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
            ->whereBetween('hitsuys.dob', [$minDate2, $maxDate2]) ->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count();
            ?>
<td ><?php echo $age2; ?></td>
      
      
                    <?php
              $minAge3 = 61;
              $maxAge3 = 1000;
              $minDate3 = Carbon::today()->subYears($maxAge3); 
              $maxDate3 = Carbon::today()->subYears($minAge3);
              $age3 = DB::table('hitsuys') ->whereBetween('hitsuys.dob', [$minDate3, $maxDate3]) ->where('hitsuyID','LIKE','0'.$i.'%')->count();
              ?>

<td ><?php $edu1 = DB::table('approved_hitsuys')->join('education_informations', 'approved_hitsuys.hitsuyID', '=', 'education_informations.hitsuyID')
          -> where('membershipType', '=', 'ወረዳ ኣመራርሓ')
->where('education_informations.educationLevel', '=', 'ት/ቲ ዘይብሉ') ->where('education_informations.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu1?></td>
<td ><?php $edu2 = DB::table('approved_hitsuys')->join('education_informations', 'approved_hitsuys.hitsuyID', '=', 'education_informations.hitsuyID')
          -> where('membershipType', '=', 'ወረዳ ኣመራርሓ')
->where('education_informations.educationLevel', '=', '1-8') ->where('education_informations.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu2?></td>
      
<td ><?php $edu3 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', '9-12 ') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu3?></td>
<td ><?php $edu4 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ሰርቲፊኬት') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu4?></td>
 
<td ><?php $edu5 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ዲፕሎማj') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu5?></td>
<td ><?php $edu6 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ዲግሪh') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu6?></td>
<?php $edu7 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'MSf') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      ?>
<?php $edu8 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ዶክተር') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      ?>
<td ><?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?> </td > 
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?>  

</tr>
    <?php $i++; $mulueC= $mulueC + $count ; $hitsuyC = $hitsuyC + $count1; $dimir1 = $mulueC + $hitsuyC; $age1C = $age1C + $age1; $age2C = $age2C + $age2; $age3C = $age3C + $age2; $ageC = $age1C + $age2C + $age3C;$edu1C = $edu1C + $edu1; 
    $edu2C = $edu2C + $edu2; $edu3C = $edu3C + $edu3; $edu4C = $edu4C + $edu4 ; $edu5C = $edu5C + $edu5; $edu6C = $edu6C + $edu6; $edu7C = $edu7C + $edu7; $edu8C = $edu8C + $edu8; $edusumC = $edusumC + $edusum;?>
   
  @endforeach

  <tr >
  <th colspan="2">ድምር</th>
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
      <td ></td>
      
      
  </tr>
  
  </tbody>
  
</table>
</br>
</font>
</body>
</html>


