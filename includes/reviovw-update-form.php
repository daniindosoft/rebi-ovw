<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    global $wpdb;
	$tbl_form = $wpdb->prefix . "rebiovw_form";
	$tbl_form_line = $wpdb->prefix . "rebiovw_form_line";
	$tbl_pesanan = $wpdb->prefix . "rebiovw_pesanan";
	if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $tbl_form WHERE id = %s", $_GET['id']));
        $wpdb->query($wpdb->prepare("DELETE FROM $tbl_form_line WHERE id_form = %s", $_GET['id']));
        $wpdb->query($wpdb->prepare("DELETE FROM $tbl_pesanan WHERE id_form = %s", $_GET['id']));
        
        $message ="Form telah dihapus";
        header('location:'.admin_url('admin.php?page=rebiovw_list_form&id='.$id).'&msg='.$message);

    }
    if (isset($_POST['addform'])) {
        // echo "<pre>";
        // echo print_r($_POST);
        // echo "</pre>";

		$title = $_POST['title'];
		$hp = $_POST['header_pesan'];
		$fp = $_POST['footer_pesan'];

        $wpdb->update(
                $tbl_form,
                array(
                    'title' => $title, 
                    'header_pesan' => $hp,
                    'footer_pesan' => $fp, 
                ),
                array('id' => $_GET['id'] )
        );
         		
		$title_elemen = $_POST['judul_elemen'];
		$type_elemen = $_POST['type_elemen'];
		$lebar = $_POST['lebar'];
 
        $for = $_POST['format'];

        for ($i=0; $i < count($title_elemen); $i++) { 
			
			$format = $for[$i];
			
            $elemen = $type_elemen[$i].' '.@$_POST['group'][$i];
            // echo '<br>'.$format.' - '.$title_elemen[$i].' - '.$elemen.' - '. $format;
	        $wpdb->update(
	                $tbl_form_line,
	                array(
	                    'judul_elemen' => $title_elemen[$i],
	                    'type_elemen' => $elemen,
	                    'lebar' => $lebar[$i],
	                    'format' => $format
	                ),
                    array('id' => $_POST['id_form_line'][$i])
	        );
        }

 

        $message ="Form telah dibuat";
	     
	}

	$data = $wpdb->get_row( "SELECT * FROM $tbl_form where id=".$_GET['id']);
?>


