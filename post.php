<?php
session_start();
require_once __DIR__ . "/inc/db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
  http_response_code(404);
  echo "Článek nenalezen.";
  exit;
}
?>
<!doctype html>
<html lang="cs">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($post['title']) ?></title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/blog.css">
  <style>
    .post-wrap{padding:5rem 10%;}
    .post-hero{max-width:1000px;margin:0 auto;}
    .post-hero img{width:100%;height:420px;object-fit:cover;border-radius:16px;}
    .post-hero h1{margin:2rem 0 1rem;font-size:3rem;}
    .post-content{max-width:1000px;margin:0 auto;color:#ddd;line-height:2;font-size:1.6rem;}
  </style>
</head>
<body>
  <?php require_once __DIR__ . "/inc/navbar.php"; ?>

  <main class="post-wrap">
    <div class="post-hero">
      <?php if (!empty($post['image'])): ?>
        <img src="<?= htmlspecialchars($post['image']) ?>" alt="">
      <?php endif; ?>
      <h1><?= htmlspecialchars($post['title']) ?></h1>
    </div>

    <article class="post-content">
      <?= nl2br(htmlspecialchars($post['content'])) ?>
    </article>
  </main>

    <a href="blog.php" class="back-to-blog">
    ← Zpět na blog
</a>
  <script src="js/app.js"></script>
</body>
</html>
