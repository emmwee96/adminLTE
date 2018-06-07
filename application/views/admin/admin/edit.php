<section class="content-header">
    <h1>
        Edit admin
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>Admin/all"><i class="fa fa-users"></i> Admin</a></li>
        <li><a href="<?= base_url() ?>Admin/add"> Edit admin</a></li>
    </ol>
</section>
<br>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Admin</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form">
            <div class="box-body">
            <div class="form-group">
                <label for="adminUsername">Username</label>
                <input type="text" class="form-control" id="adminUsername" placeholder="Username" value="AdminASD">
            </div>
            <div class="form-group">
                <label for="adminPassword">Password</label>
                <input type="password" class="form-control" id="adminPassword" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="adminPasswordRetype">Re-type Password</label>
                <input type="password" class="form-control" id="adminPasswordRetype" placeholder="Re-type Password">
            </div>
            <div class="form-group">
                <label>Role</label>
                <select class="form-control">
                    <option>Admin</option>
                    <option>Super Admin</option>
                </select>
            </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</section>