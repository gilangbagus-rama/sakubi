<?php

# Penjelasan dapat dibaca di ./documentation

// Delay script , 0.5 Seconds
usleep( 500 );

//  Include Koneksi Database
include "database/database_connection.php";

// Include routing halaman dan form
include "web/routes.php";


// Include Scroll Atas
view('scroll_atas');


// include function
// include "library/custom_function.php";
?>

<style>

	html { scroll-behavior: smooth; } 

	.nothing {
    	border: 0;
    	outline: none;
		
	}

	.wrap {
		white-space:normal !important;
		word-wrap: break-word; 
		min-width:155px;
		max-width:155px;
		/* max-width:150px; */
	}

	.no-access {
		cursor: not-allowed;
		pointer-events: none;
	}
</style>

<script>
	function cek_upload( $id_input_file , $maksimal_file ) {

															var file_upload = document.getElementById( $id_input_file );

															if ( file_upload.files[0].type != "application/pdf" ) {
																setTimeout(function () { 
																	swal({
																	title: 'Format File Salah',
																	text: 'File harus berupa *pdf',
																	icon: 'warning',
																	timer: 1500,
																	showConfirmButton: false,
																	});  
																},10);
																file_upload.value = "";
															exit;
															}

															if( file_upload.files[0].size > $maksimal_file*1024*1024 ){
																setTimeout(function () { 
																	swal({
																	title: 'File Terlalu Besar',
																	text: 'Maksimal ukuran file adalah' +$maksimal_file+ ' MB !',
																	icon: 'warning',
																	timer: 1500,
																	showConfirmButton: false,
																	});  
																},10);
																file_upload.value = "";
															exit;
															}

	};
</script>

<?php

// Flash SESSION['old'], SESSION['error'], SESSION['notifikasi'], SESSION['custom'] 
if ( !isset($_SESSION['no_flash'] ) || $_SESSION['no_flash'] === FALSE ) {
	reflash('old');
	reflash('error');
	reflash('notifikasi');
	reflash('custom');
}

// Custom Function
function back() {
	echo "<script> window.setTimeout(function(){ window.location.replace = history.go(-1); }, 10); </script>";
}



function console_log($output, $with_script_tags = true) {
	$js_code = "<script> console.log('hasil console = $output');</script>";
    echo $js_code;
}



function persiapan_upload ( $maks_upload ) {

	$maksimal_upload = $maks_upload * pow(1024, 2);

	foreach ($_FILES as $name => $value) {

		if ( $_FILES[$name] ['name'] == "" ) {
			error( $name , 'Wajib upload file !');
			$cek_form = false;
		}

		if ( $_FILES[$name] ['size'] > $maksimal_upload ){
			error( $name , 'Maksimal ukuran file ' .$maks_upload. ' MB !');
			$cek_form = false;
		}

	}

	if ( $cek_form === false ) {
		return false;
	} else {
		return true;
	}

}

function hapus_upload( $lokasi , $nama_file ){

	$lokasi_file = "./upload/" .$lokasi. "/" .$nama_file;

	if ( unlink( $lokasi_file ) === TRUE ) {
		return true;
	} else { 
		return false;
	}
}

function upload( $lokasi , $nama_input , $nama_file , $maksimal_upload ){

	$temp = $_FILES[ $nama_input ]['tmp_name'];

	if ( $nama_file == 'random' ) {
		// $name = rand(0,9999).$_FILES[$nama_input]['name'];
		$nama_file = escape( random_strings(15). ".pdf");
		$name = $nama_file;
	} else {
		$nama_file = preg_replace('/\s+/', '_', escape( $nama_file ) );
		$name = escape($nama_file. random_strings(10). ".pdf");
	}
	$size = $_FILES[ $nama_input ]['size'];
	$type = $_FILES[ $nama_input ]['type'];
	$folder = "./upload/" .$lokasi. "/";

	$maks_upload = $maksimal_upload* pow( 1024 , 2); // Maks 10 MB
	// dalam byte => satuan pengali dalam MB

	if ( !is_dir( $folder ) ) {
		mkdir( $folder, 0777, true );
	} else {
		chmod( $folder, 0777 );
	}


	if ( $size > $maks_upload ){
		error('file' , 'Maksimal ukuran file 10MB !');
		return false;
	}
	
	if ( $type != 'application/pdf' ) {
		error('file' , 'File harus berupa pdf !');
		return false;
	}

	success('file');
	if ( move_uploaded_file($temp, $folder . $name) === TRUE ) {
		success('file');
		return $name;
	} else { 
		error('file' , 'File gagal di upload !');
		return false;
	}
}


function csrf() {
	$token = $_SESSION['token'];
	echo '<input type="hidden" name="token" value="' .$token. '" />';
}

