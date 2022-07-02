<?php
/*
Plugin Name: REBI - Order Via WhatsApp
Description: Pesanan setiap produk di website kini bisa diarahkan langsung ke WhatsApp Anda dengan format sesuai kebutuhan,
Version: 1
Author: REBI - RemoteBisnis
Author URI: http://RemoteBisnis.com/tools
*/
// function to create the DB / Options / Defaults					

// error_reporting(0);

define('ROOTDIR', plugin_dir_path(__FILE__));
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

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'rebiovw_options_install');

//menu items
add_action('admin_menu','addmenu_reviovw');
function addmenu_reviovw() {
	
	//this is the main item for the menu
	add_menu_page('REBI - OVW', //page title
	'REBI - OVW', //menu title
	'manage_options', //capabilities
	'rebiovw_list', //menu slug
	'rebiovw_list',  //function call
	'https://mediabuatlinkwedding.files.wordpress.com/2022/04/iconplugin.png', 
	3
	);
	
	//this is a submenu
	add_submenu_page('rebiovw_list', //parent slug
	'Template', //page title
	'Template', //menu title
	'manage_options', //capability
	'rebiovw_list', //menu slug
	'rebiovw_list'); //function

	//this is a submenu
	add_submenu_page('rebiovw_list', //parent slug
	'Form Redirect ke WhatsApp', //page title
	'Form', //menu title
	'manage_options', //capability
	'rebiovw_create_form', //menu slug
	'rebiovw_create_form'); //function

	//this is a submenu
	add_submenu_page('rebiovw_list', //parent slug
	'Leads', //page title
	'Leads', //menu title
	'manage_options', //capability
	'rebiovw_lead', //menu slug
	'rebiovw_lead'); //function

	//this is a submenu
	add_submenu_page('rebiovw_list', //parent slug
	'Settingan', //page title
	'Setting', //menu title
	'manage_options', //capability
	'rebiovw_setting', //menu slug
	'rebiovw_setting'); //function

	add_submenu_page('', //parent slug
	'Tambah Template', //page title
	'Tambah Template', //menu title
	'manage_options', //capability
	'rebiovw_create', //menu slug
	'rebiovw_create'); //function
	
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Update OVW', //page title
	'Update', //menu title
	'manage_options', //capability
	'rebiovw_update', //menu slug
	'rebiovw_update'); //function

	add_submenu_page(null, //parent slug
	'Update Tombol', //page title
	'Update', //menu title
	'manage_options', //capability
	'rebiovw_update_tombol', //menu slug
	'rebiovw_update_tombol'); //function

	add_submenu_page(null, //parent slug
	'List form', //page title
	'List form', //menu title
	'manage_options', //capability
	'rebiovw_list_form', //menu slug
	'rebiovw_list_form'); //function

	add_submenu_page(null, //parent slug
	'Update form', //page title
	'Update form', //menu title
	'manage_options', //capability
	'rebiovw_update_form', //menu slug
	'rebiovw_update_form'); //function

	add_submenu_page(null, //parent slug
	'Update Lead', //page title
	'Update Lead', //menu title
	'manage_options', //capability
	'rebiovw_update_lead', //menu slug
	'rebiovw_update_lead'); //function

	
}

require_once(ROOTDIR . 'reviovw-list.php');
require_once(ROOTDIR . 'reviovw-list.php');
require_once(ROOTDIR . 'reviovw-create.php');
require_once(ROOTDIR . 'reviovw-update.php');
require_once(ROOTDIR . '/includes/reviovw-system.php');

