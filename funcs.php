<?php
//add a str to the end of a file
function append($string, $orig_filename)
{
    $string .= (PHP_EOL);
    $context = stream_context_create();
    $orig_file = fopen($orig_filename, 'r', 1, $context);

    $temp_filename = tempnam(sys_get_temp_dir(), 'php_prepend_');
	file_put_contents($temp_filename, $orig_file);
    file_put_contents($temp_filename, $string, FILE_APPEND);

    fclose($orig_file);
    unlink($orig_filename);
    rename($temp_filename, $orig_filename);
    chmod($orig_filename, 0777);
}

function starts_with($find_in, $to_find)
{ //find if a str starts with another str
     $length = strlen($to_find);
     return (substr($find_in, 0, $length) === $to_find);
}
?>
