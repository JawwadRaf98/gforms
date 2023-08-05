<?php
include_once 'header.php'; ?>
<style>
    body{
        background-color: #d5d3d578;
    }
</style>

<div class="container">
    <div class="add-form">
        <form action="" method="POST">

            <div class="section section-title">
                <div class="input">
                    <input type="text" name="form-title" value="Add Title" class="title main-title" requied/>
                    <textarea name="desc" id="desc" placeholder="Add a description"></textarea>
                </div>
            </div>

            <div id="questioniar">
                

                <!-- question Start -->

                <?php 
                    for($i=1; $i<=10; $i++){
                ?>
                    <div class="Question">
                        <div class="section">
                            <div class="top">
                                <div class="left" data-id="">Question no <?php echo $i; ?></div>
                                <div class="right">
                                    <select name="type" class="type">
                                    <option value="1">Question</option>
                                    <option value="2">MCQ's (Single Choice)</option>
                                    <option value="3">MCQ's (Multi Choice)</option>
                                    <option value="4">Detailed Question</option>
                                    </select>
                                </div>
                            </div>
                            <div class="center">
                                <div class="input">
                                <input type="hidden" class="question_no" value="<?php echo $i; ?>">
                                    <input type="hidden" name="question[<?php echo $i; ?>]['type']" value="1" class = "question_type">

                                    <div class="question_input_type">
                                        <input type="text" name="question[<?php echo $i; ?>]" value="Write Your Question...." class="form-input" required/>
                                    </div>
                                    <div class="options">
                                       <input type="hidden" value="" name="question[<?php echo $i; ?>]['options']" class="option_text" />
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                    }
                ?>
                


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

            // $(".fa-xmark").on('click', function(){
            //     console.log("xmark clicked" )
            //     radioValue = $(this).closest(".options_input").remove()
            // })

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
                let optionVal = `<input type="hidden" value="" name="question[${question_no}]['options']" />`;
                let inputChange =  `<input type="text" name="question[${question_no}]" value="Write Your Question...." class="form-input" required/>`
                
                console.log(selectedValue)
                if(selectedValue == "2" || selectedValue == "3"){
                  
                    console.log(question_no);
                    optionVal = `<div class="options_input">
                                        <label>
                                            <input type="text" value="Option  text" name="question[${question_no}]['options']" class="option_text" />
                                        <label>
                                    </div>  
                                    
                                    <div class="options_input">
                                        <label>
                                            <input type="text" value="Option  text" name="question[${question_no}]['options']" class="option_text" />
                                            <i class="fa-solid fa-xmark" ></i>
                                        <label>
                                    </div>  

                                    <div class="options_input">
                                        <label>
                                            <input type="text" value="Option text" name="question[${question_no}]['options']" class="option_text" />
                                        <label>
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                    
                                    <div class="add_more_div">
                                        <span class="add_more_btn">Add  more</span>
                                    <div>`;  
                        }else if( selectedValue == "4"){
                            inputChange  = ` Write Your Question....<br><textarea ame="question[${question_no}]" class="form-input"  required>
                                       
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
