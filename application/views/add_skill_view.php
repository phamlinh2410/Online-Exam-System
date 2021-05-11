<?php include("inc/header.php"); ?>
    <div class="container">
        <br />
        <h3 align="center">ADD NEW SKILL</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post" action="<?php echo base_url(); ?>Admin/addSkill">
                    <div class="form-group">
                        <label>Enter New Skill Name</label>
                        <input type="text" name="skill_name" class="form-control" value="<?php echo set_value('skill_name'); ?>"  />
                        <span class="text-danger"><?php echo form_error('skill_name'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="addSkill" value="Add" class="btn btn-info" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>Admin">Back to dashboard</a>
                    </div>
                </form>
            </div>
        </div>

        <h2>View Skills</h2>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">SkillID</th>
                        <th scope="col">SkillName</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($skills)): ?>
                        <?php foreach($skills as $skill): ?>
                            <tr class="table-active">
                                <td><?php echo $skill->SkillID; ?></td>
                                <td><?php echo $skill->SkillName; ?></td>
                                <td><?php echo $skill->Status; ?></td>
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
