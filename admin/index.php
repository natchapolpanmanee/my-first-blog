<?php
include 'partials/header.php';

// fetch current user's posts from database
$current_user_id = $_SESSION['user-id'];
$query = "SELECT id,title,topic_id FROM posts WHERE author_id = $current_user_id ORDER BY id DESC";
$posts = mysqli_query($connection, $query);
?>

<section class="dashboard">
    <?php if (isset($_SESSION['add-post-success'])) : // shows if add post was successful 
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-post-success'];
                unset($_SESSION['add-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post-success'])) : // shows if edit post was successful 
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['edit-post-success'];
                unset($_SESSION['edit-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post'])) : // shows if edit post was NOT successful 
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['edit-post'];
                unset($_SESSION['edit-post']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-post-success'])) : // shows if delete post was successful 
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-post-success'];
                unset($_SESSION['delete-post-success']);
                ?>
            </p>
        </div>
    <?php endif ?>
    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="fa-solid fa-chevron-right"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="fa-solid fa-chevron-left"></i></button>
        <aside>
            <ul>
                <li>
                    <a href="add-post.php"><i class="fa-solid fa-pen"></i>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php" class="active"><i class="fa-regular fa-address-card"></i>
                        <h5>Manage Posts</h5>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_is_admin'])) : ?>
                    <li>
                        <a href="add-user.php"><i class="fa-solid fa-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-users.php"><i class="fa-solid fa-user-gear"></i>
                            <h5>Manage User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-topic.php"><i class="fa-regular fa-pen-to-square"></i>
                            <h5>Add topic</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-topics.php"><i class="fa-solid fa-list-ul"></i>
                            <h5>Manage topics</h5>
                        </a>
                    </li>

                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Posts</h2>
            <?php if (mysqli_num_rows($posts) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Topic</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                            <!-- get topic title of each post from topics table -->
                            <?php
                            $topic_id = $post['topic_id'];
                            $topic_query = "SELECT title FROM topics WHERE id=$topic_id";
                            $topic_result = mysqli_query($connection, $topic_query);
                            $topic = mysqli_fetch_assoc($topic_result);


                            ?>
                            <tr>
                                <td><?= $post['title'] ?></td>
                                <td><?= $topic['title'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete-post.php?id=<?= $post['id'] ?>" class="btn sm danger">Delete</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error">No posts found</div>
            <?php endif ?>
        </main>
    </div>

</section>

<?php
include '../partials/footer.php';
?>