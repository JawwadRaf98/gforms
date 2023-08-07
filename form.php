<?php
include_once 'config.php';
$err = false;
$success = false;
$email_valide = false;
$guest_email = '';
$errMsg = '';
$successMsg = '';
$formId = '';
if (!isset($_GET['t'])) {
    $err = true;
    $errMsg = 'Invalide Link';
} else {
    $token = $_GET['t'];
    $jsonString = base64_decode($token);
    $arr = json_decode($jsonString, true);
    if ($arr == null) {
        $err = true;
        $errMsg = 'Invalide Link';
    } else {
        // var_dump($arr);
        $f_id = $arr['f_id'];
        $formId = $arr['f_id'];
        $st_date = $arr['from'];
        $end_date = $arr['to'];

        $sql = 'SELECT * FROM `forms` WHERE f_id = ? ';
        $data = getRow($sql, [$f_id]);

        if ($data == false) {
            $err = true;
            $errMsg = 'Form not found or expired';
        } else {
            // echo $st_date;
            if (!empty($st_date)) {
                $temp_st = $st_date; //new DateTime($st_date);
                $today = date('Y-m-d'); //new DateTime(date('Y-m-d'));
                if ($today < $temp_st) {
                    $err = true;
                    $errMsg =
                        'You can not fill this form because it is not open yet';
                }
            }

            if (!empty($end_date)) {
                $temp_end = new DateTime($end_date);
                $today = new DateTime(date('Y-m-d'));
                if ($today > $temp_end) {
                    $err = true;
                    $errMsg =
                        'You can not fill this form because it is expire now';
                }
            }
        }
    }
}

//validation;

