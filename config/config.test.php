<?php
define ('DB_SERVER','192.168.2.5');
define ('DB_USER','acvmngt');
define ('DB_PASSWORD','123456');
define ('DB_NAME','acv_management');
define ("ROOT_URL", '192.168.3.46/test');
//define ("TIMEIN", '8:00');
//define ("TIMEOUT", '5:30');
define ("IP", '192.168.3.202');
define("ROOT_DIR",$_SERVER['DOCUMENT_ROOT'].'/download/salary');
// USD ratio
//$url = 'http://vnexpress.net/block/crawler?arrKeys%5B%5D=thoi_tiet&arrKeys%5B%5D=gia_vang&arrKeys%5B%5D=ty_gia';
//$data = @file_get_contents($url);
//$data = json_decode($data,true);
//$file_headers = @get_headers($url);
//if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
define ("USD", '21,000');
//}
//else {
//    define ("USD", $data['ty_gia']['data'][1]['sell'] );
//}
