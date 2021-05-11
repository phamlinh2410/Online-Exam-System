<?php include("inc/header.php"); ?>
    <div class="container">
    <br />
    <h3 align="center">ONLINE EXAM</h3>
    <br />
    <!-- <p id="demo"></p> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <div id="display"> </div>
    

    <form id="exam" method="post" action="<?php echo base_url(); ?>HomePage/submitExam">
        <ol type="1">
            <?php foreach($questions as $question): ?>
                <li>
                    <b><?php echo $question->QuestionContent; ?></b>
                    <input type="hidden" name="questionIDs[]" value="<?php echo $question->QuestionID; ?>">
                    <?php if ($question->FormatID == 1) { ?>
                        <ol type="A">
                            <?php $this->load->model('HomePage_model'); ?>
                            <?php $answers = $this->HomePage_model->getAnswer($question->QuestionID); ?>
                            <?php foreach($answers as $answer): ?>

                                <li>
                                    <input type="radio" name="question_<?php echo $question->QuestionID; ?>" value="<?php echo $answer->AnswerID ?>">
                                    <?php echo $answer->AnswerContent; ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php } else { ?>
                        <ol type="A">
                            <?php $this->load->model('HomePage_model'); ?>
                            <?php $answers = $this->HomePage_model->getAnswer($question->QuestionID); ?>
                            <?php foreach($answers as $answer): ?>

                                <li>
                                    <input type="checkbox" name="question_<?php echo $question->QuestionID; ?>[]" value="<?php echo $answer->AnswerID ?>">
                                    <?php echo $answer->AnswerContent; ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php } ?>
                </li>
            <?php endforeach; ?>    
        </ol>
        <input type="submit" name="submit1" value="Submit" class="btn btn-info" />
    </form>
    <?php 
        if ($this->session->flashdata('message')) {
            echo '<div class = "alert alert-success">'.$this->session->flashdata("message").'</div>';
        }
    ?>
 </div>

    
<?php include("inc/footer.php"); ?>

<script type="text/javascript">
    function CountDown(duration, display) {
        if (!isNaN(duration)) {
            var timer = duration, minutes, seconds;
                
            var interVal=  setInterval(function () {
                hours = parseInt(timer / 3600, 10);
                minutes = parseInt((timer % 3600) / 60, 10);
                seconds = parseInt((timer % 3600) % 60, 10);

                hours = hours < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                $(display).html("<b>" + "REMAINING TIME: " + hours + "h : " + minutes + "m : " + seconds + "s" + "</b>");
                if (--timer < 0) {
                    timer = duration;
                    document.getElementById('exam').submit();
                    $('#display').empty();
                    clearInterval(interVal);
                }
            },1000);
        }
    }
    
    CountDown(<?php echo $duration ?>,$('#display'));
</script>