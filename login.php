<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == "login") {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = filter_var($login, FILTER_SANITIZE_EMAIL);

        $db = new mysqli("localhost", "root", "", "cms");
        $q = $db->prepare("SELECT * FROM user WHERE Login = ?");
        $q->bind_param("s", $login);
        $q->execute();
        $result = $q->get_result();

        $userRow = $result->fetch_assoc();

        if($userRow == null) {
            echo "Błędny login lub hasło <br>";
        } else {
            if(password_verify($password, $userRow["Password"])) {
                echo "Zalogowano poprawnie <br>";
            } else {
                echo "Błędny login lub hasło <br>";
            }
        }
    }

    if(isset($_POST['action']) && $_POST['action'] == "register" && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['passwordRepeat'])) {
        $db = new mysqli("localhost", "root", "", "cms");
        $login = $_POST['login'];
        $login = filter_var($login, FILTER_SANITIZE_EMAIL); 

        $password = $_POST['password'];
        $passwordRepeat = $_POST['passwordRepeat'];

        if($password == $passwordRepeat) {
            $passwordHash = password_hash($password, PASSWORD_ARGON2I);
            $q = $db->prepare("INSERT INTO userr VALUES (NULL, ?, ?)");
            $q->bind_param("ss", $login, $passwordHash);
            $result = $q->execute();
            if($result) {
                echo "Konto utworzone poprawnie";
            } else {
                echo "Coś poszło nie tak";
            }
        } else {
            echo "Hasła się nie zgadzają, spróbuj ponownie.";
        }
    }
}
?>
<h1>Zaloguj Się</h1>
<form action="login.php" method="post">
    <label for="login">Login: </label> <br>
    <input type="email" name="login" id="login"><br>
    <label for="password">Hasło: </label> <br>
    <input type="password" name="password" id="password"> <br>
    <input type="hidden" name="action" value="login">
    <input type="submit" value="Zaloguj">
</form>

<h1>Zarejestruj sier</h1>
<form action="login.php" method="post">
    <label for="login">Login: </label> <br>
    <input type="email" name="login" id="login"><br>
    <label for="password">Hasło: </label> <br>
    <input type="password" name="password" id="password"> <br>
    <label for="passwordRepeat">Powtórz hasło: </label> <br>
    <input type="password" name="passwordRepeat" id="passwordRepeat"> <br>
    <input type="hidden" name="action" value="register">
    <input type="submit" value="Zarejestruj się">
</form>
