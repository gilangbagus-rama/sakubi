<?php

error_reporting( false );
session_start();

// Buat Session Token
if ( $_SESSION['token'] == '') {
    $length = '64';
    $_SESSION['token'] = random_strings( $length );
}


// Routing POST => Untuk Form
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {


	// Cek apakah akses index.php dengan variabel selain ?form
	if ( $_SERVER['QUERY_STRING'] != "" && strstr( $_SERVER['QUERY_STRING'] , "form" ) === FALSE ) {
		view('exception/error_500');	
	exit;
	}


	// Kalau token tidak ditemukan, langsung error 419
	if ( cek_token() === false ) {
		view('exception/error_419');
	exit;
	}


	$form = $_GET['form'];
	$cek_form = to_old();
	switch ( $form ) {

		default:
			view('exception/error_controller');
		break;



		# Survei
		case 'survei_skdu':
			controller('proses_survei_skdu');
		break;

		case 'survei_konsumen':
			controller('proses_survei_konsumen');
		break;

		case 'survei_pedagang_eceran':
			controller('proses_survei_pedagang_eceran');
		break;


		// Pariwisata
		case 'wisman_kepri':
			controller('proses_wisman_kepri');
		break;

		case 'wisman_kepri_asal':
			controller('proses_wisman_kepri_asal');
		break;


		// Perbankan
		case 'kredit_se_lp':
			controller('proses_kredit_se_lp');
		break;

		case 'kredit_se_lb':
			controller('proses_kredit_se_lb');
		break;

		case 'kredit_jp_lp':
			controller('proses_kredit_jp_lp');
		break;

		case 'kredit_jp_lb':
			controller('proses_kredit_jp_lb');
		break;

		case 'npl_jp_lp':
			controller('proses_npl_jp_lp');
		break;

		case 'npl_jp_lb':
			controller('proses_npl_jp_lb');
		break;


		

		case 'perkembangan_indikator_bank':
			controller('proses_perkembangan_indikator_bank');
		break;

		case 'dana_pihak_ketiga':
			controller('proses_dana_pihak_ketiga');
		break;

		case 'kredit_bank_umum':
			controller('proses_kredit_bank_umum');
		break;

		case 'kredit_lokasi_proyek':
			controller('proses_kredit_lokasi_proyek');
		break;

		case 'aset_bank':
			controller('proses_aset_bank');
		break;

		case 'dana_perbankan':
			controller('proses_dana_perbankan');
		break;

		case 'kolektibilitas_kredit_bu_lp':
			controller('proses_kolektibilitas_kredit_bu_lp');
		break;

		case 'kolektibilitas_kredit_bu_lb':
			controller('proses_kolektibilitas_kredit_bu_lb');
		break;







		case 'pendaftaran_kendaraan':
			controller('proses_pendaftaran_kendaraan');
		break;


		case 'wisman_kepri':
			controller('proses_wisman_kepri');
		break;





		// Auth
		case 'login';
			controller('proses_login');
		break;

		case 'logout':
			controller('proses_logout');
		break;

		case 'staff';
			controller('proses_staff');
		break;


		case 'semen':
			controller('proses_semen');
		break;

		case 'pdrb_lu_berlaku':
			controller('proses_pdrb_lu_berlaku');
		break;

		case 'pdrb_lu_konstan':
			controller('proses_pdrb_lu_konstan');
		break;

		case 'pertumbuhan_ekonomi_lu':
			controller('proses_pertumbuhan_ekonomi_lu');
		break;

		case 'andil_pertumbuhan_ekonomi_lu':
			controller('proses_andil_pertumbuhan_ekonomi_lu');
		break;

		case 'pangsa_pdrb_lu':
			controller('proses_pangsa_pdrb_lu');
		break;

		case 'pdrb_p_berlaku':
			controller('proses_pdrb_p_berlaku');
		break;

		case 'pdrb_p_konstan':
			controller('proses_pdrb_p_konstan');
		break;

		case 'pertumbuhan_ekonomi_p':
			controller('proses_pertumbuhan_ekonomi_p');
		break;

		case 'andil_pertumbuhan_ekonomi_p':
			controller('proses_andil_pertumbuhan_ekonomi_p');
		break;

		case 'pangsa_pdrb_p':
			controller('proses_pangsa_pdrb_p');
		break;

		case 'tingkat_kemiskinan':
			controller('proses_tingkat_kemiskinan');
		break;

		case 'pdrb_kapita':
			controller('proses_pdrb_kapita');
		break;

		case 'ipm':
			controller('proses_ipm');
		break;

		case 'tenaga_kerja':
			controller('proses_tenaga_kerja');
		break;

		case 'pengangguran':
			controller('proses_pengangguran');
		break;

		case 'gini_ratio':
			controller('proses_gini_ratio');
		break;

		case 'ekspor_kepri':
			controller('proses_ekspor_kepri');
		break;

		case 'impor_kepri':
			controller('proses_impor_kepri');
		break;

	}


} else 


