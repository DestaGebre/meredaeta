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
<font size="2"  ><h2><u>ጠቕላላ ህልዊ ኣመራርሓ  ዞባ /ወረዳ  </u></h2></font>
<table border="1" width="100%" cellpadding="2"  >
  <thead>
  <tr>
    <th rowspan="2">ደረጃ ስርርዕ </th>
    <th colspan="4"> ብፆታ</th>
    <th colspan="2">ብደረጃ ዕድመ</th>
    <th colspan="4"> ብደረጃ ትምህርቲ </th>
    <th colspan="2"> ምድብ ስራሕ </th>
    <th colspan="2"> ዓ/ኣመራርሓ </th>
    
  </tr>
  <tr>
        <th>ተባ</th>
        <th>ኣነ</th>
        <th>ድምር</th>
        <th>%ኣ</th>
        <th><=35</th>
        <th>>=36</th>
        <th><=ዲፕሎም</th>
        <th>ዲግሪ</th>
        <th>ማስተር</th>
        <th>ዶክተር /PHD </th>
        
        <th>ኣብ ዞባ ፈፃሚት  </th>
        <th>ኣብ ወረዳን ስታፍን </th>
        <th>ነባር</th>
        <th>ሓድሽ</th>
       
  </tr>
  <tbody> 
    
    <?php $i = 1; $mulueC= 0 ; $hitsuyC = 0 ; $dimir1 = 0; $age1C = 0; $age2C = 0; $age3C = 0; $edu1C = 0; 
    $edu2C = 0; $edu3C = 0; $edu4C = 0; $edu5C = 0; $edu6C = 0; $edu7C = 0; $edu8C = 0; $edusumC = 0;?> <?php $s = " "; ?>
   
  
    
<tr >
<td >ላ/ኣመራርሓ</td>
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ተባ')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $count?></td>
<td ><?php $now= Carbon::today(); $then=Carbon::today()->subMonths(3); $count1 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ኣን')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $count1?></td>
<td ><?php echo $count + $count1 ?> </td>
<?php if($count + $count1 == 0): ?>
            <td > <?php echo 0?></td>
          <?php else : ?>
            <td > <?php echo ($count1/ $count + $count1)*100;?></td>
          <?php endif; ?>
<?php
              $minAge3 = 61;
              $maxAge3 = 1000;
              $minDate3 = Carbon::today()->subYears($maxAge3); 
              $maxDate3 = Carbon::today()->subYears($minAge3);
              $age3 = DB::table('hitsuys') ->whereBetween('hitsuys.dob', [$minDate3, $maxDate3]) ->where('hitsuyID','LIKE','0'.$i.'%')->count();
              ?>

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
          -> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
          ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
          ->whereBetween('hitsuys.dob', [$minDate1, $maxDate1]) ->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count();
          ?>

<td><?php echo $age1?> </td>
      
                <?php
            $minAge2 = 36;
            $maxAge2 = 1000;
            $minDate2 = Carbon::today()->subYears($maxAge2); 
            $maxDate2 = Carbon::today()->subYears($minAge2);
            $age2 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
            -> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
            ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
            ->whereBetween('hitsuys.dob', [$minDate2, $maxDate2]) 
            ->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count();
            ?>
<td ><?php echo $age2; ?></td>
      
      
                    
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
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?> 
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?>  
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?>   
</tr>
    <?php $i++; $mulueC= $mulueC + $count ; $hitsuyC = $hitsuyC + $count1; $dimir1 = $mulueC + $hitsuyC; $age1C = $age1C + $age1; $age2C = $age2C + $age2; $age3C = $age3C + $age3; $ageC = $age1C + $age2C + $age3C;$edu1C = $edu1C + $edu1; 
    $edu2C = $edu2C + $edu2; $edu3C = $edu3C + $edu3; $edu4C = $edu4C + $edu4 ; $edu5C = $edu5C + $edu5; $edu6C = $edu6C + $edu6; $edu7C = $edu7C + $edu7; $edu8C = $edu8C + $edu8; $edusumC = $edusumC + $edusum;?>
   

  <tr >
  <tr >
