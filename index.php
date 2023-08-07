<?php
include_once './header.php';
$user_id = $_SESSION['webuser']['id'];
$sql = 'SELECT * FROM `forms` WHERE created_by = ? ';
$data = getRows($sql, [$user_id]);

if (isset($_GET['f_id'])) {
    $f_id = $_GET['f_id'];
    // delete from form, question, reports
    $d1 = 'DELETE FROM `forms` WHERE `f_id` = ?';
    $d2 = 'DELETE FROM `questions` WHERE `f_id` = ?';
    $d3 = 'DELETE FROM `reports` WHERE `f_id` = ?';

    $res1 = setRow($d1, [$f_id]);
    $res2 = setRow($d2, [$f_id]);
    $res3 = setRow($d3, [$f_id]);

    if (
        getRow('SELECT * FROM `forms` WHERE `f_id` = ? ', [$f_id]) == false
    ) { ?>
<script>
    // console.log("jawwwad")
    window.location = <?php echo "'" . WEB_URL . "/index.php'"; ?>
</script>

<?php }
}

// var_dump($_SESSION['webuser']['id']);
?>
<div class="container">
    <h2>Dashboard</h2>
    <table class="table">
        <tr>
            <th>Sno</th>
            <th>Form Title</th>
            <th>No of Submission</th>
            <th>Actions</th>
        <tr>
        <?php foreach ($data as $key => $val) {

            $id = $val['f_id'];
            $title = $val['f_title'];
            $st_time = $val['f_st_time'];
            $end_time = $val['f_end_time'];
            $created_by = $val['created_by'];
            $sql_form_count = "SELECT COUNT(DISTINCT guest_user_email) AS 'rows' FROM reports WHERE f_id = '$id'";
            $sql_form_count_res = getRow($sql_form_count);
            $arr = [
                'f_id' => $id,
                'u_id' => $created_by,
                'from' => $st_time,
                'to' => $end_time,
            ];
            $jsonString = json_encode($arr);
            $token = base64_encode($jsonString);

            $view_link = WEB_URL . '/response.php?f_id=' . $id;
            $share_link = WEB_URL . '/share_form.php?t=' . $token;
            // $share_link = WEB_URL . '/form.php?t=' . $token;

            $download_link = WEB_URL . '/download_form_data.php?f_id=' . $id;
            $delete_link = WEB_URL . '/index.php?f_id=' . $id;
            ?>
            <tr>
            <td><?php echo $key + 1; ?></td>
            <td><?php echo $title; ?></td>
            <td><?php echo $sql_form_count_res['rows']; ?></td>
            <td>
            <?php if ($sql_form_count_res['rows'] > 0) { ?>
                <a href="<?php echo $view_link; ?>" target="_blank" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                <a href="<?php echo $download_link; ?>"  target="_blank" title="Export data"><i class="fa fa-download" aria-hidden="true"></i></a>
            <?php } ?>
            <a href="<?php echo $share_link; ?>" title="Share"> <i class="fa fa-share" aria-hidden="true"></i> </a>
            <a href="<?php echo $delete_link; ?>" onclick="return confirm('Are you sure?')" title="Delete"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
            </td>
        <tr>
        <?php
        } ?>
    <table>
</div>
<?php include_once './footer.php'; ?>

    



