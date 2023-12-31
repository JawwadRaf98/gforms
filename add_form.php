<?php
include_once 'header.php';

$msg = '';
if (
    isset($_SESSION['addFormToken']) &&
    @$_SESSION['addFormToken'] == @$_POST['token']
) {
    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";

    $user =
        isset($_SESSION['webuser']['id']) && !empty($_SESSION['webuser']['id'])
            ? $_SESSION['webuser']['id']
            : '';

    $sql_form_limit =
        "SELECT COUNT(f_id) AS 'Rows' FROM `forms` WHERE created_by = ?";
    $data = getRow($sql_form_limit, [$user]);
    $no_of_form = $data['Rows'];
    if ($no_of_form < 11) {
        if (!empty($user)) {
            $form_title =
                isset($_POST['form-title']) && !empty($_POST['form-title'])
                    ? $_POST['form-title']
                    : '';
            $form_desc =
                isset($_POST['desc']) && !empty($_POST['desc'])
                    ? $_POST['desc']
                    : '';
            $questions = $_POST['question'];
            $st_date =
                isset($_POST['form-from']) && !empty($_POST['form-from'])
                    ? $_POST['form-from']
                    : '';
            $end_date =
                isset($_POST['form-to']) && !empty($_POST['form-to'])
                    ? $_POST['form-to']
                    : '';

            $sql_form_insert =
                'INSERT INTO `forms`(`f_title`, `f_desc`, `f_st_time`, `f_end_time`, `created_by`) VALUES (?, ?, ?, ?, ?)';
            $f_id = setRow($sql_form_insert, [
                $form_title,
                $form_desc,
                $st_date,
                $end_date,
                $user,
            ]);

            if ($f_id > 0) {
                foreach ($questions as $key => $val) {
                    $title = !empty($val['question']) ? $val['question'] : '';
                    $type = !empty($val['type']) ? $val['type'] : '';
                    $option = !empty($val['options']) ? $val['options'] : [];
                    $option = implode(',', $option);

                    $sql_question_insert =
                        'INSERT INTO `questions`(`f_id`, `q_title`, `q_type`, `q_options`, `created_by`) VALUES (?, ?, ?, ?, ?)';
                    setRow($sql_question_insert, [
                        $f_id,
                        $title,
                        $type,
                        $option,
                        $user,
                    ]);
                }
                $msg =
                    '<div class="custom-alert success" role="alert">Form added successfully</div>';
            } else {
                $msg =
                    '<div class="custom-alert danger" role="alert">Something\'s went wrong</div>';
            }
        } else {
            $msg =
                '<div class="custom-alert danger" role="alert">Something\'s went wrong</div>';
        }
    } else {
        $msg =
            '<div class="custom-alert danger" role="alert">Your form limit is exceess delete previous form first.</div>';
    }
}
?>



<style>
    body{
        background-color: #d5d3d578;
    }
</style>

<div class="container">
    

    <div class="add-form">
    <?php if (!empty($msg)) {
        echo $msg;
        // exit();
    } ?>
        <form action="" method="POST">
            <?php
            $token = rand();
            $_SESSION['addFormToken'] = $token;
            echo '<input type="hidden" name="token" value="' . $token . '" />';
            ?>

            <div class="section section-title">
                <div class="input">
                    <input type="text" name="form-title" placeholder="Add Title" class="title main-title" required/>
                    <textarea name="desc" id="desc" placeholder="Add a description"></textarea>
                    
                    <div class="row" style="margin-top:1rem">
                    <div class="col">
                        <span>Start From : </span> <input type="date" name="form-from" />
                    </div>
                    <div class="col">
                        <span>End : </span> <input type="date" name="form-to" />                    </div>
                    </div>
                   
                </div>
            </div>

            <div id="questioniar">
                

                <!-- question Start -->

                <?php for ($i = 1; $i <= 10; $i++) { ?>
                    <div class="Question">
                        <div class="section">
                            <div class="top">
                                <div class="left" data-id="">Question no <?php echo $i; ?></div>
                                <div class="right">
                                    <select name="type" class="type">
                                    <option value="1">Short Question</option>
                                    <option value="2">MCQ's (Single Choice)</option>
                                    <option value="3">MCQ's (Multi Choice)</option>
                                    <option value="4">Detailed Question</option>
                                    <option value="5">Select (Dropdown)</option>
                                </select>
                                </div>
                            </div>
                            <div class="center">
                                <div class="input">
                                <input type="hidden" class="question_no" value="<?php echo $i; ?>">
                                    <input type="hidden" name="question[<?php echo $i; ?>][type]" value="1" class = "question_type">

                                    <div class="question_input_type">
                                        <input type="text" name="question[<?php echo $i; ?>][question]" placeholder="Write Your Question...." class="form-input" required/>
                                    </div>
                                    <div class="options">
                                       <input type="hidden" value="" name="question[<?php echo $i; ?>][options][]" class="option_text" />
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
                

                <div class="form-group">
                    <button type="submit">Submit</button>
            </div>
                <!-- question end -->

            </div>
        </form>
    </div>

</div>


<script>


        $(document).ready(function() {

            $(document).on('click', '.fa-xmark', function() {
                $(this).closest(".options_input").remove();
            });

           

            $(document).on('click','.add_more_btn', function(ths){
                let question_no = $(ths).closest(".input").find('.question_no').val()
                console.log($(ths).closest(".input"))
            
                    var newOption = `
                        <div class="options_input">
                            <label>
                                <input type="text" value="Option text" name="question[${question_no}]['options']" class="option_text" />
                            </label>
                            <i class="fa-solid fa-xmark remove_option"></i>
                            
                        </div>
                `;
                    $(newOption).insertBefore(".add_more_div");
            })


            

             $('.type').on('change', function() {
                const selectedValue = $(this).val();
                let question_no = $(this).closest(".Question").find('.question_no').val()
                $(this).closest(".Question").find('.question_type').val(selectedValue)
                let optionVal = `<input type="hidden" value="" name="question[${question_no}][options][]" />`;
                let inputChange =  `<input type="text" name="question[${question_no}][question]" placeholder="Write Your Question...." class="form-input" required/>`
                
                console.log(selectedValue)
                if(selectedValue == "2" || selectedValue == "3" ||  selectedValue == "5"){
                  
                    optionVal = `<div class="options_input">
                                        <label>
                                            <input type="text" value="Option  text" name="question[${question_no}][options][]" class="option_text" />
                                        <label>
                                    </div>  
                                    
                                    <div class="options_input">
                                        <label>
                                            <input type="text" value="Option  text" name="question[${question_no}][options][]" class="option_text" />
                                            <i class="fa-solid fa-xmark" ></i>
                                        <label>
                                    </div>  

                                    <div class="options_input">
                                        <label>
                                            <input type="text" value="Option text" name="question[${question_no}][options][]" class="option_text" />
                                        <label>
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                    
                                    <div class="add_more_div">
                                        <span class="add_more_btn">Add  more</span>
                                    <div>`;  
                        }else if( selectedValue == "4"){
                            inputChange  = ` Write Your Question....<br><textarea name="question[${question_no}][question]" class="form-input"  required>
                                       
                                    </textarea>`
                         

                        }
                        else{}

                    $(this).closest(".Question").find('.options').html(optionVal)
                    $(this).closest(".Question").find('.question_input_type').html(inputChange)
   

               
            });
        

            // $(".option_text").on("input", function() {
            //     var newValue = $(this).val();
            //     console.log(newValue)
            //     var radioValue = $(this).closest(".options_input").find(".option_text_value");
            //     radioValue.val(newValue);
            // });
            
        });
</script>


<!-- for question -->
