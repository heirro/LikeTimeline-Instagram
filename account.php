<?php
set_time_limit(0);
ignore_user_abort(1);
$usernameig = $_GET['id'];
$passwordig = $_GET['pw'];
    function proccess($ighost, $useragent, $url, $cookie = 0, $data = 0, $httpheader = array(), $proxy = 0){
    $url = $ighost ? 'https://i.instagram.com/api/v1/' . $url : $url;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    if($proxy):
      curl_setopt($ch, CURLOPT_PROXY, $proxy);
    endif;
    if($httpheader) curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    if($cookie) curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    if ($data):
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    endif;
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch);
    if(!$httpcode) return false; else{
      $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
      $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
      curl_close($ch);
      return array($header, $body);
    }
  }
 
 
function SendRequest($url, $post, $post_data, $user_agent, $cookies) {
    $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://instagram.com/api/v1/'.$url);
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Language: id'));
 
  if($post) {
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  }
   
  if($cookies) {
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'likefeed.txt');
  } else {
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'likefeed.txt');
  }
   
  $response = curl_exec($ch);
  $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
   
  return array($http, $response);
}
 
function GenerateGuid() {
  return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      mt_rand(0, 65535),
      mt_rand(0, 65535),
      mt_rand(0, 65535),
      mt_rand(16384, 20479),
      mt_rand(32768, 49151),
      mt_rand(0, 65535),
      mt_rand(0, 65535),
      mt_rand(0, 65535));
}
 
  function generate_useragent($sign_version = '6.22.0'){
    $resolusi = array('1080x1776','1080x1920','720x1280', '320x480', '480x800', '1024x768', '1280x720', '768x1024', '480x320');
    $versi = array('GT-N7000', 'SM-N9000', 'GT-I9220', 'GT-I9100');   $dpi = array('120', '160', '320', '240');
    $ver = $versi[array_rand($versi)];
    return 'Instagram '.$sign_version.' Android ('.mt_rand(10,11).'/'.mt_rand(1,3).'.'.mt_rand(3,5).'.'.mt_rand(0,5).'; '.$dpi[array_rand($dpi)].'; '.$resolusi[array_rand($resolusi)].'; samsung; '.$ver.'; '.$ver.'; smdkc210; en_US)';
  }
 
function GenerateSignature($data) {
     return hash_hmac('sha256', $data, '55e91155636eaa89ba5ed619eb4645a4daf1103f2161dbfe6fd94d5ea7716095');
}
 
function GetPostData_profil($filename) {
  if(!$filename) {
    echo "The image doesn't exist ".$filename;
  } else {
    $post_data = array('profile_pic' => '@'.$filename);
    return $post_data;
  }
}
 
function GetPostData($filename) {
  if(!$filename) {
    echo "The image doesn't exist ".$filename;
  } else {
    $post_data = array('device_timestamp' => time(),
              'photo' => '@'.$filename);
    return $post_data;
  }
}
function hook($data) {
    return 'ig_sig_key_version=4&signed_body=' . hash_hmac('sha256', $data, '469862b7e45f078550a0db3687f51ef03005573121a3a7e8d7f43eddb3584a36') . '.' . urlencode($data);
  }
  function generate_device_id(){
    return 'android-' . md5(rand(1000, 9999)).rand(2, 9);
  }
  function generate_guid($tipe = 0){
    $guid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    mt_rand(0, 65535),
    mt_rand(0, 65535),
    mt_rand(0, 65535),
    mt_rand(16384, 20479),
    mt_rand(32768, 49151),
    mt_rand(0, 65535),
    mt_rand(0, 65535),
    mt_rand(0, 65535));
    return $tipe ? $guid : str_replace('-', '', $guid);
  }
$myObj2->status = "failed";
$myObj2->messages = "check your username & password";
$myJSON2 = json_encode($myObj2);
$guid = GenerateGuid();
$device_id = "android-".$guid;
    $ua = generate_useragent();
        $devid = generate_device_id();
        $login = proccess(1, $ua, 'accounts/login/', 0, hook('{"device_id":"'.$devid.'","guid":"'.generate_guid().'","username":"'.$usernameig.'","password":"'.$passwordig.'","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}'));
        $data = json_decode($login[1]);
        if($data->status != 'ok')
            echo '<html><head><title>Auto Like Instagram Beranda v2.1</title></head><body><pre>' .$myJSON2.'</pre>';
        else{
            preg_match_all('%Set-Cookie: (.*?);%',$login[0],$d);$cookie = '';
            for($o=0;$o<count($d[0]);$o++)$cookie.=$d[1][$o].";";
            $_SESSION['data'] = array('cookies' => $cookie, 'useragent' => $ua, 'device_id' => $devid, 'username' => $data->logged_in_user->username, 'id' => $data->logged_in_user->pk);
$ui = $_SESSION['data'];
$rank_token = $ui['id'].'_'.$guid ;
$isi_komen = $_POST['komen'];
$req = proccess(1, $ui['useragent'], 'feed/timeline/?rank_token='.$rank_token.'&ranked_content=true&max_id=0', $ui['cookies']);
$req = json_decode($req[1]);
foreach ($req->items as $items) {
    $mau_ngelike = $items->has_liked;
    $ID = $items->id;
    if($mau_ngelike != '1') {
        $user = " @". $items->user->username;
        $like = proccess(1, $ui['useragent'], 'media/'.$ID.'/like/', $ui['cookies'], hook('{"media_id":"'.$ID.'"}'));
             sleep(2);
$myObj->status = "sukses";
$myObj->name = $user;
$myObj->foto = $ID;
$myJSON = json_encode($myObj);
echo '<pre>'.$myJSON.'</pre></body></html>';
}
    flush();
    ob_flush();
}
}
    ?>