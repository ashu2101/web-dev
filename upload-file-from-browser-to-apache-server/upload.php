<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>

<div class="position-absolute top-0 start-50 translate-middle-x">
    <div class="d-flex p-3 bd-highlight">
        <div class="container-fluid p-5 " style="border-style: solid">
            <h3>Upload Extensions and Scripts</h3>
            <br>
            <hr>
            <form action="?" method="POST" enctype="multipart/form-data">
                <div class="align-content-xxl-center my-2">
                    <select class="d-block p-2 text-light bg-info" style="width: 100%;" name="location" id="location">
                        <option value="extensions">Extensions</option>
                        <option value="scripts">Scripts</option>
                    </select>
                </div>
                <br/>
                <input type="file" name="files"/>
                <br>
                <input type="submit" name="fileupload" value="Upload File">
            </form>

            <?php
            // echo "hello world";
            if (isset($_POST['fileupload'])) {
                echo $_FILES['files'];
                $file_name = $_FILES['files']['name'];
                $file_temp_loc = $_FILES['files']['tmp_name'];
                $location = $_POST['location']."/".$file_name;

                if (move_uploaded_file($file_temp_loc,  $location)){
                    echo $file_name ." was uploaded successfully to ". $location;
                }else{
                    echo "Error: ".$file_name ." was not uploaded, please try again";
                }
            }
            ?>
            
        </div>
    </div>
</div>

</body>
</html>
