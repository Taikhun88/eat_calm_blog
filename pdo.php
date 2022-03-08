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
            ]
        );
        echo "Connexion à la base de données réussie!";

    } catch (PDOException $e) {
        echo "error : " . $e->getMessage();
    }

    // sample of data put in an array so we can send them all with one variable instead of typing one by one
    // simulates data received via form
    $user = [
        'firstname' => "Testtout", 
        'email' => "testtout@gmail.com", 
        'password' => 'testtout'
    ];

    // we use the question mark here as an indicator of an expectue data to be filled
    $statement = $pdo->prepare('INSERT INTO `user` (firstname, email, password) VALUES (
        ?,
        ?,
        ?)        
    ');

    // as we will receive all data in an array variable we can execute them by selecting with array methods. the question marks are at this execute steps replaced by the variable data.
    $statement->execute(
        [
            $user['firstname'], 
            $user['email'], 
            $user['password']
        ]
    );
    // query method version of connexion via PDO. It's a shorter version as it prepares and automatically execute afterwards
    // for more flexibility and safety it's better to use prepare and execute separately
    // $statement = $pdo->query('INSERT INTO `user` (firstname, email) VALUES ("Taiyounette","taiyounette@gmail.com")');
    ?>
</pre>