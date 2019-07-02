<?php
require_once ( $_SERVER['DOCUMENT_ROOT'].'/../include/header/_header_auth.php' );
include ($_SERVER['DOCUMENT_ROOT'].'/../include/header/_header_header_text.php');
include ($_SERVER['DOCUMENT_ROOT'].'/../include/header/_header_include_base.php');

$_SESSION['LAST_ACTIVITY'] = time();

$protocol = connectionType();
$cssURL = $protocol . DOMAINTAG;

include ($_SERVER['DOCUMENT_ROOT'] . '/../include/class/browser.php');
$browser = new Browser();

$showId=0;
$trainingId = MySQL::filter($_GET['trainingId']);
if (isset($_GET['showId']) && !empty($_GET['showId']))
    $showId = MySQL::filter($_GET['showId']);

$badge = (isset($_GET['badge']) && !empty($_GET['badge'])) ? MySQL::filter($_GET['badge']) : 0;


///////////////////////////////////////////////////////////////
//Megkeresem az elso slideshowt
///////////////////////////////////////////////////////////////
$formArray0 = array();
$formArray0['training_id'] = $trainingId;
$formArray0['office_id'] = $_SESSION['office_id'];
$formArray0['office_nametag'] = $_SESSION['office_nametag'];

if (!$showId) {
    include ($_SERVER['DOCUMENT_ROOT'] . '/errordocuments/404.php');
    exit;
}

///////////////////////////////////////////////////////////////

$formArray['slideshow_id'] = $showId;
$formArray['office_id'] = $_SESSION['office_id'];
$formArray['office_nametag'] = $_SESSION['office_nametag'];

//////////////////////////////////////////////////////////////
// check for attachment
//////////////////////////////////////////////////////////////
$sql = "
      SELECT *
      FROM media_mymedia
      WHERE FIND_IN_SET (mymedia_id, ( SELECT attachment FROM slide_slideshow WHERE slideshow_id = " . $showId . " ) )";

$attRes = MySQL::query($sql, false, false);
$attHtml = '';
$db = count($attRes);
if ($db > 0) {
    $imageURL = connectionType() . $_SESSION['office_nametag'] . '.' . DOMAINTAG . '/media/';
    $downloadUrl = connectionType() . $_SESSION['office_nametag'] . '.' . DOMAINTAG . '/download/';
    $attHtml = createAttachList($attRes, $imageURL, $downloadUrl);
}
//////////////////////////////////////////////////////////////
//query slideshow slides
//////////////////////////////////////////////////////////////
$options = array(
    'table' => 'slide_slides',
    'fields' => '*',
    'condition' => $formArray,
    'conditionExtra' => 'badge >= ' . $badge, //"name LIKE '%".$newDiskareaName['name']."%'",
    'order' => 'badge',
    'limit' => 100
);

$result = MySQL::select($options);

if ($result == true) {

    foreach ($result as $row) {

        $returnData[] = array(
            'id' => $row['slides_id'],
            'type' => $row['type'],
            'templateType' => $row['templateType'] == '' ? 'normal' : $row['templateType'],
            'html' => htmlspecialchars_decode($row['html']),
            'html2' => htmlspecialchars_decode($row['htmlForSlideshow']),
            'tag' => $row['tag'],
            'badge' => $row['badge'],
            'lft' => $row['lft'],
            'description' => htmlspecialchars_decode($row['description']),
            'templateOption' => ($row['templateOption'] == '' ? '' : json_decode($row['templateOption'], true))
        );
    }
    ;
} else {
    include ($_SERVER['DOCUMENT_ROOT'] . '/errordocuments/404.php');
    exit;
}
$tempateType = 'normal';
unset($_POST);
echo '<!DOCTYPE html>';
?>

