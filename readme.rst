###################
源码描述
###################

1. Comic_ci 是基于 CodeIgniter 3 开发的一款开源免费漫画管理网站。

2. Comic_ci 并不限制您是否商用此软件，源码完全开放。


*******************
我的开发环境
*******************

Apache/2.4.18 (Win32) PHP/5.6.20  Mysql 5.5.47

###################
安装说明
###################

1. 打开phpMyAdmin 在mysql数据库，新建数据库comic_ci

2. 将comic_ci.sql 导入 comic_ci

3. 打开 源码文件目录application/config/database.php 

修改数据库配置信息

'hostname' => 'mysql:host=localhost;dbname=comic_ci',	//修改为你的数据库地址

'username' => 'root',	//修改为你的数据库登陆用户名

'password' => 'root',	//修改为你的数据库登陆密码

'database' => 'comic_ci' //修改为你的数据库

4. 打开 源码文件目录application/config/config.php 
 
$config['base_url'] = 'http://localhost/comic_ci/';	//修改为你的站点的 url

$config['comic_base_url'] = 'http://localhost/comic_ci/uploads/comics/';	//修改为你的漫画图片的 url

$config['comic_base_dir'] = 'D:/soft design/WWW/comic_ci/uploads/comics/';	//修改为你的漫画图片上传的目录地址

$config['upload_base_url'] = 'http://localhost/comic_ci/uploads/tmps/';		//修改为你的文件上传保存的 url	

$config['upload_base_dir'] = 'D:/soft design/WWW/comic_ci/uploads/tmps/';	//修改为你的文件上传保存的目录地址

5. 后台登陆地址

后台管理员用户名admin；密码是:admin123。

http://你的站点的uri/index.php/admin/index

例如

http://localhost/comic_ci/index.php/admin/index