function input_hidden( $nama_input , $value_input ) {
	echo '<input type="hidden" name="'.$nama_input.'" value="'.$value_input.'" />';
}



function view ( $lokasi ) {

	if ( !is_file("./view/".$lokasi.".php") ) {
		return include "./view/exception/error_view.php";
	} else {
		return include "./view/" .$lokasi. ".php";
	}

}

function controller ( $nama_controller ) {

	if ( !is_file("./controller/" .$nama_controller. ".php") ) {
		return include "./view/exception/error_controller.php";
	} else {
		return include "./controller/" .$nama_controller. ".php";
	}
}


function cek_login ( ) {
	if ( $_SESSION['role'] != "" ) {
		header("location:javascript://history.go(-1)"); exit;
	}
}

function no_flash ( ) {
	return $_SESSION['no_flash'] = TRUE;
}

function flash_all ( ) {
	return $_SESSION['no_flash'] = FALSE;
}



function cek_token ( ) {

	if ( $_POST['token'] == "" || $_POST['token'] != $_SESSION['token'] ) {
	return false;
	} else {
	return true;
	}
}

function go_old($val) {
	return $_SESSION['old'] [$val] = $_SESSION['old'] [$val] ;
}

function old($val) {
	go_old($val);
	echo $_SESSION['old'] [$val];
}

function reflash($val) {
	return $_SESSION[$val] = [];
}


function show_error( $nama_val ) {
	echo $_SESSION ['error'] [$nama_val];
}

function show_notif( $nama_val ) {
	echo $_SESSION ['notifikasi'] [$nama_val];
}


function is_error( $nama_val ) {
	return isset( $_SESSION['error'] [$nama_val] );
}


function make_custom_notif ( $konteks, $error ) {
	$_SESSION ['custom'] [$konteks] = $error;
}

function make_error_notif ( $error ) {
	$_SESSION ['notifikasi'] ['error'] = $error;
}

function error ( $nama_val , $error ) {

	$_SESSION ['notifikasi'] [$nama_val] = $error;
	$_SESSION ['error'] [$nama_val] = 'is-invalid border-danger';

}

function success ( $nama_val ) {

	$_SESSION ['notifikasi'] [$nama_val] = '';
	$_SESSION ['error'] [$nama_val] = 'is-valid border-success';

}

function make_old( $nama_val , $val ) {

	return $_SESSION ['old'] [$nama_val] = $val;

}

function to_old ( ) {

	$_SESSION['old'] = [];  
	$_SESSION['error'] = [];

	foreach ( $_POST as $name => $value) {
		$_SESSION['old'] [$name] = $value;
	
		if ( $_POST[$name] == "" ) {
			error( $name , 'Tidak boleh kosong !');
			$cek_form = false;
		} else {
			success( $name );
		}
	}

	foreach ( $_FILES as $name => $value ) {
		if ( $_FILES[$name] ['name'] == "" ) {
			error( $name , 'Wajib upload file !');
			$cek_form = false;
		} else {
			success( $name );
		}
	}

	return $cek_form;
}

function random_strings ( $panjang_karakter ) {
	$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	return substr( str_shuffle($str_result), 
		0, $panjang_karakter);
}

function print_error_database ( $koneksi_db , $bool ) {
    if ( $bool === TRUE ) {

		$file = "./logs/error_database.txt";
		if ( !file_exists( $file ) ) {
			$myfile = fopen($file, "w");
		}

		$current = file_get_contents( $file );
		$current .= "Timestamp : " .date("D, d - M - Y | H:i:s"). " \n" . "Error : " .$koneksi_db -> connect_error. "\n\n";
		file_put_contents($file, $current);
		return true;
	} else {
		return true;
	}
}


function escape($value) {
    $return = '';
    for($i = 0; $i < strlen($value); ++$i) {
        $char = $value[$i];
        $ord = ord($char);
        if($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126)
            $return .= $char;
        else
            $return .= '\\x' . dechex($ord);
    }
    return $return;
}


