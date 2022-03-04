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
<font size="2"  ><h2><u>ወሰኽን ጉድለትን ጠቅላላ ወረዳ ኣመራርሓ  </u></h2></font>
<table border="1" width="100%" cellpadding="2"  >
  <thead>
  <tr>
    <th rowspan="3">ዞባ/ወረዳ</th>
    <th rowspan="3">መበገሲ</th>
    <th colspan="3"> ምኽንያት ወሰኽ</th>
    <th colspan="10">ምኽንያት ጉድለት</th>
    <th rowspan="3"> ሚዛን</th>
    <th colspan="8"> ሕዚ ዘሎ በዝሒ ጠቅላላ ወረዳ ኣመራርሓ </th>
  </tr>
  <tr>
        <th rowspan="2">ምድብ</th>
        <th rowspan="2">ብዝውውር</th>
        <th rowspan="2">ድምር</th>
        <th rowspan="2">ብሞት</th>
        <th rowspan="2">ብስንብት</th>
        <th rowspan="2">ብምብራር</th>
        <th rowspan="2">ባዕሉ ዝገደፈ</th>
        <th rowspan="2">ካብ ሓላፍነት ምውራድ /ምእጋድ</th>
        <th colspan="4" >ብዝውውር</th>
        <th rowspan="2">ድምር</th>
        <th colspan="4">ሓለፍቲ</th>
        <th colspan="4">ምኽትላት </th>
  </tr>
  <tr>
        <th >ናብ ትምህርቲ</th>
        <th >ኣብ ውሽጢ ዞባ</th>
        <th >ኣብ ውሽጢ ክልል</th>
        <th >ካብ ክልል ወፃእ</th>
        <th >ተባዕትዮ</th>
        <th >ኣንስትዮ</th>
        <th >ድምር</th>
        <th >ኣ %</th>
        <th >ተባዕትዮ</th>
        <th >ኣንስትዮ</th>
        <th >ድምር</th>
        <th >ኣ %</th>

  </tr>
  <tbody> 
  
  <?php $i = 1; $mulueC= 0 ; $hitsuyC = 0 ; $dimir1 = 0; $age1C = 0; $age2C = 0; $age3C = 0; $edu1C = 0; 
  $edu2C = 0; $edu3C = 0; $edu4C = 0; $edu5C = 0; $edu6C = 0; $edu7C = 0; $edu8C = 0; $edusumC = 0;?> <?php $s = " "; ?>
  @foreach($weredatat as $wereda)

  
<tr >
<td >{{$wereda->name}}</td>
<td ><?php  $now= carbon::today(); $then=$now->subMonths(3); $count = DB::table('approved_hitsuys')
 ->whereBetween('created_at', [$now,  $then])
-> where('membershipType', '=', 'ወረዳ ኣመራርሓ')->count();  
    echo $count?></td>
    <td ><?php $count1 = DB::table('approved_hitsuys')->join('midebas', 'approved_hitsuys.hitsuyID', '=', 'midebas.hitsuyID') 
    ->where('deraja', '=', 'ወረዳ ኣመራርሓ') 
    ->whereBetween('midebas.created_at', [$now,  $then])
    ->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
    ->count();
    echo $count1?></td>
<td ><?php $count2 = DB::table('approved_hitsuys')->join('transfers', 'approved_hitsuys.hitsuyID', '=', 'transfers.hitsuyID') 
    ->where('dereja', '=', 'ወረዳ ኣመራርሓ') 
    ->whereBetween('transfers.created_at', [$now,  $then])
    ->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
    ->count(); 
    echo $count2?></td>
    
<td ><?php echo $count1 + $count2 ?> </td>
<td ><?php $count3 = DB::table('approved_hitsuys')->join('dismisses', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
-> where('membershipType', '=', 'ወረዳ ኣመራርሓ')
->where('dismisses.dismissReason', '=', 'mot') 
->whereBetween('dismisses.created_at', [$now,  $then])
->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
->count(); 
    echo $count3?></td>
        
<?php $age1=0; ?> <?php $age2=0; ?> <?php  $age3=DB::table('approved_hitsuys')->join('dismisses', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
-> where('membershipType', '=', 'ወረዳ ኣመራርሓ')
->where('dismisses.dismissReason', '=', 'sinibit') 
->whereBetween('dismisses.created_at', [$now,  $then])
->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
->count();  ?> <td> <?php echo $age3;?></td>
<td ><?php $edu1 = DB::table('approved_hitsuys')->join('dismisses', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
-> where('membershipType', '=', 'ወረዳ ኣመራርሓ')
->where('dismisses.dismissReason', '=', 'mibirar') 
->whereBetween('dismisses.created_at', [$now,  $then])
->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
->count();
    echo $edu1?></td>
<td ><?php $edu2 =  DB::table('approved_hitsuys')->join('dismisses', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
-> where('membershipType', '=', 'ወረዳ ኣመራርሓ')
->where('dismisses.dismissReason', '=', 'baelu zigedefe') 
->whereBetween('dismisses.created_at', [$now,  $then])
->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
->count(); 
    echo $edu2?></td>
    
<td ><?php $edu3 = DB::table('approved_hitsuys')->join('penalties', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
-> where('membershipType', '=', 'ወረዳ ኣመራርሓ')
->whereBetween('penalties.created_at', [$now,  $then])
->where('approved_hitsuys.hitsuyID','LIKE','0'.$i.'%')
->count(); 
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
<td ><?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; echo $edusum?> </td>  
<td ><?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; echo $edusum?> </td>
<td ><?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; echo $edusum?> </td> 
<td ><?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; echo $edusum?> </td>
<td ><?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; echo $edusum?> </td> 
<td ><?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; echo $edusum?> </td>
<td ><?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; echo $edusum?> </td> 
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
    <td ><?php echo $edusumC;?></td> 
    <td ><?php echo $edusumC;?></td>
    <td ><?php echo $edusumC;?></td> 
    <td ><?php echo $edusumC;?></td>
    <td ><?php echo $edusumC;?></td> 
    <td ><?php echo $edusumC;?></td>
    <td ><?php echo $edusumC;?></td> 
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
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edusumC/ $edusumC)*100;?></td>
        <?php endif; ?>
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edusumC/ $edusumC)*100;?></td>
        <?php endif; ?> 
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edusumC/ $edusumC)*100;?></td>
        <?php endif; ?> 
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edusumC/ $edusumC)*100;?></td>
        <?php endif; ?> 
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edusumC/ $edusumC)*100;?></td>
        <?php endif; ?> 
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edusumC/ $edusumC)*100;?></td>
        <?php endif; ?> 
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edusumC/ $edusumC)*100;?></td>
        <?php endif; ?> 
        <?php if($edusumC == 0): ?>
          <td > <?php echo 0?></td>
        <?php else : ?>
          <td > <?php echo ($edusumC/ $edusumC)*100;?></td>
        <?php endif; ?> 
         
</tr>
</tbody>
  
</table>
</br>
</font>
</body>
</html>


