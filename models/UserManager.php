<?php
include_once "PDO.php";

// Remplacée par requête préparée 
function GetOneUserFromId($id)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM user WHERE id = :id");
  $response->execute(
    array(
      "id" => $id
    )
  );
  return $response->fetch();
}

function GetAllUsers()
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user ORDER BY nickname ASC");
  return $response->fetchAll();
}

// Remplacée par equête préparée // puis exo 7, maj de la fonction pour prendre en compte le hachage mdp
function GetUserIdFromUserAndPassword($username, $password)
{
  global $PDO;
  $response = $PDO->prepare("SELECT id FROM user WHERE nickname = :username AND password = MD5(:password) ");
  $response->execute(
    array(
      "username" => $username,
      "password" => $password
    )
  );
  if ($response->rowCount() == 1) {
    $row = $response->fetch();
    return $row['id'];
  } else {
    return -1;
  }
}


// Exo 6 : fonctions d'enregistrement
// si le pseudo est libre
function IsNicknameFree($nickname)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM user WHERE nickname = :nickname ");
  $response->execute(
    array(
      "nickname" => $nickname
    )
  );
  return $response->rowCount() == 0;
}

// création du nouvel utilisateur // Maj de la fonction a l'exo 7 pour prendre en compte le hachage mdp
function CreateNewUser($nickname, $password)
{
  global $PDO;
  $response = $PDO->prepare("INSERT INTO user (nickname, password) values (:nickname , MD5(:password) )");
  $response->execute(
    array(
      "nickname" => $nickname,
      "password" => $password
    )
  );
  return $PDO->lastInsertId();
}