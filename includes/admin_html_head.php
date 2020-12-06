<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <base href="<?= _URL_; ?>" />
    <meta name="description" content="<?= $siteDescription; ?>" />
    <meta name="keywords" content="<?= $siteKeywords; ?>" />
    <title><?= $siteBasicTitle; ?></title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />

    <?php /* <link rel="icon" href="<?=_URL_; ?>images/rel.gif" type="image/x-icon" /> */ ?>

    <link href="<?= _URL_; ?>styles/admin_style.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 8]>
<link href="<?= _URL_; ?>styles/admin_style_IE.css" rel="stylesheet" type="text/css" media="all" />
<![endif]-->

    <link href="<?= _URL_; ?>styles/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />

    <?php /* <script type="text/javascript" src="<?= _URL_; ?>js/jquery-1.4.1.js"></script> */ ?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript" src="<?= _URL_; ?>js/jquery-ui-1.8.24.custom.min.js"></script>
    <script type="text/javascript" src="<?= _URL_; ?>js/js.js"></script>
    <script type="text/javascript" src="<?= _URL_; ?>js/jquery.scrollTo-min.js"></script>
    <script type="text/javascript" src="<?= _URL_; ?>js/jquery.digits.js"></script>
    <script type="text/javascript" src="<?= _URL_; ?>tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>

    <!-- validate -->
    <script type="text/javascript" src="<?= _URL_; ?>js/jquery.validate.js"></script>
    <!-- prettyPhoto -->
    <script type="text/javascript" src="<?= _URL_; ?>js/jquery.prettyPhoto.js"></script>


    <?php /* <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> */ ?>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .tooltip {
            position: absolute;
            z-index: 1070;
            display: block;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-style: normal;
            font-weight: 400;
            line-height: 1.42857143;
            line-break: auto;
            text-align: left;
            text-align: start;
            text-decoration: none;
            text-shadow: none;
            text-transform: none;
            letter-spacing: normal;
            word-break: normal;
            word-spacing: normal;
            word-wrap: normal;
            white-space: normal;
            font-size: 12px;
            filter: alpha(opacity=0);
            opacity: 0;
        }

        .tooltip.in {
            filter: alpha(opacity=90);
            opacity: 0.9;
        }

        .tooltip.top {
            padding: 5px 0;
            margin-top: -3px;
        }

        .tooltip.right {
            padding: 0 5px;
            margin-left: 3px;
        }

        .tooltip.bottom {
            padding: 5px 0;
            margin-top: 3px;
        }

        .tooltip.left {
            padding: 0 5px;
            margin-left: -3px;
        }

        .tooltip.top .tooltip-arrow {
            bottom: 0;
            left: 50%;
            margin-left: -5px;
            border-width: 5px 5px 0;
            border-top-color: #000;
        }

        .tooltip.top-left .tooltip-arrow {
            right: 5px;
            bottom: 0;
            margin-bottom: -5px;
            border-width: 5px 5px 0;
            border-top-color: #000;
        }

        .tooltip.top-right .tooltip-arrow {
            bottom: 0;
            left: 5px;
            margin-bottom: -5px;
            border-width: 5px 5px 0;
            border-top-color: #000;
        }

        .tooltip.right .tooltip-arrow {
            top: 50%;
            left: 0;
            margin-top: -5px;
            border-width: 5px 5px 5px 0;
            border-right-color: #000;
        }

        .tooltip.left .tooltip-arrow {
            top: 50%;
            right: 0;
            margin-top: -5px;
            border-width: 5px 0 5px 5px;
            border-left-color: #000;
        }

        .tooltip.bottom .tooltip-arrow {
            top: 0;
            left: 50%;
            margin-left: -5px;
            border-width: 0 5px 5px;
            border-bottom-color: #000;
        }

        .tooltip.bottom-left .tooltip-arrow {
            top: 0;
            right: 5px;
            margin-top: -5px;
            border-width: 0 5px 5px;
            border-bottom-color: #000;
        }

        .tooltip.bottom-right .tooltip-arrow {
            top: 0;
            left: 5px;
            margin-top: -5px;
            border-width: 0 5px 5px;
            border-bottom-color: #000;
        }

        .tooltip-inner {
            max-width: 200px;
            padding: 3px 8px;
            color: #fff;
            text-align: center;
            background-color: #000;
            border-radius: 4px;
        }

        .tooltip-arrow {
            position: absolute;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid;
        }
    </style>
</head>