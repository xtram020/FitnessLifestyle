<?php
session_start();
require_once __DIR__ . "/inc/db.php";

$userId = $_SESSION["user_id"] ?? null;

if ($userId) {
    $stmt = $pdo->prepare("
        SELECT p.id, p.title, p.excerpt, p.image, p.created_at,
               (SELECT COUNT(*) FROM post_likes l WHERE l.post_id = p.id) AS likes,
               (SELECT 1 FROM post_likes l WHERE l.post_id = p.id AND l.user_id = ? LIMIT 1) AS liked_by_me
        FROM blog_posts p
        ORDER BY p.created_at DESC
    ");
    $stmt->execute([$userId]);
    $posts = $stmt->fetchAll();
} else {
    $posts = $pdo->query("
        SELECT p.id, p.title, p.excerpt, p.image, p.created_at,
               (SELECT COUNT(*) FROM post_likes l WHERE l.post_id = p.id) AS likes,
               0 AS liked_by_me
        FROM blog_posts p
        ORDER BY p.created_at DESC
    ")->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/blog.css">
</head>
<body>

 <?php require_once __DIR__ . "/inc/navbar.php"; ?>

 
<section class="blog">
    <h1 class="heading">svět fitness</h1>
        
    <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div style="text-align:center; margin: 2rem 0;">
            <a class="btn" href="blog_admin.php">Spravovat blog</a>
        </div>
    <?php endif; ?>


<div class="box-container">
<?php foreach ($posts as $p): ?>
    <div class="box shadow"> 
        <div class="image">
            <?php if (!empty($p['image'])): ?>
            <img src="<?= htmlspecialchars($p['image']) ?>" alt="">
            <?php endif; ?>

            <div class="like-btn <?= !empty($p['liked_by_me']) ? 'liked' : '' ?>"
            data-post-id="<?= (int)$p['id'] ?>">
            <i class="fas fa-heart"></i>
            <span class="like-count"><?= (int)$p['likes'] ?></span>
            </div>
        </div>

        <div class="content">
            <h2><?= htmlspecialchars($p['title']) ?></h2>
            <p><?= htmlspecialchars($p['excerpt']) ?></p>
            <a href="post.php?id=<?= (int)$p['id'] ?>" class="btn">
            read more
            </a>
        </div>
    </div>
<?php endforeach; ?>
</div>
   

</section>

<script src="js/app.js"></script>
</body>
</html>