<?php function rebiovw_update() {
    global $wpdb;
    $id = @$_GET['id'];
    $title = @$_POST["title"];
    $des = @$_POST["des"];
    $btn_text = @$_POST['text_btn'];
    $produk = @$exproduk;
    $posisi = @$_POST['posisi'];
    $table_name = $wpdb->prefix . "rebiovw_template";
    $table_template_line = $wpdb->prefix . "rebiovw_template_line";
    $tbl_tombol = $wpdb->prefix . "rebiovw_tombol";
    
     
//update
    if (isset($_POST['update'])) {
        $form = null;
        if ($_POST['event'] == 'f') {
            $form = $_POST['id_form'];
        }
        $wpdb->update(
                $table_name,
                array(
                    'title' => $title, 
                    'des' => $des,
                    'btn_text' => $btn_text,
                    'posisi' => $posisi,
                    'id_tombol' => $_POST['tombol'],
                    'id_form' => $form,
                ),
                array('id' => $id)
        );
        $wpdb->query($wpdb->prepare("DELETE FROM $table_template_line WHERE id_template = %s", $id));
        for ($i=0; $i < count($_POST['embeded']); $i++) { 
            $wpdb->insert(
                $table_template_line, //table
                array(
                    'id_template' => $id,
                    'produk_id' => $_POST['embeded'][$i]
                )
            );
        }

        $message = "Template telah update !";
        header('location:'.admin_url('admin.php?page=rebiovw_update&id='.$id).'&msg='.$message);

    }else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
        $wpdb->query($wpdb->prepare("DELETE FROM $table_template_line WHERE id_template = %s", $id));
    } else {//selecting value to update	
        $schools = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where id=%s", $id));
        foreach ($schools as $s) {
            $title = $s->title;
            $des = $s->des;
            $posisi = $s->posisi;
            $text_btn = $s->btn_text;
            $id_tombol = $s->id_tombol;
            $id_form = $s->id_form;
            // $produk = explode(':',$s->produk_id);
            $hideForm = '';
            $hideDes = 'hide';

            $fChecked = 'checked';
            $sChecked = '';

            if ($id_form == null || empty($id_form)) {
                $sChecked = 'checked';
                $fChecked = '';

                $hideForm = 'hide';
                $hideDes = '';
            }
        }
    }
    
    ?>
        <style>
     <?php require_once(ROOTDIR . 'style-admin.css'); ?>
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <div class="wrap">
        <?php if (isset($_GET['msg'])): ?><div class="updated"><p><?php echo $_GET['msg']; ?></p></div><?php endif; ?>
        <h2><i class="dashicons dashicons-edit"></i> Update/Delete Template</h2>

        <?php if (@$_POST['delete']) { ?>
            <div class="updated"><p>Template berhasil dihapus</p></div>
            <a href="<?php echo admin_url('admin.php?page=rebiovw_list') ?>">&laquo; Kembali</a>

        <?php } else if (@$_POST['update']) { ?>
            <div class="updated"><p>Template berhasil di update</p></div>
            <a href="<?php echo admin_url('admin.php?page=rebiovw_list') ?>">&laquo; Kembali</a>

        <?php } else { ?>
            <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/rebi-ovw/style-admin.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

            <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
            <a class="btn btn-sm btn-primary" href="<?php echo admin_url('admin.php?page=rebiovw_list'); ?>"><span class="dashicons dashicons-arrow-left-alt"></span> List Template</a>
            <br>
            <br>
            <div style="background-color: #eaeaea;" class="p-2">
                <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <div class="form-group">
                    <label class="font-weight-bold">Judul Template</label>
                    <input type="text" required class="form-control form-control-sm" name="title" value="<?php echo $title ?>">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Event</label><br>
                    <input type="radio" name="event" value="s" <?php echo $sChecked ?> id="s"><label for="s">Standard</label> &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="event" value="f" <?php echo $fChecked ?> id="f"><label for="f">Form</label>
                    <br>
                    <hr>
                </div>
                <div id="form" class="<?php echo $hideForm ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Pilih Form</label><br>
                            <small>Belum ada Form ?, buat <a href="<?php echo admin_url('admin.php?page=rebiovw_create_form'); ?>">disini</a></small>
                            <select name="id_form" class="form-control-sm form-control">
                                <?php 
                                    $tbl = $wpdb->prefix . "rebiovw_form";

                                    // $formdata = $wpdb->get_row( "SELECT * FROM $tbl");
                                    $formdata = $wpdb->get_results($wpdb->prepare("SELECT * from $tbl"));

                                    foreach ($formdata as $form) {
                                        $selected = '';
                                        if ($id_form == $form->id) {
                                            $selected = 'selected';
                                        }
                                ?>
                                    <option <?php echo $selected ?> value="<?php echo $form->id ?>"><?php echo $form->title ?></option>
                                <?php } ?>
                            </select>
                            <small><code>*</code><i>Ketika Tombol diklik maka form ini akan terbuka !</i></small>
                        </div>
                    </div>
                    <hr>
                </div>
                <div id="standard" class="<?php echo $hideDes ?>">
                    <div class="form-group">
                        <label class="font-weight-bold">Template Text</label>
                        <small>Untuk menggunakan <i>Text Miring</i>, <b>Tebal</b> dll, Gunakan kode seperti <code>*tebal* _italic_ ~coret~</code></small>
                        <br>
                        <small>Lihat Shortcode <a href="#kamus" data-toggle="modal" data-target="#myModal">Disini..</a></small>
                        <textarea class="form-control" cols="30" name="des" rows="10"><?php echo $des ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Text di tombol</label>
                    <input type="text" name="text_btn" class="form-control" value="<?php echo $text_btn ?>">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Tema Tombol</label>

                    <select name="tombol" class="form-control">
                        <option value="0">Default</option>
                        <?php 
                            $tombolQuery = $wpdb->get_results($wpdb->prepare("SELECT * from $tbl_tombol"));
                            foreach ($tombolQuery as $tombolQueryShow) {
                        ?>
                            <option <?php if($tombolQueryShow->id == $id_tombol){ echo 'selected'; } ?> value="<?php echo $tombolQueryShow->id ?>"><?php echo $tombolQueryShow->nama_tombol ?></option>
                        <?php } ?>
                    </select>
                </div>
                <hr>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home">Penerapan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu1">Pengaturan</a>
                    </li>
                </ul>
                  <!-- Tab panes -->
                <div class="tab-content">
                    <div id="home" class="container tab-pane active p-0">
                        <br>
                        <div class="form-group">
                            <label class="font-weight-bold">Terapkan ke produk :</label>
                            <br>
                            <select name="embeded[]" class="form-control ms" multiple="multiple">
                            <?php                               

                                $selected = '';
                                $loop = new WP_Query( array( 'post_type' => 'product') ); 
                                while ( $loop->have_posts() ) : $loop->the_post();

                                    $selected = '';

                                    $produkQuery = $wpdb->get_results($wpdb->prepare("SELECT * from $table_template_line where id_template=%s", $id));
                                    
                                    foreach ($produkQuery as $produkShow) {
                                        if ($produkShow->produk_id == get_the_ID()) {
                                            $selected = 'selected';
                                        }    
                                    }
                            ?>
                                <option <?php echo $selected ?> value="<?php echo get_the_ID() ?>"><?php echo get_the_title() ?></option>
                            <?php endwhile; ?>
                                    
                            </select>
                        </div>
                    </div>
                    <div id="menu1" class="container tab-pane fade p-0">
                        <br>
                        <label class="font-weight-bold">Tempatkan Posisi di :</label>
                        <select name="posisi" class="form-control">
                            <option <?php if($posisi == 'woocommerce_before_single_product'){ echo 'selected'; } ?> value="woocommerce_before_single_product">1. Tampil di paling atas (sebelum judul, foto dll)</option>
                            <option <?php if($posisi == 'woocommerce_before_single_product_summary'){ echo 'selected'; } ?> value="woocommerce_before_single_product_summary">2. Tampil Sebelum Ringkasan Produk</option>
                            <option <?php if($posisi == 'woocommerce_single_product_summary'){ echo 'selected'; } ?> value="woocommerce_single_product_summary">3. Tampil di tas judul Produk</option>
                            <option <?php if($posisi == 'woocommerce_before_add_to_cart_form'){ echo 'selected'; } ?> value="woocommerce_before_add_to_cart_form">4. Tampil sebelum Form Add to Cart</option>
                            <option <?php if($posisi == 'woocommerce_before_variations_form'){ echo 'selected'; } ?> value="woocommerce_before_variations_form">5. Tampil sebelum varian produk</option>
                            <option <?php if($posisi == 'woocommerce_before_add_to_cart_button'){ echo 'selected'; } ?> value="woocommerce_before_add_to_cart_button">6. Tampil sebelum tombol Add to Cart</option>
                            <option <?php if($posisi == 'woocommerce_before_single_variation'){ echo 'selected'; } ?> value="woocommerce_before_single_variation">7. Tampil sebelum single varian</option>
                            <option <?php if($posisi == 'woocommerce_single_variation'){ echo 'selected'; } ?> value="woocommerce_single_variation">8. Tampil di single varian</option>
                            <option <?php if($posisi == 'woocommerce_before_add_to_cart_quantity'){ echo 'selected'; } ?> value="woocommerce_before_add_to_cart_quantity">9. Tampil di sebelum Add to Cart Quantity</option>
                            <option <?php if($posisi == 'woocommerce_after_add_to_cart_quantity'){ echo 'selected'; } ?> value="woocommerce_after_add_to_cart_quantity">10. Tampil sesudah Add to Cart Quantity</option>
                            <option <?php if($posisi == 'woocommerce_after_single_variation'){ echo 'selected'; } ?> value="woocommerce_after_single_variation">11. Tampil sebelum single varian</option>
                            <option <?php if($posisi == 'woocommerce_after_add_to_cart_button'){ echo 'selected'; } ?> value="woocommerce_after_add_to_cart_button">12. Tampil sesudah tombol Add to Cart</option>
                            <option <?php if($posisi == 'woocommerce_after_variations_form'){ echo 'selected'; } ?> value="woocommerce_after_variations_form">13. Tampil sesudah form variasi</option>
                            <option <?php if($posisi == 'woocommerce_after_add_to_cart_form'){ echo 'selected'; } ?> value="woocommerce_after_add_to_cart_form">14. Tampil sesudah Add to Cart form</option>
                            <option <?php if($posisi == 'woocommerce_share'){ echo 'selected'; } ?> value="woocommerce_share">15. Tampil disekitar tombol share</option>
                        </select>
                    </div>
                    
                </div>
                <br>
                <button type='submit' onclick="return confirm('Yakim menyimpan perubahan ?')" name="update" class='btn btn-sm btn-success'><span class="dashicons dashicons-saved"></span> Simpan Perubahan </button>&nbsp;&nbsp;
                <input type='submit' name="delete" value='Hapus Template ini' class='btn btn-sm btn-danger' onclick="return confirm('Yakin menghapus Template ini ?')">
            </form>
            </div>
        <?php } ?>

    </div>
    <script>
        $(document).ready(function() {
            $('#s').click(function(){
                $('#standard').show();
                $('#form').hide();
            });
            $('#f').click(function(){
                $('#standard').hide();
                $('#form').show();
            });

            $('.ms').select2();
        });
    </script>
    <?php
}