<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $file = base_url() . 'assets/img/444807.jpeg';
    $image = imagecreatefromstring(file_get_contents($file));
    ob_start();
    imagejpeg($image, NULL, 100);
    $cont = ob_get_contents();
    ob_end_clean();
    imagedestroy($image);
    $content = imagecreatefromstring($cont);
    $output = base_url() . 'assets/img/output.webp';
    imagewebp($content, $output);
    imagedestroy($content);
    echo '<h4>Output Image Saved as ' . $output . '</h4>';
    ?>
</body>

</html>