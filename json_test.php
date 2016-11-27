<?php

$param2 ['access_token'] = 'Sd8fFws2TzX89tcHOlCr90yjMzAj5D05x09BfFaY6TvECzh71PZGaUlZvLAdfCQpBlSKF6z6oQfj785xI3GwXMSttml9BqIPGC7oKCRkE0LkWTkCssslIxEMotV7IbsXEGHdABAACD';
$param2 ['openid'] = 'oXAkUuJ5uQkkKUMIiaGOPqzY_vlU';
$param2 ['lang'] = 'zh_CN';

$url = 'https://api.weixin.qq.com/cgi-bin/user/info?' . http_build_query ( $param2 );
$content = file_get_contents ( $url );
file_put_contents('/tmp/log.log', $content);

$content = preg_replace('/[\x00-\x1F]/','', $content); // 当 json_last_error() 返回  JSON_ERROR_CTRL_CHAR 时，需要过滤掉控制字符

file_put_contents('/tmp/log.log.1', $content);
$tt = json_decode ( $content, true );
switch (json_last_error()) {
case JSON_ERROR_NONE:
	echo ' - No errors';
	break;
case JSON_ERROR_DEPTH:
	echo ' - Maximum stack depth exceeded';
	break;
case JSON_ERROR_STATE_MISMATCH:
	echo ' - Underflow or the modes mismatch';
	break;
case JSON_ERROR_CTRL_CHAR:
	echo ' - Unexpected control character found';
	break;
case JSON_ERROR_SYNTAX:
	echo ' - Syntax error, malformed JSON';
	break;
case JSON_ERROR_UTF8:
	echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
	break;
default:
	echo ' - Unknown error';
	break;
}

print_r($tt);
