<?php
include_once 'config.php';
$id = isset($_GET['f_id']) ? $_GET['f_id'] : '';
$table = '';
$file_name = '';
if (!empty($id)) {
    $form_sql = 'SELECT `f_title` FROM `forms` WHERE `f_id` = ? ';
    $form_data = getRow($form_sql, [$id]);
    $file_name = str_replace(' ', '_', $form_data['f_title']) . '.csv';

    $question_sql = 'SELECT * FROM `questions` WHERE `f_id` = ? ';
    $question_data = getRows($question_sql, [$id]);
    $response_sql =
        'SELECT DISTINCT `guest_user_email` FROM `reports` WHERE `f_id` = ? ';
    $response_data = getRows($response_sql, [$id]);

    $table .= 'Users/Questions,';
    foreach ($question_data as $key => $val) {
        $table .= $val['q_title'] . ',';
    }
    $table .= "\n";
    foreach ($response_data as $key1 => $val1) {
        $g_user = $val1['guest_user_email'];
        $table .= $g_user . ',';

        $sql_for_single_res =
            'SELECT * FROM `reports` WHERE `f_id` = ? AND `guest_user_email` = ? ';
        $sql_for_single_res_data = getRows($sql_for_single_res, [$id, $g_user]);
        foreach ($sql_for_single_res_data as $key2 => $val2) {
            $answers = str_replace(',', '  ||  ', $val2['answers']);
            $table .= $answers . ',';
        }
        $table .= "
            ";
    }

    header('Content-Type:   application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $file_name); //File name extension was wrong
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);

    echo $table;
}
?>
       
