<?php
//echo 'teszt';//'kopasz, lelottem';
//exit;

require($_SERVER['DOCUMENT_ROOT'] . '/../include/config.php');
$_SESSION['logged_in'] = FALSE;
preg_match('/([^.]+)\\' . DOMAINTAG_PREGSTRING . '/', $_SERVER['SERVER_NAME'], $matches);

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
/*
if (isset($matches[1]) && !empty($matches[1]) && $matches[1] !== $_SESSION['office_nametag'])
{

    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE)
    {
        $subdomain   = $_SESSION['office_nametag'] . '.';
        $temp        = explode('/', $_SERVER['REDIRECT_SCRIPT_URL']);
        $redirectTag = $_SERVER['REDIRECT_SCRIPT_URL'];
        header('Location: ' . $protocol . $subdomain . DOMAINTAG . $redirectTag);
    } else
    {
        header('Location: ' . $protocol . DOMAINTAG);
    }
    exit;
} elseif (isset($matches[1]) && !empty($matches[1]) && $matches[1] == $_SESSION['office_nametag'])
{

    header('Location: ' . $protocol . $_SESSION['office_nametag'] . '.' . DOMAINTAG . '/home/');
    exit;
} elseif (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE && isset($_SESSION['office_nametag']))
{
    header('Location: ' . $protocol . $_SESSION['office_nametag'] . '.' . DOMAINTAG . '/home/');
    exit;
}
*/
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../include/header/_header_header_text.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../include/header/_header_include_base.php');

//printR($_SESSION);

/*
preg_match('/([^.]+)\\' . DOMAINTAG_PREGSTRING . '/', $_SERVER['SERVER_NAME'], $matches);

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

if (isset($matches[1]) && !empty($matches[1]) && $matches[1] !== $_SESSION['office_nametag'])
{

    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE)
    {
        $subdomain   = $_SESSION['office_nametag'] . '.';
        $temp        = explode('/', $_SERVER['REDIRECT_SCRIPT_URL']);
        $redirectTag = $_SERVER['REDIRECT_SCRIPT_URL'];
        header('Location: ' . $protocol . $subdomain . DOMAINTAG . $redirectTag);
    } else
    {
        header('Location: ' . $protocol . DOMAINTAG);
    }
    exit;
}
if (isset($matches[1]) && !empty($matches[1]) && $matches[1] == $_SESSION['office_nametag'])
{
    if ($_SESSION['logged_in'] and $_SERVER['REQUEST_URI'] == '/')
    {
        header('Location: ' . $protocol . $_SESSION['office_nametag'] . '.' . DOMAINTAG . '/home/');
        exit;
    }
}
*/

//$protocol = connectionType();
$pageTitle = SITENAME;

if (isset($_SESSION['error']) && !empty($_SESSION['error']))
{
    $errorArray = $_SESSION['error'];
    unset($_SESSION['error']);
}

require($_SERVER['DOCUMENT_ROOT'] . '/../include/authenticate.php');
//require_once ($_SERVER['DOCUMENT_ROOT'] . '/../include/header/_header_header_text.php');
//require_once ($_SERVER['DOCUMENT_ROOT'] . '/../include/header/_header_include_base.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../include/class/browser.php');

/** @var $browser TYPE_NAME */
$browser = new Browser();
$browserArray = array(
    'name'     => $browser->getBrowser(),
    'version'  => $browser->getVersion(),
    'platform' => $browser->getPlatform(),
    'isTablet' => $detect->isTablet() ? $detect->version($browser->getBrowser()) : ''
);

if (!$_SESSION['isTablet'] && !$_SESSION['isMobile'])
{
    if ($browser->getBrowser() == Browser::BROWSER_IE)
    {
        $bVersion = $browser->getVersion();
        $bv       = (int)$bVersion;
        switch ($bv)
        {
            case 7 :
                header('X-UA-Compatible: IE=IE7');
                break;
            case 8 :
                header('X-UA-Compatible: IE=IE8');
                break;
            default:
                header('X-UA-Compatible: IE=EDGE');
                break;
        }
    }
}

///////////////////////////////////////////////////////////
// DEFAULT LANGUAGE CHECK
///////////////////////////////////////////////////////////
$pageLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$langArray = array('hu', 'en');
if (!in_array($pageLanguage, $langArray))
{
    $pageLanguage = 'en';
}
if (isset($_POST['lang_']) && in_array($_POST['lang_'], $langArray))
{
    $pageLanguage         = $_POST['lang_'];
    $_SESSION['language'] = $_POST['lang_'];
    setcookie("defLang", $pageLanguage, time() + 60 * 60 * 24 * 365, '/');
    unset($_POST['lang_']);
};
if (isset($_SESSION['language']) && in_array($_SESSION['language'], $langArray))
{
    $pageLanguage = $_SESSION['language'];
    setcookie("defLang", $pageLanguage, time() + 60 * 60 * 24 * 365, '/', "." . DOMAINTAG);
};
if (!isset($_COOKIE["defLang"]))
{
    setcookie("defLang", $pageLanguage, time() + 60 * 60 * 24 * 365, '/', "." . DOMAINTAG);
};

