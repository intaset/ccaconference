<?php

$my_email = "info@mvml.org";

/*

Enter the continue link to offer the user after the form is sent.  If you do not change this, your visitor will be given a continue link to your homepage.

If you do change it, remove the "/" symbol below and replace with the name of the page to link to, eg: "mypage.htm" or "http://www.elsewhere.com/page.htm"

*/

$continue = "/";

/*

Step 3:

Save this file (FormToEmail.php) and upload it together with your webpage containing the form to your webspace.  IMPORTANT - The file name is case sensitive!  You must save it exactly as it is named above!  Do not put this script in your cgi-bin directory (folder) it may not work from there.

THAT'S IT, FINISHED!

You do not need to make any changes below this line.

*/

$errors = array();

// Remove $_COOKIE elements from $_REQUEST.

if(count($_COOKIE)){foreach(array_keys($_COOKIE) as $value){unset($_REQUEST[$value]);}}

// Check all fields for an email header.

function recursive_array_check_header($element_value)
{

global $set;

if(!is_array($element_value)){if(preg_match("/(%0A|%0D|\n+|\r+)(content-type:|to:|cc:|bcc:)/i",$element_value)){$set = 1;}}
else
{

foreach($element_value as $value){if($set){break;} recursive_array_check_header($value);}

}

}

recursive_array_check_header($_REQUEST);

if($set){$errors[] = "You cannot send an email header";}

unset($set);

// Validate email field.

if(isset($_REQUEST['email']) && !empty($_REQUEST['email']))
{
if(preg_match("/(%0A|%0D|\n+|\r+|:)/i",$_REQUEST['email'])){$errors[] = "Email address may not contain a new line or a colon";}

$_REQUEST['email'] = trim($_REQUEST['email']);

if(substr_count($_REQUEST['email'],"@") != 1 || stristr($_REQUEST['email']," ")){$errors[] = "Email address is invalid";}else{$exploded_email = explode("@",$_REQUEST['email']);if(empty($exploded_email[0]) || strlen($exploded_email[0]) > 64 || empty($exploded_email[1])){$errors[] = "Email address is invalid";}else{if(substr_count($exploded_email[1],".") == 0){$errors[] = "Email address is invalid";}else{$exploded_domain = explode(".",$exploded_email[1]);if(in_array("",$exploded_domain)){$errors[] = "Email address is invalid";}else{foreach($exploded_domain as $value){if(strlen($value) > 63 || !preg_match('/^[a-z0-9-]+$/i',$value)){$errors[] = "Email address is invalid"; break;}}}}}}

}

// Check referrer is from same site.

