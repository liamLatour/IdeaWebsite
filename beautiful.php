<?php
$output = nl2br(htmlspecialchars($output));
$output = str_replace("**bold", "<b>", $output);
$output = str_replace("bold**", "</b>", $output);

$output = str_replace("**italic", "<i>", $output);
$output = str_replace("italic**", "</i>", $output);

$output = str_replace("**mark", "<mark>", $output);
$output = str_replace("mark**", "</mark>", $output);

$output = str_replace("**sup", "<sup>", $output);
$output = str_replace("sup**", "</sup>", $output);

$output = str_replace("**sub", "<sub>", $output);
$output = str_replace("sub**", "</sub>", $output);

$output = str_replace("**insert", "<ins>", $output);
$output = str_replace("insert**", "</ins>", $output);
echo $output; 
?>