<?php
include 'conf.php';
include 'php/functions.inc.php';
$result = array(); 
if(isset($_FILES['upload'])){
	$docFile = $_FILES['upload'];
	if(RoxyFile::IsImage($docFile['name'])) {
		$filename = RoxyFile::MakeUniqueFilename(fixPath(FILES_ROOT), $docFile['name']);
		$filePath = fixPath(FILES_ROOT).'/'.$filename;
		if(move_uploaded_file($docFile['tmp_name'], $filePath)){
			$result = array('uploaded'=>1,'fileName'=>$filename,'url'=>RETURN_URL_PREFIX.'/'.FILES_ROOT.'/'.$filename);
		} else {
			$result = array('uploaded'=>0,'error'=>array('message'=>'File Not Upload,Please try again!'));
		}                    
	} else {
		$result = array('uploaded'=>0,'error'=>array('message'=>'Invalid File Type!'));
	}
} else {
	$result = array('uploaded'=>0,'error'=>array('message'=>'File Not Found!'));
}
$action = (isset($_GET['action'])) ? $_GET['action'] : '';
if($action == 'QuickUpload'){
	$callFunc = $_GET['CKEditorFuncNum'];
	$url = ($result['uploaded'])? $result['url'] : '';
	$msg = (!$result['uploaded'])? $result['error']['message'] : '';
	echo '<script type="text/javascript">
			window.parent.CKEDITOR.tools.callFunction("'.$callFunc.'", '.json_encode($url).', '.json_encode($msg).');
		</script>';
} else {
	echo json_encode($result);exit;
}
?>