header("Content-language: $pageLanguage");

///////////////////////////////////////////////////////////
// INCLUDE SECTION AND MAIN DEFINITIONS
///////////////////////////////////////////////////////////
include ($_SERVER['DOCUMENT_ROOT'] . '/../include/lang/en_' . $pageLanguage . '.php');

echo '<!DOCTYPE html>';
//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

$subdomain = $protocol . $_SESSION['office_nametag'] . '.' . DOMAINTAG;

///////////////////////////////////////////////////////////
// PAGE CHECK
///////////////////////////////////////////////////////////
if (isset($_GET['pageN']) && $_GET['pageN'] == 'search.html')
{
    $request[1] = 'search.html';
} else
{
    $request = explode('/', $_SERVER['REQUEST_URI']);
    if (preg_match('/q=/i', $request[1])) $request[1] = 'search.html'; //unset($request[1]);
//echo 'URI: '.$request[1];
}
$_GET['pageName'] = $request[1];


?>
<!--[if lt IE 7 ]>
<html lang="<?=$pageLanguage;?>" class="ie6"> <![endif]-->
<!--[if IE 7 ]>
<html lang="<?=$pageLanguage;?>" class="ie7"> <![endif]-->
<!--[if IE 8 ]>
<html lang="<?=$pageLanguage;?>" class="ie8"> <![endif]-->
<!--[if IE 9 ]>
<html lang="<?=$pageLanguage;?>" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="<?= $pageLanguage; ?>"> <!--<![endif]-->
<head>
    <title>::<?=$pageTitle;?>::</title>
    <meta name="og:title" content="::<?= $pageTitle; ?>::">
    <meta name="title" content="::<?= $pageTitle; ?>::">

    <!-- ez valtozhat a tartalom függvényében -->
    <meta name="description" content="">
    <meta name="og:description" content="">
    <meta name="og:image" content="">
    <!--<meta name="keywords" content="<? /*include ($_SERVER['DOCUMENT_ROOT'].'/tagsFile.txt'); */?>" />  -->

    <link rel="shortcut icon" href="/favicon.ico"/>
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
    <meta name="robots" content="index, follow"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- <meta http-equiv="Pragma" content="cache" />-->
    <meta http-equiv="Expires" content="-1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <?
    if (!$_SESSION['isTablet'] && !$_SESSION['isMobile'])
    {
        $browser = new Browser();
        if ($browser->getBrowser() == Browser::BROWSER_IE)
        {
            $bVersion = $browser->getVersion();
            $bv       = (int)$bVersion;
            switch ($bv)
            {
                case 7 : print '<meta http-equiv="X-UA-Compatible" content="IE=7" />'; break;
                case 8 : print '<meta http-equiv="X-UA-Compatible" content="IE=8" />'; break;
                default: print '<meta http-equiv="X-UA-Compatible" content="IE=EDGE, chrome=1" />'; break;
            }
        }
    }
    ?>
    <!--APPLE TOUCH ICONS-->
    <link rel="apple-touch-icon" href="/images/icons/apple-touch-icon-16x16.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/icons/apple-touch-icon-114x114.png">


    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="/assets/jqueryui/jquery-ui-1.9.1.custom.min.css"/>
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="/assets/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="/assets/bootstrap/css/bootstrap-responsive.css"/>
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="/css/fonts.css"/>
    <link rel="stylesheet" type="text/css" charset="utf-8" media="all" href="/css/login/overwrite.css"/>
    <link rel="stylesheet" type="text/css" charset="utf-8" media="all" href="/css/login/style.css"/>
    <link rel="stylesheet" type="text/css" charset="utf-8" media="all" href="/css/login/default.css"/>
    <?
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/_jqueryLoad.php');
    //require_once ($_SERVER['DOCUMENT_ROOT'] . '/_bootstrapLoad.php');
    ?>
    <!-- HTML5 Shiv + detect touch events -->
    <script src="/js/modernizr.custom.js" style=""></script>


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

</head>

