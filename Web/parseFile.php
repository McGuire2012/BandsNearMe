<?php
$txt_file    = file_get_contents('path/to/file.txt');
$rows        = explode("\n", $txt_file);
array_shift($rows);

foreach($rows as $row => $data)
{
	//hi rachel
    //get row data
    $row_data = explode(',', $data);

    $info[$row]['band']           = $row_data[0];
    $info[$row]['venue']         = $row_data[1];
    $info[$row]['description']  = $row_data[2];
    $info[$row]['time']       = $row_data[3];

    //display data
    echo 'Row ' . $row . ' BAND: ' . $info[$row]['band'] . '<br />';
    echo 'Row ' . $row . ' VENUE: ' . $info[$row]['venue'] . '<br />';
    echo 'Row ' . $row . ' DESCRIPTION: ' . $info[$row]['description'] . '<br />';
    echo 'Row ' . $row . ' TIME: ' . $info[$row]['time']  . '<br />';



    foreach($row_images as $row_image)
    {
        echo ' - ' . $row_image . '<br />';
    }

    echo '<br />';
}
?>
