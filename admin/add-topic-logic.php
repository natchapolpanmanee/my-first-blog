<?php
require 'config/database.php';


if (isset($_POST['submit'])) {
    // get form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$title) {
        $_SESSION['add-topic'] = "Enter title";
    } elseif (!$description) {
        $_SESSION['add-topic'] = "Enter description";
    }

    //redirect back to add topic page with form data if there was invalid input
    if (isset($_SESSION['add-topic'])) {
        $_SESSION['add-topic-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add-topic.php');
        die();
    } else {
        //insert topic into database
        $query = "INSERT INTO topics (title,description) VALUES('$title','$description')";
        $result = mysqli_query($connection, $query);
        if (mysqli_errno($connection)) {
            $_SESSION['add-topic'] = "Couldn't add topic";
            header('location:' . ROOT_URL . 'admin/add-topic.php');
            die();
        } else {
            $_SESSION['add-topic-success'] = "$title topic added successfully";
            header('location:' . ROOT_URL . 'admin/manage-topics.php');
        }
    }
}
