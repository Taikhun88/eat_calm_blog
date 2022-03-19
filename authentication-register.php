<?php
const ERROR_REQUIRED = 'Veuillez renseigner ce champ';
$errors = [
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'password' => '',
    'confirmpassword' => ''
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty(array_filter($errors, fn($e) => $e !== ''))) {
        header('Location: /');        
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="/public/css/authentication-register.css">
    <title>S'inscrire' - Eat~CALM blog</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="block p-20 form-container">
                <h1> S'inscrire </h1>
                <form action="/authentication-register.php<?= $id ? "?id=$id" : '' ?>" , method="POST">
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
                        <label for="content">Email</label>
                        <input type="email" name="email" id="email" value="<?= $email ?? '' ?>">
                        <?php if ($errors['email']) : ?>
                            <p class="text-danger"><?= $errors['email'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="password">Mot de passe</label>
                        <input type="text" name="password" id="password">
                        <?php if ($errors['password']) : ?>
                            <p class="text-danger"><?= $errors['password'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="confirmpassword">Confirmation de mot de passe</label>
                        <input type="text" name="confirmpassword" id="confirmpassword">
                        <?php if ($errors['confirmpassword']) : ?>
                            <p class="text-danger"><?= $errors['confirmpassword'] ?></p>
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