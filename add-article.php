<?php 
    const ERROR_REQUIRED = 'Veuillez renseigner ce champ';
    const ERROR_TITLE_TOO_SHORT = 'Le titre est trop court';
    const ERROR_CONTENT_TOO_SHORT = 'L\'article est trop court';
    const ERROR_IMAGE_URL = 'L\'image doit être une url valide';

    $fileName = __DIR__ . '/data/articles.json';
    $errors = [
        'title' => '',
        'image' => '',
        'category' => '',
        'content' => ''
    ];
    $articles = [];

    // As FILTER SANITIZE STRING is now deprecated I have replaced them with FITLER UNSAFE RAW but we could use html special char to protect against XSS
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (file_exists($fileName)) {
            $articles = json_decode(file_get_contents($fileName), true) ?? [];
        }
        $_POST = filter_input_array(INPUT_POST, [
            'title' => FILTER_UNSAFE_RAW, 
            'image' => FILTER_SANITIZE_URL, 
            'category' => FILTER_UNSAFE_RAW, 
            'content' => [
                'filter' => FILTER_UNSAFE_RAW,
                'flags' => FILTER_FLAG_NO_ENCODE_QUOTES
                ]
            ]);

            $title = $_POST['title'] ?? '';
            $image = $_POST['image'] ?? '';
            $category = $_POST['category'] ?? '';
            $content = $_POST['content'] ?? '';

            if (!$title) {
                $errors['title'] = ERROR_REQUIRED;
            } elseif (mb_strlen($title) < 5) {
                $errors['title'] = ERROR_TITLE_TOO_SHORT;               
            }

            if (!$image) {
                $errors['image'] = ERROR_REQUIRED;
            } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
                $errors['image'] = ERROR_IMAGE_URL;               
            }
            
            if (!$content) {
                $errors['content'] = ERROR_REQUIRED;
            } elseif (mb_strlen($content) < 50) {
                $errors['content'] = ERROR_CONTENT_TOO_SHORT;               
            }
            

            if (empty(array_filter($errors, fn($e) => $e !== ''))) {
                $articles = [...$articles, [
                    'title' => $title,
                    'image' => $image, 
                    'category' => $category,
                    'content' => $content,
                    'id' => time() 
                ]];
                file_put_contents($fileName, json_encode($articles));
                header('Location: /');
            }             
    }

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="public/css/add-article.css">
    <title>Créer un article - Eat~CALM blog</title>
</head>

<!-- title -->
<!-- image -->
<!-- category -->
<!-- content -->

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="block p-20 form-container">
                <h1>Écrire un article</h1>
                <form action="/add-article.php" , method="POST">
                    <div class="form-control">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title"  value=<?= $title ?? '' ?>>
                        <?php if($errors['title']) : ?>
                            <p class="text-danger"><?= $errors['title'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="image">Image</label>
                        <input type="text" name="image" id="image" value=<?= $image ?? '' ?>>
                        <?php if($errors['image']) : ?>
                            <p class="text-danger"><?= $errors['image'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="category">Catégories</label>
                        <select name="category" id="category">
                            <option value="menus">Menus</option>
                            <option value="meals">Plats</option>
                            <option value="desserts">Desserts</option>
                            <option value="sidedishes">Entrées</option>
                        </select>
                        <?php if($errors['category']) : ?>
                            <p class="text-danger"><?= $errors['category'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="content">Contenu</label>
                        <textarea name="content" id="content" value=<?= $content ?? '' ?>></textarea>
                        <?php if($errors['content']) : ?>
                            <p class="text-danger"><?= $errors['content'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-actions">
                        <a href="/" class="btn btn-secondary" type="button">Annuler</a>
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>

</html>