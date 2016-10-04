<?php

class UserController extends BaseController {

    public static function login() {
        View::make('user/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $user = User::authenticate($params['kayttajatunnus'], $params['salasana']);

        if (!$user) {
            $errors = array();
            $errors[] = 'Väärä käyttäjätunnus tai salasana!';
            View::make('user/login.html', array('errors' => $errors));
        } else {
            $_SESSION['user'] = $user->id;

            Redirect::to('/note', array('message' => 'Tervetuloa takaisin ' . $user->kayttajatunnus . "!"));
        }
    }
    
    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}
