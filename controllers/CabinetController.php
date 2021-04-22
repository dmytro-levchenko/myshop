<?php

class CabinetController
{
    public function actionIndex()
    {
        
        // Получаем индефикатор юзера из сессии
        $userId = User::checkLogged();

        // Получаем информацию о юзере из БД
        $user = User::getUsersById($userId);

        require_once(ROOT . '/views/cabinet/index.php');

        return true;
    }

    public function actionEdit()
    {
        // Получаем индефикатор юзера из сессии
        $userId = User::checkLogged();

        // Получаем информацию о юзере из БД
        $user = User::getUsersById($userId);

        $name = $user['name'];
        $password = $user['password'];

        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];

            if (!User::checkName($name)) {
                $errors[] = 'Имя короче 2 символов. Введите имя длинее';
            }
            
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль короче 6 символов. Введите пароль длинее';
            }

            if ($errors == false) {
                $result = User::edit($userId, $name, $password);
            }
        }
        
        require_once(ROOT . '/views/cabinet/edit.php');

        return true;
    }
}