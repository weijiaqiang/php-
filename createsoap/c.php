<?php
 
$client = new SoapClient("http://127.0.0.1/createsoap/hello.wsdl");

// 如果不指定第一项，那么必须在options中执行location和uri
// where location is the URL of the SOAP server to send the request to,
// and uri is the target namespace of the SOAP service
$options['location'] = 'http://127.0.0.1:80/createsoap/s.php';
$options['uri'] = 'hi';
$options['soap_version'] = SOAP_1_2; // SOAP_1_1 default
$options['user_agent'] = 'WeiJiaQiang-WebKit'; // 设置user_agent
$options['trace'] = true; // 查看soap，http信息, 通过调用 __getLastRequest, __getLastRequestHeaders 等函数
$options['exceptions'] = true;
$options['connection_timeout'] = 30; 
$options['compression'] = SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP; // 对应的http 头部为 Accept-Encoding: gzip, deflate

$options['local_cert'] = 'ssl 私钥文件路径';
$options['passphrase'] = 'ssl 私钥文件密码,如果有';

// 更多的http,ssl层控制参数在 stream_context 写
$http_context_options['header'] = 'Cookie: foo=bar; name=wei%20jia%20qiang';

$ssl_context_options['verify_peer'] = false; // 不验证服务器证书
$ssl_context_options['verify_peer_name'] = false; // 不验证服务器名
$sll_context_options['allow_self_signed'] = true; // 允许自签名证书

$context_options['http'] = $http_context_options;
$context_options['ssl'] = $ssl_context_options;
$options['stream_context'] = stream_context_create( $context_options );


$client = new SoapClient(null, $options);


try {
	$result = $client->myfunc('789');
	var_dump($result);
} catch (SoapFault $f){
	echo "Error Message: {$f->getMessage()}";
}
