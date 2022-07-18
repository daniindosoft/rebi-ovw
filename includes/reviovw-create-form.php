<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php global $wpdb; if (isset($_POST['addform'])) {$tbl_form = $wpdb->prefix . "rebiovw_form"; $tbl_form_produk = $wpdb->prefix . "rebiovw_form_produk"; $tbl_form_line = $wpdb->prefix . "rebiovw_form_line"; $title = $_POST['title']; $hp = $_POST['header_pesan']; $fp = $_POST['footer_pesan']; try{$wpdb->insert($tbl_form, array('title' => $title, 'header_pesan' => $hp, 'footer_pesan' => $fp, ) ); $lastid = $wpdb->insert_id; $title_elemen = $_POST['judul_elemen']; $type_elemen = $_POST['type_elemen']; $lebar = $_POST['lebar']; $for = $_POST['format']; for ($i=0; $i < count($title_elemen); $i++) {$format = $for[$i]; $elemen = $type_elemen[$i].' '.@$_POST['group'][$i]; $wpdb->insert($tbl_form_line, array('id_form' => $lastid, 'judul_elemen' => $title_elemen[$i], 'type_elemen' => $elemen, 'lebar' => $lebar[$i], 'format' => $format ) ); } $message ="Form telah dibuat"; } catch (\Exception $ex) {echo $ex->getMessage(); } } ?> <style>
<?php require_once(ROOTDIR . 'style-admin.css'); ?>

</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<div class="wrap">

<div class="row">
<div class="col-lg-9">
<h3>Buat Form</h3>
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
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="return confirm('Yakin form akan di simpan ?')">
<div class="row">
<div class="col-lg-12">
<button class="btn-sm btn btn-info simple-form" type="button"><i class="dashicons dashicons-embed-generic"></i> Generate Form Sederhana</button>
<button class="btn-sm btn btn-info simple-form-2" type="button"><i class="fa fa-file-text"></i> Generate Form Detail</button>
<!-- <button class="btn-sm btn btn-info" type="button"><i class="fas fa-tshirt"></i> Generate Form Detail & Multiple Produk</button> -->
<br>
<hr>
</div>
<div class="col-lg-6">
<label class="font-weight-bold">Judul Form</label>
<input type="text" id="judul_form" class="form-control form-control-sm" name="title">
<label class="font-weight-bold">Header Pesan</label>
<br><small>Lihat Shortcode <a href="#kamus" data-toggle="modal" data-target="#myModal">Disini..</a></small>
<textarea name="header_pesan" id="header_pesan" class="form-control form-control-sm" id="" rows="6"></textarea>
</div>


</div>
<div class="row add-element">
<div class="col-lg-12">
<hr>
</div>
<div class="col-lg-3 param-elemen">
<div class="form-group">
<label class="font-weight-bold">Judul elemen</label>
<input type="text" class="disabled1 form-control form-control-sm" name="judul_elemen[]">
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label class="font-weight-bold">Type</label>
<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id=1>
<option value="text">Text</option>
<option value="textarea">Textarea</option>
<option value="select_box">Select Box</option>

</select>
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label class="font-weight-bold">Lebar kolom</label>
<select name="lebar[]" class="form-control form-control-sm disabled1 ">
<?php 
$rowSelect = '';
$rowSelects = '';
for ($i=1; $i <= 10; $i++) { 
$lebarFirst = "";
if ($i == 5) {
$lebarFirst = "selected";
}
$rowSelects .= '<option selected value="col-'.$i.'">'.$i.' Kolom</option>';
$rowSelect = '<option value="col-'.$i.'">'.$i.' Kolom</option>';
echo $rowSelect;
}
?>
</select>
</div>
</div>
<div class="col-lg-1 hide">
<label class="font-weight-bold">Group</label><br>
<input type="checkbox" class="checkbox" name="" value="false" data-id=1>
<input type="hidden" class="checkboxvalue1" name="group[]" value="false">
</div>
<div class="col-lg-4 placement1">
<input type="hidden" name="format[]">
</div>
</div>
<div class="row">
<div class="col-lg-12">
<button id="addrow" class="btn btn-warning btn-sm" type="button"><i class="dashicons dashicons-plus"></i> Tambah Elemen</button>
</div>
<div class="col-lg-12">
<hr>
<label class="font-weight-bold">Footer Pesan</label>
<br><small>Lihat Shortcode <a href="#kamus" data-toggle="modal" data-target="#myModal">Disini..</a></small>
<textarea id="footer_pesan" name="footer_pesan" class="form-control form-control-sm" id="" rows="6"></textarea>
</div>


