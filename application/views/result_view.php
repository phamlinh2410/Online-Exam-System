<?php include("inc/header.php"); ?>
    
    <div class="container">
        <h3>HOMEPAGE DASHBOARD</h3>
        <?php echo anchor('HomePage/logout', 'Logout', ['class' => 'btn btn-primary']); ?>
        <?php echo anchor('HomePage/changePassword', 'Change Password', ['class' => 'btn btn-primary']); ?>
        <br><br>
        <?php
            if($this->session->flashdata('message')) {
                echo '<div class="alert alert-success">'.$this->session->flashdata("message").'</div>';
            }
        ?>

        <!-- display question -->
        <h2>View Result</h2>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ExamName</th>
                        <th scope="col">Times</th>
                        <th scope="col">Score</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($records)): ?>
                        <?php foreach($records as $record): ?>
                            <tr class="table-active">
                                <td><?php echo $record->ExamName; ?></td>
                                <td><?php echo $record->Times; ?></td>
                                <td><?php echo $record->Score; ?></td>
                                <td><?php echo $record->Time; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td>No record found!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <a href="<?php echo base_url(); ?>HomePage">Back to dashboard</a>
        </div>
    </div>

<?php include("inc/footer.php"); ?>
