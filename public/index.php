<?PHP

/* written by Jan M.
   to send Jabber Msgs from Scripts
   test/usr it with: curl -F "msg=test" http://php-notify.local/room/admins
*/

/* Defauls override in ../config/config.php */
$debug      = false;
$debug_user = "alice";
$server     = "jabber.local";
$botname    = "MyBot";
$restrict   = array("10.0.", "172.16.", "192.168.");

$config_dir = $_SERVER["DOCUMENT_ROOT"]."/../config";
$allow = false;

if (file_exists($config_dir.'/config.php'))
  require_once($config_dir.'/config.php');

if ($_REQUEST['msg'] == "")
  exit;

foreach ($restrict as $ip) {
  if (strstr($_SERVER['REMOTE_ADDR'], $ip))
    $allow = true;
}

if ($allow == false)
  die ("Not allowed");

$base = "sendxmpp -r $botname -f ".$config_dir."/xmpp.conf";

$uri=$_SERVER['REQUEST_URI'];
$path=explode('/', trim($uri, '/'));

$type = $path[0];
$res = $path[1];
switch($type) {
 case "user": $cmd = "$res@$server "; break;
 case "room": $cmd = "--chatroom $res@conference.$server"; break;
 default: die("Route not found");
}

system("echo \"".addslashes($_REQUEST['msg'])."\"|$base $cmd", $return);
echo "ok";

if ($debug == true) {
  $date=date(DATE_RFC822);
  /* Send command in backround , we don't want to block the client */
  system("echo \"[".$date."] ".addslashes($_SERVER["REMOTE_ADDR"]." sent: \"".$_REQUEST['msg']."\" to: ".$type."->".$res )."\"|$base $debug_user@$server &", $return);
}

?>
