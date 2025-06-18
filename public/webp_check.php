<?php
echo "<h2>GD Library</h2>";
if (function_exists('gd_info')) {
    $gd = gd_info();
    echo "<pre>";
    print_r($gd);
    echo "</pre>";
} else {
    echo "GD tidak tersedia.<br>";
}

echo "<h2>Imagick</h2>";
if (class_exists('Imagick')) {
    $imagick = new Imagick();
    $formats = $imagick->queryFormats();
    echo "Imagick tersedia.<br>";
    echo "WEBP Support: " . (in_array('WEBP', $formats) ? 'Ya' : 'Tidak') . "<br>";
} else {
    echo "Imagick tidak tersedia.<br>";
}
