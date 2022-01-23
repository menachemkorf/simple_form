<?php

namespace App;
use PDO;

class Submission
{
    public $connection;
    public $upload_dir;

    public function __construct($connection, $upload_dir)
    {
        $this->connection = $connection;
        $this->upload_dir = $upload_dir;
    }

    public function submitForm()
    {
        $user = $this->auth();
        if(!$user) {
            return [
                'status' => 'error',
                'message' => "Credentials don't match our records.",
                'type' => 'auth',
            ];
        }

        $filename = $this->upload();
        $this->createPost($user, $filename);

        return [
            'status' => 'success',
            'message' => "Post created successfully.",
            'type' => '',
        ];
    }

    public function auth()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user_sql = "SELECT * FROM users WHERE username = '$username';";

        $query = $this->connection->query($user_sql);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if(empty($user)) {
            return false;
        }

        if(!password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }

    public function upload()
    {
        $basename = basename($_FILES['attachment']['name']);
        $uploadfile = $this->upload_dir . '/' . $basename;

        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadfile)) {
            return $basename;
        } else {
            return false;
        }
    }

    public function createPost($user, $filename)
    {
        $message = $_POST['message'];
        $data = [
            'user_id' => $user['id'],
            'message' => $message,
            'filename' => $filename,
        ];

        $post_sql = 'INSERT INTO `posts` (user_id, message, file_name) VALUES (:user_id, :message, :filename);';

        $stmt = $this->connection->prepare($post_sql);
        $stmt->execute($data);
    }
}