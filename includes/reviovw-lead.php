<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    
    <link rel="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <style>
     
    #adminmenuwrap{
        margin-top: 0px !important;
    }
        .dataTables_filter, .dataTables_paginate.paging_simple_numbers{
            float: right;
        }
.current-menu-ancestor { color: black, background: red, border:1px solid red }
.current-menu-parent { color: red, background: blue, border: 1px solid red}        
    </style>
    <div class="wrap">
        <?php if (isset($_GET['msg'])): ?><div class="updated"><p><?php echo $_GET['msg']; ?></p></div><?php endif; ?>
        <h2>Lead Anda</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a class="btn btn-sm btn-primary" href="<?php echo admin_url('admin.php?page=rebiovw_create_form'); ?>"><span class="dashicons dashicons-plus"></span> Tambah Form</a>
                <br>
                <br>
            </div>
            <br class="clear">
        </div>
        <br>
        <div style="background-color: #f3f3f3;" class="p-2">
            <?php
            global $wpdb;
            $table_form = $wpdb->prefix . "rebiovw_form";
            $table_pesanan = $wpdb->prefix . "rebiovw_pesanan";

            $rowsleadrebiovw = $wpdb->get_results("SELECT * from $table_pesanan group by unix order by id desc limit 500");
            ?>
            <table class='table table-border table-striped' id="example" style="width: 100%">
                <thead>
                    <tr>
                        <th class="manage-column ss-list-width">Lead <br><small><code>*</code>Field pertama dari form</small></th>
                        <th class="manage-column ss-list-width">Judul Form</th>
                    </tr>
                </thead>
                <tbody>
                    
                <?php $no=1; foreach ($rowsleadrebiovw as $row) { 
                        $judul = $wpdb->get_row($wpdb->prepare("SELECT * from $table_form where id = %d", (int)$row->id_form));
                    ?>
                    <tr>
                        <td class="manage-column ss-list-width">
                            <a href="<?php echo admin_url('admin.php?page=rebiovw_update_lead&id='.$row->unix); ?>"><?php echo $no++.'. '.(string)$row->isi ?></a>
                        </td>
                        <td class="manage-column ss-list-width">
                             <?php echo ($judul->title) ?>
                        </td>
                        
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            
            
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
        $('#example').DataTable();
    } );
    </script>