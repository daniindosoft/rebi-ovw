<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    
    <link rel="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <style>
        .dataTables_filter, .dataTables_paginate.paging_simple_numbers{
            float: right;
        }
.current-menu-ancestor { color: black, background: red, border:1px solid red }
.current-menu-parent { color: red, background: blue, border: 1px solid red}        
    </style>
    <div class="wrap">
        <?php if (isset($_GET['msg'])): ?><div class="updated"><p><?php echo $_GET['msg']; ?></p></div><?php endif; ?>
        <h2>List Form</h2>
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

            $rows = $wpdb->get_results("SELECT * from $table_form order by id desc");
            ?>
            <table class='table table-border table-striped' id="example" style="width: 100%">
                <thead>
                    <tr>
                        <th class="manage-column ss-list-width">Nama Form</th>
                        <th class="manage-column ss-list-width">Header Pesan</th>
                    </tr>
                </thead>
                <tbody>
                    
                <?php $no=1; foreach ($rows as $row) { ?>
                    <tr>
                        <td class="manage-column ss-list-width">
                            <?php echo '<b>'.$no++.'</b>. '; ?><a href="<?php echo admin_url('admin.php?page=rebiovw_update_form&id='.$row->id); ?>">
                                <?php echo $row->title; ?>
                            </a>
                        </td>
                        <td class="manage-column ss-list-width">
                            <?php 
                                echo substr(strip_tags($row->header_pesan), 0, 75); 
                            ?>
                        </td>
                        
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <!--  -->
            
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