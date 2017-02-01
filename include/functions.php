<?php

function log_to_file($array)
{
    $file_name = time() . '_' . rand(0, 30) . '_log.txt';
    $myfile = fopen('logs/' . $file_name, "w");
    if (is_array($array))
        $array = var_export($array, true);
    fwrite($myfile, $array);
    fclose($myfile);
}

function log_telegram_error($res, $data, $file_name, $array = '')
{
    global $mysqli;
    
    if ($res['ok'] == true)
        return;

    $json_error = json_encode($res);
    if ( $array != '' )
        $json_error = json_encode($res) . "\n". json_encode($array);
    $date = $data['message']['date'];
    $day = date('d');
    $month = date('m');
    $year = date('Y');

    $sql = "INSERT INTO `error_logs` 
                      (`id`, `description`, `file_name`, `date`, `day`, `month`, `year`) VALUE 
                      (null, '$json_error', '$file_name', '$date', '$day', '$month', '$year')";
    $mysqli->query($sql);
}