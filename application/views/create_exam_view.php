<?php include("inc/header.php"); ?>
    <div class="container">
        <br />
        <h3 align="center">CREATE NEW EXAM</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
                    if ($this->session->flashdata('message')) {
                        echo '<div class = "alert alert-success">'.$this->session->flashdata("message").'</div>';
                    }
                ?>
                <form method="post" action="<?php echo base_url(); ?>Admin/createExam">
                    <div class="box">
                        <p><label>Choose Category:</label></p>
                        <select name="category">
                            <?php if (count($categories)): ?>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category->CategoryID; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category->CategoryName; ?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                <?php endforeach; ?>    
                            <?php else: ?>
                                <option>No option!</option>
                            <?php endif; ?>     
                        </select>
                    </div> <br>
                    <div class="form-group">
                        <label>Enter Duration (Seconds):</label>
                        <input type="text" name="duration" class="form-control" value="<?php echo set_value('duration'); ?>"  />
                        <span class="text-danger"><?php echo form_error('duration'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Enter Total Of Questions:</label>
                        <input type="text" name="numberOfQuestions" class="form-control" value="<?php echo set_value('numberOfQuestions'); ?>"  />
                        <span class="text-danger"><?php echo form_error('numberOfQuestions'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Enter Exam Name:</label>
                        <input type="text" name="examName" class="form-control" value="<?php echo set_value('examName'); ?>"  />
                        <span class="text-danger"><?php echo form_error('examName'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="createExam" value="Create" class="btn btn-info" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>Admin">Back to dashboard</a>
                    </div>

                </form>
            </div>
        </div>
        <h2>View Exams Information</h2>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ExamID</th>
                        <th scope="col">CategoryName</th>
                        <th scope="col">ExamName</th>
                        <th scope="col">TotalQuestions</th>
                        <th scope="col">Time Created</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($examInfor)): ?>
                        <?php foreach($examInfor as $exam): ?>
                            <tr class="table-active">
                                <td><?php echo $exam->ExamID; ?></td>
                                <td><?php echo $exam->CategoryName; ?></td>
                                <td><?php echo $exam->ExamName; ?></td>
                                <td><?php echo $exam->TotalQuestions; ?></td>
                                <td><?php echo $exam->TimeCreated; ?></td>
                                <td><?php echo $exam->Status; ?></td>
                                <td><?php echo anchor("Admin/viewQuestionsOfExam/{$exam->ExamID}", "View Questions", ['class' => 'btn btn-primary']); ?></td>
                                <td><?php echo anchor("Admin/deleteExam/{$exam->ExamID}", "Delete", ['class' => 'btn btn-primary']); ?></td>
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