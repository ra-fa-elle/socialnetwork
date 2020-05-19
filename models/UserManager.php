<?php
include_once "PDO.php";

function GetOneUserFromId($id)
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user WHERE id = $id");
  return $response->fetch();
}

function GetAllUsers()
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user ORDER BY nickname ASC");
  return $response->fetchAll();
}

function GetUserIdFromUserAndPassword($username, $password)
{
  global $PDO;
  $preparedRequest = $PDO->prepare("SELECT * FROM user WHERE nickname=:nickname AND password=:password");
  $preparedRequest->execute(
    array(
      "nickname" => $username,
      "password" => $password
    )
  );
  $users = $preparedRequest->fetchAll();
  if (count($users) == 1) {
    $user = $users[0];
    return $user['id'];
  } else {
    return -1;
  }
}