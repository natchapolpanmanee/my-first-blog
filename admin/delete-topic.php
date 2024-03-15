<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // FOR LATER
    // update topic_id of posts that belong to this topic to id of uncategorized topic
    $update_query = "UPDATE posts SET topic_id = 5 WHERE topic_id = $id";
    $update_result = mysqli_query($connection, $update_query);

    if (!mysqli_errno($connection)) {
        // delete topic
        $query = "DELETE FROM topics WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
        $_SESSION['delete-topic-success'] = "topic delted successfully";
    }
}

header('location:' . ROOT_URL . 'admin/manage-topics.php');
die();
