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

    // we use the question mark here as an indicator / placeholder of an expectue data to be filled
    // we can replace the question marks by :nameofplaceholder so it's easier to guess the expected data
    // EX : $stmt->bindParam(':firstname', $user['firstname'], PDO::PARAM_STR);

    // if it is needed to receive, store a specific type of data within the databases, it can be specified
    // We call this transtyping, a way to convert by force the sent data
    // EX : $stmt->bindParam(3, $user['password'], PDO::PARAM_INT);

    $statement = $pdo->prepare('INSERT INTO `user` (firstname, email, password) VALUES (
        ?,
        ?,
        ?)        
    ');

    // A bindvalue step can be included right before the execute, here below an example
    // in which case we have to remove the data to be execute in the parameters of execute    
    // bindParam could replace the bindValue method below. 
    // It allows to load the data at the execution step if it ever changed it's pretty convenient

    // if named placeholders are used then replace the 1st parameter of bind by the namedplaceholders
    // $statement->bindValue(1, $user['firstname']);
    // $statement->bindValue(2, $user['email']);
    // $statement->bindValue(3, $user['password']);

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
    // Also, prepare can be executed multiple times and prevent of SQL injections

    //$statement = $pdo->query('INSERT INTO `user` (firstname, email) VALUES ("Taiyounette","taiyounette@gmail.com")');

    ?>
</pre>