<body class="guest<? if (isset($errorArray) && !empty($errorArray))
{
    echo " error";
} ?>">
<?php
if (!$_SESSION['isTablet'] && !$_SESSION['isMobile'])
{
    if ($browser->getBrowser() == Browser::BROWSER_IE)
    {
        $bVersion = $browser->getVersion();
        if ($bVersion < 9)
            echo '<div class="alert" style="color:black"><!--<button type="button" class="close" data-dismiss="alert">×</button>--><strong>Please note that SKILLBI supports Internet Explorer versions 7 or 8 in minimal level.</strong><br>We recommend upgrading to Internet Explorer 9, or use of following Google Chrome, or Firefox to reach best user experience and full functionality</div><div class="clearfix"></div>';
    }
}
?>
<noscript>Engedélyezd a javascriptet</noscript>
<div id="wrapper">
<?
//error messages
if (isset($errorArray) && !empty($errorArray)) {
    echo'<div class="container">';
        echo '<div class="row">';
            echo '<div class="span6 error" style="width:auto;margin: 30px 0 0 30px;"><div class="alert alert-' . $errorArray['type'] . '" style="padding: 5px 5px 5px 10px;">';
                foreach ($errorArray['messages'] as $error) {
                    echo '<p style="margin:5px;">' . $error . '</p>';
                }
            echo '</div></div>';
    /*
    if ($errorArray['type'] == 'error' or $errorArray['type'] == 'warning') {
        echo '<div class="span12" style="margin: 30px 0 0 30px;">
          <p class="pull-left">Térjen vissza a bejelentkező oldalra</p>
          <div class="clearfix"></div>
          <p class="pull-left"><a href="/logout" >Vissza</p>';
        echo '</div>';
        exit;
    }
    */
    echo '</div></div>';
    echo '<div class="clearfix"></div>';
}
?>
<header>
    <div class="container">
        

        <div class="row" style="margin-top:30px;">
            <div class="span4">
                <a href="/">
                    <div class="logo">
                        <div class="pull-left "><h1><i class="fa fa-graduation-cap"></i> HASCAMPUS</h1></div>
                    </div>
                </a>
            </div>
            <div class="span8">

            </div>
        </div>
    </div>
</header>

<!-- end #content -->
<?
if (isset($_GET['pageName']) && $_GET['pageName'] != '')
{ //&& isset($_GET['type']) && $_GET['type'] !='' && isset($_GET['subpage']) && $_GET['subpage'] !='') {
    $page    = $_GET['pageName'];
    $type    = $_GET['type'];
    $subpage = $_GET['subpage'];


    switch ($page)
    {
        case 'index.html'       :
            $filename = ($_SERVER['DOCUMENT_ROOT'] . '/pages/index.html');
            break;
        case 'about.html'       :
            $filename = ($_SERVER['DOCUMENT_ROOT'] . '/pages/about.html');
            break;
        case 'free.html'        :
            $filename = ($_SERVER['DOCUMENT_ROOT'] . '/pages/free.html');
            break;
        case 'method.html'      :
            $filename = ($_SERVER['DOCUMENT_ROOT'] . '/pages/method.html');
            break;
        case 'price.html'       :
            $filename = ($_SERVER['DOCUMENT_ROOT'] . '/pages/price.html');
            break;
        case 'blog.html'        :
            $filename = ($_SERVER['DOCUMENT_ROOT'] . '/pages/blog.html');
            break;
        case 'contact.html'     :
            $filename = ($_SERVER['DOCUMENT_ROOT'] . '/pages/contact.html');
            break;
        case 'search.html'      :
            $filename = ($_SERVER['DOCUMENT_ROOT'] . '/pages/search.html');
            break;
        case 'terms.html'      :
            $filename = ($_SERVER['DOCUMENT_ROOT'] . '/pages/terms.html');
            break;
        case 'privacy.html'      :
            $filename = ($_SERVER['DOCUMENT_ROOT'] . '/pages/privacy.html');
            break;
        //default : include ('404.php'); break;
    }
    if (file_exists($filename))
    {
        include $filename;
    } else
    {
        include ($_SERVER['DOCUMENT_ROOT'] . '/errordocuments/404.php');
        //echo 'ilyen oldal nincs'; //include ('404.php');
    }
} else
{
    //echo 'ez a foldal';
    $filename = ($_SERVER['DOCUMENT_ROOT'] . '/pages/index.html');
    include $filename;
    //echo $request[1];
}

?>


    <footer class="navbar-fixed-bottom">

        <div id="sub-footer">
            <div class="container">
                <div class="row">
                    <div class="span6">
                        <div class="copyright">
                            <p><span>HASCAMPUS.COM © 2013 -  <? echo date("Y");?> All right reserved. </span></p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </footer>

</div>


<script src="/assets/bootstrap/bootstrap.js"></script>
<script src="/js/jquery.touchSwipe.min.js"></script>
<script src="/js/login.js"></script>

<a href="#" class="scrollup" style="display: none;"><i class="icon-chevron-up icon-square icon-32 active"></i></a>

</body>
</html>
