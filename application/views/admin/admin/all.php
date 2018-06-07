<section class="content-header">
    <h1>
        Admins
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>admin/all"><i class="fa fa-users"></i> Admin</a></li>
    </ol>
</section>
<br>
<section class="content">
    <div class="box">
        <div class='box-header'>
            <h4 class="whiteTitle" style='display: inline-block;'>Admin</h4>

            <a href='<?php echo site_url('admin/add'); ?>' class='btn btn-info pull-right'>
                <i class='fa fa-plus' ></i> Add</a>

        </div>
        <div class='box-body no-padding'>

            <div id="refreshBox">
                <table id="data-table" class="table table-bordered table-hover data-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td><a href="<?= base_url() ?>admin/detail/">1</a></td>
                                <td><a href="<?= base_url() ?>admin/detail/">AdminASD</a></td>
                                <td><a href="<?= base_url() ?>admin/detail/">Admin</a></td>
                                <td><a href="" class="btn btn-danger">Delete</a></td>

                            </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</section>