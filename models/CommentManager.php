<?php
include_once "PDO.php";

// Requête préparée
function GetOneCommentFromId($id)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM comment WHERE id = :id ");
  $response->execute(
    array(
      "id" => $id
    )
  );
  return $response->fetch();
}

function GetAllComments()
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM comment ORDER BY created_at ASC");
  return $response->fetchAll();
}

// Remplacée par requête préparée
function GetAllCommentsFromUserId($userId)
{
  global $PDO;
  $response = $PDO->prepare(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.user_id = :userId "
      . "ORDER BY comment.created_at ASC"
  );
  $response->execute(
    array(
      "userId" => $userId
    )
    );
  return $response->fetchAll();
}

// Remplacée par requête préparée
function GetAllCommentsFromPostId($postId) 
{
  global $PDO;
  $response = $PDO->prepare(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.post_id = :postId "
      . "ORDER BY comment.created_at ASC "
  );
  $response->execute(
    array(
      "postId" => $postId
    )
    );
  return $response->fetchAll();
}

// Exo 8 : Envoi d'un nouveau commentaire
function CreateNewComment($userId, $postId, $comment) 
{
  global $PDO;
  $response = $PDO->prepare("INSERT INTO comment(user_id, post_id, content) VALUES (:userId, :postId, :comment)");
  $response->execute(
    array(
      "userId" => $userId,
      "postId" => $postId,
      "comment" => $comment
    )
    );
}