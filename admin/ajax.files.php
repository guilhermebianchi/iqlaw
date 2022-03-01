<?php
include '../core.php';
include '../config.php';
session_start();

header('Content-Type: application/json');

function sanitize($string, $force_lowercase = true, $anal = true) {
	$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
				   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
				   "â€”", "â€“", ",", "<", ".", ">", "/", "?");
	$clean = trim(str_replace($strip, "", strip_tags($string)));
	$clean = preg_replace('/\s+/', "-", $clean);
	$clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
	return ($force_lowercase) ?
		(function_exists('mb_strtolower')) ?
			mb_strtolower($clean, 'UTF-8') :
			strtolower($clean) :
		$clean;
}

$accepted_formats = array(
	// Image formats
	'jpg|jpeg|jpe' => 'image/jpeg',
	'gif' => 'image/gif',
	'png' => 'image/png',
	'bmp' => 'image/bmp',
	'tif|tiff' => 'image/tiff',
	'ico' => 'image/x-icon',
	// Video formats
	'asf|asx|wax|wmv|wmx' => 'video/asf',
	'avi' => 'video/avi',
	'divx' => 'video/divx',
	'flv' => 'video/x-flv',
	'mov|qt' => 'video/quicktime',
	'mpeg|mpg|mpe' => 'video/mpeg',
	'mp4|m4v' => 'video/mp4',
	'ogv' => 'video/ogg',
	'mkv' => 'video/x-matroska',
	// Text formats
	'txt|asc|c|cc|h' => 'text/plain',
	'csv' => 'text/csv',
	'tsv' => 'text/tab-separated-values',
	'ics' => 'text/calendar',
	'rtx' => 'text/richtext',
	'css' => 'text/css',
	'htm|html' => 'text/html',
	// Audio formats
	'mp3|m4a|m4b' => 'audio/mpeg',
	'ra|ram' => 'audio/x-realaudio',
	'wav' => 'audio/wav',
	'ogg|oga' => 'audio/ogg',
	'mid|midi' => 'audio/midi',
	'wma' => 'audio/wma',
	'mka' => 'audio/x-matroska',
	// Misc application formats
	'rtf' => 'application/rtf',
	'js' => 'application/javascript',
	'pdf' => 'application/pdf',
	'swf' => 'application/x-shockwave-flash',
	'class' => 'application/java',
	'tar' => 'application/x-tar',
	'zip' => 'application/zip',
	'gz|gzip' => 'application/x-gzip',
	'rar' => 'application/rar',
	'7z' => 'application/x-7z-compressed',
	// MS Office formats
	'doc' => 'application/msword',
	'pot|pps|ppt' => 'application/vnd.ms-powerpoint',
	'wri' => 'application/vnd.ms-write',
	'xla|xls|xlt|xlw' => 'application/vnd.ms-excel',
	'mdb' => 'application/vnd.ms-access',
	'mpp' => 'application/vnd.ms-project',
	'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
	'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
	'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
	'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
	'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
	'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
	'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
	'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
	'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
	'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
	'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
	'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
	'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
	'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
	'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
	'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
	'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
	'sldm' => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
	'onetoc|onetoc2|onetmp|onepkg' => 'application/onenote',
	// OpenOffice formats
	'odt' => 'application/vnd.oasis.opendocument.text',
	'odp' => 'application/vnd.oasis.opendocument.presentation',
	'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
	'odg' => 'application/vnd.oasis.opendocument.graphics',
	'odc' => 'application/vnd.oasis.opendocument.chart',
	'odb' => 'application/vnd.oasis.opendocument.database',
	'odf' => 'application/vnd.oasis.opendocument.formula',
	// WordPerfect formats
	'wp|wpd' => 'application/wordperfect',
);

function is_dir_empty($dir) {
  if (!is_readable($dir)) return NULL; 
  return (count(scandir($dir)) == 2);
}

$json = array();

if (!isset($_SESSION['login'])) {
	
} else {
	$base_dir = '../upload';
	
	switch ($_GET['action']) {
		case 'create-dir':
			$path = str_replace('..', '', $_POST['path']);
			$name = $_POST['name'];
			
			if (is_dir($base_dir.'/'.$path)) {
				$i = 0;
				
				while (is_dir($base_dir.'/'.$path.'/'.$name)) {
					$name = str_replace(' ('.$i.')', '', $name);
					$i++;
					$name .= ' ('.$i.')';
				}
				
				mkdir($base_dir.'/'.$path.'/'.$name);
				$json['success'] = true;
			} else {
				$json['success'] = false;
			}
		break;
		
		
		
		
		case 'delete-dir':
			$path = str_replace('..', '', $_POST['path']);
			$files = $_POST['files'];
			
			foreach ($files as $file) {
				if (is_dir($base_dir.'/'.$path.'/'.$file) && is_dir_empty($base_dir.'/'.$path.'/'.$file)) {
					if (rmdir($base_dir.'/'.$path.'/'.$file)) {
						$json['success'] = true;
					} else {
						$json['error'] = true;
					}
				} else if (is_file($base_dir.'/'.$path.'/'.$file)) {
					unlink($base_dir.'/'.$path.'/'.$file);
					$json['success'] = true;
				}
			}
			
		break;
		
		
		
		
		case 'upload-file':
			$path = str_replace('..', '', $_POST['path']);
			
			$error = false;
			
			$files = array();
			foreach ($_FILES['files']['name'] as $key=>$value) {
				$files[$key]['name'] = $_FILES['files']['name'][$key];
				$files[$key]['type'] = $_FILES['files']['type'][$key];
				$files[$key]['tmp_name'] = $_FILES['files']['tmp_name'][$key];
				$files[$key]['error'] = $_FILES['files']['error'][$key];
				$files[$key]['size'] = $_FILES['files']['size'][$key];
			}

			foreach ($files as $file) {
				if ($file['error'] == 0) {
					if (in_array($file['type'], $accepted_formats)) {
						if ($file['size'] < 1000000) {
							if (is_dir($base_dir.'/'.$path)) {
								$name = explode('.', $file['name']);
								$ext = array_pop($name);
								$name = implode('', $name);
								$name = sanitize($name);
								$name = $name.'.'.$ext;
								$i = 0;
								while (is_file($base_dir.'/'.$path.'/'.$name)) {
									$name = explode('.', $name);
									$format = array_pop($name);
									$name = implode('.', $name);
									
									$name = str_replace(' ('.$i.')', '', $name);
									$i++;
									$name .= ' ('.$i.')';
									
									$name .= '.'.$format;
								}
								if (!move_uploaded_file($file['tmp_name'], $base_dir.'/'.$path.'/'.$name)) {
									$error = true;
									$json['error_message'] = "Ocorreu um erro ao salvar o arquivo.";
								}
							} else {
								$error = true;
								$json['error_message'] = "Diretório inválido.";
							}
						} else {
							$error = true;
							$json['error_message'] = "Tamanho do arquivo acima do permitido.";
						}
					} else {
						$error = true;
						$json['error_message'] = "Formato de arquivo não permitido.";
					}
				} else {
					$error = true;
					$json['error_message'] = $file['error'];
				}
			}
			
			if (!$error) {
				$json['success'] = true;
			} else {
				$json['success'] = false;
			}
		break;
	}
}

echo json_encode($json);