<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/sign_in.php");
    exit();
}

if ($_SESSION['user_role'] != "admin") {
    header("Location: ../index.php");
    exit();
}

require __DIR__ . "/../model/category.php";

$message = "";

if (isset($_POST['submit'])) {

    $name = $_POST['name'];

    if (empty($name)) {

        $message = "Category name cannot be empty.";

    } else {

        $result = addCategory($name);

        if ($result) {
            $message = "Category Added Successfully";
        } else {
            $message = "Error! Category was not added.";
        }
    }
}

require __DIR__ . "/../view/admin/add_category.php";

?>
