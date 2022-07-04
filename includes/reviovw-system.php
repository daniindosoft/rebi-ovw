<?php


function rebiovw_include_icon(){
    echo '
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />';
}
function rebiovw_wrap($hook){
    global $wpdb;
    $tbl_template = $wpdb->prefix . "rebiovw_template";
    $tbl_tombol = $wpdb->prefix . "rebiovw_tombol";
    $tbl_template_line = $wpdb->prefix . "rebiovw_template_line";
    $tbl_setting = $wpdb->prefix . "rebiovw_setting";
    $tbl_form = $wpdb->prefix . "rebiovw_form";

    $nowa = $wpdb->get_row( "SELECT * FROM $tbl_setting");
    $rows = $wpdb->get_row( $wpdb->prepare( "SELECT *, t.id_form as idn, t.title as judul_formnya FROM $tbl_template as t join $tbl_template_line as tl on t.id = tl.id_template left join $tbl_tombol as btn on btn.id = t.id_tombol where t.posisi ='".$hook."' and tl.produk_id = %d", get_the_ID() ) );

    if (!empty($rows->btn_text)) {
        $header = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $tbl_form where id = %d", $rows->idn));
        rebiovw_include_icon(); 
        $urlcode = rebiovwContentUrlEncode($rows->des);

        if ($rows->id_form >= 1) {
            rebiovw_style($hook);
            rebiovw_modal($hook, $rows->btn_text, $rows->idn, $rows->css, $rows->judul_formnya, $rows->btn_text, rebiovwContentUrlEncode($header->header_pesan), rebiovwContentUrlEncode($header->footer_pesan), $nowa->nowa);
        }else{
            echo '<a style="'.$rows->css.'" href="https://api.whatsapp.com/send?phone='.$nowa->nowa.'&text='.$urlcode.'" target="_blank" class="button button-success"> <i class="fab fa-whatsapp"></i> '.$rows->btn_text.' </a>';
        }
    }
}

function rebiovwContentUrlEncode($des){
    $kode = ["|NP|", "|PL|"];
    $trans   = ['*'.get_the_title().'*', '*'.get_the_permalink().'*'];
    $deskripsi = str_replace($kode, $trans, $des);
    return  urlencode($deskripsi);
}
function rebiovw_woocommerce_before_single_product_register(){
    rebiovw_wrap('woocommerce_before_single_product');


}

function rebiovw_woocommerce_before_single_product_summary_register(){
    rebiovw_wrap('woocommerce_before_single_product_summary');

}

function rebiovw_woocommerce_single_product_summary_register(){
    rebiovw_wrap('woocommerce_single_product_summary');


}

function rebiovw_woocommerce_before_variations_form_register(){
    rebiovw_wrap('woocommerce_before_variations_form');

}

function rebiovw_woocommerce_before_add_to_cart_button_register(){
    rebiovw_wrap('woocommerce_before_add_to_cart_button');

}

function rebiovw_woocommerce_before_single_variation_register(){
    rebiovw_wrap('woocommerce_before_single_variation');
}

function rebiovw_woocommerce_single_variation_register(){
    rebiovw_wrap('woocommerce_single_variationon');

}

function rebiovw_woocommerce_before_add_to_cart_quantity_register(){
    rebiovw_wrap('woocommerce_before_add_to_cart_quantity');

}

function rebiovw_woocommerce_after_add_to_cart_quantity_register(){
    rebiovw_wrap('woocommerce_after_add_to_cart_quantity');

}

function rebiovw_woocommerce_after_single_variation_register(){
    rebiovw_wrap('woocommerce_after_single_variation');

}

function rebiovw_woocommerce_after_add_to_cart_button_register(){
    rebiovw_wrap('woocommerce_after_add_to_cart_button');

}

function rebiovw_woocommerce_after_variations_form_register(){
    rebiovw_wrap('woocommerce_after_variations_form');

}

function rebiovw_woocommerce_after_add_to_cart_form_register(){
    rebiovw_wrap('woocommerce_after_add_to_cart_form');

}

function rebiovw_woocommerce_share_register(){
    rebiovw_wrap('woocommerce_sharegle_variation');
}

