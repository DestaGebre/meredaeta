@extends('layouts.app')

@section('htmlheader_title')
    ውህብቶ
@endsection

@section('contentheader_title')
ቅፅዓታት ኣመራርሓ ዞባ ኮሚቴ                               
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

<div>
      <a href="{{ route('HtmlToPDF11') }}" class="btn btn-primary">Download in PDF</a>
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
