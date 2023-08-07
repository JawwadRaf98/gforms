<?php
include_once 'header.php';

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

if (
    isset($_SESSION['validationToken']) &&
    @$_SESSION['validationToken'] == @$_POST['token']
) {
    $emails = $_POST['guest_email'];
    $emails = explode(',', $emails);
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $success = 'failed';
        $successMsg = 'You are at local server mail sending failed';
    } else {
        foreach ($emails as $key => $email) {
            if (
                filter_var($email, FILTER_VALIDATE_EMAIL) &&
                $_SERVER['HTTP_HOST'] !== 'localhost'
            ) {
                $subject = 'Survey Form';
                $token = $_GET['t'];
                $share_link = WEB_URL . '/form.php?t=' . $token;
                $msg = 'Please Fill the following form';
                echo mail($email, $subject, $msg);
            }
        }
        $success = true;
        $successMsg =
            'Mail has been send to validate emails that you have provided';
    }
}

if ($err) {
    echo '<div class="container"><div class="custom-alert danger" role="alert">' .
        $errMsg .
        '</div></div>';
} else {
     ?>
<div class="container">
    <h2>Share Form</h2>
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
                echo '<input type="hidden" name="token" value="' .
                    $token .
                    '" />';

                $token = $_GET['t'];
                $share_link = WEB_URL . '/form.php?t=' . $token;
                ?>
                <div class="mb-3">
                    <small><b>Link : <?php echo $share_link; ?></b></small>
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    
                    <input type="text" name="guest_email" placeholder="abc@xyz, def@xyy.com" required class="form-control form-input" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Please enter your email ids seperated by comma(,) whome you want to share this form</div>
                </div>
            
                <div class="form-group">
                    <button type="submit">Submit</button>
            </div>
                </form>
    
</div>
<?php
} ?>
