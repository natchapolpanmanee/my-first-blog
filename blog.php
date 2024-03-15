<?php
include './partials/header.php';

// fetch all posts from posts table
$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$posts = mysqli_query($connection, $query);
?>

<section class="search__bar">
    <form action="<?= ROOT_URL ?>search.php" class="container search__bar-container" method="GET">
        <div>
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" name="search" placeholder="Search">
        </div>
        <button type="submit" name="submit" class="btn">Go</button>
    </form>
</section>
<!-- ================================ END OF SEARCH ======================================== -->

<section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
    <div class="container posts__container">
        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?= $post['thumbnail'] ?>" alt="">
                </div>
                <div class="post__info">
                    <?php
                    // fetch topic from topics table using topic_id of post
                    $topic_id = $post['topic_id'];
                    $topic_query = "SELECT * FROM topics WHERE id = $topic_id";
                    $topic_result = mysqli_query($connection, $topic_query);
                    $topic = mysqli_fetch_assoc($topic_result);
                    ?>

                    <a href="<?= ROOT_URL ?>topic-posts.php?id=<?= $post['topic_id'] ?>" class="topic__button"><?= $topic['title'] ?></a>
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