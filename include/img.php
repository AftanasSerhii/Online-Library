<?php
$title = $row['title']; 
$basePath = "imeges/section-catalog/"; 


$jpgPath = $basePath . $title . ".jpg";
$pngPath = $basePath . $title . ".png";


if (file_exists($jpgPath)) {
    $imagePath = $jpgPath; 
} elseif (file_exists($pngPath)) {
    $imagePath = $pngPath; 
} else {
    $imagePath = $basePath . "default.jpg"; 
}
?>