function getBrowser() { 
	$location = $_SERVER['REMOTE_ADDR'];
	$u_agent = $_SERVER['HTTP_USER_AGENT'];
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version= "";

	//First get the platform?
	if (preg_match('/linux/i', $u_agent)) {
	  $platform = 'linux';
	}elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
	  $platform = 'mac';
	}elseif (preg_match('/windows|win32/i', $u_agent)) {
	  $platform = 'windows';
	}

	// Next get the name of the useragent yes seperately and for good reason
	if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
	  $bname = 'Internet Explorer';
	  $ub = "MSIE";
	}elseif(preg_match('/Firefox/i',$u_agent)){
	  $bname = 'Mozilla Firefox';
	  $ub = "Firefox";
	}elseif(preg_match('/OPR/i',$u_agent)){
	  $bname = 'Opera';
	  $ub = "Opera";
	}elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
	  $bname = 'Google Chrome';
	  $ub = "Chrome";
	}elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
	  $bname = 'Apple Safari';
	  $ub = "Safari";
	}elseif(preg_match('/Netscape/i',$u_agent)){
	  $bname = 'Netscape';
	  $ub = "Netscape";
	}elseif(preg_match('/Edge/i',$u_agent)){
	  $bname = 'Edge';
	  $ub = "Edge";
	}elseif(preg_match('/Trident/i',$u_agent)){
	  $bname = 'Internet Explorer';
	  $ub = "MSIE";
	}

	// finally get the correct version number
	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) .
  ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if (!preg_match_all($pattern, $u_agent, $matches)) {
	  // we have no matching number just continue
	}
	// see how many we have
	$i = count($matches['browser']);
	if ($i != 1) {
	  //we will have two since we are not using 'other' argument yet
	  //see if version is before or after the name
	  if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
		  $version= $matches['version'][0];
	  }else {
		  $version= $matches['version'][1];
	  }
	}else {
	  $version= $matches['version'][0];
	}

	// check if we have a number
	if ($version==null || $version=="") {$version="?";}

	// return array(
	//   'userAgent' => $u_agent,
	//   'name'      => $bname,
	//   'version'   => $version,
	//   'platform'  => $platform,
	//   'pattern'   => $pattern,
	//   'location'  => $location,
	// );

	return $u_agent. " " . $version. " di " .$platform. " pada " .$location;


}

function reflash_all() {
	reflash('old');
	reflash('error');
	reflash('notifikasi');
	reflash('custom');

	return true;
}

function swal2( $judul , $notifikasi , $tipe) {


	echo "
	<link rel='stylesheet' href='./assets/sweetalert2.css'>
    <script src='./assets/sweetalert2.all.js'></script>


	<script type='text/javascript'>
	setTimeout(function () { 
		swal.fire({
			
			title               : '$judul',
			text                :  '$notifikasi',
			icon                : '$tipe',
			timer               : 2000,
			showConfirmButton   : true
		});  
	},10); 
	</script>";


}


function redirect ( $page ) {

	if ( $page == "" ) {
		echo "<script> window.setTimeout(function(){ window.location = 'index.php'; }, 1000); </script>";
	} else {
		echo "<script> window.setTimeout(function(){ window.location = 'index.php?page=$page'; }, 1000); </script>";
	}
}

function redirect_back ( ) {
	echo "<script> window.setTimeout( function(){ window.location.replace = history.go(-1) ; }, 1000); </script>";
}


function active_sidebar ( $nama_page ) {

	if ( $_GET['page'] == $nama_page ) {

		
		echo "active";
	}


}

function active_sidebar2 ( Array $allowed_page ) {


	foreach ( $allowed_page as $page ) {

		if ( $_GET['page'] == 'kelola_wisman_kepri' && $page = 'kelola_wisman_kepri' ) {
			echo "active";
		} else

		if ( stripos( $_SERVER['QUERY_STRING'], $page) !== FALSE ) {

		
			echo "active";
		}
	}


}


function active_sidebar3 ( $nama_page ) {

	if ( $_SERVER['QUERY_STRING'] == "page=" .$nama_page ) {

		echo "active";
	}


}


function aria_expanded ( Array $allowed_page ) {

	foreach ( $allowed_page as $page ) {

		if ( stripos( $_SERVER['QUERY_STRING'], $page) !== FALSE ) {

			echo "aria-expanded='true'";
		}
	}

}


function show ( Array $allowed_page ) {

	foreach ( $allowed_page as $page ) {

		if ( stripos( $_SERVER['QUERY_STRING'], $page) !== FALSE ) {

			echo "show";
		}
	}

}



function open_menu ( Array $allowed_page ) {

	foreach ( $allowed_page as $page ) {

		if ( stripos( $_SERVER['QUERY_STRING'], $page) !== FALSE ) {
			echo "active submenu";
		}
	}
}

function open_submenu ( Array $allowed_page ) {

	foreach ( $allowed_page as $page ) {

		if ( stripos( $_SERVER['QUERY_STRING'], $page) !== FALSE ) {
			echo "submenu show";
		}
	}
}

function show_menu ( Array $allowed_page ) {

	foreach ( $allowed_page as $page ) {

		if ( stripos( $_SERVER['QUERY_STRING'], $page) !== FALSE ) {
			echo "show";
		}
	}
}






?>

<style>

.disabled2{
	pointer-events: none;
}

::-webkit-scrollbar {
	width: 8px;
}
    
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);     
    background: #fff;    
}

::-webkit-scrollbar-thumb {
	background: #6c757d;
}

</style>