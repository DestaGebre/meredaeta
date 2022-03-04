@extends('layouts.app')

@section('htmlheader_title')
    ውህብቶ
@endsection

@section('contentheader_title')
ጠርነፍቲ ዋህዮ ነበርቲ ገጠርን ከተማን                           
@endsection

@section('header-extra')
@endsection

@section('main-content')
<?php


use Carbon\Carbon;
use Carbon\CarbonInterval; ?>
<div class="box box-primary">
  


</div>
  
  <div id="giftlist">
      <div class="col-sm-12">
      <div class="card-box table-responsive">
        <p class="text-muted font-13 m-b-30">
        </p>
    <div class="container ">
      {{ csrf_field() }}
      <div class="table-responsive text-center">
        <table border="1" width="100%" cellpadding="2"  >
  <thead>
  <tr>
  <th rowspan="2">ተ/ቁ</th>
    <th rowspan="2">ዞባ/ወረዳ</th>
    <th colspan="4"> ብፆታ</th>
    <th colspan="2">ብደረጃ ዕድመ</th>
    <th colspan="2"> ብደረጃ ትምህርቲ </th>
    <th colspan="2"> ዓይነት ኣመራርሓ </th>
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
        <th>ሞዴል</th>
        <th>ዘይሞዴል</th>
        
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
 
<td ><?php $edu5 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ዲፕሎማ') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu5?></td>
<td ><?php $edu6 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ዲግሪr') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      echo $edu6?></td>
<?php $edu7 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'MS') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      ?>
<?php $edu8 = DB::table('education_informations') ->where('education_informations.educationLevel', '=', 'ዶክተር') ->where('hitsuyID','LIKE','0'.$i.'%')->count(); 
      ?>
<?php $edusum = $edu1 + $edu2 + $edu3 + $edu4 + $edu5 + $edu6 + $edu7 + $edu8; ?>  
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
      <td ></td>
      
      
  </tr>
  
  </tbody>
  
</table>
</br>

<div>
      <a href="{{ route('HtmlToPDF16') }}" class="btn btn-primary">Download in PDF</a>
  </div>
</br>
      </div>
    </div>
  </div>
  </div>
  </div>

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>

        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
          <div class="form-group">
              <div class="col-sm-10">
                <input type="hidden" class="form-control" id="id">
              </div>
            </div>
                       
            <div class="form-group">
              <label class="control-label col-md-2 col-sm-3 col-xs-12" for="donorId">መፍለይ ቑፅሪ ለጋሲ<span class="required">（*）</span>
              </label>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <input type="text" id="donorId" name="donorId" required="required" readonly class="form-control col-md-7 col-xs-12">
               </div>
            </div> 
            
            <div class="form-group">
            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="giftType">ዓይነት ውህብቶ</label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <select class="form-control" id="giftType" name="giftType" required="required">
                <option selected disabled>ምረፅ</option>
                <option>ተሽከርከርቲ</option>
                <option>ህንፃ</option>
                <option>ቀዋሚ ንብረት</option>
                 <option>ሃላቂ ኣቕሓ</option>
                <option>ጥረ ገንዘብ</option>                         
              </select>
            </div>
          </div>
          <div class="form-group">
             <label class="control-label col-md-2 col-sm-3 col-xs-12" for="purpose">ዕላማ ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input type="text" id="purpose" name="purpose" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div> 
         <div class="form-group">           
            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="giftName">ሽም ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input type="text" id="giftName" name="giftName" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>  
       <div class="form-group">
            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="valuation">ግምት ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input type="text" id="valuation" name="valuation" required="required" class="form-control col-md-7 col-xs-12">
            </div>
      </div>  
       <div class="form-group">
            <label class="control-label col-md-2 col-sm-3 col-xs-" for="status">ኩነታት ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <select class="form-control" id="status" name="status" required="required">
                <option>ምረፅ</option>
                <option>ቃል ዝተኣተወ</option>
                <option>ዝተወሃበ</option>                                   
              </select>
            </div>
      </div>
      <div class="form-group"> 
        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="donationDate">ዝተዋሃበሉ ዕለት<span class="required"></span>
        </label>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <input type="text" id="donationDate" name="donationDate" required="required" class="form-control col-md-7 col-xs-12">
        </div>
      </div>          
          </form>

          <div class="deleteContent">
             <span class="dname"></span>ብትክክል ክጠፍአ ይድለ ድዩ ? <span class="hidden did"></span>
              <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
          </div>


          <div class="modal-footer">
            <button type="button" class="btn actionBtn" data-dismiss="modal">
              <span id="footer_action_button" class='glyphicon'> </span>
            </button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove'></span> ዕፀው
            </button>
          </div>
          </div>
      </div>
    </div>
  </div>

    </div>
