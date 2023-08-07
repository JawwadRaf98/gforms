<?php
include_once 'header.php';
$id = isset($_GET['f_id']) ? $_GET['f_id'] : '';
?>

<div class="container">
    <?php if (empty($id)) { ?>
        <h2>Invalide Link</h2>
    <?php } else {
        $question_sql = 'SELECT * FROM `questions` WHERE `f_id` = ? ';
        $question_data = getRows($question_sql, [$id]);

        $response_sql =
            'SELECT DISTINCT `guest_user_email` FROM `reports` WHERE `f_id` = ? ';
        $response_data = getRows($response_sql, [$id]);
        ?>
    <h2>User response</h2>
    
    <table class="table">
        <tr>
            <th>Users/Questions</th>
            <?php foreach ($question_data as $key => $val) {
                echo '<th>' . $val['q_title'] . '</th>';
            } ?>
        </tr>
        
        <?php foreach ($response_data as $key1 => $val1) {
            $g_user = $val1['guest_user_email'];
            echo '<tr>';
            echo '<td>' . $g_user . '</td>';

            $sql_for_single_res =
                'SELECT * FROM `reports` WHERE `f_id` = ? AND `guest_user_email` = ? ';
            $sql_for_single_res_data = getRows($sql_for_single_res, [
                $id,
                $g_user,
            ]);
            foreach ($sql_for_single_res_data as $key2 => $val2) {
                echo '<td>' . $val2['answers'] . '</td>';
            }
            echo '</tr>';
        } ?>
    <table>
    
    
    
    
        
    <?php } ?>
       
</div>