<td >ማ/ኣመራርሓ </br>
(ጠ/ወረዳ ኣመራርሓ </br>
+ካብ ጠ/ወ/ኣመራርሓ ወፃእ)</td>
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count3= DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ማ/ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ተባ')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $count3?></td>
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count4 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ማ/ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ኣን')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $count4?></td>
<td ><?php echo $count3 + $count4 ?> </td>
<?php if($count3 + $count4 == 0): ?>
            <td > <?php echo 0?></td>
          <?php else : ?>
            <td > <?php echo ($count3/ $count3 + $count4)*100;?></td>
          <?php endif; ?>
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
          -> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
          ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
          ->whereBetween('hitsuys.dob', [$minDate1, $maxDate1]) ->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count();
          ?>

<td><?php echo $age1?> </td>
      
                <?php
            $minAge2 = 36;
            $maxAge2 = 1000;
            $minDate2 = Carbon::today()->subYears($maxAge2); 
            $maxDate2 = Carbon::today()->subYears($minAge2);
            $age2 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
            -> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
            ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
            ->whereBetween('hitsuys.dob', [$minDate2, $maxDate2]) 
            ->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count();
            ?>
<td ><?php echo $age2; ?></td>
      
      
                    <?php
              $minAge3 = 61;
              $maxAge3 = 1000;
              $minDate3 = Carbon::today()->subYears($maxAge3); 
              $maxDate3 = Carbon::today()->subYears($minAge3);
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
<?php $edu8 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ዶክተር') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      ?> 
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?> 
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?>  
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?>   
</tr>
    <?php $i++; $mulueC= $mulueC + $count ; $hitsuyC = $hitsuyC + $count1; $dimir1 = $mulueC + $hitsuyC; $age1C = $age1C + $age1; $age2C = $age2C + $age2; $age3C = $age3C + $age3; $ageC = $age1C + $age2C + $age3C;$edu1C = $edu1C + $edu1; 
    $edu2C = $edu2C + $edu2; $edu3C = $edu3C + $edu3; $edu4C = $edu4C + $edu4 ; $edu5C = $edu5C + $edu5; $edu6C = $edu6C + $edu6; $edu7C = $edu7C + $edu7; $edu8C = $edu8C + $edu8; $edusumC = $edusumC + $edusum;?>
   

  <tr >
  <tr >
<td > ጀማሪ/ዕቁር ኣመራርሓ     
</td>
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count5 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ጀማሪ ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ተባ')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $count5?></td>
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count6 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ጀማሪ ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ኣን')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $count6?></td>
<td ><?php echo $count5 + $count6 ?> </td>
<?php if($count5 + $count6 == 0): ?>
            <td > <?php echo 0?></td>
          <?php else : ?>
            <td > <?php echo ($count5/ $count5 + $count6)*100;?></td>
          <?php endif; ?>
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
          -> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
          ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
          ->whereBetween('hitsuys.dob', [$minDate1, $maxDate1]) ->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count();
          ?>

<td><?php echo $age1?> </td>
      
                <?php
            $minAge2 = 36;
            $maxAge2 = 1000;
            $minDate2 = Carbon::today()->subYears($maxAge2); 
            $maxDate2 = Carbon::today()->subYears($minAge2);
            $age2 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
            -> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
            ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
            ->whereBetween('hitsuys.dob', [$minDate2, $maxDate2]) 
            ->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count();
            ?>
