<?php
session_start();

class PDO_ extends PDO
{
    public $dsn = 'mysql:host=localhost;dbname=dorogi';
    public $user = 'root';
    public $pass = 'root';

    /**
     * PDO constructor.
     */
    public function __construct()
    {
        try {
            parent::__construct($this->dsn, $this->user, $this->pass);

        } catch (PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();

        }
    }

    function SignUp($mail, $password, $name, $surname, $patronymic, $login)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = $this->prepare("INSERT INTO `user` (`name`,`surname`,`patronymic`,`login`,`mail`, `password`,`root`) VALUES (:name,:surname,:patronymic,:login,:mail,:password,'0')");
        $query->bindParam(':surname', $surname, PDO::PARAM_STR);
        $query->bindParam(':patronymic', $patronymic, PDO::PARAM_STR);
        $query->bindParam(':login', $login, PDO::PARAM_STR);
        $query->bindParam(':mail', $mail, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->execute();
    }

    function getUserMail($mail)
    {
        $query = $this->prepare("SELECT mail FROM user WHERE mail=:mail");
        $query->bindParam(':mail', $mail, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);

    }


    function getToken($mail)
    {
        $query = $this->prepare("SELECT mail, password FROM user WHERE mail=:mail");
        $query->bindParam(':mail', $mail, PDO::PARAM_STR);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row != null) {
            return $row['password'];
        } else return "";
    }

    function getUserPass($password, $token)
    {

        return password_verify($password, $token);
    }

    function checkUserPass($mail, $password)
    {

        return $this->getUserPass($password, $this->getToken($mail));
    }

    function logIn($mail, $password)
    {
        session_start();

        if (!isset($_SESSION['mail']) && !isset($_SESSION['password'])) {
            if ($this->checkUserPass($mail, $password) == true) {
                if ($this->admin_verify($mail) == "1") {
                    $_SESSION['mail'] = $mail;
                    $_SESSION['root'] = $this->admin_verify($mail)['root'];
                } else {
                    $_SESSION['id'] = $this->getUserId($mail)['id'];
                    $_SESSION['name'] = $this->getUserName($mail)['name'];
                    $_SESSION['mail'] = $mail;
                    $_SESSION['root'] = $this->admin_verify($mail)['root'];
                }
            } else return false;
        } else return true;
    }

    function admin_verify($mail)
    {
        $query = $this->prepare("SELECT root FROM user WHERE mail=:mail");
        $query->bindParam(':mail', $mail, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getUserName($mail)
    {
        $query = $this->prepare("SELECT name FROM user WHERE mail=:mail");
        $query->bindParam(':mail', $mail, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function getUserId($mail)
    {
        $query = $this->prepare("SELECT id FROM user WHERE mail=:mail");
        $query->bindParam(':mail', $mail, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function logOut()
    {
        session_start();
        unset($_SESSION['id']);
        unset($_SESSION['name']);
        unset($_SESSION['mail']);
        unset($_SESSION['root']);
    }

    function addCategory($category_name)
    {
        $query = $this->prepare("INSERT INTO `category`(`category_name`) VALUES (:category_name)");
        $query->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        $query->execute();

    }

    function getCategory()
    {
        $query = $this->prepare("SELECT * FROM category ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function addRequest($name, $description, $id_category, $photo)
    {
        $data = date("Y-m-d H:i:s");
        $id_user = $_SESSION['id'];
        $query = $this->prepare("INSERT INTO `request`(`name`, `description`, `photoBefore`, `photoAfter` ,`data`, `status`, `id_user`, `id_category`) VALUES (:name,:description,:photo,'null',:data,'Новая',:id_user,:id_category)");
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':id_user', $id_user, PDO::PARAM_STR);
        $query->bindParam(':data', $data, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':id_category', $id_category, PDO::PARAM_STR);
        $query->bindParam(':photo', $photo, PDO::PARAM_STR);

        $query->execute();

    }

    function deleteRequest($id_request)
    {
        $query = $this->prepare("DELETE FROM `request` WHERE id = :id_request");
        $query->bindParam(':id_request', $id_request, PDO::PARAM_STR);
        $query->execute();

    }

    function getUserInfo()
    {
        $query = $this->prepare("SELECT request.id,request.name,request.description,category.category_name,request.status,request.data FROM request INNER JOIN category  INNER JOIN user WHERE user.id=:id_user and category.id=request.id_category and user.id=request.id_user");
        $query->bindParam(':id_user', $_SESSION['id'], PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getRequestMain()
    {
        $query = $this->prepare("SELECT request.id_category,request.name,request.photoAfter,request.photoBefore,request.status,category.category_name, category.id,request.id,request.data FROM request INNER JOIN category WHERE category.id=request.id_category ORDER BY request.data DESC LIMIT 4 ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function deleteCategory($id_request)
    {
        $query = $this->prepare("DELETE FROM category WHERE id = :id_request");
        $query->bindParam(':id_request', $id_request, PDO::PARAM_STR);
        $query->execute();
    }


    function requestAccess($id_request){
        $status='Решена';
        $query = $this->prepare("UPDATE `request` SET `status`=:status WHERE id=:id_request");
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':id_request', $id_request, PDO::PARAM_STR);
        $query->execute();
    }
    function requestReject($id_request){
        $status='Отклонена';
        $query = $this->prepare("UPDATE `request` SET `status`=:status WHERE id=:id_request");
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':id_request', $id_request, PDO::PARAM_STR);
        $query->execute();
    }
    function checkRequest($id_request){
        $query = $this->prepare("SELECT status FROM request WHERE id = :id_request");
        $query->bindParam(':id_request', $id_request, PDO::PARAM_STR);
        $query->execute();
    }
}
