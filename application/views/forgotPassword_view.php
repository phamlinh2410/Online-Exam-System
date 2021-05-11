<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">Enter your Email address and we'll send you a link to reset your password!</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">Enter your Email address</div>
            <div class="panel-body">
                <?php
                if($this->session->flashdata('message')) {
                    echo '<div class="alert alert-success">'.$this->session->flashdata("message").'</div>';
                }
                ?>
                <form method="post" action="<?php echo base_url(); ?>Login/forgotPassword">
                    <div class="form-group">
                        <label>Enter Email Address</label>
                        <input type="text" name="email" class="form-control" value="<?php echo set_value('email'); ?>" />
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="next" value="Next" class="btn btn-info" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>Login">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>