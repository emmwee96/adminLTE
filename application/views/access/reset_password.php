<div class='loginBox '>
    <div class="panel-heading">
        Reset Password
    </div>
    <div class='panel-body'>
        <form method="post">
            <label>New Password</label>
            <input name='password' type="password" class="form-control"/>
            <br/>
            <label>Confirm Password</label>
            <input name='password2' type="password" class="form-control"/>
<br />
            <div class ="button-container">
                <input type="submit" value='Reset Password' class="btn btn-default">
            </div>
        </form>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger alert-dismissable">
                <?= $error; ?>
            </div>
        <?php }; ?>
    </div>

</div>