<html style="height: 100%;">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport" content="width=1024"/>
    <title>::SKILLBI::SLIDESHOW REVIEW</title>
    <?
    if ($browser->getBrowser() == Browser::BROWSER_IE) {
        $bVersion = $browser->getVersion();
        $bv = (int)$bVersion;
        switch ($bv) {
            case 7 :
                print '<meta http-equiv="X-UA-Compatible" content="IE=7" />';
                break;
            case 8 :
                print '<meta http-equiv="X-UA-Compatible" content="IE=8" />';
                break;
            default:
                print '<meta http-equiv="X-UA-Compatible" content="IE=EDGE, chrome=1" />';
                break;
        }
    }
    ?>
    <!--
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="/assets/jqueryui/jquery-ui-1.9.1.custom.min.css" />
    -->
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="/assets/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen"
          href="/assets/bootstrap/css/bootstrap-responsive.css"/>
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="/css/fonts.css"/>
    <!---->
    <link rel="stylesheet" type="text/css" charset="utf-8" media="all" href="/css/basecolor.css"/>
    <link rel="stylesheet" type="text/css" charset="utf-8" media="all" href="/css/slideeditor.css"/>
    <!--
    <link rel="stylesheet" type="text/css" charset="utf-8" media="all" href="/css/layout.css" />
    -->
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="<?= $cssURL; ?>/css/slideshow.css"/>
    <!---->
    <link rel="stylesheet" type="text/css" charset="utf-8" media="all" href="/css/video.css"/>


    <?
    $includeFile = $_SERVER['DOCUMENT_ROOT'] . '/../media/' . $_SESSION['office_nametag'] . '/corporate/' . $_SESSION['office_nametag'] . '.css';
    $cssFile = $protocol . $_SESSION['office_nametag'] . '.' . DOMAINTAG . '/media/corporate/' . $_SESSION['office_nametag'] . '.css';
    if (file_exists($includeFile)) {
        echo '<link rel="stylesheet" type="text/css" charset="utf-8" media="all" href="' . $cssFile . '">';
    }
    ?>
    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="/assets/960/1200.css"/><![endif]-->
    <!--[if IE 8]>
    <link rel="stylesheet" type="text/css" href="/css/ie8.css"/><![endif]-->
    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="/css/ie7.css"/><![endif]-->
    <!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
    <!--[if lt IE 10]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--<script type="text/javascript" charset="utf-8" src="/css/pie/PIE.js" ></script>-->

    <?
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/_jqueryLoad.php');
    ?>
    <!--<script type="text/javascript" charset="utf-8" src="/assets/video.js"></script>-->
</head>
<body class="firstTime <?= $_SESSION['office_nametag']; ?>">
<div id="corporateHeader" class="corporateHeader row">
    <?
    $includeFile = $_SERVER['DOCUMENT_ROOT'] . '/../media/' . $_SESSION['office_nametag'] . '/corporate/' . $_SESSION['office_nametag'] . 'SlideshowHeader.php';
    if (file_exists($includeFile))
        include($includeFile);
    ?>
</div>

<div id="impress">

    <?php
    $db = count($returnData);
    $x = array();$y = array();$z = array();$rotate = array();
    //x,y,z -6000 +6000 ->12000/$db
    //rotate 0 - 360    ->360/$db
    for ($i = 0; $i < $db; $i++) {
        $x[] = -6000 + (12000 / 6) * $i;
        $rotate[] = 0 + (360 / $db) * $i;
    }

    $js=''; $trainingResultsArray=array();

    $lastToken = TrainingDetails::getLastToken($trainingId,$showId,$_SESSION['u_id']);
    if ($lastToken)
    {
        $trainingResultsArray = (TrainingDetails::getTrainingResultsTableRowsWithIndexSlideId($trainingId,$showId,$lastToken,$_SESSION['u_id']));
    }
    else
    {
        //@todo security
    }

    foreach ($returnData as $row) {
        if ($trainingResultsArray[$row['id']])
        {
            echo '<div class="slide step" id="slide_' . $row['badge'] . '" data-template-type="' . $row['templateType'] . '" data-slide-tag="' . $row['tag'] . '" data-x="' . $x[$row['badge'] - 1] . '" data-y="0"  data-z="0" data-scale="1" data-rotate="0">'; //'.$rotate[$row['badge']-1].'
            echo '<div class="answer">'.$trainingResultsArray[$row['id']]['answer'].'</div>';
            echo '<div class="takaro">';
            if ($row['templateType'] !== 'normal') {

                $js='';

                switch ($row['templateType']) {
                    case 'sorting':

                    break;

                    case 'pairing':

                    break;

                    case 'groupping':

                    break;
                }
            }
            else
            {

            }
            echo $row['html2'];
            echo '</div>'; //takaro
            echo '</div>'; //slide stp
            /*
            if ($row['templateType'] !== 'normal') {
                //$tempateType = 'template';
                break;
            }*/
            echo $js;
        }
    }
    ?>
    <!---->
    <? if ($tempateType == 'normal' && $db > 5)
        echo '<div id="overview" class="step slide" data-x="" data-y="" data-scale="10" data-slide-tag="overview">
    <img src="http://www.hdwallcloud.com/wp-content/uploads/2013/02/abstract-color-background-picture-8016-HD_wallpapers.jpg" width="1920" height="1200"/>
    </div>';
    ?>
</div>

<!-- Fallback message-->
<div class="fallback-message">
    <p>Your browser <b>doesn't support the features required</b> by impress.js,
        so you are presented with a simplified version of this presentation.</p>

    <p>For the best experience please use the latest <b>Chrome</b>,
        <b>Safari</b> or <b>Firefox</b> browser.</p>
</div>
<!-- Hint for handling-->
<div class="hint"><p>Use a spacebar or arrow keys to navigate</p></div>
<!--<div class="progressbar"><div></div></div>-->
<div class="progress badge"></div>
<div id="corporateFooter">
    <div class="userBrand"><span class="pull-left slogen"></span><span class="pull-left sup"></span></div>
