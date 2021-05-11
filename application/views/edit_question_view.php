<?php include("inc/header.php"); ?>
    <div class="container">
        <br />
        <h3 align="center">EDIT QUESTION <?php echo $id; ?></h3>
        <br />
        <div class="panel panel-de  fault">
            <div class="panel-body">
                <form method="post" action="<?php echo base_url(); ?>Admin/editQuestion">
                    <div class="form-group">
                        <label>Edit Question Content</label>
                        <input type="text" name="edit_content" class="form-control" value="<?php echo set_value('question_content'); ?>"  />
                        <span class="text-danger"><?php echo form_error('question_content'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Enter Category</label>
                        <input type="text" name="category" class="form-control" value="<?php echo set_value('category'); ?>"  />
                        <span class="text-danger"><?php echo form_error('category'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="editQuestion" value="Edit" class="btn btn-info" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>Admin">Back to dashboard</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include("inc/footer.php"); ?>
