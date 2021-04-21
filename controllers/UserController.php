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
}