// Routing GET => Untuk Halaman
if ( $_SERVER['REQUEST_METHOD'] == "GET" ) {


	// Untuk Previous Halaman dengan function back();
	$_SESSION['previous'] = $_SERVER['REQUEST_URI'];


	// Cek apakah akses index.php dengan variabel selain ?page
	if ( $_SERVER['QUERY_STRING'] != "" && strstr( $_SERVER['QUERY_STRING'] , "page" ) === FALSE ) {
		view('exception/error_500');	
	exit;
	}


	// Jika dapat $_GET['page']
	if ( isset( $_GET['page'] ) && $_GET['page'] != "") {


		// Switch - Case $_GET['page']
		$page = $_GET['page'];
		switch ( $page ) {


			// Jika tidak ada otomatis ke error_404
			default:
				view('exception/error_404');
			break;





			// STATISTIK
			case 'statistik_ekspor':
				view('statistik_ekspor');
			break;

			case 'statistik_impor':
				view('statistik_impor');
			break;

			case 'statistik_kredit_sektor_ekonomi':
				view('statistik_kredit_sektor_ekonomi');
			break;

			case 'statistik_inflasi':
				view('statistik_inflasi');
			break;

			case 'statistik_pengangguran':
				view('statistik_pengangguran');
			break;

			case 'statistik_ipm':
				view('statistik_ipm');
			break;

			case 'statistik_gini_ratio':
				view('statistik_gini_ratio');
			break;


			case 'statistik_tenaga_kerja':
				view('statistik_tenaga_kerja');
			break;


			case 'statistik_rupiah':
				view('statistik_rupiah');
			break;

			case 'statistik_dollar':
				view('statistik_dollar');
			break;

			case 'statistik_tingkat_pendidikan':
				view('statistik_tingkat_pendidikan');
			break;

			case 'statistik_pertumbuhan_ekonomi':
				view('statistik_pertumbuhan_ekonomi');
			break;

			case 'statistik_listrik':
				view('statistik_listrik');
			break;

			case 'statistik_pdrb_lu_berlaku':
				view('statistik_pdrb_lu_berlaku');
			break;

			

			case 'statistik_semen':
				view('statistik_semen');
			break;

			case 'statistik_miskin':
				view('statistik_miskin');
			break;






			// PDRB
			case 'kelola_pdrb_lu_berlaku':
				view('staff/pdrb/kelola_pdrb_lapangan_usaha_berlaku');
			break;

			case 'kelola_pdrb_lu_konstan':
				view('staff/pdrb/kelola_pdrb_lapangan_usaha_konstan');
			break;

			case 'kelola_pertumbuhan_ekonomi_lu':
				view('staff/pdrb/kelola_pertumbuhan_ekonomi_lu');
			break;

			case 'kelola_andil_pertumbuhan_ekonomi_lu':
				view('staff/pdrb/kelola_andil_pertumbuhan_ekonomi_lu');
			break;

			case 'kelola_pangsa_pdrb_lu':
				view('staff/pdrb/kelola_pangsa_pdrb_lu');
			break;

			case 'kelola_pdrb_p_berlaku':
				view('staff/pdrb/kelola_pdrb_pengeluaran_berlaku');
			break;

			case 'kelola_pdrb_p_konstan':
				view('staff/pdrb/kelola_pdrb_pengeluaran_konstan');
			break;

			case 'kelola_pertumbuhan_ekonomi_p':
				view('staff/pdrb/kelola_pertumbuhan_ekonomi_p');
			break;

			case 'kelola_andil_pertumbuhan_ekonomi_p':
				view('staff/pdrb/kelola_andil_pertumbuhan_ekonomi_p');
			break;

			case 'kelola_pangsa_pdrb_p':
				view('staff/pdrb/kelola_pangsa_pdrb_p');
			break;


			case 'kelola_pdrb_kapita':
				view('staff/pdrb/kelola_pdrb_kapita');
			break;



			// KETENAGAKERJAAN
			case 'kelola_pengangguran':
				view('staff/ketenagakerjaan/kelola_pengangguran');
			break;

			case 'kelola_tenaga_kerja':
				view('staff/ketenagakerjaan/kelola_tenaga_kerja');
			break;

			case 'kelola_tingkat_kemiskinan':
				view('staff/ketenagakerjaan/kelola_tingkat_kemiskinan');
			break;

			case 'kelola_ipm':
				view('staff/ketenagakerjaan/kelola_ipm_kepri');
			break;

			case 'kelola_gini_ratio':
				view('staff/ketenagakerjaan/kelola_gini_ratio');
			break;


			// Inflasi
			case 'kelola_inflasi':
				view('staff/inflasi/kelola_inflasi');
			break;


			// Ekspor-Impor
			case 'kelola_ekspor_kepri':
				view('staff/ekspor_impor/kelola_ekspor_kepri');
			break;

			case 'kelola_impor_kepri':
				view('staff/ekspor_impor/kelola_impor_kepri');
			break;


			// Pariwisata
			case 'kelola_wisman_kepri':
				view('staff/pariwisata/kelola_wisman_kepri');
			break;
			
			case 'kelola_wisman_kepri_asal':
				view('staff/pariwisata/kelola_wisman_kepri_asal');
			break;


			// Perbankan
			#Kredit Jenis Penggunaan
			case 'kelola_kredit_jp_lp':
				view('staff/perkembangan_perbankan/kelola_kredit_jp/kelola_kredit_jp_lp');
			break;

			case 'kelola_kredit_jp_lb':
				view('staff/perkembangan_perbankan/kelola_kredit_jp/kelola_kredit_jp_lb');
			break;

			#NPL Jenis Penggunaan
			case 'kelola_npl_jp_lb':
				view('staff/perkembangan_perbankan/kelola_npl_jp/kelola_npl_jp_lb');
			break;

			case 'kelola_npl_jp_lp':
				view('staff/perkembangan_perbankan/kelola_npl_jp/kelola_npl_jp_lp');
			break;



			# Asset Bank
			case 'kelola_aset_bank':
				view('staff/perkembangan_perbankan/kelola_aset_bank/kelola_aset_bank');
			break;
	
			case 'tambah_aset_bank':
				view('staff/perkembangan_perbankan/kelola_aset_bank/tambah_aset_bank');
			break;
	
			case 'edit_aset_bank':
				view('staff/perkembangan_perbankan/kelola_aset_bank/edit_aset_bank');
			break;


			# Dana Perbankan
			case 'kelola_dana_perbankan':
				view('staff/perkembangan_perbankan/kelola_dana_perbankan/kelola_dana_perbankan');
			break;
	
			case 'tambah_dana_perbankan':
				view('staff/perkembangan_perbankan/kelola_dana_perbankan/tambah_dana_perbankan');
			break;
	
			case 'edit_dana_perbankan':
				view('staff/perkembangan_perbankan/kelola_dana_perbankan/edit_dana_perbankan');
			break;


			# kolektibilitas Kredit
			case 'kelola_kolektibilitas_kredit_bu_lp':
				view('staff/perkembangan_perbankan/kelola_kolektibilitas_bank/kelola_kolektibilitas_kredit_bank_umum_lp');
			break;
	
			case 'kelola_kolektibilitas_kredit_bu_lb':
				view('staff/perkembangan_perbankan/kelola_kolektibilitas_bank/kelola_kolektibilitas_kredit_bank_umum_lb');
			break;


			# Kredit Sektor Ekonomi
			case 'kelola_kredit_sektor_lp':
				view('staff/perkembangan_perbankan/kelola_kredit_sektor_ekonomi/kelola_kredit_sektor_lp');
			break;

			case 'tambah_kredit_sektor_lp':
				view('staff/perkembangan_perbankan/kelola_kredit_sektor_ekonomi/tambah_kredit_sektor_lp');
			break;

			case 'edit_kredit_sektor_lp':
				view('staff/perkembangan_perbankan/kelola_kredit_sektor_ekonomi/edit_kredit_sektor_lp');
			break;

			case 'kelola_kredit_sektor_lb':
				view('staff/perkembangan_perbankan/kelola_kredit_sektor_ekonomi/kelola_kredit_sektor_lb');
			break;

			case 'tambah_kredit_sektor_lb':
				view('staff/perkembangan_perbankan/kelola_kredit_sektor_ekonomi/tambah_kredit_sektor_lb');
			break;

			case 'edit_kredit_sektor_lb':
				view('staff/perkembangan_perbankan/kelola_kredit_sektor_ekonomi/edit_kredit_sektor_lb');
			break;




			// Indikator Perkonomian Lainnya

			# Listrik
			case 'kelola_listrik':
				view('staff/ekonomi_lainnya/kelola_listrik');
			break;

			# Hasil Survei dan Liaison
			case 'kelola_s_konsumen':
				view('staff/ekonomi_lainnya/hasil_survei/kelola_s_konsumen');
			break;
			

			case 'kelola_skdu':
				view('staff/ekonomi_lainnya/hasil_survei/kelola_skdu');
			break;
			
			
			case 'kelola_s_pedagang_eceran':
				view('staff/ekonomi_lainnya/hasil_survei/kelola_s_pedagang_eceran');
			break;


			# Kendaraan
			case 'kelola_pendaftaran_kendaraan_baru':
				view('staff/ekonomi_lainnya/kelola_pendaftaran_kendaraan_baru');
			break;


			# Pengadaan Semen
			case 'kelola_semen':
				view('staff/ekonomi_lainnya/kelola_semen');
			break;


			case 'kelola_parkir':
				view('staff/ekonomi_lainnya/kelola_parkir');
			break;




			// Menu Staff Administrasi
			case 'kelola_staff':
				view('staff/kelola_pengguna/kelola_staff');
			break;

			case 'kelola_pegawai':
				view('staff/kelola_pengguna/kelola_pegawai');
			break;









			case '':
				header('location: index.php');
			break;

			case 'home':
				header('location: index.php');
			break;


			case 'login':
				view('auth/login');
			break;


			case 'logout':
				view('auth/logout');
			break;



		}


	} else 

	// Jika tidak dapat $_GET['page']
	if ( !isset( $_GET['page'] ) || $_GET['page'] == "" ) {

		session_start();
	
		$role = $_SESSION['role'];

		if ( $role == "" || $role === NULL ) {
			view('home');
		} else 
	
		if ( $role == "Staff Administrasi" ) {
			view('staff/dashboard_staff');
		} else 
	
		if ( $role == "Pegawai" ) {
			view('pegawai/dashboard_pegawai');
		} 
		else {
			view('exception/error_no_role');
		}
	
	} 

}

?>