<td ><?php echo $age2; ?></td>
      
      
                    <?php
              $minAge3 = 61;
              $maxAge3 = 1000;
              $minDate3 = Carbon::today()->subYears($maxAge3); 
              $maxDate3 = Carbon::today()->subYears($minAge3);
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
<?php $edu8 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ዶክተር') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      ?>
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?> 
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?>  
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?>   
</tr>
    <?php $i++; $mulueC= $mulueC + $count ; $hitsuyC = $hitsuyC + $count1; $dimir1 = $mulueC + $hitsuyC; $age1C = $age1C + $age1; $age2C = $age2C + $age2; $age3C = $age3C + $age3; $ageC = $age1C + $age2C + $age3C;$edu1C = $edu1C + $edu1; 
    $edu2C = $edu2C + $edu2; $edu3C = $edu3C + $edu3; $edu4C = $edu4C + $edu4 ; $edu5C = $edu5C + $edu5; $edu6C = $edu6C + $edu6; $edu7C = $edu7C + $edu7; $edu8C = $edu8C + $edu8; $edusumC = $edusumC + $edusum;?>
   

  <tr >
  <tr >
<td >ታሕተዋይ  ኣመራርሓ </br> (ዋህዮ፣መ/ውዳበ) ጠርነፍቲ</td>
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count7 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ታሕተዋይ ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ተባ')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $count7?></td>
<td ><?php $now= carbon::today(); $then=$now->subMonths(3); $count8 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID') 
-> where('membershipType', '=', 'ታሕተዋይ ኣመራርሓ')
-> where('hitsuys.gender', '=', 'ኣን')
->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $count8?></td>
<td ><?php echo $count7 + $count8 ?> </td>
<?php if($count7 + $count8 == 0): ?>
            <td > <?php echo 0?></td>
          <?php else : ?>
            <td > <?php echo ($count7/ $count7 + $count8)*100;?></td>
          <?php endif; ?>
         
      
          <?php
          $minAge1 = 18;
          $maxAge1 = 35;
          $minDate1 = Carbon::today()->subYears($maxAge1); 
          $maxDate1 = Carbon::today()->subYears($minAge1);
          $age1 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
          -> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
          ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
          ->whereBetween('hitsuys.dob', [$minDate1, $maxDate1]) ->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count();
          ?>

<td><?php echo $age1?> </td>
      
                <?php
            $minAge2 = 36;
            $maxAge2 = 1000;
            $minDate2 = Carbon::today()->subYears($maxAge2); 
            $maxDate2 = Carbon::today()->subYears($minAge2);
            $age2 = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
            -> where('membershipType', '=', 'ላዕለዋይ ኣመራርሓ')
            ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
            ->whereBetween('hitsuys.dob', [$minDate2, $maxDate2]) 
            ->where('hitsuys.hitsuyID','LIKE','0'.$i.'%')->count();
            ?>
<td ><?php echo $age2; ?></td>
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
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?> 
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?>  
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?>   
</tr>
    <?php $i++; $mulueC= $mulueC + $count ; $hitsuyC = $hitsuyC + $count1; $dimir1 = $mulueC + $hitsuyC; $age1C = $age1C + $age1; $age2C = $age2C + $age2; $age3C = $age3C + $age3; $ageC = $age1C + $age2C + $age3C;$edu1C = $edu1C + $edu1; 
    $edu2C = $edu2C + $edu2; $edu3C = $edu3C + $edu3; $edu4C = $edu4C + $edu4 ; $edu5C = $edu5C + $edu5; $edu6C = $edu6C + $edu6; $edu7C = $edu7C + $edu7; $edu8C = $edu8C + $edu8; $edusumC = $edusumC + $edusum;?>
   

  <tr >
      <th>ድምር</th>
      <td ><?php echo $mulueC;?></td>
      <td ><?php echo $hitsuyC;?></td>
      <td ><?php echo $dimir1;?></td>
      <td >-</td>
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
      
          
            <td > - </td>
         
            <?php $ageC = $age1C + $age2C + $age3C;?>
         
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
           
          
  </tr>
  </tbody>
  
</table>
</br>
ነዚ ቅጥዒ ዘዳለወ ፐርሶኔል ሽም _____________________ ፌርማ__________________  ዕለት_____________ </br>
ነዚ  ዘዳለ ውዳበ ሽም ___________________________  ፌርማ___________________  ዕለት_____________
</br> </br>
</font>
</body>
</html>


