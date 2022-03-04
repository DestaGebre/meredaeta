<!doctype html>
<html>
<head>
     <meta charset="utf-8">
     <link href="css/styles.css" rel="stylesheet" type="text/css" media="screen">
     <link href="css/js-image-slider.css" rel="stylesheet">
     <script src="js/js-image-slider.js" type="text/javascript"></script>
<!--<script src="../js/tooltip.js" type="text/javascript"></script>-->
     <script type="text/javascript">
        imageSlider.thumbnailPreview(function (thumbIndex) { return "<img src='img/thumb" + (thumbIndex + 1) + ".jpg' style='width:100px;height:60px;' />"; });
    </script>
     <title>ህዝባዊ ወያነ ሓርነት ትግራይ </title>
</head>
      <body>
            <div id="wrapper">
                              <div id="logo">
                              <img src="img/banner1.jpg" width="990" height="180">
                              </div>
                              
              <div id="topnav">
                                  <ul>
                                     <li><a class="{{ Request::is('main*') ? 'active' : '' }}" href="{{ url('main') }}"> መቕድም </a></li>
                                     <li> | </li>
                                     <li><a class="{{ Request::is('about*') ? 'active' : '' }}" href="{{ url('about') }}"> ታሪኽ ቃልሲ ህዝቢ ትግራይ </a></li>
                                     <li> | </li>
                                     <!-- <li><a class="{{ Request::is('structure*') ? 'active' : '' }}" href="{{ url('structure') }}"> አወዳድባ ቤት ፅሕፈት </a></li>
                                     <li> | </li>-->
                                     <li><a class="{{ Request::is('mehawur*') ? 'active' : '' }}" href="{{ url('mehawur') }}"> ዝተመዝገቡ ዓወታት </a></li>
                                     <li> | </li>
                                     
                                     <li><a class="{{ Request::is('resources*') ? 'active' : '' }}" href="{{ url('resources') }}"> ጉባኤታት </a></li>
                                     <li> | </li>
									 <li><a class="{{ Request::is('download*') ? 'active' : '' }}" href="{{ url('download') }}"> አዉርድ </a></li>
                                     <li> | </li>
                                     <!-- <li><a class="{{ Request::is('vacancy*') ? 'active' : '' }}" href="{{ url('vacancy') }}"> ክፍቲ መደብ ስራሕ </a></li>
                                     <li> | </li> -->
                                     <li><a class="{{ Request::is('contact*') ? 'active' : '' }}" href="{{ url('contact') }}"> ርኸቡና </a></li>
                                     <li> | </li>
                                     <li><a class="{{ Request::is('login*') ? 'active' : '' }}" href="{{ url('login') }}"> ናብ ሲስተም እቶ </a></li>
                                 </ul>
              </div>
                            <!-- <div id="banner">
                              <img src="../images/coast.jpg" width="990">
                              </div>-->
                              
                              <div id="content-full">
                                <!--<div id="content-message">-->
                                  <h1>ዝርዝር ክፍቲ መደብ ስራሕቲ</h1> 
                                                     <p>ኣብ ሃገርናን ክልልናን ዝሓዝናዮ ልምዓትን ህንፀት ስርዓት ዴሞክራሲን ዕውት ንምግባር ንፁር ፖሊሲን ስትራቴጅን ተቐሪፁ ኩሎም ስራሕትና ኣብ ምዕሩይ ስርዓት ምሕደራ ዝተመሰረተ ንክኸውን ሰናይ ምምሕዳር ምስ ልምዓት ዘይነፃፀል ቁልፊ ናይ ህልውና ጉዳይን ናይ ዝሓዝናዮ ልምዓታዊ መስመር መለለይን ተግባር እዩ ። ሰናይ ምምሕዳር ናይ ምንጋስ ጉዳይ ናይ ኩሉ ክፋል ሕ/ሰብን መንግስትን ዋኒን እንትኸውን ነዚ ዕውት ንምግባር ኣብ ትልሚ ዕብየትን ስግግርን ዓብይ ኣንፈት ኮይኑ ተቐሚጡ ‘ዩ። ካብ’ዚ ብምልዓል ከም ሃገርን ክልልን ዝለዓለ ትኹረት ተዋሂብዎ ንሰናይ ምምሕዳር ጠንቂ ዝኾኑ ተግባራት ኣብ በቢ ከባቢኡ ተፈልዮም ቓልሲ ብምግባር ንክፍትሑ ፃዕሪ እናተገበረሉ ዝርከብን ዘተባብዕ ውፅኢት ካብ ጊዜ ናብ ጊዜ እናመፀሉ ዝርከብ እዩ ። ብመሰረት’ዚ ኣብ ክልልና ልምዓትን  ሰናይ ምምሕዳርን ንምንጋስ ብዝተኣታተው ሪፎርምታት ኣቢልካ ዝመፅእን ልምዓታዊን ዴሞክራስያውን ስቪል ሰርቨሰ ዝህነፀሉን መስርሕ ብምካኑ  ሪፎርምን ፓኬጃት ሰናይ ምምሕዳርን ንህንፀት ልምዓታዊ ሰራዊት ስቪል ሰርቫንት ዘለዎም ግደን ኣብ በቢ ብርኩ ዘሎ ምንቅስቃስን እንታይነትን ብዝግባእ ብምርዳእ ብሙሉእ ቁመነኦም ብፃልነት ብምትግባር ብቁዕ ግልጋሎት ብምሃብ ኣብ በቢ ብርኩ ዘሎ ሕብረተሰብ ዕግበቱ ንምርግጋፅ ዘክእል ግንዛበን ዓቅምን ንምፍጣር ዝስዕብ መመያየጢ ሰነድ ተዳልዩ ኣሎ ።  ኣብ ሃገርናን ክልልናን ዝሓዝናዮ ልምዓትን ህንፀት ስርዓት ዴሞክራሲን ዕውት ንምግባር ንፁር ፖሊሲን ስትራቴጅን ተቐሪፁ ኩሎም ስራሕትና ኣብ ምዕሩይ ስርዓት ምሕደራ ዝተመሰረተ ንክኸውን ሰናይ ምምሕዳር ምስ ልምዓት ዘይነፃፀል ቁልፊ ናይ ህልውና ጉዳይን ናይ ዝሓዝናዮ ልምዓታዊ መስመር መለለይን ተግባር እዩ ።</p>
              </div>
                                             
                             <div id="content">
                                               <!--<div id="mcontainer">-->
                                               <div id="rvideos11">
                                                                    <h3>ዝርዝር መደባት ክፍቲ ስራሕ</h3>
                                                                     <table width="970" border="1">
  <tr>
    <td width="161"><h3> መደብ  ስራሕ ዝወፀሉ ዕለት  </h3></td>
    <td width="471" align="center"><h3> ዝርዝር ትሕዝቶ መደብ  ስራሕ</h3></td>
    <td width="316" align="center"><h3>  እዋን መመልከቲ ክፍቲ መደብ  ስራሕ ዝዕፀወሉ ግዜ</h3></td>
  </tr>
  <tr>
    <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
    <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
   <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
  <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
   <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
  <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
   <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
  <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
   <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
   <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
  <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
    <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
 <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
   <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
<td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
   <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
   <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
   <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
  <tr>
   <td width="161"> መደብ  ስራሕ ዝወፀሉ ዕለት  </td>
    <td width="471"> contents of vacancy comes here ...</td>
    <td width="316"> clouser of vacancy  date comes here ...</td>
  </tr>
</table>
                                                                   
                                               </div>
                                               
                                              
                              </div>
                              <div id="footer">
                              <p>&copy; 2018 . መብቱ ብሕጊ ዝተሓለወ እዩ ! ቤት ፅሕፈት ህዝባዊ ወያነ ሓርነት ትግራይ </p>
              </div>         
            
            </div>
      </body>
</html>
