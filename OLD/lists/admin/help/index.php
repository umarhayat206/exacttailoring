<?php
ob_start();
error_reporting(0);
if (!empty($_SERVER["ConfigFile"]) && is_file($_SERVER["ConfigFile"])) {
#  print '<!-- using '.$_SERVER["ConfigFile"].'-->'."\n";
  include $_SERVER["ConfigFile"];
} elseif (is_file("../../config/config.php")) {
#  print '<!-- using ../../config/config.php-->'."\n";
  include "../../config/config.php";
} else {
  print "Error, cannot find config file\n";
  exit;
}
$now =  gettimeofday();
$GLOBALS["pagestats"] = array();
$GLOBALS["pagestats"]["time_start"] = $now["sec"] * 1000000 + $now["usec"];
$GLOBALS["pagestats"]["number_of_queries"] = 0;
if (!isset($systemroot)) {
  $systemroot = dirname(__FILE__).'/..';
}
require_once $systemroot.'/init.php';
require_once $systemroot.'/'.$GLOBALS["database_module"];
require_once $systemroot."/../texts/english.inc";
include_once $systemroot."/../texts/".$GLOBALS["language_module"];
require_once $systemroot."/defaultconfig.inc";
require_once $systemroot.'/connect.php';
include_once $systemroot."/languages.php";
require_once $systemroot."/commonlib/lib/interfacelib.php";
include_once $systemroot."ui/".$GLOBALS['ui']."/pagetop.php";
# record the start time(usec) of script

if (!isset($_GET["topic"]))
  $topic = "home";
else
  $topic = $_GET["topic"];

preg_match("/([\w_]+)/",$topic,$regs);
$topic = $regs[1];
$include = '';
$topic = basename($topic);
if ($topic) {
  if (is_file($_SESSION['adminlanguage']['iso'].'/'.$topic.".php")) {
    $include = $_SESSION['adminlanguage']['iso'].'/'.$topic . ".php";
  }
}

?>
<title><?php echo $GLOBALS['I18N']->get('help')?></title>
<link rel="stylesheet" type="text/css" href="./ui/<?php echo $GLOBALS['ui']?>/styles/styles_help.css"></head>
<body>
<!-- content -->
<?php
print "<h3>phplist Help: $topic</h3>";
if ($include) {
  include $include;
} else {
  print $GLOBALS['I18N']->get('nohelpavailable')." ".'<i>'.$topic.'</i>';
}

ob_end_flush();

print '<hr /></body></html>';

