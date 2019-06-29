<?php
if (filter_has_var(INPUT_POST, 'upload')) {
  session_start();
  $file = $_FILES['file'];
  $fileName = basename($file['name']);
  $fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
  $fileTemp = $file['tmp_name'];
  $userID = $_SESSION['id'];
  if (!file_exists("uploads/user$userID")) {mkdir("uploads/user$userID");}
  $fileNewName ="uploads/user$userID/profile.jpg";
  move_uploaded_file($fileTemp, $fileNewName);
}
header("Location: index.php");

