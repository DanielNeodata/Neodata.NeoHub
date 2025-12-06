<?php 
   $language_file=str_replace("-","_",$language);
?>
<head>
	<meta charset="utf-8">
	<title><?php echo $title_page;?></title>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Language" content="<?php echo $language;?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <meta http-equiv="Content-Security-Policy" content="
          base-uri 'self';
          form-action 'self';
          default-src * 'self';
          worker-src * 'self';
          script-src * 'self' 'unsafe-inline';
          connect-src * 'self' 'unsafe-inline';
          media-src * 'self';
          object-src * 'self';
          font-src * 'self';
          img-src * data: content: blob: 'self' 'unsafe-inline';
          style-src * 'self' 'unsafe-inline';
		  frame-ancestors 'none';
		  frame-src * 'self';"
		  />
	<meta property='og:type' content='website' />
	<meta property='og:title' content='Acceso directo' />
	<meta property='og:description' content='Grupo Neodata' />
	<meta property='og:image' content='/assets/img/logo.png'/>

    <link rel="icon" type="image/png" href="./assets/icons/favicon.ico"/>
    <link rel="apple-touch-icon" sizes="57x57" href="assets/icons/apple-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="60x60" href="assets/icons/apple-icon-60x60.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="assets/icons/apple-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/icons/apple-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="assets/icons/apple-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="assets/icons/apple-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="assets/icons/apple-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="assets/icons/apple-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/icons/apple-icon-180x180.png" />
    <link rel="apple-touch-icon-precomposed" sizes="190x190" href="assets/icons/apple-icon-precomposed.png" />
    <link rel="icon" sizes="16x16" href="assets/icons/favicon-16x16.png" />
    <link rel="icon" sizes="32x32" href="assets/icons/favicon-32x32.png" />
    <link rel="icon" sizes="36x36" href="assets/icons/android-icon-36x36.png" />
    <link rel="icon" sizes="48x48" href="assets/icons/android-icon-48x48.png" />
    <link rel="icon" sizes="70x70" href="assets/icons/ms-icon-70x70.png" />
    <link rel="icon" sizes="72x72" href="assets/icons/android-icon-72x72.png" />
    <link rel="icon" sizes="96x96" href="assets/icons/android-icon-96x96.png" />
    <link rel="icon" sizes="144x144" href="assets/icons/android-icon-144x144.png" />
    <link rel="icon" sizes="150x150" href="assets/icons/ms-icon-150x150.png" />
    <link rel="icon" sizes="192x192" href="assets/icons/android-icon-192x192.png" />
    <link rel="icon" sizes="310x310" href="assets/icons/ms-icon-310x310.png" />

    <link rel="stylesheet" href="./assets/css/neotransac.css" />
    <link rel="stylesheet" href="./assets/css/material-icons.css" />
    <link rel="stylesheet" href="./assets/css/croppie.css" />
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap-select.css" />
    <link rel="stylesheet" href="./assets/bootstrap-material-design/css/bootstrap-material-design.css" />
    <link rel="stylesheet" href="./assets/js/trumbo/ui/trumbowyg.min.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script type="text/javascript" src="./assets/js/_third/jquery.min.js"></script>
    <script type="text/javascript" src="./assets/js/_third/popper.min.js"></script>
    <script type="text/javascript" src="./assets/js/_third/jszip.min.js"></script>
    <script type="text/javascript" src="./assets/js/_third/moment.min.js"></script>
    <script type="text/javascript" src="./assets/js/_third/moment-timezone.min.js"></script>
    <script type="text/javascript" src="./assets/js/_third/blockui.js"></script>
    <script type="text/javascript" src="./assets/js/_third/exif.js"></script>
    <script type="text/javascript" src="./assets/js/_third/smoothie.js"></script>
    <script type="text/javascript" src="./assets/js/_third/shorten.js"></script>
    <script type="text/javascript" src="./assets/js/_third/croppie.min.js"></script>
    <script type="text/javascript" src="./assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./assets/bootstrap/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="./assets/bootstrap-material-design/js/bootstrap-material-design.min.js"></script>
    <script type="text/javascript" src="./assets/js/trumbo/trumbowyg.min.js"></script>
    <script type="text/javascript" src="./assets/js/trumbo/langs/<?php echo $language_file;?>.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
