<h1>Gallery</h1>




<form action="index.php?page=3" method="post">
    <p>Выберите расширение файла изображения: </p>
    <select name="extensions" class="form-select w-25">
        <?php
            $path="images/";
            if($dir=opendir($path))
            {
                $arr = array();
            // считываем файлы из директории пока они есть
                while(($file=readdir($dir))!==false)
                {
                    $fullname=$path. $file;
                    $pos=strpos($fullname, "."); // получаем позицию точки из полного имени файла
                    $ext=substr($fullname, $pos+1); // получаем строку на следующей позиции после точки, это будет расширение
                    // если такого расширения нет в массиве - записываем
                    if(!in_array($ext, $arr))
                    {
                        $arr[]=$ext;
                        echo "<option>" . $ext . "</option>";
                    }
                }
                closedir();
 
            }
 
        ?>
    </select>
    <input type="submit" value="Показать картинки" class="btn btn-outline-primary mt-2" name="submit">
</form>

<?php

if (isset($_POST["submit"])) {
    $ext = $_POST["extensions"];
    //поиск 
    $arr = glob($path . "*." . $ext);
    echo "<div class='panel panel-primary'>";
    echo "<div class='panel-heading'>";
    echo "<h3 class='panel-title'>Gallery content</h3></div>";
    foreach ($arr as $a) {
        echo "<a href='$a' target='_blank'>
                <img src='$a' height='100px' border='0' alt='picture' class='img-polaroid'/>    
            </a>";
    }
    echo "</div>";
}
?>