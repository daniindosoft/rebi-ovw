<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    global $wpdb;
	$idLead = $_GET['id'];
    $tbl = $wpdb->prefix . "rebiovw_pesanan";

    $rebiovw_lead = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `wp_rebiovw_pesanan` as wp join wp_rebiovw_form_line as wfl on wfl.id = wp.id_form_line where wp.unix=%d", $idLead) );
    
?>


<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/rebi-ovw/style-admin.css?ver=1.2" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<div class="wrap">

    <div class="row">
    	<div class="col-lg-9">
    		<h3>Detail Leads</h3>
    	</div>
    	<div class="col-lg-3 text-right">
	    	<a href="">Lihat Plugin Lainnya</a>
    	</div>
	</div>
    <div class="tablenav top">
        <div class="alignleft actions">
            <a class="btn btn-sm btn-primary" href="<?php echo admin_url('admin.php?page=rebiovw_list'); ?>"><span class="dashicons dashicons-arrow-left-alt"></span> List Template</a>
            <a class="btn btn-sm btn-primary" href="<?php echo admin_url('admin.php?page=rebiovw_list_form'); ?>"><span class="dashicons dashicons-format-aside"></span> List Form</a>
            <br>
            <br>
        </div>
        <br class="clear">
    </div>
    <br>
    <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
    <div style="background-color: #f2f2f2;" class="p-2">
    	<table class="table-lead">
		<?php 
			$waktuMasuk = '';
			foreach ($rebiovw_lead as $key => $valSingleLead): 
				$waktuMasuk = $valSingleLead->waktu;
		?>
    		<tr>
    			<td class="title"><?php echo $valSingleLead->judul_elemen; ?></td>
    			<td><?php echo ': <b>'.$valSingleLead->isi.'</b>'; ?></td>
			</tr>
		<?php endforeach ?>
		</table>
		<hr>
		<small>Tanggal : <?php echo $waktuMasuk ?></small>
    </div>
</div>
<script>
    $(document).ready(function() {
		$(document).on("click", ".checkbox" , function() {
			if ($(this).is(':checked')) {
				$(this).attr('value', 'true');
                $('.checkboxvalue'+$(this).data('id')).val('true');
			} else {
				$(this).attr('value', 'false');
                $('.checkboxvalue'+$(this).data('id')).val('false');
			}
		});
		$(document).on("click", ".simple-form" , function() { });
		$(document).on("click", ".delete" , function() {
			$('.numid'+$(this).data('id')).remove();
		});
		$(document).on("change", ".selectbox" , function() {
    		var param = $(this).val();
			var id = $(this).data('id');
    		if (param == 'select_box') {
    			$('.placement'+id).html('<label class="font-weight-bold">Masukan List sesuai format</label><textarea name="format[]" placeholder="Merah&#10;Biru&#10;Hijau" rows="8" class="form-control form-control-sm" row></textarea>');
    		}else{
    			$('.placement'+$(this).data('id')).html('<input type="hidden" name="format[]">');
    		}
    	});
    	 
        $('.ms').select2();
    });
</script>