function rebiovw_woocommerce_before_add_to_cart_form_register() {
    rebiovw_wrap('woocommerce_before_add_to_cart_form');

}
function rebiovw_get_form_field($dataLine){
     
    $pregVarjs = "*".ucwords($dataLine->judul_elemen)."*";
    
    $elemen0 = explode(' ',$dataLine->type_elemen)[0];
    $elemen1 = explode(' ',$dataLine->type_elemen)[1];

    // $datalines .= $dataLine->judul_elemen.' - '. $dataLine->type_elemen. ' - '. $dataLine->lebar. ' - '. $dataLine->format.'<br>';
    if ($elemen0 == 'text') {
        $datalines .= '<div class="'.$dataLine->lebar.'"><label>'.ucwords($dataLine->judul_elemen).'</label><input placeholder="Masukan '.$dataLine->judul_elemen.'" name="'.$dataLine->id.'x_x'.$pregVarjs.'" data-value-form="'.ucwords($dataLine->judul_elemen).'" type="text"></div>';

    }elseif($elemen0 == 'textarea'){
        $datalines .= '<div class="'.$dataLine->lebar.'"><label>'.ucwords($dataLine->judul_elemen).'</label><textarea placeholder="Masukan '.$dataLine->judul_elemen.'" name="'.$dataLine->id.'x_x'.$pregVarjs.'" data-value-form="'.ucwords($dataLine->judul_elemen).'"></textarea></div>';

    }elseif($elemen0 == 'select_box'){
        $data = explode(PHP_EOL, $dataLine->format);
        $dataOption = '';
        foreach ($data as $dataOptions) {
            $dataOption .= '<option value="'.trim($dataOptions).'">'.trim($dataOptions).'</option>';
        }
        $datalines .= '<div class="'.$dataLine->lebar.'"><label>'.ucwords($dataLine->judul_elemen).'</label>
            <select name="'.$dataLine->id.'x_x'.$pregVarjs.'">
                '.$dataOption.'
            </select></div>
        ';

    }elseif($elemen0 == 'alamat'){
        $datalines .= '
            <div class="'.$dataLine->lebar.'">
                <label>'.ucwords($dataLine->judul_elemen).'</label>
                <input placeholder="Cari '.$dataLine->judul_elemen.'/masukan alamat lebih spesifik" type="text" name="'.$dataLine->id.'x_x'.$pregVarjs.'" data-value-form="'.ucwords($dataLine->judul_elemen).'" id="alamat">
                <ul class="rebiovw_alamat">
                    <li>Tunggu..</li>
                </ul>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>
            function rebiovw_alamat(x){
                $("#alamat").val(x);
                $(".rebiovw_alamat").hide();            
            }
            $(document).ready(function(){
                $(".rebiovw_alamat").hide();
                $(document).click(function(){
                    $(".rebiovw_alamat").hide();
                });
                function delay(callback, ms) {
                  var timer = 0;
                  return function() {
                    var context = this, args = arguments;
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                      callback.apply(context, args);
                    }, ms || 0);
                  };
                }
               
                $("#alamat").keyup(delay(function (e) {
                    $(".rebiovw_alamat").show();
                    $(".rebiovw_alamat").html("<li>Mohon tunggu..</li>");
                    var varname = $("#alamat").val();
                    jQuery.ajax({
                        type: "POST",
                        url: "'.$url.'",
                        data: { 
                            "action" : "rebiovw-alamat",
                            "nama" : varname,
                        },
                        success: function(a) { 
                            $(".rebiovw_alamat").html(a);
                            
                        },
                        error: function (request, status, error) {
                            alert(request.responseText);
                        }
                    });
                }, 500));
              });
            </script>
        ';

    }else{
        $datalines .= '<div class="'.$dataLine->lebar.'"><label>'.ucwords($dataLine->judul_elemen).'</label><input placeholder="Masukan '.$dataLine->judul_elemen.'" name="'.$dataLine->id.'x_x'.$pregVarjs.'" data-value-form="'.ucwords($dataLine->judul_elemen).'" type="text"></div>';
    }
    return $datalines;
}
function rebiovw_modal($hook, $text, $id, $style= '', $judul_formnya, $btn_text, $text_header, $text_footer, $nowa){
    global $wpdb;

    $tbl = $wpdb->prefix . "rebiovw_form_line";
    $tbl_alamat = $wpdb->prefix . "rebiovw_region";
    
    $rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $tbl where id_form = %d", $id ) );
    $alamat = $wpdb->get_results("SELECT nama FROM $tbl_alamat");
    
    $datalines = '<h4>'.ucwords($judul_formnya).'</h4><div id="rebiovw_sendwa_form"><div class="rebiovw-grid">';
    $varJsField = '';    
    $url = get_site_url()."/wp-admin/admin-post.php";
    foreach($rows as $dataLine){
        $pregVarjs = "*".ucwords($dataLine->judul_elemen)."*";
        
        $elemen0 = explode(' ',$dataLine->type_elemen)[0];
        $elemen1 = explode(' ',$dataLine->type_elemen)[1];

        // $datalines .= $dataLine->judul_elemen.' - '. $dataLine->type_elemen. ' - '. $dataLine->lebar. ' - '. $dataLine->format.'<br>';
        if ($elemen0 == 'text') {
            $datalines .= '<div class="'.$dataLine->lebar.'"><label>'.ucwords($dataLine->judul_elemen).'</label><input placeholder="Masukan '.$dataLine->judul_elemen.'" name="'.$dataLine->id.'x_x'.$pregVarjs.'" data-value-form="'.ucwords($dataLine->judul_elemen).'" type="text"></div>';

        }elseif($elemen0 == 'textarea'){
            $datalines .= '<div class="'.$dataLine->lebar.'"><label>'.ucwords($dataLine->judul_elemen).'</label><textarea placeholder="Masukan '.$dataLine->judul_elemen.'" name="'.$dataLine->id.'x_x'.$pregVarjs.'" data-value-form="'.ucwords($dataLine->judul_elemen).'"></textarea></div>';

        }elseif($elemen0 == 'select_box'){
            $data = explode(PHP_EOL, $dataLine->format);
            $dataOption = '';
            foreach ($data as $dataOptions) {
                $dataOption .= '<option value="'.trim($dataOptions).'">'.trim($dataOptions).'</option>';
            }
            $datalines .= '<div class="'.$dataLine->lebar.'"><label>'.ucwords($dataLine->judul_elemen).'</label>
                <select name="'.$dataLine->id.'x_x'.$pregVarjs.'">
                    '.$dataOption.'
                </select></div>
            ';

        }elseif($elemen0 == 'alamat'){
            $datalines .= '
                <div class="'.$dataLine->lebar.'">
                    <label>'.ucwords($dataLine->judul_elemen).'</label>
                    <input placeholder="Cari '.$dataLine->judul_elemen.'/masukan alamat lebih spesifik" type="text" name="'.$dataLine->id.'x_x'.$pregVarjs.'" data-value-form="'.ucwords($dataLine->judul_elemen).'" id="alamat">
                    <ul class="rebiovw_alamat">
                        <li>Tunggu..</li>
                    </ul>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script>
                function rebiovw_alamat(x){
                    $("#alamat").val(x);
                    $(".rebiovw_alamat").hide();            
                }
                $(document).ready(function(){
                    $(".rebiovw_alamat").hide();
                    $(document).click(function(){
                        $(".rebiovw_alamat").hide();
                    });
                    function delay(callback, ms) {
                      var timer = 0;
                      return function() {
                        var context = this, args = arguments;
                        clearTimeout(timer);
                        timer = setTimeout(function () {
                          callback.apply(context, args);
                        }, ms || 0);
                      };
                    }
                   
                    $("#alamat").keyup(delay(function (e) {
                        $(".rebiovw_alamat").show();
                        $(".rebiovw_alamat").html("<li>Mohon tunggu..</li>");
                        var varname = $("#alamat").val();
                        jQuery.ajax({
                            type: "POST",
                            url: "'.$url.'",
                            data: { 
                                "action" : "rebiovw-alamat",
                                "nama" : varname,
                            },
                            success: function(a) { 
                                $(".rebiovw_alamat").html(a);
                                
                            },
                            error: function (request, status, error) {
                                alert(request.responseText);
                            }
                        });
                    }, 500));
                  });
                </script>
            ';

        }else{
            $datalines .= '<div class="'.$dataLine->lebar.'"><label>'.ucwords($dataLine->judul_elemen).'</label><input placeholder="Masukan '.$dataLine->judul_elemen.'" name="'.$dataLine->id.'x_x'.$pregVarjs.'" data-value-form="'.ucwords($dataLine->judul_elemen).'" type="text"></div>';
        }
    }
    $datalines .= '</div></div>';

    echo '
        <button id="myBtn'.$hook.'" style="'.$style.'" type="button" class="button button-success"><i class="fab fa-whatsapp"></i>'.$text.'</button>
        <div id="myModal'.$hook.'" class="modal">
          <div class="modal-content">
              
                    <span class="rebiovw_close">&times;</span>
                    '.$datalines.'
                    <div class="rebiovw-grid">
                        <div class="col-10">
                            <button class="button button-success button-small rebiovw_100p" type="button" onclick="rebiovw_sendwa()"><i class="fab fa-whatsapp"></i> '.$btn_text.'</button>
                        </div>
                    </div>
              
          </div>
        </div>

        <script>
        function rebiovw_sendwa(){
            jQuery(function($) {
                var rebiovwserialize = $("#rebiovw_sendwa_form input, #rebiovw_sendwa_form textarea, #rebiovw_sendwa_form select").serialize();
                
                var rebiovw_text = "'.$text_header.'%0A%0A";
                var rebiovw_text_data = "";
                var idform = "'.$id.'";
                $.each(rebiovwserialize.split("&"), function (index, elem) {
                     rebiovw_text += elem.replace("="," = ").split("x_x")[1]+"%0A";
                     rebiovw_text_data += elem+"{}";
                });
                rebiovw_text += "%0A'.$text_footer.'";
                $.ajax({
                    type: "POST",
                    url: "'.$url.'",
                    data: { 
                        "action" : "rebiovw-pesanan",
                        "data" : rebiovw_text_data,
                        "id_form" : idform,
                    },
                    success: function(a) { 
                        window.open("https://api.whatsapp.com/send?phone='.$nowa.'&text="+rebiovw_text,"_blank");
                    }
                })
                });

        }
        var '.$hook.'_modal = document.getElementById("myModal'.$hook.'");

        var '.$hook.'btn = document.getElementById("myBtn'.$hook.'");

        var span = document.getElementsByClassName("rebiovw_close")[0];

        '.$hook.'btn.onclick = function() {
          '.$hook.'_modal.style.display = "block";
        }

        span.onclick = function() {
          '.$hook.'_modal.style.display = "none";
        }

        window.onclick = function(event) {
          if (event.target == '.$hook.'_modal) {
            '.$hook.'_modal.style.display = "none";
          }
        }
        </script>
    ';
}
 
