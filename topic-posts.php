<?php
include './partials/header.php';

// fetch posts if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE topic_id = $id ORDER BY date_time DESC";
    $posts = mysqli_query($connection, $query);
} else {
    header('location:' . ROOT_URL . 'blog.php');
    die();
}
?>

<header class="topic__title">
    <h2>
        <?php
        // fetch topic from topics table using topic_id of post
        $topic_id = $id;
        $topic_query = "SELECT * FROM topics WHERE id = $topic_id";
        $topic_result = mysqli_query($connection, $topic_query);
        $topic = mysqli_fetch_assoc($topic_result);
        echo $topic['title'];
        ?>
    </h2>
</header>
<!-- ================================ END OF topic TITLE ======================================== -->


<?php if (mysqli_num_rows($posts) > 0) : ?>
    <section class="posts">
        <div class="container posts__container">
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>" alt="">
                    </div>
                    <div class="post__info">
                        <h3 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h3>
                        <p class="post__body">
                            <?= substr($post['body'], 0, 150) ?>...
                        </p>
                        <div class="post__author">
                            <?php
                            // fetch author from users table using author_id
                            $author_id = $post['author_id'];
                            $author_query = "SELECT * FROM users WHERE id = $author_id";
                            $author_result = mysqli_query($connection, $author_query);
                            $author = mysqli_fetch_assoc($author_result);
                            ?>
                            <div class="post__author-avatar">
                                <img src="./images/<?= $author['avatar'] ?>" alt="">
                            </div>
                            <div class="post__author-info">
                                <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                                <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile ?>

        </div>
    </section>
<?php else : ?>
    <div class="alert__message error lg">
        <p>No posts found for this topic</p>
    </div>
<?php endif ?>
<!-- ================================ END OF POSTS ======================================== -->

<section class="topic__buttons">
    <div class="container topic__buttons-container">
        <?php
        $all_topics_query = 'SELECT * FROM topics';
        $all_topics = mysqli_query($connection, $all_topics_query);
        ?>
        <?php while ($topic = mysqli_fetch_assoc($all_topics)) : ?>
            <a href="<?= ROOT_URL ?>topic-posts.php?id=<?= $topic['id'] ?>" class="topic__button"><?= $topic['title'] ?></a>
        <?php endwhile ?>
    </div>
</section>
<!-- ================================ END OF topic BUTTONS ======================================== -->
<?php
include './partials/footer.php'
?>