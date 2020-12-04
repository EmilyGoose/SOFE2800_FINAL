<?php

$error = "";

// Check if this is a post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include and call function to connect to db
    include_once 'components/dbConnection.php';
    $conn = getConnection();

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    session_start();

    // Get post request variables
    //$email = $_POST["email"];
    $password = $_POST["password"];
    $mode = $_POST["mode"];
    //$firstName = $_POST["firstName"];
    //$lastName = $_POST["lastName"];
    $username = $_POST["username"];

    // Make a sql query to see if the user exists (This is useful for both login and signup)
    $sql = "SELECT username FROM user WHERE username = '$username';";
    if (mysqli_query($conn, $sql)->num_rows > 0) {
        $userExists = true;
    } else {
        $userExists = false;
    }

    if ($mode == "login") {
        // Make sure the user exists
        if ($userExists) {

            // Get a user matching the email/password pair
            $sql = "SELECT username ,id FROM user WHERE username = '$username' AND passwordHash = '$password';";
            $result = mysqli_query($conn, $sql);
            // If nothing was returned, the password is wrong
            if ($result->num_rows == 0) {
                $error = "Wrong password!";
            } else {
                while ($row = $result->fetch_assoc()) {
                    $_SESSION['sessionID'] = $row['id'];
                    //echo "your User id is ".$row['id']."<br>" ."session id is the same: ".$_SESSION['sessionID'];
                    header("Location:index.php");

                }
            }
        } else {
            $error = "User not found! Check your email address and try again.";
        }
    } else if ($mode == "signup") {
        // Check if the user exists
        if ($userExists) {
            $error = "A user already exists with that username";
        } else {
            // Insert the new info into the database
            $sql = "INSERT INTO user (username, passwordHash) VALUES ('$username','$password');";
            mysqli_query($conn, $sql);
            // Log the user in as the newly created user
            $_SESSION['sessionID'] = $conn->insert_id;
            header("Location:index.php");
        }
    }
}


?>

<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="scripts.js" async></script>
    <?php include_once("components/imports.php") ?>
</head>
<body>
<div id="loginBox">
    <div id="splitHeader">
        <button type="button" class="headerButton" id="loginButton" onclick="loginMode()">Log In</button>
        <button type="button" class="headerButton" id="signupButton" onclick="signupMode()">Sign Up</button>
    </div>
    <div id="formBody">
        <h1 class="formHeader">Login to my website</h1>
        <!-- Form posts to itself -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!--
            <label for="firstName" class="signup">First Name</label>
            <input type="text" id="firstName" class="signup" name="firstName">

            <label for="lastName" class="signup">Last Name</label>
            <input type="text" id="lastName" class="signup" name="lastName">
            -->

            <label for="username" class="login">Username</label>
            <input type="text" id="username" class="login" name="username" required>

            <!--
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            -->

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <input type="text" value="login" id="mode" name="mode" hidden>

            <input type="submit" id="submit">
            <p style="color: red"><?php echo $error; ?></p>
        </form>
    </div>
</div>
</body>
</html>
