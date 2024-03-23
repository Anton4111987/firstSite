<h1>Upload Form</h1>

<?php
    if(!isset($_POST["uploadbtn"]) && !isset($_POST["uploadbtnfordb"]))
    {

    
?>
    <!-- аттрибут enctype необходим для загрузки файлов на сервер -->
    <form action="index.php?page=2" method="post" enctype="multipart/form-data">
        <div class="form-group my-2">
            <label for="myfile" class="form-label">Выберите файл для загрузки: </label>
            <input type="file" name="myfile" id="myfile" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-outline-primary" name="uploadbtn">Отправить файл</button>
        <button type="submit" class="btn btn-outline-primary" name="uploadbtnfordb">Отправить файл в базу данных</button>

    </form>


    <?php
    } 
    else
    {
        if(isset($_POST["uploadbtn"])) 
        {
            //если загрузка завершилась с ошибками
            if ($_FILES["myfile"]["error"] != 0) 
            {
                echo "<h3 class='text-danger'>Ошибка при загрузке файла: " . $_FILES["myfile"]["error"] . "</h3>";
                exit(); //завершаем выполнение текущего скрипта
            }
                //если файл есть во временной директории
            if (is_uploaded_file($_FILES["myfile"]["tmp_name"])) 
            {
                //переносим из временной директории в заготовленную для картинок
                move_uploaded_file($_FILES["myfile"]["tmp_name"],  "./images/" . $_FILES["myfile"]["name"]);
            }
                echo "<h3 class='text-success'>Файл " . $_FILES["myfile"]["name"] . " успешно загружен! </h3>";
            
        }
        if(isset($_POST["uploadbtnfordb"])) 
        {
            //если загрузка завершилась с ошибками
            if ($_FILES["myfile"]["error"] != 0) 
            {
                echo "<h3 class='text-danger'>Ошибка при загрузке файла: " . $_FILES["myfile"]["error"] . "</h3>";
                exit(); //завершаем выполнение текущего скрипта
            }
                //если файл есть во временной директории
            if (is_uploaded_file($_FILES["myfile"]["tmp_name"])) 
            {
                //переносим из временной директории в заготовленную для картинок
                move_uploaded_file($_FILES["myfile"]["tmp_name"],  "./images/" . $_FILES["myfile"]["name"]);
            }
                echo "<h3 class='text-success'>Файл " . $_FILES["myfile"]["name"] . " успешно загружен! </h3>";
                $path="/images/" . $_FILES["myfile"]["name"];
                $ins = "insert into images(imagepath) values('$path')";
                echo $ins;
                $link = connect();
                $link->query($ins);
                $link->close();
        }
    }

?>