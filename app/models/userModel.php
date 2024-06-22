<?php

class UserModel
{
    // Propiedades del usuario
    public $id;
    public $username; // Username
    public $pass;  // Almacena la contraseña cifrada por seguridad
    public $type;

    private $filePath = '../../config/user.json';

    public function __construct()
    {
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    private function encryptPassword($password)
    {
        return md5($password); // Puedes cambiar esto por cualquier otro método de encriptación
    }

    private function readUsers()
    {
        return json_decode(file_get_contents($this->filePath), true);
    }

    private function writeUsers($users)
    {
        file_put_contents($this->filePath, json_encode($users));
    }

    public function new($username, $pass, $type)
    {
        $users = $this->readUsers();
        $id = end($users)['id'] + 1;

        $newUser = [
            'id' => $id,
            'username' => $username,
            'pass' => $this->encryptPassword($pass),
            'type' => $type
        ];

        $users[] = $newUser;
        $this->writeUsers($users);

        return true;
    }

    public function verify($username)
    {
        $users = $this->readUsers();
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                return true;
            }
        }
        return false;
    }

    public function getAll()
    {
        return $this->readUsers();
    }

    public function login($username, $pass)
    {
        $users = $this->readUsers();
        $encryptedPass = $this->encryptPassword($pass);

        foreach ($users as $user) {
            if ($user['username'] === $username && $user['pass'] === $encryptedPass) {
                return $user;
            }
        }

        return false;
    }

    public function update($username, $pass, $type, $id)
    {
        $users = $this->readUsers();
        foreach ($users as &$user) {
            if ($user['id'] == $id) {
                $user['username'] = $username;
                if ($pass !== "") {
                    $user['pass'] = $this->encryptPassword($pass);
                }
                $user['type'] = $type;
            }
        }
        $this->writeUsers($users);

        return true;
    }

    public function delete($id)
    {
        $users = $this->readUsers();
        foreach ($users as $key => $user) {
            if ($user['id'] == $id) {
                unset($users[$key]);
            }
        }
        $this->writeUsers(array_values($users));

        return true;
    }

    public function getLicence()
    {
        $config = json_decode(file_get_contents('../config/config.json'), true);
        return isset($config['license']) ? $config['license'] : null;
    }
}
