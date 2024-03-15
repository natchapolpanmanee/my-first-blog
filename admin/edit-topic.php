<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch topic from database
    $query = "SELECT * FROM topics WHERE id=$id";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) == 1) {
        $topic = mysqli_fetch_assoc($result);
    }
} else {
    header('location:' . ROOT_URL . 'admin/manage-topics.php');
    die();
}
?>



<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit topic</h2>
        <form action="<?= ROOT_URL ?>/admin/edit-topic-logic.php" method="POST">
            <input type="hidden" value="<?= $topic['id'] ?>" name="id">
            <input type="text" value="<?= $topic['title'] ?>" name="title" placeholder="Title">
            <textarea rows="4" name="description" placeholder="Description"><?= $topic['description'] ?></textarea>
            <button type="submit" name="submit" class="btn">Update topic</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php'
?>