<?php

   //<?= htmlspecialchars(strip_tags($item));

require_once ('classes/filestore.php');

//var_dump($_GET)
//var_dump($_FILES)
//var_dump($_POST)

$stuff = new Filestore('data/todo.txt');
$items = $stuff->read('data/todo.txt');
$errorMessage = '';



// check if we need to remove an item from the list
if (isset($_GET['key'])) {
    $removeindex = $_GET['key'];
    unset($items[$_GET['key']]);
    $stuff->write($items);
}

// do we need to add a new item?
if (!empty($_POST['todoitem'])) {
    array_push($items, $_POST['todoitem']);
    $stuff->write($items);
}

// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {

    if ($_FILES['file1']['type'] == 'text/plain') {
        // Set the destination directory for uploads
        $upload_dir = '/vagrant/sites/todo.dev/public/uploads/';
        // Grab the filename from the uploaded file by using basename
        $uploadedFilename = basename($_FILES['file1']['name']);
        // Create the saved filename using the file's original name and our upload directory
        $saved_filename = $upload_dir . $uploadedFilename;
        // Move the file from the temp location to our uploads directory
        move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);

        $textfile = $saved_filename;
        $newfile = read($textfile);
        $items = array_merge($newfile, $items);

        $stuff->write($items);

    } else {
        //$errorMessage = "Not a valid file. Please use only a plain text file";
    }

}
if(isset($saved_filename)){
    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
}


?>
<!DOCTYPE html>
<html>

<head class="fancy-header">
     <meta http-equiv="content-type" content="text/csv; charset=UTF-8"/>
    <title>Todo PHP</title>
    <link rel="stylesheet" href ="css/todo_list.css">
</head>
<body>
<!--    <div>
 -->    <h1 class="fancy-header" id="child"><center>TODO</center></h1>
    
    <?if(!empty($errorMessage)) : ?>
    <li><?= $errorMessage;?></li>
    <? endif; ?>


    <ul>
   
    <?foreach ($items as $key => $item) : ?>
    <li><?= $item ?><a href="?key=<?= $key; ?>">Mark Complete</a></li>
    <? endforeach; ?>
    </ul>

    <h1 class="fancy-header">Please add more todo list!</h1>
    <form method="POST" action="/todo_list.php">
        <p>
            <label for="todoitem">Add Todo Item</label>
            <input id="todoitem" name="todoitem" type="text" placeholder="Enter Your Item">
        </p>
            <input type="submit" value="Submit">
        </p>
    </form>

    <h1 class="fancy-header">Upload File</h1>
    <form method="POST" enctype="multipart/form-data">
        <p>
            <label for="file1">File to upload: </label>
            <input type="file" id="file1" name="file1">
        </p>
        <p>
            <input type="submit" value="Upload">
        </p>
    </form>
<!-- </div>
 --></body>
</html>