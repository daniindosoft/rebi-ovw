<?php
/*
Plugin Name: REBI - Order Via WhatsApp
Description: Pesanan setiap produk di website kini bisa diarahkan langsung ke WhatsApp Anda dengan format sesuai kebutuhan,
Version: 1
Author: REBI - RemoteBisnis
Author URI: http://RemoteBisnis.com/tools
*/
// function to create the DB / Options / Defaults					

define('ROOTDIR', plugin_dir_path(__FILE__));
$x = file_get_contents(base64_decode('aHR0cDovL21lbWJlci5yZW1vdGViaXNuaXMuY29tL3Jlc3QvYXBpLnBocD90eXBlPWluc3Rhbl9zY3JhcCZ3ZWJzaXRlPQ==').''.$_SERVER['HTTP_HOST']);
if($x == 1){
function rebiovw_options_install() {

    global $wpdb;

    $tbl_template = $wpdb->prefix . "rebiovw_template";
    $tbl_line = $wpdb->prefix . "rebiovw_template_line";
    $tbl_tombol = $wpdb->prefix . "rebiovw_tombol";
    $tbl_setting = $wpdb->prefix . "rebiovw_setting";
    $tbl_form = $wpdb->prefix . "rebiovw_form";
    $tbl_form_produk = $wpdb->prefix . "rebiovw_form_produk";
    $tbl_form_line = $wpdb->prefix . "rebiovw_form_line";
    $tbl_pesanan = $wpdb->prefix . "rebiovw_pesanan";
    $tbl_region = $wpdb->prefix . "rebiovw_region";

    $sql = "
    	CREATE TABLE $tbl_line(
            `id` int(11) AUTO_INCREMENT,
            `id_template` int(11)    NOT NULL,
            `produk_id` int(11)    NOT NULL,
            PRIMARY KEY (`id`)
          ) ; 

	    CREATE TABLE $tbl_template (
	            `id` int(11) AUTO_INCREMENT,
	            `title` varchar(50)    NOT NULL,
	            `btn_text` varchar(50)    NOT NULL,
	            `posisi` varchar(50)    NOT NULL,
	            `des` longtext,
	            `id_form` int(11),
	            `id_tombol` int(11),
	            PRIMARY KEY (`id`)
	          ) ; 

	    CREATE TABLE $tbl_pesanan (
                `id` int(11) AUTO_INCREMENT,
                `id_form_line` varchar(50)    NOT NULL,
                `isi` longtext NOT NULL,
                `id_form` int(11),
                `unix` CHAR(20),
                `waktu` TIMESTAMP,
                PRIMARY KEY (`id`)
              ) ; 

        CREATE TABLE IF NOT EXISTS $tbl_region (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `nama` varchar(550) NOT NULL,
		  PRIMARY KEY (`id`)
		  );

		ALTER TABLE $tbl_template CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

		CREATE TABLE $tbl_tombol (
	            `id` int(11) AUTO_INCREMENT,
	            `nama_tombol` varchar(50)    NOT NULL,
	            `css` longtext    NOT NULL,
	            PRIMARY KEY (`id`)
	          ) ; 
		
		CREATE TABLE $tbl_setting (
	            `id` int(11) AUTO_INCREMENT,
	            `nowa` varchar(20),
	            PRIMARY KEY (`id`)
	          ) ;

	    CREATE TABLE $tbl_form_line (
	            `id` int(11) AUTO_INCREMENT,
	            `id_form` INT(11) NOT NULL,
	            `judul_elemen` varchar(50) NOT NULL,
	            `type_elemen` varchar(15) NOT NULL,
	            `lebar` char(15) NOT NULL,
	            `format` longtext,
	            PRIMARY KEY (`id`)
	          ) ; 
	          
	          
		CREATE TABLE $tbl_form (
	            `id` int(11) AUTO_INCREMENT,
	            `title` varchar(50) NOT NULL,
	            `header_pesan` longtext NOT NULL,
	            `footer_pesan` longtext NOT NULL,
	            PRIMARY KEY (`id`)
	          ) ; 

		CREATE TABLE $tbl_form_produk (
	            `id` int(11) AUTO_INCREMENT,
	            `id_form` int(11) NOT NULL,
	            `produk_id` int(11) NOT NULL,
	            PRIMARY KEY (`id`)
	          ) ; 

	    INSERT INTO $tbl_setting (nowa) VALUES ('6285...');

    ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
    $wpdb->query($sql);
}

 
register_activation_hook(__FILE__, 'rebiovw_options_install');

add_action('admin_menu','addmenu_reviovw');
function addmenu_reviovw() {
	
	add_menu_page('REBI - OVW',
	'REBI - OVW',
	'manage_options',
	'rebiovw_list',
	'rebiovw_list',   
	'https://mediabuatlinkwedding.files.wordpress.com/2022/04/iconplugin.png', 
	3
	);
 
	add_submenu_page('rebiovw_list',
	'Template',
	'Template',
	'manage_options',
	'rebiovw_list',
	'rebiovw_list');  
 
	add_submenu_page('rebiovw_list',
	'Form Redirect ke WhatsApp',
	'Form',
	'manage_options',
	'rebiovw_create_form',
	'rebiovw_create_form');  

 
	add_submenu_page('rebiovw_list',
	'Leads',
	'Leads',
	'manage_options',
	'rebiovw_lead',
	'rebiovw_lead');  
 
	add_submenu_page('rebiovw_list',
	'Settingan',
	'Setting',
	'manage_options',
	'rebiovw_setting',
	'rebiovw_setting'); 

	add_submenu_page('',
	'Tambah Template',
	'Tambah Template',
	'manage_options',
	'rebiovw_create',
	'rebiovw_create'); 
	
	
	add_submenu_page(null,
	'Update OVW',
	'Update',
	'manage_options',
	'rebiovw_update',
	'rebiovw_update');

	add_submenu_page(null,
	'Update Tombol',
	'Update',
	'manage_options',
	'rebiovw_update_tombol',
	'rebiovw_update_tombol'); 

	add_submenu_page(null,
	'List form',
	'List form',
	'manage_options',
	'rebiovw_list_form',
	'rebiovw_list_form'); 

	add_submenu_page(null,
	'Update form',
	'Update form',
	'manage_options',
	'rebiovw_update_form',
	'rebiovw_update_form');  

	add_submenu_page(null,
	'Update Lead',
	'Update Lead',
	'manage_options',
	'rebiovw_update_lead',
	'rebiovw_update_lead');  

	
}

require_once(ROOTDIR . 'reviovw-list.php');
require_once(ROOTDIR . 'reviovw-list.php');
require_once(ROOTDIR . 'reviovw-create.php');
require_once(ROOTDIR . 'reviovw-update.php');
require_once(ROOTDIR . '/includes/reviovw-system.php');

}else{
	echo '<script>
            alert("'.base64_decode('UGx1Z2luIHRpZGFrIGJpc2EgZGlndW5ha2FuIGthcmVuYSBXZWJzaXRlIGFuZGEgdGlkYWsgbWVtaWxpa2kgbGlzZW5zaSAhLCBIdWJ1bmdpIFdBOjA4MTIyMjY4NTY1OQ==').'");
    </script>';
}