<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/rebi-ovw/style-admin.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<div class="wrap">

    <div class="row">
    	<div class="col-lg-9">
    		<h3>Update/Delete Form</h3>
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
        <!-- <form method="post" action=" $_SERVER['REQUEST_URI']; ?>" onsubmit="return confirm('Yakin untuk melanjutkan proses ?')"> -->
        	<div class="row">
            	 
            	<div class="col-lg-6">
            		<label class="font-weight-bold">Judul Form</label>
            		<input type="text" id="judul_form" class="form-control" name="title" value="<?php echo $data->title ?>">
            		<label class="font-weight-bold">Header Pesan</label>
            		<textarea name="header_pesan" id="header_pesan" class="form-control form-control-sm" id="" rows="6"><?php echo $data->header_pesan; ?></textarea>
            	</div>
            	

        	</div>
            <div class="row add-element">
            	<?php 
            		$no = 1;
                    foreach ($wpdb->get_results("SELECT * from $tbl_form_line where id_form=".$_GET['id']) as $loopElemen): 
            		$no++;
                        
                        $elemen1 = explode(' ',$loopElemen->type_elemen)[1];
                        $elemen0 = explode(' ',$loopElemen->type_elemen)[0];
                        
                ?>
	            	<div class="col-lg-12">
	            		<hr>
	            	</div>
	            	<div class="col-lg-4 param-elemen">
	            		<div class="form-group">
	            			<label class="font-weight-bold">Judul elemen</label>
	            			<input type="text" class="disabled1 form-control form-control-sm" name="judul_elemen[]" value="<?php echo $loopElemen->judul_elemen ?>">
	            		</div>
	            	</div>
	            	<div class="col-lg-2">
                        <input type="hidden" value="<?php echo $loopElemen->id ?>" name="id_form_line[]">
	            		<div class="form-group">
	            			<label class="font-weight-bold">Type <?php echo $elemen0 ?></label>
	            			<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id='<?php echo $no ?>'>
	            				<option <?php if($elemen0 == 'text'){ echo 'disabled selected '; } ?> value="text">Text</option>
	            				<option <?php if($elemen0 == 'textarea'){ echo 'disabled selected'; } ?> value="textarea">Textarea</option>
	            				<option <?php if($elemen0 == 'select_box'){ echo 'disabled selected '; } ?> value="select_box">Select Box</option>
	            				
	            			</select>


	            		</div>
	            	</div>
	            	<div class="col-lg-1">
	            		<div class="form-group">
	            			<label class="font-weight-bold">Lebar</label>
	            			<select name="lebar[]" class="form-control form-control-sm disabled1 ">
	            				<?php 
	            					$rowSelect = '';
                                    $rowSelects = '';
		            				for ($i=1; $i <= 10; $i++) { 
                                        $selected = '';
                                        if ($loopElemen->lebar == 'col-'.$i.'') {
                                            $selected = 'selected';
                                        }
		            					
                                        $rowSelects .= '<option value="col-'.$i.'">'.$i.' Kolom</option>';
                                        $rowSelect = '<option '.$selected.' value="col-'.$i.'">'.$i.' Kolom</option>';

		            					echo $rowSelect;
		            				}
	            				?>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="col-lg-1 hide">
                        
	            		<label class="font-weight-bold">Group</label><br>
	            		<input type="checkbox" class="checkbox" <?php if($elemen1 == 'true' ){ echo 'checked'; } ?> name="" value="false" data-id=<?php echo $loopElemen->id ?>>
	                    <input type="hidden" class="checkboxvalue<?php echo $loopElemen->id ?>" name="group[]" value="<?= $elemen1 ?>">
	            	</div>
	            	<div class="col-lg-4 placement<?php echo $no ?>">
                        <?php if ($elemen0 == 'select_box'): ?>
                            <label class="font-weight-bold">Masukan List sesuai format</label><br>
                            <textarea name="format[]" class="form-control-sm form-control" rows="8"><?php echo $loopElemen->format ?></textarea>
                        <?php else: ?>
    	                    <input type="hidden" name="format[]">
                        <?php endif ?>
	            	</div>
	            <?php endforeach ?>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		<button id="addrow" class="btn btn-warning btn-sm" type="button"><i class="dashicons dashicons-plus"></i> Tambah Elemen</button>
            	</div>
            	<div class="col-lg-12">
            		<hr>
            		<label class="font-weight-bold">Footer Pesan</label>
            		<textarea id="footer_pesan" name="footer_pesan" class="form-control form-control-sm" id="" rows="6"><?php echo $data->footer_pesan ?></textarea>
            	</div>
            	 
            	 
            	<div class="col-lg-12">
            		<hr>
            		<!-- <button name="addform" class="btn btn-success btn-sm" type="submit"><i class="dashicons dashicons-saved"></i> Simpan</button> -->
                    <button name="delete" onclick="return confirm('Pesanan atau lead yang terkait dengan form ini akan hilang juga, yakin untuk menghapus Form ini ?')" class="btn btn-danger btn-sm" type="submit"><i class="dashicons dashicons-trash"></i> Hapus Form ini</button>
                    <br>
            	</div>
            </div>
        <!-- </form> -->
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
    	$('#addrow').on('click', function(){
	    	var numrow = $('.param-elemen').length + 1;
	    	$('.add-element').append(`
	    		<div class="col-lg-12 numid`+numrow+`">
            		<hr>
            	</div>
            	<div class="col-lg-4 numid`+numrow+`">
            		<div class="form-group param-elemen">
            			<label class="font-weight-bold">Judul elemen</label>
            			<div class="input-group">
							<div class="input-group-prepend">
								<button type="button" data-id ="`+numrow+`"class="delete btn btn-danger btn-sm">X</button>
							</div>
	            			<input type="text" class="disabled`+numrow+` form-control form-control-sm" name="judul_elemen[]">
						</div>
            		</div>
            	</div>
            	<div class="col-lg-2 numid`+numrow+`">
            		<div class="form-group">
            			<label class="font-weight-bold">Type</label>
            			<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id=`+numrow+`>
            				<option value="text">Text</option>
            				<option value="textarea">Textarea</option>
            				<option value="select_box">Select Box</option>
            				
            			</select>
            		</div>
            	</div>
            	<div class="col-lg-1 numid`+numrow+`">
            		<div class="form-group">
            			<label class="font-weight-bold">Lebar</label>
            			<select name="lebar[]" class="form-control form-control-sm disabled`+numrow+`">
            				<?php 
            					echo $rowSelects;
            				?>
            			</select>
            		</div>
            	</div>

            	<div class="col-lg-1 hide">
            		<label class="font-weight-bold">Group</label><br>
                    <input type="checkbox" class="checkbox" name="" value="false" data-id="`+numrow+`">
                    <input type="hidden" class="checkboxvalue`+numrow+`" name="group[]" value="false">
            	</div>
            	<div class="col-lg-4 numid`+numrow+` placement`+numrow+`">
                <input type="hidden" name="format[]">
            	</div>
	    		`);
    	});
        $('.ms').select2();
    });
</script>