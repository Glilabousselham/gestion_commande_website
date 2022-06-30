<?php

namespace App\Controllers;

use App\Http\Request;

class AuthController
{



    public function admin_login(Request $request)
    {

        echo "<br>";

        echo $request;

        return '';

    }



    // public function register(Request $request)
    // {

    //     $uname = htmlspecialchars(addslashes($request->uname));
    //     $pwd = htmlspecialchars(addslashes($request->pwd));

    //     // return $pwd;
    //     $pwd = password_hash($pwd, PASSWORD_BCRYPT);

    //     $user =  User::create([
    //         'username' => $uname,
    //         'password' => $pwd
    //     ]);

    //     if ($user) {
    //         $token = Token::create([
    //             'token' => m_generate_token(),
    //             'user_id' => $user->id,
    //         ]);
    //         $user->token = $token->token;
    //         return Response::json($user);
    //     }
    //     return Response::json([], false);
    // }


    // public function logout(Request $request)
    // {
    //     $token = htmlspecialchars(addslashes($request->token));
    //     if ($token) {
    //         $success =  Token::delete_where("token = '" . $token . "'");
    //     } else {
    //         $success = false;
    //     }

    //     return Response::json([], $success);
    // }

    // public function login(Request $request)
    // {

    //     $username = addslashes($request->uname);

    //     $data = User::where([['username', $username]]);
    //     if (!$data) {
    //         return Response::json([], false, "this username is not exists");
    //     }

    //     $user = new User($data[0]);

    //     $pass_verified = password_verify($request->pwd, $user->password);
    //     if (!$pass_verified) {
    //         return Response::json([], false, "the password is not valid");
    //     }

    //     $token = Token::create([
    //         "user_id" => $user->id,
    //         "token" => m_generate_token(),
    //     ]);

    //     $user->token = $token->token;

    //     return Response::json($user);
    // }
}
