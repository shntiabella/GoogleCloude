<?php

class User {
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    // register
    public function register($data)
    {
        // hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // set role default user
        $data['role'] = 'user';

        return $this->createUsers($data);
    }

    // get user
    public function getAllUsers()
    {
        return $this->connection->query("SELECT * FROM users ORDER BY id DESC");
    }

    // get user by id
    public function getUsersById($id)
    {
        $query = $this->connection->prepare("SELECT * FROM users WHERE id = ?");
        $query->bind_param("i", $id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    // get user by email (untuk login & cek email duplikat)
    public function getUserByEmail($email)
    {
        $query = $this->connection->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $query->bind_param("s", $email);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    // create users
    public function createUsers($data)
    {
        $query = $this->connection->prepare("INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)");
        $query->bind_param(
            "sssss",
            $data['name'],
            $data['email'],
            $data['password'],
            $data['phone'],
            $data['role'],
        );

        return $query->execute();
    }

    public function updateUser($data)
    {
        $query = $this->connection->prepare("UPDATE users SET WHERE id = ?");

    }
}