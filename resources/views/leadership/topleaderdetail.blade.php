
@extends('layouts.app')

@section('htmlheader_title')
ናይ ላዕለዋይ ኣመራርሓ {{ $name }}[መለለዪ ቑፅሪ፥ {{ $id }}] ገምጋም {{ $year }} [{{ $period }}]
@endsection

@section('contentheader_title')
ናይ ላዕለዋይ ኣመራርሓ {{ $name }} ማህደር
@endsection

@section('header-extra')
<style type="text/css">
    .form-control:read-only {
        background-color: #fdfdfd;
        cursor: default;
    }
	.heading{
        border-bottom: 1px solid #f4f4f4;
        text-align: center;
		background:#F2FFE6;
		color: #5D8AA8;
		style: bold;
    }
    input,p {

    }
    p {
        word-break: break-word;
        background: #fdfdfd;
        padding: 15px;
        border: 1px solid #999;
    }
    @media print{
      #print,.switchBtn {
        display: none;
      }
    }
</style>

@endsection
@section('main-content')
<div class="box box-primary">
        
    <div id="myDetails">
   <div class="box-header with-border">
	<div class="box-header with-border heading">
		<h1 class="box-title" color="4DA6FF"  style="font-size: 22px, font-color: 5D8AA8, bold;">ሓፈሻዊ መረዳእታ ላዕለዋይ ኣመራርሓ</h1>
        <div class="pull-left">
            <a class="btn switchBtn btn-info" href="{{ url('topleader') }}?id={{ str_replace('/', '_', $data->hitsuyID) }}&year={{$data->year}}&period={{$data->half}}"><span class="glyphicon glyphicon-edit"></span>ኣስተኻኽል</a>
            <button class="delete-button btn btn-danger" data-info="">
            <span class="glyphicon glyphicon-trash"></span>ሰርዝ</button></td>
        </div>
        <div class="pull-right">                      
            <a class="btn switchBtn btn-info" href="{{ URL::previous() }}"><span class="glyphicon glyphicon-arrow-up"></span></a>
            <a class="btn switchBtn btn-info" href="{{ url('topleader#step-1') }}"><span class="glyphicon glyphicon-home"></span></a>
        </div>
		 </div>
            <!-- Button ይመለሱ -->
            <form id="detail-form">
                <!-- Step 1 -->
           <div class="form-group col-sm-12 col-md-12">                     
                
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ሙሉእ ሽም: <span style="text-decoration: underline;"> {{$name}}</span>
                    <!-- <input type="text" id="fullName" name="fullName" class="form-control" value="{{$name}}" readonly> -->
                </div>
                <!-- <label class="control-label col-md-1 col-sm-1" for="gender">ፆታ:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ፆታ: <span style="text-decoration: underline;"> {{$member->hitsuy->gender}}</span>
                    <!-- <input type="text" id="gender" name="gender" class="form-control" value="{{$member->hitsuy->gender}}" readonly> -->
                </div>
				<!-- <label class="control-label col-md-1 col-sm-1" for="hitsuyID">መ.ቑ:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    መ.ቑ: <span style="text-decoration: underline;"> {{$id}}</span>
                    <!-- <input type="text" id="hitsuyID" name="hitsuyID" class="form-control" value="{{$id}}" readonly> -->
                </div>
                <!-- <label class="control-label col-md-1 col-sm-1" for="fullName">ሽም:</label> -->
            </div>
            <div class="form-group col-sm-12 col-md-12"> 
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ዝተወደብሉ ዞባ: <span style="text-decoration: underline;"> {{$zoneName}}</span>
                    <!-- <input type="text" id="zone" name="zone" class="form-control" value="{{$zoneName}}" readonly> -->
                </div>
                <!-- <label class="control-label col-md-1 col-sm-1" for="woreda">ወረዳ:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ወረዳ: <span style="text-decoration: underline;"> {{$woredaName}}</span>
                    <!-- <input type="text" id="woreda" name="woreda" class="form-control" value="{{$woredaName}}" readonly> -->
                </div>
				<div class="col-md-3 col-sm-4 col-xs-4">
                    መሰረታዊ ውዳበ: <span style="text-decoration: underline;"> {{$member->hitsuy->proposerWidabe}}</span>
                    <!-- <input type="text" id="woreda" name="woreda" class="form-control" value="{{$woredaName}}" readonly> -->
                </div>
            </div> 
			<div class="form-group col-sm-12 col-md-12"> 
              
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ትውልዲ ቦታ: <span style="text-decoration: underline;"> {{$member->hitsuy->birthPlace	}}</span>
                </div>
				 <div class="col-md-3 col-sm-4 col-xs-4">
                    ዕድመ: <span style="text-decoration: underline;">{{ (date('Y') - date('Y',strtotime($member->hitsuy->dob))) }}</span> 
                </div>	
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ኣባልነት ዘመን: <span style="text-decoration: underline;"> {{ date('Y',strtotime($member->hitsuy->regDate)) }}</span>
                   </div>
                
			</div>
            <div class="form-group col-sm-12 col-md-12"> 
              
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ደረጃ ትምህርቲ: <span style="text-decoration: underline;">{{ $member->hitsuy->educationlevel }}</span> 
                </div>
				<div class="col-md-3 col-sm-4 col-xs-4">
                    ማሕበራዊ መሰረት: <span style="text-decoration: underline;"> {{$member->hitsuy->occupation}}</span>
                  </div>
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ቁፅሪ ስልኪ: <span style="text-decoration: underline;"> {{$member->hitsuy->tell}}</span>
                   </div>
                </div>
			</div>  
			
           <div class="box-header with-border">
        <div id="tableofContents">
           
				<div class="box-header with-border heading">
				<h1 class="box-title"  style="font-size: 22px;">ዝርዝር ማህደር</h1>
				</div>
            <div class="form-group col-sm-12 col-md-12"> 
                <label class="control-label">1. መድረኽ ዝሓቶ ፖለቲካዊ አተሓሳስብኡን ብቅዓትን ዝምልከት: (<span id="sum1">{{ $data->result1 + $data->result2 + $data->result3 + $data->result4 + $data->result5 + $data->result6 + $data->result7 + $data->result8 }}</span>/45)</label><br>
                <label class="control-label" for="answer1">1.1 ናይ ክልስ ሓሳብ ፍልጠቱን አጠቃላሊ ግንዛብኡን: <span> ({{ $data->result1}}/11)</span></label>
                <div class="col-sm-12 col-md-12">
                    <p> {{ $data->answer1 }} </p>
                </div><br/>
            </div>

            <div class="form-group col-sm-12 col-md-12"> 
                <label class="control-label">1.2 ዘለዎ መርገፂ/ዝንባለ: (<span id="sum1p2">{{ $data->result2 + $data->result3 }}</span>/20)</label>
                <label class="col-sm-12 col-md-12 control-label" for="answer2">1.2.1 ኣብ ዕላማ ሕወሓት/ኢህወደግ መስመርን ስትራትጅን ዘለዎ ዝተማልአ እምነትን ቁርፀኝነትን : <span> ({{ $data->result2}}/10)</span></label>
                <div class="col-sm-12 col-md-12">
                    <p> {{ $data->answer2 }} </p>
                </div><br/>
            </div>

            <div class="form-group col-sm-12 col-md-12">                     
                <label class="col-sm-12 col-md-12 control-label" for="answer3">1.2.2 ንኣተሓሳስባ ክራይ ኣካብነት፣ ዝንባለታትን ተግባርን ኣምሪሩ ዝፀልእ፤ ንባዕሉ ነፃ ዝኾነን ኣብ ካልኦት ንዝራኣዩ ፀገማት ደፊኻ ብፅንዓት ኣብ ምቅላስን: <span> ({{ $data->result3}}/10)</span></label>
                <div class="col-sm-12 col-md-12">
                    <p> {{ $data->answer3 }} </p>
                </div><br/>
            </div>

            <div class="form-group col-sm-12 col-md-12">                     
                <label class="control-label">1.3 ኣብ ተግባራት ሰናይ ምምሕዳር  መርኣያን ህርኩትን ኣብ ምኻን፣ (<span id="sum1p3">{{ $data->result4 + $data->result5 + $data->result6 + $data->result7 + $data->result8 }}</span>/14)</label>
                            <label class="col-sm-12 col-md-12 control-label" for="answer4">1.3.1 ዝተማልአ ዲሞክራሲያዊ ስብእና ኣብ ምህላው: <span> ({{ $data->result4}}/6)</span></label>
                            <div class="col-sm-12 col-md-12">
                                <p> {{ $data->answer4 }} </p>
                            </div><br/>
            <!-- Step 2 -->
                        <div class="form-group col-sm-12 col-md-12"> 
                          <label class="col-sm-12 col-md-12 control-label" for="answer5">1.3.2 ምስ ኣባላትን መሳርሕቱን ዘለዎ ዝምድና: <span> ({{ $data->result5}}/2)</span></label>
                            <div class="col-sm-12 col-md-12">
                                <p> {{ $data->answer5 }} </p>
                            </div><br/>               
							</div>

                        <div class="form-group col-sm-12 col-md-12"> 
                          <label class="col-sm-12 col-md-12 control-label" for="answer6">1.3.3 ህዝባዊ ውግንንኡን ዴሞክራሲያዊ ኣተኣላልይኡን ዝምልከት: <span> ({{ $data->result6}}/2)</span></label>
                            <div class="col-sm-12 col-md-12">
                                <p> {{ $data->answer6 }} </p>
                            </div><br/>                  
							</div>


                        <div class="form-group col-sm-12 col-md-12">                     
                            <label class="col-sm-12 col-md-12 control-label" for="answer7">1.3.4 ሓሳባት ብዲሞክራሲያዊ መንገዲ ኣብ ምትእንጋድን ንዝረኣዩ ጉድለታት ብኣግባቡ ኣብ ምእራምን: <span> ({{ $data->result7}}/2)</span></label>
                            <div class="col-sm-12 col-md-12">
                                <p> {{ $data->answer7 }} </p>
                            </div><br/>                 
							</div>

                        <div class="form-group col-sm-12 col-md-12">                     
                            <label class="col-sm-12 col-md-12 control-label" for="answer8">1.3.5 ወያናይ ስነ ምግባሩን ስብእንኡን ዝምልከት: <span> ({{ $data->result8}}/2)</span></label>
                            <div class="col-sm-12 col-md-12">
                                <p> {{ $data->answer8 }} </p>
                            </div><br/>                   
							</div>
            <!-- Step 3 -->
            <div class="form-group col-sm-12 col-md-12"> 
                <label class="control-label">2. ናይ ልምዓት፥ ሰናይ ምምሕዳር ተግባራትን ልኡኽን ብብቕዓት ናይ ምምራሕን ምስራሕን ክእለቱ: (<span id="sum2">{{ $data->result9 + $data->result10 + $data->result11 }}</span>/35)</label>
                <label class="control-label col-sm-12 col-md-12" for="answer9">2.1 ብቑዕ ትልሚ ኣብ ምድላው ዘለዎ ናይ ኣመራርሓ ብቅዓትን ጥበብን: <span> ({{ $data->result9}}/11)</span></label>
                <div class="col-sm-12 col-md-12">
                    <p> {{ $data->answer9 }} </p>
                </div><br/>    
				</div>
            
            <div class="form-group col-sm-12 col-md-12">                     
                <label class="control-label" for="answer10">2.2 ፈፀምቲ ዓቅምታት ናይ ምድለው ብቅዓቱን ክእለቱን: <span> ({{ $data->result10}}/10)</span></label>
                <div class="col-sm-12 col-md-12">
                    <p> {{ $data->answer10 }} </p>
                </div><br/>      
				</div>                    

            <div class="form-group col-sm-12 col-md-12">                     
                <label class="control-label" for="answer11">2.3 ብቑዕ ናይ ድጋፍን ክትትልን ስርዓት ብምዝርጋሕን ብፅንዓት ኣብ ምትግባርን: <span> ({{ $data->result11}}/14)</span></label>
                <div class="col-sm-12 col-md-12">
                    <p> {{ $data->answer11 }} </p>
                </div><br/>   
				</div>

          
            <!-- Step 4 -->
                        <div class="form-group col-sm-12 col-md-12">                     
                            <label class="control-label" for="answer12">3. ብቁዕ ኣሰራርሓን ኣወዳድባን ብምፍጣር ውፅኢታዊ ስራሕ ኣብ ምስራሕን: <span> ({{ $data->result12}}/10)</span></label>
                            <div class="col-sm-12 col-md-12">
                                <p> {{ $data->answer12 }} </p>
                            </div><br/>
                        </div>

                        <div class="form-group col-sm-12 col-md-12">                     
                            <label class="control-label" for="answer13">4. ንውፅኢታዊ ስራሕ ዘድልዩ እታወታት/ቴክኖሎጂ/ ንምምላእ ዘለዎ ናይ ኣመራርሓ ብቕዓትን: <span> ({{ $data->result13}}/10)</span></label>
                            <div class="col-sm-12 col-md-12">
                                <p> {{ $data->answer13 }} </p>
                            </div><br/>
                        </div>

            <div class="form-group col-sm-12 col-md-12">                     
                <label class="control-label" for="answer14">5. መለለይ ጠንካራ ጎኒ</label>
                <div class="col-sm-12 col-md-12">
                    <p> {{ $data->answer14 }} </p>
                </div>                        
            </div>

            <div class="form-group col-sm-12 col-md-12">                     
                <label class="control-label" for="answer15">6. መለለይ ደካማ ጎኒ</label>
                <div class="col-sm-12 col-md-12">
                    <p> {{ $data->answer15 }} </p>
                </div>                        
            </div>
            <div class="form-group col-sm-12 col-md-12">                     
                <label class="control-label" >7. ድምር ዝረኸቦ ማርኪ: (<span id="totalResult">{{ $data->sum }}</span>/100)</label><br/>
				
					<?php $rank = 0;?>
					@if($data->sum >= 90)
							<?php $rank='A+';?> 
					@elseif($data->sum >= 80) 
							<?php $rank='A';?>
					@elseif($data->sum >= 66)
							<?php $rank='B';?>
					@else
							<?php $rank='C';?>
						@endif
                <label class="control-label" >&nbsp &nbsp ድምር ሚዛን/ስርርዕ: <span id="totalWeight">{{ $rank }}</span></label>
            </div>

            <div class="form-group col-sm-12 col-md-12">                     
                <label class="control-label" for="remark">9. ናይ በዓል ዋና ሪኢቶን</label>
                <div class="col-sm-12 col-md-12">
                    <p> {{ $data->remark  }} </p>
                </div>  
                <label class="col-sm-2 col-md-12 control-label">ፌርማ:______________________</label>                                 
            </div>
             <div class="form-group col-sm-12 col-md-12">                     
                <label class="control-label" >10. ናይ ወረዳ ውዳበ ሽም:_______________________________________ ፌርማ:____________________ ዕለት:________________</label><br/>            
                <label class="control-label" >11. ናይ ዞባ ውዳበ ሽም:_______________________________________ ፌርማ:____________________ ዕለት:________________</label>
            </div>
            <hr style="border:groove 1px #79D57E;"/>       
          </form>
             <div class="text-center">                    
                <button  id="print" class="btn printerBtn btn-info" onclick="window.print();return false;"><span class="fa fa-print"></span>ፕሪንት </button>                
            </div>
        </div>
    </div>
	 </div>
    </div>

@endsection

@section('scripts-extra')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.delete-button', function() {
        if(confirm('ገምጋም '+"{{ $data->hitsuyID }}"+ ' ዓመት '+"{{$data->year}}"+' ንምስራዝ ርግፀኛ ድዮም?')){
            $.ajax({
            type: 'post',
            url: 'deletetopleader',
            data: {
                '_token': $('input[name=_token]').val(),  
                'id': "{{$data->id}}",      
                'hitsuyID': "{{$data->hitsuyID}}",
                'year': "{{$data->year}}",
            },
      
            success: function(data) {
                if(data[0] === true){
                  toastr.clear();
                  toastr.warning('ገምጋም '+"{{ $data->hitsuyID }}"+ ' ዓመት '+"{{$data->year}}"+' ተሰሪዙ ኣሎ');
                  setTimeout(function(){
                    window.location.replace('{{url("topleaderslist")}}');
                  }, 3000);
                }
                else{
                   toastr.error('ገምጋም '+"{{ $data->hitsuyID }}"+ ' ዓመት '+"{{$data->year}}"+' ኣይተረኽበን');
                }
               },

            error: function(xhr,errorType,exception){
                
                  alert(exception);
                        
            }
        });
        }
                
    });
    });
</script>
@endsection