function rebiovw_style(){
    echo "<style>";
    include_once(ROOTDIR.'rebiovw-style-form.css');
    echo "</style>";
}
add_action( 'admin_post_nopriv_rebiovw-pesanan', 'rebiovw_pesanan' );
add_action( 'admin_post_rebiovw-pesanan', 'rebiovw_pesanan' );
function rebiovw_pesanan(){
    global $wpdb;
    $table_name = $wpdb->prefix . "rebiovw_pesanan";
    $split = explode('{}', $_POST['data']);
    $dateUnik = date('Ymd0his').'0'.rand(10,9999);
    foreach ($split as $val) {
        $replace = str_replace('*','',urldecode($val));
        $id = explode('x_x', $replace)[0];
        if (!empty($id) || $id != '' || $id != null) {
            $value = explode('=', $replace)[1];
            $wpdb->insert(
                $table_name,
                array(
                    'id_form_line' => $id,
                    'isi' => $value,
                    'unix' => $dateUnik,
                    'id_form' => $_POST['id_form']
                )
            );
        }
    }
}
add_action( 'admin_post_rebiovw-alamat', 'rebiovw_find_alamat' );
add_action( 'admin_post_nopriv_rebiovw-alamat', 'rebiovw_find_alamat' );
function rebiovw_find_alamat(){
    global $wpdb;
    $tbl_alamat = $wpdb->prefix . "rebiovw_region";

    $alamat = $wpdb->get_results("SELECT * FROM $tbl_alamat where nama like '%".$_POST['nama']."%' limit 15");
    foreach ($alamat as $val) {
        $n = $val->nama.'.';
        echo '<li class="btn-alamat" onclick="rebiovw_alamat(`'.$n.'`)">'.$val->nama.'</li>';
    }
    
}