if (
    isset($_SESSION['validationToken']) &&
    @$_SESSION['validationToken'] == @$_POST['guest_token']
) {
    $guest_email = $_POST['guest_email'];

    if (!filter_var($guest_email, FILTER_VALIDATE_EMAIL)) {
        $err = true;
        $errMsg = 'Invalid email format';
    } else {
        $sql_search = "SELECT COUNT(id) AS 'rows' FROM `reports` WHERE guest_user_email = '$guest_email' AND f_id = '$formId' ORDER BY `reports`.`id` ASC;";
        $res = getRow($sql_search);

        if ($res['rows'] > 0) {
            $err = true;
            $errMsg = 'Record Already submited through this email';
        } else {
            $email_valide = true;
        }
    }
}
//validation;
if (
    isset($_SESSION['formToken']) &&
    @$_SESSION['formToken'] == @$_POST['form_token']
) {
    $f_id = @$_POST['f_iq'];
    $guest_email = @$_POST['guest_email'];
    $questions = $_POST['question'];
    $insert = false;
    $sql =
        'INSERT INTO `reports`(`f_id`, `guest_user_email` , `q_id`, `q_type`, `answers`) VALUES ';
    foreach ($questions as $key => $val1) {
        $insert = true;
        $q_id = isset($val1['q_id']) ? $val1['q_id'] : '';
        $q_type = isset($val1['type']) ? $val1['type'] : '';
        $answer = isset($val1['answer']) ? $val1['answer'] : '';
        if ($q_type == '2' || $q_type == '3' || $q_type == '5') {
            if (is_array($answer)) {
                $answer = implode(',', $answer);
            }
        }
        $sql .= "('$f_id', '$guest_email', '$q_id', '$q_type', '$answer'),";
    }
    if ($insert) {
        $sql;
        $sql = trim($sql, ',');
        $res = setRow($sql);
        if ($res) {
            $success = true;
            $successMsg = 'Rocord has been submit successfully';
        } else {
            $success = 'failed';
            $successMsg = 'Rocord submission failed please refill form';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
    <link rel="stylesheet"  href="./css/style.css?magic=<?php echo rand(); ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a16440b640.js" crossorigin="anonymous"></script>
    <style>
    body{
        background-color: #d5d3d578;
    }
</style>

</head>
<body>
    <div class="container">
        <?php if ($err) {
            echo '<div class="custom-alert danger" role="alert">' .
                $errMsg .
                '</div>';
        } elseif ($email_valide == false) { ?>
               
            
                <form method="POST" class="guest_user_form">
                    <?php if ($success !== false) {
                        if ($success) {
                            echo '<div class="custom-alert success" role="alert">' .
                                $successMsg .
                                '</div>';
                        } else {
                            echo '<div class="custom-alert danger" role="alert">' .
                                $successMsg .
                                '</div>';
                        }
                    } ?>
                    
                <?php
                $token = rand();
                $_SESSION['validationToken'] = $token;
                echo '<input type="hidden" name="guest_token" value="' .
                    $token .
                    '" />';
                ?>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="guest_email" required class="form-control form-input" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Please enter your email id to fill form</div>
                </div>
            
                <div class="form-group">
                    <button type="submit">Submit</button>
            </div>
                </form>
                
        
        <?php } else {
            $token = $_GET['t'];
            $jsonString = base64_decode($token);
            $arr = json_decode($jsonString, true);
            $f_id = $arr['f_id'];
            $u_id = $arr['u_id'];
            $sql = 'SELECT * FROM `forms` WHERE f_id = ? ';
            $data = getRow($sql, [$f_id]);
            // $f_id = $data['f_id'];
            $f_title = $data['f_title'];
            $f_desc = $data['f_desc'];
            $f_st_time = $data['f_st_time'];
            $f_end_time = $data['f_end_time'];

            $questions_sql =
                'SELECT * FROM `questions` WHERE f_id = ? AND created_by = ? ORDER BY q_id LIMIT 0, 10 ';
            $questionArray = getRows($questions_sql, [$f_id, $u_id]);

            // echo '<pre>';
            // var_dump($questionArray);
            // echo '</pre>';
            ?> 
                <div class="questionior">
                    <section class="main">
                        <h2 class="title"><?php echo $f_title; ?></h2>
                        <p class="detail"><?php echo $f_desc; ?></p> 
                        <?php
                        if (!empty($f_st_time)) {
                            echo '<p class="dates">Open from : ' .
                                $f_st_time .
                                '</p>';
                        }
                        if (!empty($f_end_time)) {
                            echo '<p class="dates" >Expire  : ' .
                                $f_end_time .
                                '</p>';
                        }
                        ?>   
                        </section>
                        <div class="questions">
                            <form method="POST">
                            <?php
                            $token = rand();
                            $_SESSION['formToken'] = $token;
                            echo '<input type="hidden" name="form_token" value="' .
                                $token .
                                '" />';
                            ?>
                                <input type="hidden" name="f_iq" value="<?php echo $f_id; ?>" />
                                <input type="hidden" name="guest_email" value="<?php echo $guest_email; ?>" />
                                
                                <?php foreach (
                                    $questionArray
                                    as $key => $ques
                                ) {

                                    $q_id = $ques['q_id'];
                                    $q_type = $ques['q_type'];
                                    $q_title = $ques['q_title'];
                                    $q_options = $ques['q_options'];
                                    ?>
                                        <div class="ques">
                                            <h4 class="h4"><?php echo $q_title; ?></h4>
                                            <input type="hidden" name="question[<?php echo $q_id; ?>][q_id]" value="<?php echo $q_id; ?>" class="form-input" />

                                            <?php if ($q_type == 1) { ?>
                                                <input type="hidden" name="question[<?php echo $q_id; ?>][type]" value="<?php echo $q_type; ?>" class="form-input" />
                                                <input type="text" name="question[<?php echo $q_id; ?>][answer]" class="form-input" required />
                                            <?php } elseif (
                                                $q_type == 2 ||
                                                $q_type == 3
                                            ) { ?>
                                                <section class="option">
                                                    <input type="hidden" name="question[<?php echo $q_id; ?>][type]" value="<?php echo $q_type; ?>" class="form-input" />

                                                    <div class="radio">
                                                        <?php
                                                        $type =
                                                            $q_type == 2
                                                                ? 'radio'
                                                                : 'checkbox';
                                                        $required =
                                                            $q_type == 2
                                                                ? 'required'
                                                                : '';

                                                        $q_options_arr = explode(
                                                            ',',
                                                            $q_options
                                                        );
                                                        foreach (
                                                            $q_options_arr
                                                            as $key2 => $option
                                                        ) { ?>  
                                                            <div>
                                                                <input type="<?php echo $type; ?>" name="question[<?php echo $q_id; ?>][answer][]" id="<?php echo $q_id .
    '_option_' .
    $key2; ?>" value="<?php echo trim($option); ?>"  <?php echo $required; ?> />
                                                                <label class="label" for="<?php echo $q_id .
                                                                    '_option_' .
                                                                    $key2; ?>"><?php echo trim(
    $option
); ?></label>
                                                            </div>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                </section>
                
                                            <?php } elseif ($q_type == 4) { ?>
                                                <input type="hidden" name="question[<?php echo $q_id; ?>][type]" value="<?php echo $q_type; ?>" class="form-input" />
                                                <textarea name="question[<?php echo $q_id; ?>][answer]" required></textarea>                                            
                                                <?php } elseif (
                                                $q_type == 5
                                            ) { ?>
                                                    <section class="option">
                                                        <div class="radio">                                                    <input type="hidden" name="question[<?php echo $q_id; ?>][type]" value="<?php echo $q_type; ?>" class="form-input" />
                                                            <input type="hidden" name="question[<?php echo $q_id; ?>][type]" value="<?php echo $q_type; ?>" class="form-input" />
                                                            <select name="question[<?php echo $q_id; ?>][answer][]" class="type" require>
                                                                <option value="" >--select--</option>
                                                                <?php
                                                                $q_options_arr = explode(
                                                                    ',',
                                                                    $q_options
                                                                );
                                                                foreach (
                                                                    $q_options_arr
                                                                    as $key2 =>
                                                                        $option
                                                                ) {
                                                                    echo "<option value='" .
                                                                        $option .
                                                                        "' >" .
                                                                        $option .
                                                                        '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </section>
                                                <?php } ?>
                                            
                                            
                                        </div>
                                        
                                        
                                        
                                    <?php
                                } ?>
                                
                                <input type="submit" value="Submit">
                            </form>
                        </div>
                </div>
            
            
            
            
            <?php } ?> 
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>