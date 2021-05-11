<?php include("inc/header.php"); ?>
    
    <div class="container">
            
        <h2>View Answers</h2>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">QuestionID</th>
                        <th scope="col">AnswerID</th>
                        <th scope="col">Answer Content</th>
                        <th scope="col">True/False</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($answers)): ?>
                        <?php foreach($answers as $answer): ?>
                            <tr class="table-active">
                                <td><?php echo $answer->QuestionID; ?></td>
                                <td><?php echo $answer->AnswerID; ?></td>
                                <td><?php echo $answer->AnswerContent; ?></td>
                                <td><?php echo $answer->TorF; ?></td>
                                <td><?php echo $answer->Status; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <td><?php echo anchor("", "Edit Answer", ['class' => 'btn btn-primary']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>Admin">Back to dashboard</a></td>
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