@endsection


  @section('scripts-extra')
  <script>
 
 
   $(document).ready(function() {
      $('#table2').DataTable();
        } );
    $(document).on('click', '.switchBtn', function() {
      $('#giftlist').addClass('hidden');
      $('.myswitch').addClass('hidden');
        $('#giftdiv').removeClass('hidden');                 
        $('.mytoggle').removeClass('hidden');                 
    }); 
    $(document).on('click', '.toggleBtn', function() {
      $('#giftdiv').addClass('hidden');
      $('.mytoggle').addClass('hidden');
        $('#giftlist').removeClass('hidden');                 
        $('.myswitch').removeClass('hidden'); 
    });
   $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text("ሰርዝ");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text(' መሰረዚ ልገሳ');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        var stuff = $(this).data('info').split(',');          
         $('.did').text(stuff[0]);   
        $('.dname').html(stuff[1]);
        $('#myModal').modal('show');
    });
    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" ኣስተኻኽል");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('#footer_action_button').removeClass('glyphicon-search');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('search');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('መስተኻኸሊ ለጋሲ');
        $('.deleteContent').hide();
        $('.searchContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff)
        $('#myModal').modal('show');
    });

    function fillmodalData(details){
      $('#id').val(details[0]);  
      $('#donorId').val(details[1]);
      $('#giftType').val(details[2]);
      $('#purpose').val(details[3]);
      $('#giftName').val(details[4]);
      $('#valuation').val(details[5]);
      $('#status').val(details[6]);
      $('#donationDate').val(details[7]);
          
    }
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: '/editgift',
            data: {
                '_token': $('input[name=_token]').val(),        
                'donorId': $('#id').val(),
                'giftType': $('#giftType').val(),
                'purpose': $('#purpose').val(),
                'giftName': $('#giftName').val(),
                'valuation': $('#valuation').val(),
                'status': $('#status').val(),
                'donationDate': $('#donationDate').val()               
              
            },
      
            success: function(data) {
               //$('.item' + data.id).replaceWith("<tr class='item" + data.id + "'> <td>" + data.id +
                      //"</td><td>" + data.donorId + "</td><td>" + data.giftType + "</td><td>" + data.purpose + "</td><td>" + data.giftName + "</td><td>" + data.valuation + "</td><td>" + data.status + "</td><td>" + data.donationDate + "</td><td><button class='edit-modal btn btn-info' data-info='" + data.id+","+data.donorId+","+data.giftType+","+data.purpose+","data.giftName+","+data.valuation+","data.status+","+data.donationDate"'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-info='" + data.id+","+data.donorId+"' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                
                document.getElementById("id").value="";
                document.getElementById("donorId").value="";
            document.getElementById("giftType").value="";
            document.getElementById("purpose").value="";
            document.getElementById("giftName").value="";
            document.getElementById("valuation").value="";
            document.getElementById("status").value="";
            document.getElementById("donationDate").value="";          
               },

            error: function(xhr,errorType,exception){
                
                  alert(exception);
                        
            }
        });
    });
  
  $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: '/deletegift',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
        
            },
      
            success: function(data) {
              
         $('.item' + $('.did').text()).remove();
         
          
            }
        });
    });
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection
