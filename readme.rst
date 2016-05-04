###################
说明
###################

这是基本 CodeIgniter 3 开发的一套漫画管理网站。

*******************
我的开发环境
*******************

Apache/2.4.18 (Win32) PHP/5.6.20

###################
安装说明
###################

1. 打开phpMyAdmin 在mysql数据库，新建数据库comic_ci
2. 将comic_ci.sql 导入 comic_ci
3. 打开 源码文件目录application\config\database.php 
修改数据库配置信息
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'mysql:host=localhost;dbname=comic_ci',	//修改为你的数据库地址
	'username' => 'root',	//修改为你的数据库登陆用户名
	'password' => 'root',	//修改为你的数据库登陆密码
	'database' => 'comic_ci',
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
4. 打开 源码文件目录application\config\config.php 
 
$config['base_url'] = 'http://localhost/comic_ci/';	//修改为你的站点的 url

$config['comic_base_url'] = 'http://localhost/comic_ci/uploads/comics/';	//修改为你的漫画图片的 url
$config['comic_base_dir'] = 'D:/soft design/WWW/comic_ci/uploads/comics/';	//修改为你的漫画图片上传的目录地址
$config['upload_base_url'] = 'http://localhost/comic_ci/uploads/tmps/';		//修改为你的文件上传保存的 url	
$config['upload_base_dir'] = 'D:/soft design/WWW/comic_ci/uploads/tmps/';	//修改为你的文件上传保存的目录地址