<div class="col-lg-12">
<hr>
<button name="addform" class="btn-block btn btn-success btn-sm" type="submit"><i class="dashicons dashicons-saved"></i> Simpan</button>
</div>
</div>
</form>
</div>
</div>
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">

<div class="modal-body">
<h3>Shortcode</h3>
<p>
Template text WhatsApp yang dibuat bisa menyisipkan <u>Nama produk dan Link Produk</u>, jadi ketika Customer Anda melakukan chat maka nama produk atau link produk bisa ikut terkirim/tersematkan.
<br>
<br>
berikut perbandinganya/contohnya:
</p>
<p style="padding: 10px;background: #e5e5e5;border: 3px dotted;">
Hallo kak saya ingin pesan produk <b>|NP|</b>
<br>
Link produk : <br>
<b>|PL|</b>
</p>
<b>Jadi</b>
<p style="padding: 10px;background: #e5e5e5;border: 3px dotted;">
Hallo kak saya ingin pesan produk <b>Kaos Premium Polos</b>
<br>
Link produk : <br>
<b>https://xxx.com/produk/kaos-premium</b>
</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>

</div>

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
$(document).on("click", ".simple-form-2" , function() {
$('#judul_form').val('Form Pesanan');
$('#header_pesan').val('Hallo kak, saya mau pesan kaos |NP|, berikut detail alamatnya');
$('#footer_pesan').val('Ongkirnya berapa ya kak?&#10; Terima kasih');
$('.add-element').html(`

<div class="col-lg-12">
<hr>
</div>
<div class="col-lg-3 param-elemen">
<div class="form-group">
<label class="font-weight-bold">Judul elemen</label>
<input type="text" value="Nama Anda" class="disabled1 form-control form-control-sm" name="judul_elemen[]">
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label class="font-weight-bold">Type</label>
<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id="1">
<option selected value="text">Text</option>
<option value="textarea">Textarea</option>
<option value="select_box">Select Box</option>

</select>
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label class="font-weight-bold">Lebar kolom</label>
<select name="lebar[]" class="form-control form-control-sm disabled1 ">
<option value="col-1">1 Kolom</option>
<option value="col-2">2 Kolom</option>
<option value="col-3">3 Kolom</option>
<option value="col-4">4 Kolom</option>
<option selected value="col-5">5 Kolom</option>
<option value="col-6">6 Kolom</option>
<option value="col-7">7 Kolom</option>
<option value="col-8">8 Kolom</option>
<option value="col-9">9 Kolom</option>
<option value="col-10">10 Kolom</option>

</select>    
</select>
</div>
</div>
<div class="col-lg-1 hide">
<label class="font-weight-bold">Group</label><br>
<input type="checkbox" class="checkbox" name="" value="false" data-id="1">
<input type="hidden" class="checkboxvalue1" name="group[]" value="false">
</div>
<div class="col-lg-4 placement1">
<input type="hidden" name="format[]">
</div>

<div class="col-lg-12 numid2">
<hr>
</div>
<div class="col-lg-3 numid2">
<div class="form-group param-elemen">
<label class="font-weight-bold">Judul elemen</label>
<div class="input-group">
<div class="input-group-prepend">
<button type="button" data-id="2" class="delete btn btn-danger btn-sm">X</button>
</div>
<input type="text" value="No WhatsApp" class="disabled2 form-control form-control-sm" name="judul_elemen[]">
</div>
</div>
</div>
<div class="col-lg-2 numid2">
<div class="form-group">
<label class="font-weight-bold">Type</label>
<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id="2">
<option selected value="text">Text</option>
<option value="textarea">Textarea</option>
<option value="select_box">Select Box</option>

</select>
</div>
</div>
<div class="col-lg-2 numid2">
<div class="form-group">
<label class="font-weight-bold">Lebar</label>
<select name="lebar[]" class="form-control form-control-sm disabled2">
<option value="col-1">1 Kolom</option>
<option value="col-2">2 Kolom</option>
<option value="col-3">3 Kolom</option>
<option value="col-4">4 Kolom</option>
<option selected value="col-5">5 Kolom</option>
<option value="col-6">6 Kolom</option>
<option value="col-7">7 Kolom</option>
<option value="col-8">8 Kolom</option>
<option value="col-9">9 Kolom</option>
<option value="col-10">10 Kolom</option>    
</select>
</div>
</div>

<div class="col-lg-1 hide">
<label class="font-weight-bold">Group</label><br>
<input type="checkbox" class="checkbox" name="" value="false" data-id="2">
<input type="hidden" class="checkboxvalue2" name="group[]" value="false">
</div>
<div class="col-lg-4 numid2 placement2"><input type="hidden" name="format[]"></div>

<div class="col-lg-12 numid3">
<hr>
</div>
<div class="col-lg-3 numid3">
<div class="form-group param-elemen">
<label class="font-weight-bold">Judul elemen</label>
<div class="input-group">
<div class="input-group-prepend">
<button type="button" data-id="3" class="delete btn btn-danger btn-sm">X</button>
</div>
<input type="text" class="disabled3 form-control form-control-sm" value="Ukuran" name="judul_elemen[]">
</div>
</div>
</div>
<div class="col-lg-2 numid3">
<div class="form-group">
<label class="font-weight-bold">Type</label>
<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id="3">
<option value="text">Text</option>
<option value="textarea">Textarea</option>
<option selected value="select_box">Select Box</option>

</select>
</div>
</div>
<div class="col-lg-2 numid3">
<div class="form-group">
<label class="font-weight-bold">Lebar</label>
<select name="lebar[]" class="form-control form-control-sm disabled3">
<option value="col-1">1 Kolom</option>
<option value="col-2">2 Kolom</option>
<option value="col-3">3 Kolom</option>
<option value="col-4">4 Kolom</option>
<option selected value="col-5">5 Kolom</option>
<option value="col-6">6 Kolom</option>
<option value="col-7">7 Kolom</option>
<option value="col-8">8 Kolom</option>
<option value="col-9">9 Kolom</option>
<option value="col-10">10 Kolom</option></select>
</div>
</div>

<div class="col-lg-1 hide">
<label class="font-weight-bold">Group</label><br>
<input type="checkbox" class="checkbox" name="" value="false" data-id="3">
<input type="hidden" class="checkboxvalue3" name="group[]" value="false">
</div>
<div class="col-lg-4 numid3 placement3"><label class="font-weight-bold">Masukan List sesuai format</label><textarea name="format[]" placeholder="" rows="8" class="form-control form-control-sm" row="">XL&#10;M&#10;L</textarea></div>

<div class="col-lg-12 numid4">
<hr>
</div>
<div class="col-lg-3 numid4">
<div class="form-group param-elemen">
<label class="font-weight-bold">Judul elemen</label>
<div class="input-group">
<div class="input-group-prepend">
<button type="button" data-id="4" class="delete btn btn-danger btn-sm">X</button>
</div>
<input type="text" class="disabled4 form-control form-control-sm" value="Alamat" name="judul_elemen[]">
</div>
</div>
</div>
<div class="col-lg-2 numid4">
<div class="form-group">
<label class="font-weight-bold">Type</label>
<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id="4">
<option value="text">Text</option>
<option value="textarea">Textarea</option>
<option value="select_box">Select Box</option>

</select>
</div>
</div>
<div class="col-lg-2 numid4">
<div class="form-group">
<label class="font-weight-bold">Lebar</label>
<select name="lebar[]" class="form-control form-control-sm disabled4">
<option value="col-1">1 Kolom</option>
<option value="col-2">2 Kolom</option>
<option value="col-3">3 Kolom</option>
<option value="col-4">4 Kolom</option>
<option selected value="col-5">5 Kolom</option>
<option value="col-6">6 Kolom</option>
<option value="col-7">7 Kolom</option>
<option value="col-8">8 Kolom</option>
<option value="col-9">9 Kolom</option>
<option value="col-10">10 Kolom</option></select>
</div>
</div>

<div class="col-lg-1 hide">
<label class="font-weight-bold">Group</label><br>
<input type="checkbox" class="checkbox" name="" value="false" data-id="4">
<input type="hidden" class="checkboxvalue4" name="group[]" value="false">
</div>
<div class="col-lg-4 numid4 placement4"><input type="hidden" name="format[]"></div>
</div>

<div class="col-lg-3 numid5">
<div class="form-group param-elemen">
<label class="font-weight-bold">Judul elemen</label>
<div class="input-group">
<div class="input-group-prepend">
<button type="button" data-id="5" class="delete btn btn-danger btn-sm">X</button>
</div>
<input type="text" class="disabled5 form-control form-control-sm" value="Alamat Lengkap/Jalan" name="judul_elemen[]">
</div>
</div>
</div>
<div class="col-lg-2 numid5">
<div class="form-group">
<label class="font-weight-bold">Type</label>
<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id="5">
<option value="text">Text</option>
<option selected value="textarea">Textarea</option>
<option value="select_box">Select Box</option>

</select>
</div>
</div>
<div class="col-lg-2 numid5">
<div class="form-group">
<label class="font-weight-bold">Lebar</label>
<select name="lebar[]" class="form-control form-control-sm disabled5">
<option value="col-1">1 Kolom</option>
<option value="col-2">2 Kolom</option>
<option value="col-3">3 Kolom</option>
<option value="col-4">4 Kolom</option>
<option selected value="col-5">5 Kolom</option>
<option value="col-6">6 Kolom</option>
<option value="col-7">7 Kolom</option>
<option value="col-8">8 Kolom</option>
<option value="col-9">9 Kolom</option>
<option value="col-10">10 Kolom</option></select>
</div>
</div>

<div class="col-lg-1 hide">
<label class="font-weight-bold">Group</label><br>
<input type="checkbox" class="checkbox" name="" value="false" data-id="5">
<input type="hidden" class="checkboxvalue4" name="group[]" value="false">
</div>
<div class="col-lg-4 numid5 placement4"><input type="hidden" name="format[]"></div>

`);

});
$(document).on("click", ".simple-form" , function() {
$('#judul_form').val('Form Pesanan');
$('#header_pesan').val('Hallo kak, saya mau pesan |NP|, berikut detail alamatnya');
$('#footer_pesan').val('Terima kasih');
$('.add-element').html(`

<div class="col-lg-12">
<hr>
</div>
<div class="col-lg-3 param-elemen">
<div class="form-group">
<label class="font-weight-bold">Judul elemen</label>
<input type="text" class="disabled1 form-control form-control-sm" name="judul_elemen[]" value="Nama Anda">
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label class="font-weight-bold">Type</label>
<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id="1">
<option selected value="text">Text</option>
<option value="textarea">Textarea</option>
<option value="select_box">Select Box</option>

</select>
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label class="font-weight-bold">Lebar</label>
<select name="lebar[]" class="form-control form-control-sm disabled1 ">
<?php 
echo $rowSelects;
?>
</select>
</div>
</div>

<div class="col-lg-1 hide">
<label class="font-weight-bold">Group</label><br> 
<input type="checkbox" class="checkbox" name="" value="false" data-id="1">
<input type="hidden" class="checkboxvalue1" name="group[]" value="false">
</div>
<div class="col-lg-4 placement1"><input type="hidden" name="format[]"></div>

<div class="col-lg-12 numid2">
<hr>
</div>
<div class="col-lg-3 numid2">
<div class="form-group param-elemen">
<label class="font-weight-bold">Judul elemen</label>
<div class="input-group">
<div class="input-group-prepend">
<button type="button" data-id="2" class="delete btn btn-danger btn-sm">X</button>
</div>
<input type="text" class="disabled2 form-control form-control-sm" name="judul_elemen[]" value="Nomor WhatsApp">
</div>
</div>
</div>
<div class="col-lg-2 numid2">
<div class="form-group">
<label class="font-weight-bold">Type</label>
<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id="2">
<option selected value="text">Text</option>
<option value="textarea">Textarea</option>
<option value="select_box">Select Box</option>

</select>
</div>
</div>
<div class="col-lg-2 numid2">
<div class="form-group">
<label class="font-weight-bold">Lebar</label>
<select name="lebar[]" class="form-control form-control-sm disabled2 " >
<?php 
echo $rowSelects;
?>
</select>
</div>
</div>

<div class="col-lg-1 hide">
<label class="font-weight-bold">Group</label><br>
<input type="checkbox" class="checkbox" name="" value="false" data-id="2">
<input type="hidden" class="checkboxvalue2" name="group[]" value="false">
</div>
<div class="col-lg-4 numid2 placement2"><input type="hidden" name="format[]"></div>

<div class="col-lg-12 numid3">
<hr>
</div>
<div class="col-lg-3 numid3">
<div class="form-group param-elemen">
<label class="font-weight-bold">Judul elemen</label>
<div class="input-group">
<div class="input-group-prepend">
<button type="button" data-id="3" class="delete btn btn-danger btn-sm">X</button>
</div>
<input type="text" class="disabled3 form-control form-control-sm" name="judul_elemen[]" value="Alamat Lengkap">
</div>
</div>
</div>
<div class="col-lg-2 numid3">
<div class="form-group">
<label class="font-weight-bold">Type</label>
<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id="3">
<option value="text">Text</option>
<option selected value="textarea">Textarea</option>
<option value="select_box">Select Box</option>

</select>
</div>
</div>
<div class="col-lg-2 numid3">
<div class="form-group">
<label class="font-weight-bold">Lebar</label>
<select name="lebar[]" class="form-control form-control-sm disabled3 "><?php 
echo $rowSelects;
?>
</select>
</div>
</div>

<div class="col-lg-1 hide">
<label class="font-weight-bold">Group</label><br>
<input type="checkbox" class="checkbox" name="" value="false" data-id="3">
<input type="hidden" class="checkboxvalue3" name="group[]" value="false">
</div>
<div class="col-lg-4 numid3 placement3">
<input type="hidden" name="format[]">
</div>

<div class="col-lg-12 numid4">
<hr>
</div>
<div class="col-lg-3 numid4">
<div class="form-group param-elemen">
<label class="font-weight-bold">Judul elemen</label>
<div class="input-group">
<div class="input-group-prepend">
<button type="button" data-id="4" class="delete btn btn-danger btn-sm">X</button>
</div>
<input type="text" class="disabled4 form-control form-control-sm" name="judul_elemen[]" value="Catatan Pesanan">
</div>
</div>
</div>
<div class="col-lg-2 numid4">
<div class="form-group">
<label class="font-weight-bold">Type</label>
<select name="type_elemen[]" class="form-control form-control-sm selectbox" data-id="4">
<option value="text">Text</option>
<option selected value="textarea">Textarea</option>
<option value="select_box">Select Box</option>

</select>
</div>
</div>
<div class="col-lg-2 numid4">
<div class="form-group">
<label class="font-weight-bold">Lebar</label>
<select name="lebar[]" class="form-control form-control-sm disabled4 "><?php 
echo $rowSelects;
?>
</select>
</div>
</div>

<div class="col-lg-1 hide">
<label class="font-weight-bold">Group</label><br>

<input type="checkbox" class="checkbox" name="" value="false" data-id="4">
<input type="hidden" class="checkboxvalue4" name="group[]" value="false">
</div>
<div class="col-lg-4 numid4 placement4">
<input type="hidden" name="format[]">
</div>
</div>
`);
});
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
<div class="col-lg-3 numid`+numrow+`">
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
<div class="col-lg-2 numid`+numrow+`">
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
$('.toplevel_page_rebiovw_list').addClass('wp-has-current-submenu');
});
</script>