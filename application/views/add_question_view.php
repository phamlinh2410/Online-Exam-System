<!DOCTYPE html>
<html>
<head>
    <title>Add new question</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">ADD NEW QUESTION</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">Add Question Form</div>
            <div class="panel-body">
                <form name="questionForm" method="post" action="<?php echo base_url(); ?>Admin/addQuestion" onsubmit="return validateForm()">
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
                    <div class="box">
                        <p><label>Choose Format:</label></p>
                        <select name="format">
                            <?php if (count($formats)): ?>
                                <?php foreach($formats as $format): ?>
                                    <option value="<?php echo $format->FormatID; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $format->FormatName; ?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                <?php endforeach; ?>    
                            <?php else: ?>
                                <option>No option!</option>
                            <?php endif; ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <label>Enter Skill Percent</label> <br>
                            <?php if (count($skills)): ?>
                                <?php foreach($skills as $skill): ?>
                                    <?php echo $skill->SkillName; ?>
                                    <input type="text" name="skill_<?php echo $skill->SkillID; ?>" class="form-control" value="0"  />
                                <?php endforeach; ?>    
                            <?php else: ?>
                                <?php echo "Have no skill exist!"; ?>
                            <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Enter Question Content</label>
                        <input type="text" name="question_content" class="form-control" value="<?php echo set_value('question_content'); ?>" />
                        <span class="text-danger"><?php echo form_error('question_content'); ?></span>
                    </div>
                    
                    <!-- Enter answer -->
                    <div class="form-group">  
                            <div class="table-responsive">  
                                <table class="table" id="dynamic_field">  
                                    <tr> 
                                        <td><input type="checkbox" name="checks[]" value="1"></td>
                                        <td><input type="text" name="answer_1" placeholder="Enter Answer" class="form-control name_list" /></td>  
                                        <td><input type="hidden" name="answerIDs[]" value="1"></td>
                                        <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
                                    </tr>  
                                </table>  
                            </div>  
                    </div>  
                    
                    <div class="form-group">
                        <input type="submit" name="addQuestion" value="Add" class="btn btn-info" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>Admin">Back to dashboard</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script>  
    $(document).ready(function(){  
        var i=1;  
        $('#add').click(function(){  
            i++;  
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="checkbox" name="checks[]" value="'+i+'"></td><td><input type="text" name="answer_'+i+'" placeholder="Enter answer" class="form-control name_list" /></td><td><input type="hidden" name="answerIDs[]" value="'+i+'"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
        });  
  
        $(document).on('click', '.btn_remove', function(){  
            var button_id = $(this).attr("id");   
            $('#row'+button_id+'').remove();
        });  
    });  

    function validateForm() {
        var totalPercent = 0;
        <?php if (count($skills)): ?>
            <?php foreach($skills as $skill): ?>
                totalPercent = totalPercent + parseInt(document.forms["questionForm"]["skill_<?php echo $skill->SkillID; ?>"].value, 10)
            <?php endforeach; ?>    
        <?php endif; ?>
        if (totalPercent != 100) {
            alert("Total percent must be 100%");
            return false;
        }
    }
   

</script>