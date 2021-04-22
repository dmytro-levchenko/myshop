<?php
/**
 * Контроллер UserController
 */
class UserController
{
    /**
     * Action для страницы "Регистрация"
     */
    public function actionRegister()
    {
        $name = false;
        $email = false;
        $password = false;
        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $errors = false;

            if (!User::checkName($name)) {
                $errors[] = 'Имя короче 2 символов. Введите имя длинее';
            }

            if (!User::checkEmail($email)) {
                $errors[] = 'Email неправильный';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль короче 6 символов. Введите пароль длинее';
            }

            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой Email существует';
            }

            if ($errors == false) {
                $result = User::register($name, $email, $password);
            }
        }
        // Подключаем вид
        require_once(ROOT . '/views/user/register.php');
        return true;
    }

    /**
     * Action для страницы "Вход на сайт"
     */
    public function actionLogin()
    {
        // Переменные для формы
        $email = false;
        $password = false;
        
        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена 
            // Получаем данные из формы
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Флаг ошибок
            $errors = false;

            // Валидация полей
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            // Проверяем существует ли пользователь
            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                // Если данные неправильные - показываем ошибку
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                // Если данные правильные, запоминаем пользователя (сессия)
                User::auth($userId);

                // Перенаправляем пользователя в закрытую часть - кабинет 
                header("Location: /myshop/cabinet");
            }
        }

        // Подключаем вид
        require_once(ROOT . '/views/user/login.php');
        return true;
    }

    /**
     * Action для удаления данных о пользователе из сессий
     */
    public function actionLogout()
    {
        session_start();
        unset($_SESSION['user']);
        header("Location: /myshop/");
    }
}