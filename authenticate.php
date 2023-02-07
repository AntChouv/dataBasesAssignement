
<?php

function __autoload($name) {
    include_once $name . '.php';
}

$db = new DbHandler();
session_start();
if (isset($_POST['login'])) {
    //echo 'eeeeeeeeeeeeeeee';
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    //$userKind = htmlspecialchars($_POST['userKind']);
    $result = $db->login($username, $password);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userKind = $row["userKind"];
            $customerId = $row['customerId'];
        }
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['userKind'] = $userKind;
        $_SESSION['customerId'] = $customerId;
        //echo 'buongiorno'.$_SESSION['loggedin'];
        header('Location: index.php');
    } else {
        echo 'can not log in';
    }
}