add_action('woocommerce_before_single_product', 'rebiovw_woocommerce_before_single_product_register');
add_action('woocommerce_before_single_product_summary', 'rebiovw_woocommerce_before_single_product_summary_register');
add_action('woocommerce_single_product_summary', 'rebiovw_woocommerce_single_product_summary_register');
add_action('woocommerce_before_add_to_cart_form', 'rebiovw_woocommerce_before_add_to_cart_form_register');
add_action('woocommerce_before_variations_form', 'rebiovw_woocommerce_before_variations_form_register');
add_action('woocommerce_before_add_to_cart_button', 'rebiovw_woocommerce_before_add_to_cart_button_register');
add_action('woocommerce_before_single_variation', 'rebiovw_woocommerce_before_single_variation_register');
add_action('woocommerce_single_variation', 'rebiovw_woocommerce_single_variation_register');
add_action('woocommerce_before_add_to_cart_quantity', 'rebiovw_woocommerce_before_add_to_cart_quantity_register');
add_action('woocommerce_after_add_to_cart_quantity', 'rebiovw_woocommerce_after_add_to_cart_quantity_register');
add_action('woocommerce_after_single_variation', 'rebiovw_woocommerce_after_single_variation_register');
add_action('woocommerce_after_add_to_cart_button', 'rebiovw_woocommerce_after_add_to_cart_button_register');
add_action('woocommerce_after_variations_form', 'rebiovw_woocommerce_after_variations_form_register');
add_action('woocommerce_after_add_to_cart_form', 'rebiovw_woocommerce_after_add_to_cart_form_register');
add_action('woocommerce_share', 'rebiovw_woocommerce_share_register');