<?php include '../connect.php'; 

if(isset($_SESSION['connected'])) {
    if ($_SESSION['connected'] == true){
        header("Location: ../home");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to Twist</title>
        <?php require "../style.php"; ?>
        <link rel="shortcut icon" href="../assets/icon_v1.png" type="image/x-icon">
    </head>
    <body>
        <div id="container">
            <div class="block navbar" style="width: 100%;">
                <div class="left flex">
                    <a href="../"><img src="../assets/logo_v1.png" alt="Twist Logo" class="logo"></a>
                    <h3 class="title">Welcome to Twist</h3>
                </div>
            </div>
            <div class="page">
                <h1>What's Twist ?</h1>
                <p>
                    Twist is a social network developed by <a href="http://mazegroup.org/">MazeGroup</a> (Genius_um) allowing you to share your posts with your community and interact with others. It was created with the aim of competing with the Plot social network developed by Rayanis55 during a competition for who would create the best post-type social network with these specifications :
                    <ul>
                        <li>In retro style of socials networks of 2008</li>
                        <li>The social network will have to evolve</li>
                        <li>In <a href="https://fr.wikipedia.org/wiki/Skeuomorphisme">skeuomorphism</a> style</li>
                        <li>The two admins/competitor (Genius_um & Rayanis55 - of MazeGroup) will be able to invite anyone to their social network to promote or animate it.</li>
                        <li>No responsive, like back then</li>
                    </ul>
                </p>
                <hr>
                <h1>Enter on Twist</h1>
                <div class="twos">
                    <div class="left">
                        <div class="section">
                            <div class="flex">
                                <h2>Sign up</h2>
                            </div><br>
                            <form method="POST" action="../welcome/act.php">
                                <label for="email">📧 E-Mail :</label><br>
                                <input type="email" name="email" id="email" placeholder="In lowercase" class="lower"><br>
                                <label for="username">👨 Username : <red>*</red></label><br>
                                <input type="text" name="username" id="username" maxlength="16" minlength="3" placeholder="Lenght : 3 to 16, in lowercase" required class="lower"><br>
                                <label for="password">🔒 Password : <red>*</red></label><br>
                                <input type="password" name="password" id="password" maxlength="16" minlength="3" placeholder="Lenght : 3 to 16" required><br>
                                <label for="password_confirmation">🔒 Password confirmation : <red>*</red></label><br>
                                <input type="password" name="password_confirmation" id="password_confirmation" maxlength="16" minlength="3" placeholder="Lenght : 3 to 16" required><br><br>
                                <button type="submit" name="signup">Create a account</button>
                                <p style="font-size:10px "> By creating an account you accept our <a href="../help/privacy.php">privacy policy</a></p>
                                <?php
                                    if (isset($_GET['1_err'])) {
                                        $err = htmlspecialchars($_GET['1_err']);

                                        switch($err)
                                        {
                                            case 'email_already':
                                                ?>
                                                <red>
                                                    Email already taken
                                                </red>
                                                <?php
                                                break;
                                            case 'username_already':
                                                ?>
                                                <red>
                                                    Username already taken
                                                </red>
                                                <?php
                                                break;
                                            case 'same_password':
                                                ?>
                                                <red>
                                                    The password and the confirmation are'nt the same
                                                </red>
                                                <?php
                                                break;
                                            case 'len_username':
                                                ?>
                                                <red>
                                                    Username lenght must be between 3 and 16
                                                </red>
                                                <?php
                                                break;
                                            case 'len_password':
                                                ?>
                                                <red>
                                                    Password lenght must be between 3 and 16
                                                </red>
                                                <?php
                                                break;
                                            default:
                                                ?>
                                                <red>
                                                    Unkown error
                                                </red>
                                                <?php
                                                break;
                                        }
                                    }
                                ?>
                            </form>
                        </div>
                    </div>
                    <div class="right">
                        <div class="section">
                            <div class="flex">
                                <h2>Log In</h2>
                            </div><br>
                            <form method="POST" action="../welcome/act.php">
                                <label for="username">👨 Username : <red>*</red></label><br>
                                <input type="text" name="username" id="username" maxlength="16" minlength="3" placeholder="Lenght : 3 to 16, in lowercase" required class="lower"><br>
                                <label for="password">🔒 Password : <red>*</red></label><br>
                                <input type="password" name="password" id="password" maxlength="16" minlength="3" placeholder="Lenght : 3 to 16" required><br><br>
                                <button type="submit" name="login">Connect</button>
                                <?php
                                    if (isset($_GET['2_err'])) {
                                        $err = htmlspecialchars($_GET['2_err']);

                                        switch($err)
                                        {
                                            case 'bad_username':
                                                ?>
                                                <red>
                                                    Bad username
                                                </red>
                                                <?php
                                                break;
                                            case 'bad_password':
                                                ?>
                                                <red>
                                                    Bad password
                                                </red>
                                                <?php
                                                break;
                                            default:
                                                ?>
                                                <red>
                                                    Unkown error
                                                </red>
                                                <?php
                                                break;
                                        }
                                    }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <? include "../components/footer.php" ?>
        </div>
        <script>
            var container = document.getElementById('container');
            container.style.height = Math.max(window.innerHeight, container.scrollHeight) + 'px';
        </script>
    </body>
</html>
