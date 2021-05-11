<?php include("inc/header.php"); ?>
    
    <div class="container">
        <h3>ADMIN DASHBOARD</h3>
    
        <!-- display question -->
        <h2>View Questions Of Exam</h2>
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
                            </tr>
                        <?php endforeach; ?>    
                    <?php else: ?>
                        <tr>
                            <td>No record found!</td>
                        </tr>
                    <?php endif; ?>     

                </tbody>
            </table>
            <a href="<?php echo base_url(); ?>Admin">Back to dashboard</a>
            
        </div>
    </div>

<?php include("inc/footer.php"); ?>
