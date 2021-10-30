<?php
// This class has a constructor to connect to a database. The given
// code assumes you have created a database named 'quotes' inside MariaDB.
//
// Call function startByScratch() to drop quotes if it exists and then create
// a new database named quotes and add the two tables (design done for you).
// The function startByScratch() is only used for testing code at the bottom.
// 
// Authors: Rick Mercer and Xin Li
//
class DatabaseAdaptor
{
    private $DB; // The instance variable used in every method below
    // Connect to an existing data based named 'first'
    public function __construct()
    {
        $dataBase = 'mysql:dbname=quotes;charset=utf8;host=127.0.0.1';
        $user = 'root';
        $password = ''; // Empty string with XAMPP install
        try {
            $this->DB = new PDO($dataBase, $user, $password);
            $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo ('Error establishing Connection');
            exit();
        }
    }

    // This function exists only for testing purposes. Do not call it any other time.
    public function startFromScratch()
    {
        $stmt = $this->DB->prepare("DROP DATABASE IF EXISTS quotes;");
        $stmt->execute();

        // This will fail unless you created database quotes inside MariaDB.
        $stmt = $this->DB->prepare("create database quotes;");
        $stmt->execute();

        $stmt = $this->DB->prepare("use quotes;");
        $stmt->execute();

        $update = " CREATE TABLE quotations ( " .
            " id int(20) NOT NULL AUTO_INCREMENT, added datetime, quote varchar(2000), " .
            " author varchar(100), rating int(11), flagged tinyint(1), PRIMARY KEY (id));";
        $stmt = $this->DB->prepare($update);
        $stmt->execute();

        $update = "CREATE TABLE users ( " .
            "id int(6) unsigned AUTO_INCREMENT, username varchar(64),
            password varchar(255), PRIMARY KEY (id) );";
        $stmt = $this->DB->prepare($update);
        $stmt->execute();
    }


    // ^^^^^^^ Keep all code above for testing  ^^^^^^^^^


    /////////////////////////////////////////////////////////////
    // Complete these five straightfoward functions and run as a CLI application


    public function getAllQuotations()
    {
        $stmt = $this->DB->prepare("SELECT * FROM quotations ORDER BY rating DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsers()
    {
        $stmt = $this->DB->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addQuote($quote, $author)
    {
        $stmt = $this->DB->prepare("INSERT INTO quotations (added, quote, author, rating, flagged) VALUES (now(), :quote, :author, 0, 0);");
        $stmt->bindParam(':quote', $quote);
        $stmt->bindParam(':author', $author);
        $stmt->execute();
    }

    public function addUser($accountname, $psw)
    {
        $hashed_password = password_hash($psw, PASSWORD_DEFAULT);
        $stmt = $this->DB->prepare("INSERT INTO users (username, password) VALUES (:accountname, :hashed_password);");
        $stmt->bindParam(':accountname', $accountname);
        $stmt->bindParam(':hashed_password', $hashed_password);
        $stmt->execute();
    }

    public function accountExists($accountname)
    {
        $stmt = $this->DB->prepare("SELECT username FROM users WHERE username = :accountname");
        $stmt->bindParam(':accountname', $accountname);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if (count($result) == 0) return false;
        return true;
    }

    public function verifyCredentials($accountname, $psw)
    {
        $stmt = $this->DB->prepare("SELECT password FROM users WHERE username = :accountname;");
        $stmt->bindParam(':accountname', $accountname);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if (count($result) == 0) return False;
        return password_verify($psw, $result[0]);
    }

    public function increaseRating($id)
    {
        $stmt = $this->DB->prepare("UPDATE quotations SET rating = rating + 1 WHERE id = :id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function decreaseRating($id)
    {
        $stmt = $this->DB->prepare("UPDATE quotations SET rating = rating - 1 WHERE id = :id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteQuote($id)
    {
        $stmt = $this->DB->prepare("DELETE FROM quotations WHERE id = :id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}  // End class DatabaseAdaptor
