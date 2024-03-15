<?php
require 'config/database.php';

// get signup form data if signup button was clicked
if (isset($_POST['submit'])) {
    $firstName = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createPassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmPassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // validate input values
    if (!$firstName) {
        $_SESSION['signup'] = "Please enter your First Name";
    } else if (!$lastName) {
        $_SESSION['signup'] = "Please enter your Last Name";
    } else if (!$username) {
        $_SESSION['signup'] = "Please enter your Username";
    } else if (!$email) {
        $_SESSION['signup'] = "Please enter your a valid email";
    } else if (strlen($createPassword) < 8 || strlen($confirmPassword) < 8) {
        $_SESSION['signup'] = "Password should be 8+ characters";
    } else if (!$avatar['name']) {
        $_SESSION['signup'] = "Please add avatar";
    } else {
        file_put_contents('log.txt', print_r($avatar, true));
        // check if passwords don't match
        if ($createPassword !== $confirmPassword) {
            $_SESSION['signup'] = "Passwords do not match";
        } else {
            //hash password
            $hashed_password = password_hash($createPassword, PASSWORD_DEFAULT);

            //check if username or email already exist in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = "Username or Email already exixt";
            } else {
                // Work on avatar
                // rename avatar
                $time = time(); //make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;

                // make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);
                if (in_array($extention, $allowed_files)) {
                    //make sure image is not too large (1mb+)
                    if ($avatar['size'] < 1000000) {
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['signup'] = "File size too big. Should be less than 1mb";
                    }
                } else {
                    $_SESSION['signup'] = "File should be png, jpg or jpeg";
                }
            }
        }
    }

    // redirect back to signup page if there was any problem
    if (isset($_SESSION['signup'])) {
        // pass form data back to sigup page
        $_SESSION['signup-data'] = $_POST;
        header('location:' . ROOT_URL . 'signup.php');
        die();
    } else {
        // insert new user into users table
        $insert_user_query = "INSERT INTO users (firstname,lastname,username,email,password,avatar,is_admin) VALUES('$firstName','$lastName','$username','$email','$hashed_password','$avatar_name',0)";
        $inser_user_result = mysqli_query($connection, $insert_user_query);
        if (!mysqli_errno($connection)) {
            // redirect to login page with success message
            $_SESSION['signup-success'] = "Registration successful. Please log in";
            header('location:' . ROOT_URL . 'signin.php');
            die();
        }
    }
} else {
    // if button wasn't clicked, bounce back to signup page
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
