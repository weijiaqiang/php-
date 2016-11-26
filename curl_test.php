<?php
/*
 * 以下配置都是针对http 协议进行的测试
 */
$ch = curl_init( );  

/*
 * 设置访问url curlopt_url 
 */
curl_setopt( $ch, CURLOPT_URL, "http://max.inrice.cn" );
/*
 * 如果需要获取到http response 头部，那么需要设置 CURLOPT_HEADER 为 true
 * curl_setopt( $ch, CURLOPT_HEADER, true );  
 */

/*
 * 需要curl_exec 函数返回执行结果，而不是输出到STDOUT, CURLOPT_RETURNTRANSFER 为 true
 * curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 */
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );  

/*
 * 当需要通过post 方式上传文件，有两种方法
 * 1  需要将 CURLOPT_SAFE_UPLOAD 设置为 false * 因为这个选项默认设置为 true， 因此在php版本大于 5.5.0 时，默认不能通过 @ 方式上传文件
 * 2 使用CURLFile 类来实现文件上传
 * cul_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
 */
curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);

/*
 * 继续请求重定向url
 * curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 * 这样设置之后curl会根据http response的结果，可能无限次的重定向下去，
 * 如果限制重定向次数，设置 CURLOPT_MAXREDIRS,
 * curl_setopt($ch, CURLOPT_MAXREDIS, 10); 这里限制最多重定向10次
 *
 */
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

/*
 * 自动加上 referer http 头部, 当服务器返回重定向时，curl库会请求重定向url带上referer 头部
 * curl_setopt($ch, CURLOPT_AUTOREFERER, true);
 */
curl_setopt($ch, CURLOPT_AUTOREFERER, true);

/*
 * 默认使用 GET 来发送请求的，如果需要使用 POST, 设置 CURLOPT_POST 为true
 * curl_setopt($ch, CURLOPT_POST, true);
 * 默认的Content-Type: application/x-www-form-urlencoded
 */
curl_setopt($ch, CURLOPT_POST, true);
/*
 * 设置POST 参数，CURLOPT_POSTFIELDS, 这个参数的值有：
 * 1 经过urlencode 编码后的拼接字符串
 * 2 key-value 数组
 */
//$userinfo = http_build_query(array(
$userinfo = array(
	'username' => 'admin',
	'password' => 'aaaaaa',
	'verify' => 'urb6',
	'buffer' => new CURLFile('/home/www/ttt.txt'),
);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $userinfo );

/*
 * 设置连接超时 CURLOPT_CONNECTTIMOUT, 单位为秒, 但连接超时，curl可能会产生信号
 * 因此要忽略这个信号
 */
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_NOSIGNAL, true);

/*
 * ssl 相关
 *  不验证服务器的证书, 将 CURLOPT_SSL_VERIFYPEER 设置为 false, CURLOPT_SSL_VERIFYHOST 设置为 false
 */
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
/*
 * ssl 相关
 *	向服务器提供证书,证书上面有实体的公钥, 因此需要告诉curl 证书的路径
 *	1 证书的类型 CURLOPT_SSLCERTTYPE, 默认为 PERM，另外还有 DER ENG
 *	curl_setopt($ch, CURLOPT_SSLCERTTYPE, "PEM");
 *	2 证书的路径 CURLOPT_SSLCERT
 *	curl_setopt($ch, CURLOPT_SSLCERT, 'path-to-cert');
 *	3 如果本地打开证书文件需要密码，告诉curl密码, CURLOPT_SSLCERTPASSWD
 *	curl_setopt($ch, CURLOPT_SSLCERTPASSWD, 'passwdhere');
 *
 *
 * 上面说道实体的公钥是方式在证书中的，curl在和服务器进行ssl时，肯定会用到私钥文件，因此需要设置私钥信息
 * 1 私钥文件的类型 (和上面证书文件的类型是一样的) CURLOPT_SSLKEYTYPE
 * curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
 * 2 私钥文件的路径 CURLOPT_SSLKEY
 * curl_setopt($ch, CURLOPT_SSLKEY, 'path-to-private-key-file');
 * 3 打开私钥文件需要的密码，私钥是一个非常非常非常重要的文件，需要安全保存，因此一般情况下都会需要
 * 使用密码来打开 CURLOPT_SSLKEYPASSWD
 * curl_setopt($ch, CURLOPT_SSLKEYPASSWD, 'private-passwd');
 */



/*
 * 设置user_agent, CURLOPT_USERAGENT,也可以在设置http 头部进行 user_agent的设置
 * curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36');
 *
 */
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36');

/*
 * 设置http 头部
 * CURLOPT_HTTPHEADER , 头部数组，value是一个完整的头部，例如: array('Content-Type: application/json', 'Content-Length: 100');
 * curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: 100'));
 *
 */

$http_headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36';
//$http_headers[] = 'Cookie: InRiceWeixin_homethink_language=zh-CN; PHPSESSID=qgi226c7iiq3kg1gvssd3hh3n2'; 
//$http_headers[] = 'Content-Type: application/json; charset=utf-8';
//$http_headers[] = 'Content-Length: 100';
curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);

/*
 * Cookie 相关
 *	1 保存cookie到指定文件，CURLOPT_COOKIEJAR, 
 *		curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookie.log');
 *	2 从指定文件加载cookie，CURLOPT_COOKIEFILE
 *		curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookie.log');
 *	3 指定cookie， CURLOPT_COOKIE, cookie之间必须要使用 分号空格 隔开
 *		curl_setopt($ch, CURLOPT_COOKIE, 'AppId=123; PHPSESSION=xxxx;');
 *
 *	4 启用新的session cookie, 就是启用新的回话cookie，CURLOPT_COOKIESESSION 设置为true
 *		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
 */

/*
 * 如果需要在 curl_close 之前的所有http 请求都自动带上能带上的cookie值，必须要下面这两个设置选项
 */
curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookie.log');
curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookie.log');

/*
 * 当通过curl_init 重新启动一个新的回话cookie时，需要加入下个选项
 */
curl_setopt($ch, CURLOPT_COOKIESESSION, true);

$contents = curl_exec( $ch );  
if ($contents === false) {
	die("请求失败");	
}
curl_close( $ch ); 
