<section class="content-header">
    <h1>
        Admin Detail
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>Admin/all"><i class="fa fa-users"></i> Admin</a></li>
        <li><a href="<?= base_url() ?>Admin/add"> Admin Detail</a></li>
    </ol>
</section>
<br>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Admin</h3>
            <a href='<?php echo site_url('admin/edit'); ?>' class='btn btn-default pull-right'>
                <i class='fa fa-edit' ></i> Edit</a>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form">
            <div class="box-body">
            <div class="form-group">
                <label for="adminUsername">Username : AdminASD</label>
            </div>
            <div class="form-group">
                <label for="adminPassword">Password : ***</label>
            </div>
            <div class="form-group">
                <label>Role : Admin</label>
            </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</section>