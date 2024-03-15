<?php
include 'partials/header.php';

// fetch topics from database
$query = "SELECT * FROM topics ORDER BY title";
$topics = mysqli_query($connection, $query);


?>

<section class="dashboard">

    <?php if (isset($_SESSION['add-topic-success'])) : //shows if add topic was successful 
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-topic-success'];
                unset($_SESSION['add-topic-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['add-topic'])) : //shows if add topic was NOT successful 
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['add-topic'];
                unset($_SESSION['add-topic']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-topic'])) : //shows if edit topic was NOT successful 
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['edit-topic'];
                unset($_SESSION['edit-topic']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-topic-success'])) : //shows if edit topic was successful 
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['edit-topic-success'];
                unset($_SESSION['edit-topic-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-topic-success'])) : //shows if delete topic was successful 
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-topic-success'];
                unset($_SESSION['delete-topic-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-topic'])) : //shows if delete topic was NOT successful 
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-topic'];
                unset($_SESSION['delete-topic']);
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
                    <a href="index.php"><i class="fa-regular fa-address-card"></i>
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
                        <a href="manage-topics.php" class="active"><i class="fa-solid fa-list-ul"></i>
                            <h5>Manage topics</h5>
                        </a>
                    </li>


                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage topics</h2>
            <?php if (mysqli_num_rows($topics) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($topic = mysqli_fetch_assoc($topics)) : ?>
                            <tr>
                                <td><?= $topic['title'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-topic.php?id=<?= $topic['id'] ?>" class="btn sm">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete-topic.php?id=<?= $topic['id'] ?>" class="btn sm danger">Delete</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error">No topics found</div>
            <?php endif ?>
        </main>
    </div>

</section>

<?php
include '../partials/footer.php'
?>