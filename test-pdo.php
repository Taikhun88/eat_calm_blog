<pre>
    <?php

    $dns = 'mysql:host=localhost;dbname=test';
    $username = 'root';
    $password = 'root';

    try {
        $pdo = new PDO(
            $dns,
            $username,
            $password,
            [
                // CONSTANT of PDO which enables error messages working with resctrictions for example errors won't display sensitive info
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        echo "Connexion à la base de données réussie!";

    } catch (PDOException $e) {
        echo "error : " . $e->getMessage();
    }

    class User {
        function greeting() {
            echo ' <br> Hello ' . $this->firstname . ' ' . $this->email;
        }
    }
    // SELECT request test
    $statement = $pdo->prepare('SELECT * FROM user WHERE iduser = :id');
    $statement->bindValue(':id', 15);
    $users = $statement->execute();

    // the attempt of print fails as the boolean result displays 1 as the execute is unable to get and display the data in $users with execute ONLY
    // to print successfully we need to use fetch Methods fetch or fetchAll
    // this methods allows to display proper error messages if anything goes wrong
    // $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    // if we use a class we will have an object so we can execute fetchObject method
    $users = $statement->fetchObject('User');
    $users->greeting();

    // to avoid typing this FETCH ASSOC method in the fetch method paramater we can include it at TRY step above