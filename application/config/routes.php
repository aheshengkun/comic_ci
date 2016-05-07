<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Comic/showComicList';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['index'] = 'Comic/showComicList';

$route['admin/index'] = 'admin/index/showIndex';

$route['admin/userlist'] = 'admin/User/showUserList';
$route['admin/userlist/(:num)'] = 'admin/User/showUserList/$1';
$route['admin/usercreate'] = 'admin/User/createUser';

$route['admin/comiclist'] = 'admin/Comic/showComicList';
$route['admin/createcomic'] = 'admin/Comic/createComic';
$route['admin/editcomic'] = 'admin/Comic/editComic';
$route['admin/updatecomic'] = 'admin/Comic/updateComic';

$route['admin/updatecomicnum'] = 'admin/ComicNum/updateComicNum';
$route['admin/editcomicnum'] = 'admin/ComicNum/editComicNum';
$route['admin/createcomicnum'] = 'admin/ComicNum/createComicNum';
$route['admin/comicnumlist'] = 'admin/ComicNum/showComicNumList';
$route['admin/sortcomicnum'] = 'admin/ComicNum/sortComicNum';

$route['admin/comicpage'] = 'admin/ComicPage/showComicPage';
$route['admin/comicpageupload'] = 'admin/ComicPage/doUpload';
$route['admin/createcomicpage'] = 'admin/ComicPage/createComicPage';

$route['admin/comicdir'] = 'admin/ComicDir/showComicDir';
$route['admin/editcomicdir'] = 'admin/ComicDir/eidtComicDir';
$route['admin/updatecomicdir'] = 'admin/ComicDir/updateComicDir';

$route['admin/comictypelist'] = 'admin/ComicType/showTypeList';
$route['admin/comictypecreate'] = 'admin/ComicType/createType';
$route['admin/comictypedelete'] = 'admin/ComicType/deleteType';
$route['admin/sortcomictype'] = 'admin/ComicType/sortComicType';

$route['page'] = 'Page/ShowPage';

$route['loginback'] = 'admin/User/showLogin';
$route['admin/loginout'] = 'admin/User/loginOut';
$route['check/loginback'] = 'admin/User/checkLogin' ;
$route['get/captcha'] = 'admin/User/jsonCreateCaptcha';

$route['admin/upload'] = 'upload/upload/doUpload';
