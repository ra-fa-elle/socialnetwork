<?php
include_once "PDO.php";

// Remplacée par requête préparée 
function GetOnePostFromId($id)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM post WHERE id = :id");
  $response->execute(
    array(
      "id" => $id
    )
    );
  return $response->fetch();
}

function GetAllPosts()
{
  global $PDO;
  $response = $PDO->query(
    "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "ORDER BY post.created_at DESC"
  );
  return $response->fetchAll();
}

// Remplacée par requête préparée 
function GetAllPostsFromUserId($userId)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM post WHERE user_id = :userId ORDER BY created_at DESC");
  $response->execute(
    array(
      "userId" => $userId
    )
    );
  return $response->fetchAll();
}

// Remplacée par requête préparée 
function SearchInPosts($search)
{
  global $PDO;
  $response = $PDO->prepare(
    "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "WHERE content like :searchparam or user.nickname like :searchparam or post.created_at like :searchparam "
      . "ORDER BY post.created_at DESC"
  );
  $searchWithPercent = "%$search%";
  $response->execute(
    array(
      "searchparam" => $searchWithPercent
    )
  );
  return $response->fetchAll();
}

// Remplacée par requête préparée
function CreateNewPost($userId, $msg)
{
  global $PDO;
  $response = $PDO->prepare("INSERT INTO post(user_id, content) values (:userId, :msg)");
  $response->execute(
    array(
      "userId" => $userId,
      "msg" => $msg
    )
  );
}