if(!(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && stristr($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST']))){$errors[] = "You must enable referrer logging to use the form";}

// Check for a blank form.

function recursive_array_check_blank($element_value)
{

global $set;

if(!is_array($element_value)){if(!empty($element_value)){$set = 1;}}
else
{

foreach($element_value as $value){if($set){break;} recursive_array_check_blank($value);}

}

}

recursive_array_check_blank($_REQUEST);

if(!$set){$errors[] = "You cannot send a blank form";}

unset($set);

// Display any errors and exit if errors exist.

if(count($errors)){foreach($errors as $value){print "$value<br>";} exit;}

if(!defined("PHP_EOL")){define("PHP_EOL", strtoupper(substr(PHP_OS,0,3) == "WIN") ? "\r\n" : "\n");}

// Build message.

function build_message($request_input){if(!isset($message_output)){$message_output ="";}if(!is_array($request_input)){$message_output = $request_input;}else{foreach($request_input as $key => $value){if(!empty($value)){if(!is_numeric($key)){$message_output .= str_replace("_"," ",ucfirst($key)).": ".build_message($value).PHP_EOL.PHP_EOL;}else{$message_output .= build_message($value).", ";}}}}return rtrim($message_output,", ");}

$message = build_message($_REQUEST);

$message = $message . PHP_EOL.PHP_EOL."-- ".PHP_EOL."";

$message = stripslashes($message);

$subject = $_REQUEST['Subject'];

$headers = "From: " . $_REQUEST['Email'];

mail($my_email,$subject,$message,$headers);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noarchive">
<meta name="description" content="">
<meta name="keywords" content="">
<title>MVML'16 - Contact Us</title>

<meta name="handheldfriendly" content="true">
<meta name="mobileoptimized" content="240">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="../css/ffhmt.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic|Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
<!--[if IE-9]><html lang="en" class="ie9"><![endif]-->

<script src="../js/modernizr.custom.63321.js"></script>
<script>
  (function() {
    var cx = '016656741306535874023:y7as1mei7la';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
</head>

<body>
<nav id="slide-menu">
  <h1>MVML'16</h1>
  <ul>
    <li><a href="/">Home</a></li>
    <li><a href="../papers">Paper Submissions</a></li>
    <li><a href="../program">Program</a></li>
    <li><a href="../dates">Important Dates</a></li>
    <li><a href="../registration">Registration</a></li>
    <li><a href="../committee">Committee</a></li>
    <li><a href="../keynote">Keynotes</a></li>
    <li><a href="../sponsor">Sponsors</a></li>
    <li><a href="../venue">Venue</a></li>
    <li><a href="../accommodation">Accommodation</a></li>
    <li><a href="../symposium">Symposiums</a></li>
    <li><a href="#contact">Contact Us</a></li>
  </ul>
</nav>

<div id="content">
  <div class="desktop">
  <div class="cbp-af-header">
	<div class="cbp-af-inner">
		<a href="/"><img src="../img/logo.png" class="flex-logo"></a>
			<nav>
				<a href="/">Home</a><p class="dot">&middot;</p><a href="../papers">Paper Submission</a><p class="dot">&middot;</p><a href="../program">Program</a><p class="dot">&middot;</p><a href="../dates">Important Dates</a><p class="dot">&middot;</p><a href="../registration">Registration</a><p class="dot">&middot;</p><a href="../committee">Committee</a><p class="dot">&middot;</p><a href="../keynote">Keynotes</a><p class="dot">&middot;</p><a href="../sponsor">Sponsors</a><p class="dot">&middot;</p><a href="../venue">Venue</a><p class="dot">&middot;</p><a href="../accommodation">Accommodation</a><p class="dot">&middot;</p><a href="../symposium">Symposiums</a><p class="dot">&middot;</p><a href="#contact">Contact Us</a>
		</nav>
	</div>
</div>
</div>

  <header>
    <div class="mobile">
      <div class="cbp-af-header">
	<div class="cbp-af-inner">
		<div class="unit unit-s-3-4 unit-m-1-3 unit-l-1-3">
      		<a href="/"><img src="../img/logo.png" class="flex-logo"></a>
   	 	</div>
    	<div class="unit unit-s-1-3 unit-m-2-3 unit-m-2-3-1 unit-l-2-3">
      		<div class="menu-trigger"></div>
  		</div>
	</div>
</div>
        <div class="bg">
          <h1>3<sup>rd</sup> International Conference on Machine<br>Vision and Machine Learning (MVML'16)</h1>
          <p class="subhead">August 17 - 18, 2016 | Budapest, Hungary</p>

          <a href="../papers" class="bg-link">Paper Submission</a> <p class="dot">&middot;</p> <a href="../dates" class="bg-link">Important Dates</a> <p class="dot">&middot;</p> <a href="../registration" class="bg-link">Registration</a>

        <div class="searchbox grid">
        <div class="unit unit-s-1 unit-m-3-4 unit-l-3-4">
          <div class="unit unit-s-1 unit-m-1-4-2 unit-l-1-4-2">
            <p class="body">Search:</p> 
          </div>
 <div class="unit unit-s-3-4 unit-m-3-4 unit-l-3-4">
        <gcse:searchbox-only resultsUrl="../results"></gcse:searchbox-only>
  </div>
</div>
</div>
        </div>
    </div>

    <div class="desktop">
      <div class="grid">
        <div class="unit unit-s-1 unit-m-1 unit-l-1">
        <div class="bg-img">
          <img src="../img/header.jpg" class="flex-img" alt="Header">
        </div>

        <div class="bg">
          <h1>3<sup>rd</sup> International Conference on Machine<br>Vision and Machine Learning (MVML'16)</h1>
          <p class="subhead">August 17 - 18, 2016 | Budapest, Hungary</p>

          <a href="../papers" class="bg-link">Paper Submission</a> <p class="dot">&middot;</p> <a href="../dates" class="bg-link">Important Dates</a> <p class="dot">&middot;</p> <a href="../registration" class="bg-link">Registration</a>

        <div class="searchbox grid">
        <div class="unit unit-s-1 unit-m-3-4 unit-l-3-4">
          <div class="unit unit-s-1 unit-m-1-4-2 unit-l-1-4-2">
            <p class="body">Search:</p> 
          </div>
 <div class="unit unit-s-3-4 unit-m-3-4 unit-l-3-4">
        <gcse:searchbox-only resultsUrl="../results"></gcse:searchbox-only>
  </div>
</div>
</div>
        </div>
        </div> 
      </div>
    </div>
  </header>

  <div class="grid main-content">
  <div class="unit unit-s-1 unit-m-1-3-1 unit-l-1-3-1">
    <div class="unit-spacer">
      <h2>Announcements</h2>
      <div id="main-slider" class="liquid-slider">
    <div>
      <h2 class="title">1</h2>
      <p class="bold">MVML 2016:</p>
      <p class="body">MVML 2016 will  be held in Ottawa, Canada on August 17 - 18, 2016.</p>
    </div>          
    <div>
      <h2 class="title">2</h2>
      <p class="bold">Best Paper Award:</p>
      <p class="body">Two best paper awards will be conferred to author(s) of the papers that receive the highest rank during the peer-review and by the respected session chairs. Please visit <a href="../papers" class="body-link">Paper Submission</a> for more information.</p>
    </div>

  </div>
    </div>
  </div>

<div class="unit unit-s-1 unit-m-1-4-1 unit-l-1-4-1">
  <div class="unit-spacer content">
    <p class="body">We have received your message and we will try our best to get back to you within the next 48 hours.<br><br>
    Thank you for your interest in MVML'16.</p>
  </div>
</div>

  <div class="unit unit-s-1 unit-m-1-3-1 unit-l-1-3-1">
  <div class="unit-spacer">
    <section class="main">
				<div class="custom-calendar-wrap">
					<div id="custom-inner" class="custom-inner">
						<div class="custom-header clearfix">
							<nav>
								<span id="custom-prev" class="custom-prev"></span>
								<span id="custom-next" class="custom-next"></span>
							</nav>
							<h2 id="custom-month" class="custom-month"></h2>
							<h3 id="custom-year" class="custom-year"></h3>
						</div>
						<div id="calendar" class="fc-calendar-container"></div>
					</div>
				</div>
			</section>
<!--     <h2>Upcoming Dates</h2>

<div class="grid events">
<div class="unit unit-s-1 unit-m-1-4 unit-l-1-4">
	<div class="date">
		Dec. 10, 2015
	</div>
</div>

<div class="unit unit-s-1 unit-m-3-4 unit-l-3-4">
	<div class="unit-spacer">
		Paper Submission Deadline
	</div>
</div>
</div>

<div class="grid events">
<div class="unit unit-s-1 unit-m-1-4 unit-l-1-4">
	<div class="date">
		Jan. 25, 2016
	</div>
</div>

<div class="unit unit-s-1 unit-m-3-4 unit-l-3-4">
	<div class="unit-spacer">
		Notification of Authors
	</div>
</div>
</div>

<div class="grid events">
<div class="unit unit-s-1 unit-m-1-4 unit-l-1-4">
	<div class="date">
		Feb. 20, 2016
	</div>
</div>

<div class="unit unit-s-1 unit-m-3-4 unit-l-3-4">
	<div class="unit-spacer">
		Camera Ready Submission Deadline
	</div>
</div>
</div> -->
  </div>
  </div>
</div>

<footer id="contact">
	<div class="grid">
	<div class="unit unit-s-1 unit-m-1-3 unit-l-1-3">
	<div class="unit-spacer">
		<h2>Contact Us</h2>
		<p class="body">International ASET Inc.<br>
		Unit No. 417, 1376 Bank St.<br>
		Ottawa, Ontario, Canada<br>
		Postal Code: K1H 7Y3<br>
		+1-613-695-3040<br>
		<a href="mailto:info@mvml.org">info@mvml.org</a></p>
		</div>
	</div>

	<div class="unit unit-s-1 unit-m-2-3 unit-l-2-3 contact">
	<div class="unit-spacer">
	<p class="body">For questions or comments regarding MVML'16, please fill out the form below:</p>

    <form action="../contactus.php" method="post" enctype="multipart/form-data" name="ContactForm">
  
  <table border="0" class="contact">
    <tbody>
      <tr>
        <td class="label">Name:</td>
        <td class="text"><span id="sprytextfield1">
              <input name="Name" type="text" id="Name" size="40" autocomplete="off">

              <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>

        <tr>
            <td class="label">Email:</td>
            <td class="text"><span id="sprytextfield2">
            <input name="Email" type="text" id="Email" size="40" autocomplete="off">
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
          </tr>

          <tr>
            <td class="label">Confirm Email:</td>
             <td class="text"><span id="spryconfirm4">
              <input name="Confirm Email" type="text" id="Confirm Email" size="40" autocomplete="off">
              <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">Emails don't match.</span></span></td>
          </tr>

          <tr>
            <td class="label">Subject:</td>
            <td class="text"><span id="sprytextfield3">
              <input name="Subject" type="text" id="Subject" size="40" autocomplete="off">
              <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          </tr>

          <tr>
            <td valign="top" class="label">Message:</td>
            <td class="text"><span id="sprytextarea1">
              <textarea name="Message" id="Message" cols="31" rows="10" autocomplete="off"></textarea>
              <span class="textareaRequiredMsg">A value is required.</span></span>
              <center>
        <input type="submit" name="Submit" value="Submit" accept="image/jpeg">
        <input type="reset" name="Reset" value="Reset"></center></td>
          </tr>

        </tbody></table><br>

        
</form>
    </div>
	</div>
	</div>
</footer> 

<div class="copyright">
	<a href="international-aset.com">International ASET Inc.</a> | <a href="http://international-aset.com/phplistpublic/?p=subscribe&id=1">Subscribe</a> | <a href="../terms">Terms of Use</a> | <a href="../sitemap">Sitemap</a>
	<p class="body">&copy; Copyright International ASET Inc., 2015. All rights reserved.</p>
	<p class="copyright1">Have any feedback? Please provide them here: <script>var refURL = window.location.protocol + "//" + window.location.host + window.location.pathname; document.write('<a href="http://international-aset.com/feedback/?refURL=' + refURL+'" class="body-link">Feedback</a>');</script></p>
</div>
</div>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="../js/jquery.nicescroll.min.js"></script>
  <script type="text/javascript" src="../js/jquery.calendario.js"></script>
    <script type="text/javascript" src="../js/data.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
  <script src="../js/jquery.liquid-slider.min.js"></script>  
  <script src="../js/classie.js"></script>
    <script src="../js/cbpAnimatedHeader.min.js"></script>
    <script src="../js/SpryValidationSelect.js" type="text/javascript"></script>

    <script src="../js/SpryValidationTextField.js" type="text/javascript"></script>

    <script src="../js/SpryValidationConfirm.js" type="text/javascript"></script>

    <script src="../js/SpryValidationCheckbox.js" type="text/javascript"></script>
    <script src="../js/SpryValidationTextarea.js" type="text/javascript"></script>

    <script type="text/javascript">
/*
  Slidemenu
*/
(function() {
  var $body = document.body
  , $menu_trigger = $body.getElementsByClassName('menu-trigger')[0];

  if ( typeof $menu_trigger !== 'undefined' ) {
    $menu_trigger.addEventListener('click', function() {
      $body.className = ( $body.className == 'menu-active' )? '' : 'menu-active';
    });
  }

}).call(this);
</script>

    <script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {isRequired:false});

var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");

var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");

var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");

var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");

var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1"});

var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "email");

var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");

var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3", {invalidValue:"-1", isRequired:false});

var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "date", {format:"mm/dd/yyyy"});

var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1");
</script>


    <script type="text/javascript"> 
      $(function() {
      
        var transEndEventNames = {
            'WebkitTransition' : 'webkitTransitionEnd',
            'MozTransition' : 'transitionend',
            'OTransition' : 'oTransitionEnd',
            'msTransition' : 'MSTransitionEnd',
            'transition' : 'transitionend'
          },
          transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
          $wrapper = $( '#custom-inner' ),
          $calendar = $( '#calendar' ),
          cal = $calendar.calendario( {
            onDayClick : function( $el, $contentEl, dateProperties ) {

              if( $contentEl.length > 0 ) {
                showEvents( $contentEl, dateProperties );
              }

            },
            caldata : codropsEvents,
            displayWeekAbbr : true
          } ),
          $month = $( '#custom-month' ).html( cal.getMonthName() ),
          $year = $( '#custom-year' ).html( cal.getYear() );

        $( '#custom-next' ).on( 'click', function() {
          cal.gotoNextMonth( updateMonthYear );
        } );
        $( '#custom-prev' ).on( 'click', function() {
          cal.gotoPreviousMonth( updateMonthYear );
        } );

        function updateMonthYear() {        
          $month.html( cal.getMonthName() );
          $year.html( cal.getYear() );
        }

        // just an example..
        function showEvents( $contentEl, dateProperties ) {

          hideEvents();
          
          var $events = $( '<div id="custom-content-reveal" class="custom-content-reveal"><h4>Events for ' + dateProperties.monthname + ' ' + dateProperties.day + ', ' + dateProperties.year + '</h4></div>' ),
            $close = $( '<span class="custom-content-close"></span>' ).on( 'click', hideEvents );

          $events.append( $contentEl.html() , $close ).insertAfter( $wrapper );
          
          setTimeout( function() {
            $events.css( 'top', '0%' );
          }, 25 );

        }
        function hideEvents() {

          var $events = $( '#custom-content-reveal' );
          if( $events.length > 0 ) {
            
            $events.css( 'top', '100%' );
            Modernizr.csstransitions ? $events.on( transEndEventName, function() { $( this ).remove(); } ) : $events.remove();

          }

        }
      
      });
    </script>

        <script>
    $('#main-slider').liquidSlider();
  </script>
  <script>
(function($){
        $(window).load(function(){
            $("html").niceScroll();
        });
    })(jQuery);
</script>
</body>
</html>