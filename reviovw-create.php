<?php function rebiovw_create() {
    //insert
    global $wpdb;
    $table_name = $wpdb->prefix . "rebiovw_template";
    $tbl_tombol = $wpdb->prefix . "rebiovw_tombol";
    $table_line = $wpdb->prefix . "rebiovw_template_line";
    if (isset($_POST['insert'])) {

        $title = $_POST["title"];
        $des = $_POST["des"];
        $btn_text = $_POST['text_btn'];
        $posisi = $_POST['posisi'];

        $wpdb->insert(
                $table_name,
                array(
                    'title' => $title, 
                    'des' => $des,
                    'btn_text' => $btn_text,
                    'posisi' => $posisi,
                    'id_tombol' => $_POST['tombol'],
                    'id_form' => $_POST['id_form'],
                )
        );
        $lastid = $wpdb->insert_id;
        for ($i=0; $i < count($_POST['embeded']); $i++) { 
            $wpdb->insert(
                $table_line,  
                array(
                    'id_template' => $lastid,
                    'produk_id' => $_POST['embeded'][$i]
                )
            );
        }

        $message ="Template telah ditambahkan !";

    }
    ?>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
     <?php require_once(ROOTDIR . 'style-admin.css'); ?>
    </style>
    

    <div class="wrap">

        <h2>Tambah Template Baru</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a class="btn btn-sm btn-primary" href="<?php echo admin_url('admin.php?page=rebiovw_list'); ?>"><span class="dashicons dashicons-arrow-left-alt"></span> List Template</a>
                <br>
                <br>
            </div>
            <br class="clear">
        </div>
        <br>
        <br>
        <div style="background-color: #f2f2f2;" class="p-2">
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="return confirm('Simpan template ini ?')">
                <div class="form-group">
                    <label class="font-weight-bold">Judul Template</label>
                    <input type="text" required class="form-control form-control-sm" name="title" value="">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Event</label><br>
                    <input type="radio" name="event" checked id="s"><label for="s">Standard</label> &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="event" id="f"><label for="f">Form</label>
                    <br>
                    <hr>
                </div>
                <div id="form" class="hide">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Pilih Form</label><br>
                            <small>Belum ada Form ?, buat <a href="<?php echo admin_url('admin.php?page=rebiovw_create_form'); ?>">disini</a></small>
                            <select name="id_form" class="form-control-sm form-control">
                                <?php 
                                    $tbl = $wpdb->prefix . "rebiovw_form";

                                    // $formdata = $wpdb->get_row( "SELECT * FROM $tbl");
                                    $formdata = $wpdb->get_results("SELECT * from $tbl");

                                    foreach ($formdata as $form) {
                                ?>
                                    <option value="<?php echo $form->id ?>"><?php echo $form->title ?></option>
                                <?php } ?>
                            </select>
                            <small><code>*</code><i>Ketika Tombol diklik maka form ini akan terbuka !</i></small>
                        </div>
                    </div>
                    <hr>
                </div>
                <div id="standard" class="">
                    <div class="form-group">
                        <label class="font-weight-bold">Template Text</label>
                        <small>Untuk menggunakan <i>Text Miring</i>, <b>Tebal</b> dll, Gunakan kode seperti <code>*tebal* _italic_ ~coret~</code></small>
                        <br>
                        <small>Lihat Shortcode <a href="#kamus" data-toggle="modal" data-target="#myModal">Disini..</a></small>
                        <textarea class="form-control" cols="30" name="des" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Text di tombol</label>
                    <input type="text" name="text_btn" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Tema Tombol</label>

                    <select name="tombol" class="form-control">
                        <option value="0">Default</option>
                        <?php 
                            $tombolQuery = $wpdb->get_results($wpdb->prepare("SELECT * from $tbl_tombol"));
                            foreach ($tombolQuery as $tombolQueryShow) {
                        ?>
                            <option value="<?php echo $tombolQueryShow->id ?>"><?php echo $tombolQueryShow->nama_tombol ?></option>
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
                            <label class="font-weight-bold">Terapkan ke produk :</label><br>
                            <small>
                                <code>*</code>Produk hanya boleh memiliki 1 Template saja
                            </small>
                            <br>
                            <select name="embeded[]" class="form-control ms" multiple="multiple">
                            <?php 
                                $tblTemplateLine = $wpdb->prefix . "rebiovw_template_line";
                                                                
                                $loop = new WP_Query( array( 'post_type' => 'product') ); 
                                while ( $loop->have_posts() ) : $loop->the_post();
                                    $arrayTemplateLine = $wpdb->get_row("SELECT * from $tblTemplateLine where produk_id=".get_the_ID());
                                    if(!$arrayTemplateLine){
                            ?>
                                <option value="<?php echo get_the_ID() ?>"><?php echo get_the_title() ?></option>
                            <?php } endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div id="menu1" class="container tab-pane fade p-0">
                        <br>
                        <label class="font-weight-bold">Tempatkan Posisi di :</label>
                        <p>
                            <code>*</code>Posisi di beberapa tema mungkin berbeda dari semestinya karena dipengaruhi oleh tema wordpress/woocommerce yang berbeda-beda
                        </p>
                        <select name="posisi" class="form-control">
                            <option value="woocommerce_before_single_product">1. Tampil di paling atas (sebelum judul, foto dll)</option>
                            <option value="woocommerce_before_single_product_summary">2. Tampil Sebelum Ringkasan Produk</option>
                            <option value="woocommerce_single_product_summary">3. Tampil di tas judul Produk</option>
                            <option value="woocommerce_before_add_to_cart_form">4. Tampil sebelum Form Add to Cart</option>
                            <option value="woocommerce_before_variations_form">5. Tampil sebelum varian produk</option>
                            <option value="woocommerce_before_add_to_cart_button">6. Tampil sebelum tombol Add to Cart</option>
                            <option value="woocommerce_before_single_variation">7. Tampil sebelum single varian</option>
                            <option value="woocommerce_single_variation">8. Tampil di single varian</option>
                            <option value="woocommerce_before_add_to_cart_quantity">9. Tampil di sebelum Add to Cart Quantity</option>
                            <option value="woocommerce_after_add_to_cart_quantity">10. Tampil sesudah Add to Cart Quantity</option>
                            <option value="woocommerce_after_single_variation">11. Tampil sebelum single varian</option>
                            <option value="woocommerce_after_add_to_cart_button">12. Tampil sesudah tombol Add to Cart</option>
                            <option value="woocommerce_after_variations_form">13. Tampil sesudah form variasi</option>
                            <option value="woocommerce_after_add_to_cart_form">14. Tampil sesudah Add to Cart form</option>
                            <option value="woocommerce_share">15. Tampil disekitar tombol share</option>
                        </select>
                    </div>
                    
                </div>
                
                <br>
                <button type="submit" name="insert" class="btn btn-success"><span class="dashicons dashicons-saved"></span> Simpan & Terapkan</button>
            </form>
        </div>

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
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
            $('.toplevel_page_rebiovw_list').addClass('wp-has-current-submenu');
            
        });
    </script>
    <?php
}