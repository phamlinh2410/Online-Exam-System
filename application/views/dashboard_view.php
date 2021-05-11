<?php include("inc/header.php"); ?>
    
    <div class="container">
        <h3>ADMIN DASHBOARD</h3>
        <?php echo anchor('HomePage/logout', 'Logout', ['class' => 'btn btn-primary']); ?>
        <?php echo anchor('HomePage/changePassword', 'Change Password', ['class' => 'btn btn-primary']); ?>
        <br> <br>
        <?php echo anchor('Admin/addQuestion', 'Add Question', ['class' => 'btn btn-primary']); ?>
        <?php echo anchor('Admin/addCategory', 'Add Category', ['class' => 'btn btn-primary']); ?>
        <?php echo anchor('Admin/addSkill', 'Add Skill', ['class' => 'btn btn-primary']); ?>
        <?php echo anchor('Admin/createExam', 'Create Exam', ['class' => 'btn btn-primary']); ?>
    
        <!-- display question -->
        <h2>View Questions</h2>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">QuestionID</th>
                        <th scope="col">Category</th>
                        <th scope="col">Format</th>
                        <th scope="col">Question Content</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($questions)): ?>
                        <?php foreach($questions as $question): ?>
                            <tr class="table-active">
                                <td><?php echo $question->QuestionID; ?></td>
                                <td><?php echo $question->CategoryName; ?></td>
                                <td><?php echo $question->FormatName; ?></td>
                                <td><?php echo $question->QuestionContent; ?></td>
                                <td><?php echo $question->Status; ?></td>
                                <td><?php echo anchor("Admin/viewAnswer/{$question->QuestionID}", "View Answer", ['class' => 'btn btn-primary']); ?></td>
                                <td><?php echo anchor("Admin/deleteQuestion/{$question->QuestionID}", "Delete", ['class' => 'btn btn-primary']); ?></td>
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
