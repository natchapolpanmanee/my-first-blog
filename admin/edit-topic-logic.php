<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate input
    if (!$title || !$description) {
        $_SESSION['edit-topic'] = "Invalid form input on edit topic page";
    } else {
        $query = "UPDATE topics SET title='$title',description='$description' WHERE id = $id LIMIT 1";
        $result = mysqli_query($connection, $query);

        if (mysqli_errno($connection)) {
            $_SESSION['edit-topic'] = "Couldn't update topic";
        } else {
            $_SESSION['edit-topic-success'] = "topic $title updated successfully";
        }
    }
}


header('location:' . ROOT_URL . 'admin/manage-topics.php');
die();
