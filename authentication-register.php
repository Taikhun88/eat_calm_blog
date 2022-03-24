<?php
$pdo = require_once './database/database.php';
$authenticationDB = require_once 'database/security.php';

// List of different errors depending on type of input expected
const ERROR_REQUIRED = 'Veuillez renseigner ce champ';
const ERROR_TOO_SHORT = 'Ce champ est trop court';
const ERROR_PASSWORD_TOO_SHORT = 'Le mot de passe choisi doit être composé de minimum 6 caractères';
const ERROR_EMAIL_INVALID = 'L\'email saisi n\'est pas conforme';
const ERROR_MISMATCH_PASSWORD = 'Veuillez saisir le même mot de passe';

// Store the variables of errors message into an array with empty message
// Note that confirm password requirement in the form is only for checking typo purpose
$errors = [
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'password' => '',
    'confirmPassword' => ''
];

// Checks existece of POST method for safety
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = filter_input_array(INPUT_POST, [
        // if we want to avoid encoding of special chars such é or ê in database we can use SPECIAL CHARS instead of FULL SPECIAL or SANITIZE STRING
        'firstname' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 
        'lastname' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'email' => FILTER_SANITIZE_EMAIL,
    ]);
    $firstname = $input['firstname'] ?? '';
    $lastname = $input['lastname'] ?? '';
    $email = $input['email'] ?? '';

    // data sent via form method
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // displays specific error messages if input is empty
    if (!$firstname) {
        //checks length
        $errors['firstname'] = ERROR_REQUIRED;
    } elseif (mb_strlen($firstname) < 2) {
        $errors['firstname'] = ERROR_TOO_SHORT;
    }

    if (!$lastname) {
        $errors['lastname'] = ERROR_REQUIRED;
    } elseif (mb_strlen($lastname) < 2) {
        $errors['lastname'] = ERROR_TOO_SHORT;
    }

    if (!$email) {
        //checks validate format of email
        $errors['email'] = ERROR_REQUIRED;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = ERROR_EMAIL_INVALID;
    }

    if (!$password) {
        $errors['password'] = ERROR_REQUIRED;
    } elseif (mb_strlen($password) < 6) {
        $errors['password'] = ERROR_PASSWORD_TOO_SHORT;
    }

    if (!$confirmPassword) {
        $errors['confirmPassword'] = ERROR_REQUIRED;
        // checks match input typo 
    } elseif ($confirmPassword !== $password) {
        $errors['confirmPassword'] = ERROR_MISMATCH_PASSWORD;
    }

    // checks if there is no errors if no errors then we proceed the SQL request to send input to database
    if (empty(array_filter($errors, fn($e) => $e !== ''))) {
        $authenticationDB->register([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email, 
            'password' => $password
        ]);        
        // immediate redirection after request done
        header('Location: /');        
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="/public/css/authentication-register.css">
    <title>S'inscrire - Eat~CALM blog</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="block p-20 form-container">
                <h1> S'inscrire </h1>
                <form action="/authentication-register.php" , method="POST">
                    <div class="form-control">
                        <label for="firstname">Prénom</label>
                        <input type="text" name="firstname" id="firstname" value="<?= $firstname ?? '' ?>">
                        <?php if ($errors['firstname']) : ?>
                            <p class="text-danger"><?= $errors['firstname'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="lastname">Nom de famille</label>
                        <input type="text" name="lastname" id="lastname" value="<?= $lastname ?? '' ?>">
                        <?php if ($errors['lastname']) : ?>
                            <p class="text-danger"><?= $errors['lastname'] ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-control">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= $email ?? '' ?>">
                        <?php if ($errors['email']) : ?>
                            <p class="text-danger"><?= $errors['email'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password">
                        <?php if ($errors['password']) : ?>
                            <p class="text-danger"><?= $errors['password'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="confirmPassword">Confirmation de mot de passe</label>
                        <input type="password" name="confirmPassword" id="confirmPassword">
                        <?php if ($errors['confirmPassword']) : ?>
                            <p class="text-danger"><?= $errors['confirmPassword'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-actions">
                        <a href="/" class="btn btn-secondary" type="button">Annuler</a>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>

</html>