</div>
<!---->
<?
if ($browser->getBrowser() == Browser::BROWSER_IE) {
    echo '<script type="text/javascript" charset="utf-8" src="/assets/jmpress.js"></script>';
} else {
    echo '<script type="text/javascript" charset="utf-8" src="/assets/impress.plugins.js"></script>';
    echo '<script type="text/javascript" charset="utf-8" src="/assets/impress.js"></script>';
    //echo '<script type="text/javascript" charset="utf-8" src="/lib/jmpress.js"></script>';
}
?>

<script type="text/javascript">
    if ("ontouchstart" in document.documentElement) {
        document.querySelector(".hint").innerHTML = "<p>Tap on the left or right to navigate</p>";
    }

    $(function () {
        //ell ie eseten jmpress
        //minden mas impress
        /*
         //impress().init(), impress().showMenu()
         //$('#impress').jmpress()
         $videos = $('#impress').find('video');
         $.each($videos, function(i, e){
         });
         */

        $.when(
                <?
                if ($browser->getBrowser() == Browser::BROWSER_IE) {
                  echo "$('#impress').jmpress()";
                } else {
                  echo 'impress().init(), impress().showMenu()'; //
                  //echo "$('#impress').jmpress()";
                }
                ?>
            ).done(function (resp) {
                setTimeout(function () {
                    $('body').removeClass('firstTime');
                }, 2000);
                $('body').removeClass('firstTime');
                <? if ($browser->getBrowser() !== Browser::BROWSER_IE) { ?>
                $('div[class^="pointer-right"]').bind('click', function () {
                    impress().next();
                });
                $('div[class^="pointer-left"]').bind('click', function () {
                    impress().prev();
                });
                <? } ?>
                $videos = $('#impress').find('video');
                var data = [];
                $.each($videos, function (i, e) {
                    //alert( e + '  ' + i );
                    //$(this).attr('poster', ''); //ios
                    $(this).attr('class', 'video-js vjs-default-skin');
                    $(this).attr('id', 'video' + i).css({'width': '100%', 'height': '90%'});

                    //touchon kell
                    _V_('video' + i, { 'width': '100%', 'height': '90%'});
                    //$(this).load();
                    $('.video-js').css({'width': '100%', 'height': '90%'});
                });
                var token = $("#auth_token", parent.document.body);
                $('#impress').find('form').each(function () {
                    $(this).append(token.clone());
                });
            });

        <? if ($attHtml !== ''){ ?>
        $("#fileList", parent.document.body).html('<?=$attHtml;?>');
        $("#attachDrop", parent.document.body).removeClass("hidden");
        <?}
        //echo "alert('".$tempateType."');";
            switch ($tempateType){
              case 'sorting':
                print "
                $('ul.sortableForm').sortable({
                  update:function(event,ui){
                    $('#sortSer').val(  $('ul.sortableForm').sortable('serialize') );
                  }
                });";
                  print "$('#sortSer').val(  $('ul.sortableForm').sortable('serialize') );";
                break;
              case 'pairing':
                print "
                $('ul.sortable').sortable({
                  update:function(event,ui){
                    $('#sortSer').val(  $('ul.sortable').sortable('serialize') );
                  }
                });";
                  print "$('#sortSer').val(  $('ul.sortable').sortable('serialize') );";
                break;
              case 'groupping':
                print "
                  $( '#sortableHolder' ).sortable({connectWith: 'ul.sortableForm'});";
                print "
                  $('.slide[data-template-type=\"groupping\"]')
                    .find('ul.sortableForm')
                    .each(function(i,el){
                      $('.slide[data-template-type=\"groupping\"] #slideForm').prepend('<input type=\"hidden\" name=\"sort_'+$(this).attr('id')+'\" id=\"sort_'+$(this).attr('id')+'\" value=\"\" />');
                      $(this).sortable(
                        {connectWith: 'ul.sortableForm'},
                        {update:function(event,ui){
                          $('#sort_'+$(this).attr('id')).val( $('#'+$(this).attr('id')).sortable('serialize') );
                        }
                      });
                    });";
                print "
                  $('ul.sortableForm')
                    .each(function(i,el){
                      $('#sort_'+$(this).attr('id')).val( $('#'+$(this).attr('id')).sortable('serialize') );
                    });";
                break;
            }

            if(isset($_SESSION['29_testPoint']) && !empty($_SESSION['29_testPoint'])){
              echo "$('#testPointDiv').val('".$_SESSION['29_testPoint']."');";
              echo "$('div.badge.test', parent.document.body).text('".$_SESSION['29_testPoint']." pont');";
            }
        ?>

    });
</script>
</body>
</html>
