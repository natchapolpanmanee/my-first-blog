<?php
include 'partials/header.php';

// get back form data if invalid
$title = $_SESSION['add-topic-data']['title'] ?? null;
$description = $_SESSION['add-topic-data']['description'] ?? null;

unset($_SESSION['add-topic-data']);
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Add topic</h2>
        <?php if (isset($_SESSION['add-topic'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-topic'];
                    unset($_SESSION['add-topic']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-topic-logic.php" method="POST">
            <input type="text" value="<?= $title ?>" name="title" placeholder="Title">
            <textarea rows="4" name="description" placeholder="Description"><?= $description ?></textarea>
            <button type="submit" name="submit" class="btn">Add topic</button>
        </form>
    </div>
</section>

<?php
include '..partials/footer.php'
?>