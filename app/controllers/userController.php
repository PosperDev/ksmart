<?php

require '../../models/userModel.php'; // Incluir la clase UserModel

class UserController {

  public function login($username, $pass) {
    if (empty($username) || empty($pass)) {
      // Manejar campos vacíos (redirigir o mostrar mensaje de error)
      return false;
    }

    $userModel = new UserModel(); // Crear una instancia de UserModel

    $result = $userModel->login($username, $pass); // Obtener el resultado del inicio de sesión del UserModel

    return $result; // Devolver directamente el resultado del inicio de sesión
  }

  public function verify($username) {
    if (empty($username)) {
      // Manejar campos vacíos (redirigir o mostrar mensaje de error)
      return false;
    }
    // Crear una instancia de UserModel
    $userModel = new UserModel();
    // Obtener el resultado de verificar del UserModel
    $result = $userModel->verify($username);

    return $result; // Devolver directamente el resultado de la verificación
  }

  public function getAll() {
    $userModel = new UserModel(); // Crear una instancia de UserModel

    $result = $userModel->getAll();

    return $result;
  }

  public function getLicence() {
    $userModel = new UserModel(); // Crear una instancia de UserModel

    $result = $userModel->getLicence();

    return $result;
  }

  public function new($username, $pass, $type) {
    $userModel = new UserModel(); // Crear una instancia de UserModel

    $result = $userModel->new($username, $pass, $type);

    return $result;
  }

  public function update($username, $pass, $type, $id) {
    $userModel = new UserModel(); // Crear una instancia de UserModel

    $result = $userModel->update($username, $pass, $type, $id);

    return $result;
  }

  public function delete($id) {
    $userModel = new UserModel(); // Crear una instancia de UserModel

    $result = $userModel->delete($id);

    return $result;
  }
}
