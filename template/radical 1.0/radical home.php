<?php
/**
 * Template Name: Radical home Page
 *
 * Displays the Home page with Parallax effects.
 *
 */
?>

<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

	 if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 11')){$IE=11;}
else if(strstr($_SERVER['HTTP_USER_AGENT'], 'WOW64')){$IE=11;}
else if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 10')){$IE=10;}
else if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 9' )){$IE=9;}
else if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 8' )){$IE=8;}
else if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 7' )){$IE=7;}
else if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6' )){$IE=6;}
else if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 5' )){$IE=5;}
else{
$IE=0;
}
//echo $_SERVER['PHP_SELF'];
/*
if( !strstr($_SERVER['PHP_SELF'], 'htm' ) ){
	header('Location:'.$_GET['p'].'.htm');
}*/

$video_background=1;
$msie = strstr($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
$firefox = strstr($_SERVER["HTTP_USER_AGENT"], 'Firefox') ? true : false;
$safari = strstr($_SERVER["HTTP_USER_AGENT"], 'Safari') ? true : false;
$chrome = strstr($_SERVER["HTTP_USER_AGENT"], 'Chrome') ? true : false;
$Opera = strstr($_SERVER["HTTP_USER_AGENT"], 'Opera') ? true : false;
$phone = strstr($_SERVER["HTTP_USER_AGENT"], 'Phone') ? true : false;
$ipad = strstr($_SERVER["HTTP_USER_AGENT"], 'iPad') ? true : false;
$android = strstr($_SERVER["HTTP_USER_AGENT"], 'Android') ? true : false;
$linux = strstr($_SERVER["HTTP_USER_AGENT"], 'Linux') ? true : false;
$ipod = strstr($_SERVER["HTTP_USER_AGENT"], 'iPod') ? true : false;
$iphone = strstr($_SERVER["HTTP_USER_AGENT"], 'iPhone') ? true : false;
$WOW64 = strstr($_SERVER["HTTP_USER_AGENT"], 'WOW64') ? true : false;
$android = strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android') ? true : false;
$windowsPhone8 = strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') ? true : false;


if(($iphone||$ipod||$windowsPhone8||$phone||$IE<=8 && $IE!=0 ) ){
	$video_background=0;
}

include_once "admin/logsys.php";
$isAdmin=__check_is_admin__();


  if ( array_key_exists("HTTP_ACCEPT", $_SERVER) &&
        (stristr($_SERVER["HTTP_ACCEPT"], "application/xhtml") ||
         stristr($_SERVER["HTTP_ACCEPT"], "application/xml") )
       ||
       (array_key_exists("HTTP_USER_AGENT", $_SERVER) &&
        stristr($_SERVER["HTTP_USER_AGENT"], "W3C_Validator"))
     )
  {
  // header("Content-type: application/xhtml+xml");
   header("Content-type: text/html; charset=utf-8");
  }
  else
  {
    header("Content-type: text/html; charset=utf-8");
  }
/*
<!DOCTYPE html><html>
*/

$HEAD='<title>';if(defined('TITLE')===true){$HEAD.= tag_feature_extractor(TITLE,'{'.$_SESSION['lc'].'::','::'.$_SESSION['lc'].'}',$_SESSION['lc']);}$HEAD.='</title>';
if(defined('DESCRIPTION')===true && DESCRIPTION!=''){$HEAD.='<meta name="description" content="'. tag_feature_extractor(DESCRIPTION,'{'.$_SESSION['lc'].'::','::'.$_SESSION['lc'].'}',$_SESSION['lc']).'"/>';}
if(defined('KEYWORD')===true && KEYWORD!=''){$HEAD.='<meta name="keywords" content="'. tag_feature_extractor(KEYWORD,'{'.$_SESSION['lc'].'::','::'.$_SESSION['lc'].'}',$_SESSION['lc']).'"/>';}
/*
echo '<?xml version="1.0" encoding="UTF-8"?>'
 xml:lang="fr-ca" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"
*/




$RETURN=Array();
$BTARGET  ='';
$RETURN['items']=Array();
$RETURN['sous-total']=0;
$RETURN['tps']=0;
$RETURN['tvq']=0;
$RETURN['total']=0;
$RETURN['quantity']=0;

$TOTAL=0;
foreach( $_SESSION['basket'] as $link => $Quantity ){
	
	
		$L=explode('.', $link);
		$L=array_reverse($L);
	
	//print_r($L);
	$a=get_from_pos($L[0],'alias',$L[1],  $BTARGET  );
	
	
	//$a
	/*if(is_array($a))*/
	if( is_array( $a ) ){
		foreach( $a as $k => $D){
			$pos =		strpos($D['content'], 'src="', strpos($D['content'], 'img'))+5;
			$pos2=		strpos($D['content'], '"', $pos);
			$img1=	substr ( $D['content'] , $pos , $pos2-$pos );
		$D['value']=simple_feature_extractor($D['value'] );
		if(is_array($D['value']))$D['value']=$D['value'][$_SESSION['lc'].$_SESSION['lcValueExt']];
			$RETURN['sous-total']+=$D['value']*$Quantity;
			$RETURN['items'][$D['name']]['img']=$img1;
			$RETURN['items'][$D['name']]['quantity']=$Quantity;
			$RETURN['items'][$D['name']]['price']=$D['value'];
			$RETURN['items'][$D['name']]['total']=$D['value']*$Quantity;
			$RETURN['quantity']+=$Quantity;

		$RETURN['tps']=round($RETURN['sous-total']/100*5*100)/100;
		$RETURN['tvq']=round($RETURN['sous-total']/100*9.975*100)/100;
		$RETURN['total']=round(($RETURN['sous-total']+$RETURN['tps']+$RETURN['tvq'])*100)/100;









		}
	}
}
//$RETURN['sous-total']=number_format($RETURN['sous-total'],2);


?><!DOCTYPE html>
<!--[if IE 8]> <html class="ie8"> <![endif]-->
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <?php if(isset($HEAD))echo $HEAD; ?>
        <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <base href="<?php echo "//".$_SERVER["HTTP_HOST"].$_SERVER["BASE"] ; ?>">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" defer />
		<link rel="stylesheet" type="text/css" href="js/admin/grid-editor-master/dist/flexboxgrid.min.css" defer />
        <link rel="stylesheet" href="css/font-awesome.min.css" defer>
        <link rel="stylesheet" href="css/prettyPhoto.css" defer>
        <link rel="stylesheet" href="css/owl.carousel.css" defer>
        <link rel="stylesheet" href="css/revslider.css" defer>
        
        <!-- Favicon and Apple Icons -->
        <link rel="icon" type="image/png" href="images/icons/icon.png">
        <link rel="apple-touch-icon" sizes="57x57" href="images/icons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/icons/apple-icon-72x72.png">
        
        <!--- jQuery -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" defer></script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.11.1.min.js"><\/script>')</script>

        <!--[if lt IE 9]>
            <script src="js/html5shiv.js" defer></script>
            <script src="js/respond.min.js" defer></script>
        <![endif]-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous" defer></script>
		<script src="js/smoothscroll.js" defer></script>
		<script src="js/jquery.debouncedresize.js" defer></script>
		<script src="js/retina.min.js" defer></script>
		<script src="js/jquery.placeholder.js" defer></script>
		<script src="js/jquery.hoverIntent.min.js" defer></script>
		<script src="js/twitter/jquery.tweet.min.js" defer></script>
		<script src="js/jquery.flexslider-min.js" defer></script>
		<script src="js/owl.carousel.min.js" defer></script>
		<script src="js/jflickrfeed.min.js" defer></script>
		<script src="js/jquery.prettyPhoto.js" defer></script>
		<script src="js/jquery.themepunch.tools.min.js" defer></script>
		<script src="js/jquery.themepunch.revolution.min.js" defer></script>
		
<?php


if( $isAdmin ){

$theme_url='template/radical 1.0/';
/*
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"  defer/>
    <link rel="stylesheet" type="text/css" href="<?php echo $theme_url; ?>/dist/flexboxgrid.min.css"  defer/>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"  defer/>
	<script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js" defer></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" defer></script>


	
    <!-- Grid editor -->
    <link rel="stylesheet" type="text/css" href="<?php echo $theme_url; ?>/dist/spectrum.css" defer/>
    <link rel="stylesheet" type="text/css" href="<?php echo $theme_url; ?>/dist/grideditor.css" defer/>
    <script src="<?php echo $theme_url; ?>/dist/jquery.ui.touch-punch.js" defer></script>
    <script src="<?php echo $theme_url; ?>/dist/jqColorPicker.min.js" defer></script>
    <script src="<?php echo $theme_url; ?>/dist/spectrum.js" defer></script>
    <script src="<?php echo $theme_url; ?>/dist/tinymce/tinymce.min.js" defer></script>
    <script src="<?php echo $theme_url; ?>/dist/tinymce/jquery.tinymce.min.js" defer></script>
    <script src="<?php echo $theme_url; ?>/dist/cssParser.js" defer></script>
    <script src="<?php echo $theme_url; ?>/dist/jquery.grideditor.js" defer></script>
	*/
?>
	
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="js/admin/grid-editor-master/dist/flexboxgrid.min.css" />
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />
	<script src="https://code.jquery.com/jquery-1.11.2.js" defer></script>
	<!--<script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js" defer></script>-->
	<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js" defer></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" defer></script>

	
	<!-- Grid editor -->
	<link rel="stylesheet" type="text/css" href="js/admin/grid-editor-master/dist/spectrum.css" />
	<link rel="stylesheet" type="text/css" href="js/admin/grid-editor-master/dist/grideditor.css" />
	<script src="js/admin/grid-editor-master/dist/jquery.ui.touch-punch.js" defer></script>
	<script src="js/admin/grid-editor-master/dist/jqColorPicker.min.js" defer></script>
	<script src="js/admin/grid-editor-master/dist/spectrum.js" defer></script>
	<script src="js/admin/grid-editor-master/dist/tinymce/tinymce.min.js" defer></script>
	<script src="js/admin/grid-editor-master/dist/tinymce/jquery.tinymce.min.js" defer></script>
	<script src="js/admin/grid-editor-master/dist/cssParser.js" defer></script>
	<script src="js/admin/grid-editor-master/dist/jquery.grideditor.js" defer></script>
<?php

}



?>

        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/responsive.css" defer>


<?php if(isset($HEAD))echo $HEAD; ?><meta charset="utf-8"/>
<?php

if($_SERVER['HTTP_HOST']=='santelavie.ca'){

?>
<meta name="msvalidate.01" content="7C141C38F59582581C516F8C39EC614A" />
<meta name="google-site-verification" content="kxzxqgTczSdLVcs92OTJr8vEna2YIlVS7r2ICs3cN0c" />
<?php

}else{

?>
<meta name="msvalidate.01" content="7C141C38F59582581C516F8C39EC614A" />
<meta name="google-site-verification" content="kxzxqgTczSdLVcs92OTJr8vEna2YIlVS7r2ICs3cN0c" />
<?php

}
/*
?>



        <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
		<link rel="stylesheet" href="css/call.css?bootstrap.min&amp;style&amp;sequence-slider&amp;owl.carousel&amp;responsive&amp;minify">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
<style>
					.icon-cart-text:before{
						content:"<?php echo $_SESSION['language_traduct']['add_to_card']; ?>";
					}
					.microdescription .m:before{
						content:"<?php echo $_SESSION['language_traduct']['moreinfo']; ?>";
					}
					
</style>
		<!--<link rel="stylesheet" href="css/call.css?prettyPhoto">-->
		<script src="js/call.js?jquery.min&amp;bootstrap.min&amp;smoothscroll&amp;retina-1.1.0.min&amp;jquery.placeholder&amp;jquery.hoverIntent.min&amp;jquery.flexslider-min&amp;owl.carousel.min&amp;jquery.prettyPhoto&amp;jquery.sequence-min&amp;main&amp;add.basket"></script>
        <?php if($IE==8){ ?>
		<!--[if IE 8]>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/prettyPhoto.css">
        <link rel="stylesheet" href="css/sequence-slider.css">
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/responsive.css">
		<![endif]-->
		<?php } ?>
		<link rel="shortcut icon" href="images/icons/favicon.ico">
        <link rel="icon" type="image/png" href="images/icons/icon.png">
        <link rel="apple-touch-icon" sizes="57x57" href="images/icons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/icons/apple-icon-72x72.png">
		<?php if( $IE<=8 && $IE!=0 ){ ?>
		<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
		<![endif]-->
		<?php } ?>
		
	<?php if($IE==8){ ?>
	<!--[if IE 8]>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/smoothscroll.js"></script>
    <script src="js/retina-1.1.0.min.js"></script>
    <script src="js/jquery.placeholder.js"></script>
    <script src="js/jquery.hoverIntent.min.js"></script>
    <script src="js/jquery.flexslider-min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jflickrfeed.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.sequence-min.js"></script>
    <script src="js/main.js"></script>
<script src="js/add.basket.js"></script>
	<![endif]-->
	<?php } ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, min-width=720px, user-scalable=no">
<script>

if (typeof console !== 'undefined') {
        console.log(" <?php



echo '\\r\\n\\r\\nCMS Benchmark (temps de réaction en seconde) : \\r\\nCMS nom : RADICAL\\r\\nVersion 1.1\\r\\n';
if(isset($includ)){
foreach($includ as $k => $d){
	echo 'inclusion ('.$k.') : '.number_format($includ_end[$k]-$includ[$k],25).'\\r\\n';
}
}
if(isset($runner)){
	echo 'Rendu : '.number_format($runner_end - $runner,25).'\\r\\n';
}

?>\n\rend\n\r" );  
    }
</script>
<?php /**/ ?>



	</head>
	<body <?php


if( $isAdmin ){
	echo 'class=""';
}

?>><?php


if( $isAdmin ){

include 'js/admin/grid-editor-master/dist/editor.php';

}



?>
	<div class="alert"></div>
	<div id="wrapper">
<?php /*include 'header.php';/**/ ?>

		<section id="content">
<?php


?><?php


if( $isAdmin ){
echo '<div id="gridEditor">';

}



?><?php
	
	if(defined('CONTENT')){
		
		
		echo tag_feature_extractor(CONTENT,'{'.$_SESSION['lc'].'::','::'.$_SESSION['lc'].'}',$_SESSION['lc']);
		
		
	}
	
?>

<?php


if( $isAdmin ){

?></div><?php

}



?>

		</section>
		<footer id="footer">

			<div id="newsletter-container" style="background:#004c93;">
				<div class="container">
					<div>
							

						<div id="brand-slider-container" class="carousel-wrapper" style="margin:0;" class="row">
							<div class="col-md-11 col-sm-10 col-xs-12 clearfix">
									<div class="bottom-slider owl-carousel">
									
										<div style="padding:0 95px;">
											<p style="font-size:15px;text-align:center;line-height:15px;">Notre système a été conçu afin d&#39;apporter une sécurité transactionnelle optimale, vérifié à la loupe, les informations suspectes sont soumises à des tests vigoureux et acheminés dans notre base de données protégée.</p>
										</div>
										<div style="padding:0 95px;">
											<p style="font-size:15px;text-align:center;line-height:15px;">Si avez vu une promotion que nous n’avons pas, appelez-nous sans hésiter, car nous avons accès à toutes les promotions autorisées par USANA et nous ajusterons votre transaction pour vous.</p>
										</div>
									


									</div><!-- End .brand-slider -->
							</div>
							
							
							
							<div class="col-md-1 col-sm-2 col-xs-12 clearfix">
								<div class="carousel-controls" style="background:none;width:78px;">
									<div id="bottom-slider-prev" class="carousel-btn btn-custom-3 carousel-btn-prev-dark btn-xs">
									</div><!-- End .carousel-prev -->
									<div id="bottom-slider-next" class="carousel-btn btn-custom-3 carousel-btn-next-dark btn-xs carousel-space">
									</div><!-- End .carousel-next -->
								</div><!-- End .carousel-controllers -->
							</div>
						</div><!-- End #brand-slider-container -->
						<!--End  .col-md-6 -->
						
					</div><!-- End .row -->
				</div><!-- End .container -->
			</div><!-- End #newsletter-container -->
<?php /*include 'innerFooter.php';/**/ ?>

			
			<div id="footer-bottom">
				<div class="container">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-12 footer-social-links-container">
							<ul class="social-links clearfix">
								<li><a href="#" class="social-icon icon-facebook"></a></li>
								<li><a href="#" class="social-icon icon-email"></a></li>
							</ul>
						</div><!-- End .col-md-7 -->
						
						<div class="col-md-5 col-sm-5 col-xs-12 footer-text-container">
							<p style="text-align:left;">
								Les résultats peuvent varier et ne sont pas garanties.<br /> 
								Les images des produits et du texte sont la propriété  de USANA Health Sciences et sont utilisées avec leur permission. <br />
								Ces produits ne sont pas destinés à diagnostiquer, traiter, guérir ou prévenir une maladie quelconque.
							</p>
						</div><!-- End .col-md-5 -->
						<div class="col-md-5 col-sm-5 col-xs-12 footer-text-container">
							<p style="text-align:left;">
								Copyright &copy; 2016 Santelavie.ca &copy; Tous droits réservés - Termes et conditions<br />
								Groupe Synergie Alliance inc. est un distributeur indépendant.<br />
								USANA Health Sciences, 3838 Parkway Blvd. Salt Lake City, UT 84120<br />
								ADV-471
							</p>
						</div><!-- End .col-md-5 -->
					</div><!-- End .row -->
				</div><!-- End .container -->
			</div><!-- End #footer-bottom -->
			
		</footer><!-- End #footer -->
	</div><!-- End #wrapper -->
	
	<a href="#" id="scroll-top" title="Scroll to Top"><i class="fa fa-angle-up"></i></a><!-- End #scroll-top -->
	
	
<?php


if( !$isAdmin ){

$theme_url='template/radical 1.0/';
?>
	<!-- END -->
	<script src="js/add.basket.js"></script>
	<script src="js/main.js" defer></script>
	
	<script defer>
		$(function() {

			
			jQuery('#slider-rev').revolution({
				delay:5000,
				startwidth:1170,
				startheight:370,
				onHoverStop:"true",
				hideThumbs:250,
				navigationHAlign:"center",
				navigationVAlign:"bottom",
				navigationHOffset:0,
				navigationVOffset:20,
				soloArrowLeftHalign:"left",
				soloArrowLeftValign:"center",
				soloArrowLeftHOffset:0,
				soloArrowLeftVOffset:0,
				soloArrowRightHalign:"right",
				soloArrowRightValign:"center",
				soloArrowRightHOffset:0,
				soloArrowRightVOffset:0,
				touchenabled:"on",
				stopAtSlide:-1,
				stopAfterLoops:-1,
				dottedOverlay:"none",
				fullWidth:"on",
				spinned:"spinner2",
				shadow:0,
				hideTimerBar: "on"
			  });
		
		});
	</script>
<?php

}



?>
	<?php /*include 'footer.php';/**/ ?>
	<?php


if( $isAdmin ){

?></div>

<script src="js/admin/grid-editor-master/dist/Rfscript.js" defer></script>
<?php
/*<script src="<?php echo $theme_url; ?>/dist/Rfscript.js" defer></script>*/
}



?>

    </body>
</html>