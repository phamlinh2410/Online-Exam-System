</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">Please enter your new password</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">Reset password Form</div>
            <div class="panel-body">
                <?php
                if($this->session->flashdata('message')) {
                    echo '<div class="alert alert-success">'.$this->session->flashdata("message").'</div>';
                }
                ?>
                <form method="post" action="<?php echo base_url(); ?>Login/resetPassword">
                    <div class="form-group">
                        <label>Enter New Password</label>
                        <input type="password" class="form-control" name="newPassword" value="<?php echo set_value('newPassword'); ?>">
                        <span class="text-danger"><?php echo form_error('newPassword'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Comfirm New Password</label>
                        <input type="password" class="form-control" name="rePassword" value="<?php echo set_value('rePassword'); ?>">
                        <span class="text-danger"><?php echo form_error('rePassword'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Submit" class="btn btn-info" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>Login">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>