<?php
define ('DB_SERVER','localhost');
define ('DB_USER','root');
define ('DB_PASSWORD','');
define ('DB_NAME','yii_machine');
define ("ROOT_URL", $_SERVER['SERVER_NAME']);
//define ("TIMEIN", '8:00');
//define ("TIMEOUT", '5:30');
define ("IP", '192.168.3.202');
define ("ROOT_DIR", "D:/projects/atmarkcafe/download/salary");
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
