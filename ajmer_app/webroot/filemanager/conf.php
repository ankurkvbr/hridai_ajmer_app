<?php
if(!session_id()){
    session_start();
}

if(!empty($_SERVER['HTTP_REFERER'])){
	parse_str(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY), $_get_array);
	if(!empty($_GET) && !empty($_get_array)){
		$_GET = array_merge($_GET, $_get_array);
	}
	$_SESSION['FM_$_GET'] = $_GET;
}

$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5)) == 'https'? 'https://' : 'http://' ;
$server = (isset($_SERVER['HTTP_X_FORWARDED_HOST']))?$_SERVER['HTTP_X_FORWARDED_HOST']:$_SERVER['HTTP_HOST'];
$site_url = $protocol.$server;
$upload_path = 'ajmerapp/webroot/img/';

$de_config = array();
$de_config["FILES_ROOT"] = $upload_path;
$de_config["RETURN_URL_PREFIX"] = $site_url;
$de_config["SESSION_PATH_KEY"] = "";
$de_config["THUMBS_VIEW_WIDTH"] = "140";
$de_config["THUMBS_VIEW_HEIGHT"] = "120";
$de_config["PREVIEW_THUMB_WIDTH"] = "100";
$de_config["PREVIEW_THUMB_HEIGHT"] = "100";
$de_config["MAX_IMAGE_WIDTH"] = "2000";
$de_config["MAX_IMAGE_HEIGHT"] =  "2000";
$de_config["INTEGRATION"] = "ckeditor";
$de_config["DIRLIST"] = "php/dirtree.php";
$de_config["CREATEDIR"] = "php/createdir.php";
$de_config["DELETEDIR"] = "php/deletedir.php";
$de_config["MOVEDIR"] = "php/movedir.php";
$de_config["COPYDIR"] = "php/copydir.php";
$de_config["RENAMEDIR"] = "php/renamedir.php";
$de_config["FILESLIST"] = "php/fileslist.php";
$de_config["UPLOAD"] =  "php/upload.php";
$de_config["DOWNLOAD"] =  "php/download.php";
$de_config["DOWNLOADDIR"] = "php/downloaddir.php";
$de_config["DELETEFILE"] =  "php/deletefile.php";
$de_config["MOVEFILE"] =  "php/movefile.php";
$de_config["COPYFILE"] =  "php/copyfile.php";
$de_config["RENAMEFILE"] =  "php/renamefile.php";
$de_config["GENERATETHUMB"] = "php/thumb.php";
$de_config["DEFAULTVIEW"] = "thumb";
$de_config["FORBIDDEN_UPLOADS"] = "zip js jsp jsb mhtml mht xhtml xht php phtml php3 php4 php5 phps shtml jhtml pl sh py cgi exe application gadget hta cpl msc jar vb jse ws wsf wsc wsh ps1 ps2 psc1 psc2 msh msh1 msh2 inf reg scf msp scr dll msi vbs bat com pif cmd vxd cpl htpasswd htaccess";
$de_config["ALLOWED_UPLOADS"] = "jpg jpeg png gif";
$de_config["FILEPERMISSIONS"] = "0777";
$de_config["DIRPERMISSIONS"] =  "0777";
$de_config["LANG"] =  "en";
$de_config["DATEFORMAT"] =  "dd/MM/yyyy HH:mm";
$de_config["OPEN_LAST_DIR"] = "yes";

if(!empty($_GET['get_type'])){
	header('Content-Type: application/json');
	echo json_encode($de_config,JSON_UNESCAPED_SLASHES);
	exit;
}

?>