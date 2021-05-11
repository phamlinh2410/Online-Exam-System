<?php include("inc/header.php"); ?>
    <div class="container">
        <br />
        <h3 align="center">ADD NEW CATEGORY</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post" action="<?php echo base_url(); ?>Admin/addCategory">
                    <div class="form-group">
                        <label>Enter New Category Name</label>
                        <input type="text" name="category_name" class="form-control" value="<?php echo set_value('category_name'); ?>"  />
                        <span class="text-danger"><?php echo form_error('category_name'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="addCategory" value="Add" class="btn btn-info" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>Admin">Back to dashboard</a>
                    </div>

                </form>
            </div>
        </div>
        <h2>View Categories</h2>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">CategoryID</th>
                        <th scope="col">CategoryName</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($categories)): ?>
                        <?php foreach($categories as $category): ?>
                            <tr class="table-active">
                                <td><?php echo $category->CategoryID; ?></td>
                                <td><?php echo $category->CategoryName; ?></td>
                                <td><?php echo $category->Status; ?></td>
                            </tr>
                        <?php endforeach; ?>    
                    <?php else: ?>
                        <tr>
                            <td>No record found!</td>
                        </tr>
                    <?php endif; ?>     

                </tbody>
            </table>
        </div>
    </div>

    
<?php include("inc/footer.php"); ?>