<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">Change Password here!</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">Change Password</div>
            <div class="panel-body">
                <?php
                if($this->session->flashdata('message')) {
                    echo '<div class="alert alert-success">'.$this->session->flashdata("message").'</div>';
                }
                ?>
                <form method="post" action="<?php echo base_url(); ?>HomePage/changePassword">
                    <div class="form-group">
                        <label>Enter Current Password</label>
                        <input type="password" name="currentPassword" class="form-control" value="<?php echo set_value('currentPassword'); ?>" />
                        <span class="text-danger"><?php echo form_error('currentPassword'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Enter New Password</label>
                        <input type="password" name="newPassword" class="form-control" value="<?php echo set_value('newPassword'); ?>" />
                        <span class="text-danger"><?php echo form_error('newPassword'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Comfirm New Password</label>
                        <input type="password" name="rePassword" class="form-control" value="<?php echo set_value('rePassword'); ?>" />
                        <span class="text-danger"><?php echo form_error('rePassword'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="changePassword" value="Change Password" class="btn btn-info" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>HomePage">Back to dashboard</a>
                        <?php if($accountType == 3) { ?>
                        <a href="<?php echo base_url(); ?>Homepage">Homepage</a>
                        <?php } elseif ($accountType == 2) { ?>
                            <a href="<?php echo base_url(); ?>AdminManager">Homepage</a>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>