<?php

namespace Controllers;

use Core\Controller;

class Users extends Controller
{
    protected  $usersModel;
    function __construct(){
        $this -> usersModel = new \Models\Users();
    }

    public function actionProfile(){
        if(!isset($_SESSION['user'])){
            header("Location:\\users\\register");

        }
        else{
            return $this -> render('profile', null, [
                'MainTitle' => 'My profile'
            ]);
        }
    }

    function actionLogout(){
        header( "refresh:1;url=\\recipes" );

        unset($_SESSION['user']);
        return $this -> renderMessage('ok', 'You have quit the account', null,
            [
                'MainTitle' => 'Witch\'s Kitchen'
            ]);
    }

    function actionLogin(){
        $mainTitle = 'Witch\'s Kitchen';

        if(isset($_SESSION['user'])){
            header( "refresh:1;url=\\" );
            return $this -> renderMessage('ok', 'You are already authenticated!', null,
                [
                    'MainTitle' => $mainTitle
                ]);
        }

        if ($this -> isPost()){

            $login = $_POST['email'];
            $password = $_POST['password'];

            $user = $this -> usersModel -> authUser($login, $password);

            if (!empty($user)){

                $_SESSION['user'] = $user;

                $result = $this -> renderMessage('ok', 'Authentication was successful!', null,
                [
                    'MainTitle' => $mainTitle
                ]);

                header( "refresh:1;url=\\recipes" );

                return $result;

            }
            else{
                return $this -> render('registerAndLogin', null, [
                    'MainTitle' => 'Login/Sign in',
                    'MessageText' => 'Wrong login or password',
                    'MessageClass' => 'danger'
                ]);
            }

        }
        else{
            $params = [
                'MainTitle' => 'Login/Sign in'
            ];
            return $this -> render('registerAndLogin', null, $params);
        }
    }

    function actionRegister(){

        if ($this -> isPost()){

            $result = $this -> usersModel -> addUser($_POST);

            if ($result === true){
                $result = $this -> renderMessage('ok', 'Registration was successful', null,
                    [
                        'MainTitle' => 'Registration'
                    ]);

                header( "refresh:1;url=\\recipes" );

                return $result;

            }
            else{
                $message = implode('<br>', $result);
                return $this -> render('registerAndLogin', null, [
                    'MainTitle' => 'Registration',
                    'MessageText' => $message,
                    'MessageClass' => 'danger'
                ]);
            }
        }
        else{
            $params = [
                'MainTitle' => 'Registration'
            ];
            return $this -> render('registerAndLogin', null, $params);
        }


    }
}