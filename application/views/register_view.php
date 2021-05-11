<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">Complete Your Registration</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">Register Form</div>
            <div class="panel-body">
                <?php
                    if ($this->session->flashdata('message')) {
                        echo '<div class = "alert alert-success">'.$this->session->flashdata("message").'</div>';
                    }
                ?>
                <form method="post" action="<?php echo base_url(); ?>Register">
                    <div class="form-group">
                        <label>Enter Your Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo set_value('name'); ?>"  />
                        <span class="text-danger"><?php echo form_error('name'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Enter Your Email Address</label>
                        <input type="text" name="email" class="form-control" value="<?php echo set_value('email'); ?>"  />
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Enter Password</label>
                        <input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>" />
                        <span class="text-danger"><?php echo form_error('password'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="rePassword" class="form-control" value="<?php echo set_value('rePassword'); ?>" />
                        <span class="text-danger"><?php echo form_error('rePassword'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="register" value="Register" class="btn btn-info" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>Login">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>