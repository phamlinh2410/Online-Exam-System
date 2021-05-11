<?php include("inc/header.php"); ?>
    
    <div class="container">
        <h3>USER DASHBOARD</h3>
        <?php echo anchor('HomePage/logout', 'Logout', ['class' => 'btn btn-primary']); ?>
        <?php echo anchor('HomePage/changePassword', 'Change Password', ['class' => 'btn btn-primary']); ?>
        <?php echo anchor('HomePage/viewResult', 'View Result', ['class' => 'btn btn-primary']); ?>
    
        <!-- display question -->
        <h2>View Exams</h2>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ExamName</th>
                        <th scope="col">CategoryName</th>
                        <th scope="col">TotalQuestions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($examInfor)): ?>
                        <?php foreach($examInfor as $exam): ?>
                            <tr class="table-active">
                                <td><?php echo $exam->ExamName; ?></td>
                                <td><?php echo $exam->CategoryName; ?></td>
                                <td><?php echo $exam->TotalQuestions; ?></td>
                                <td><?php echo anchor("HomePage/viewExam/{$exam->ExamID}", "Test", ['class' => 'btn btn-primary']); ?></td>
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
