<?php
class User {
    
    private $id;
    private $email;
    private $password;

    

    //konstruktor
    public function __construct(int $id, string $email)
    {
        
        $this->id = $id;
        $this->email = $email;
    }


    public static function Register(string $email, string $password) : bool {
        
        $db = new mysqli('localhost', 'root', '', 'cms');
        $sql = "INSERT INTO user (email, password) VALUES (?, ?)";
        $q = $db->prepare($sql);
        $passwordHash = password_hash($password, PASSWORD_ARGON2I);
        $q->bind_param("ss", $email, $passwordHash);
        $result = $q->execute();
        return $result;
    }
    public static function Login(string $email, string $password) : bool {
        
        $db = new mysqli('localhost', 'root', '', 'cms');
        $sql = "SELECT * FROM user WHERE email = ? LIMIT 1";
        $q = $db->prepare($sql);
        $q->bind_param("s", $email);
        $q->execute();
        $result = $q->get_result();
        $row = $result->fetch_assoc();
        //tu muszą się nazwy w nawiasach [] zgadzać z nazwą kolumny w bazie danych
        $id = $row['ID'];
        $passwordHash = $row['password'];
        if(password_verify($password, $passwordHash)) {
            //hasło się zgadza
            //zapisz dane użytkownika do sesji
            $user = new User($id, $email);
            $_SESSION['user'] = $user;
            return true;
        } else {
            //hasło się nie zgadza
            return false;
        }
    }
    public function Logout() {
        //funkcja wylogowuje użytkownika

    }
}

?>