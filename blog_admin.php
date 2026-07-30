<?php
require_once __DIR__ . "/inc/auth.php";
require_role(['admin']);
require_once __DIR__ . "/inc/db.php";

function uploadImage(string $fieldName, string $destAbsDir): ?string {
    if (empty($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) return null;

    if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) throw new RuntimeException("Chyba uploadu.");

    $tmp = $_FILES[$fieldName]['tmp_name'];

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($tmp);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];

    if (!isset($allowed[$mime])) throw new RuntimeException("Pouze JPG, PNG nebo WEBP.");

    if (!is_dir($destAbsDir)) mkdir($destAbsDir, 0775, true);

    $name = bin2hex(random_bytes(10)) . "." . $allowed[$mime];
    $dest = $destAbsDir . "/" . $name;

   if (!move_uploaded_file($tmp, $dest)) {
  throw new RuntimeException("Upload selhal – zkontroluj složku images/blog (existuje a má práva).");
}
return "images/blog/" . $name;

}

$action = $_POST['action'] ?? $_GET['action'] ?? null;
$error = null;

if ($action === "delete") {
    $id = (int)$_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id=?");
    $stmt->execute([$id]);

    header("Location: blog_admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === "save") {

    $id = (int)($_POST['id'] ?? 0);
    $title = $_POST['title'];
    $excerpt = $_POST['excerpt'];
    $content = $_POST['content'];
    $currentImage = $_POST['current_image'] ?? '';

    try {
        $uploaded = uploadImage("image", __DIR__ . "/images/blog");
        $imagePath = $uploaded ?? $currentImage;

        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE blog_posts SET title=?, excerpt=?, content=?, image=? WHERE id=?");
            $stmt->execute([$title, $excerpt, $content, $imagePath, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO blog_posts (title, excerpt, content, image) VALUES (?,?,?,?)");
            $stmt->execute([$title, $excerpt, $content, $imagePath]);
        }

        header("Location: blog_admin.php");
        exit;

    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$editId = (int)($_GET['edit'] ?? 0);
$edit = ['id'=>0,'title'=>'','excerpt'=>'','content'=>'','image'=>''];

if ($editId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id=?");
    $stmt->execute([$editId]);
    $edit = $stmt->fetch();
}

$posts = $pdo->query("SELECT id, title FROM blog_posts ORDER BY created_at DESC")->fetchAll();
?>

<!doctype html>
<html lang="cs">
<head>
<meta charset="utf-8">
<title>Admin Blog</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/blog_admin.css">
</head>

<body>
<?php require_once __DIR__ . "/inc/navbar.php"; ?>

<div class="admin-wrap">
  <h1 class="admin-title">Správa blogu</h1>

  <div class="admin-grid">

    <!-- LEVÝ BOX seznam článků -->
    <section class="admin-card">
      <h2>Články</h2>

      <table class="admin-table">
        <?php foreach ($posts as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p['title']) ?></td>
            <td class="admin-actions">
              <a class="admin-link" href="blog_admin.php?edit=<?= (int)$p['id'] ?>">Upravit</a>
              <span class="sep">|</span>
              <a class="admin-link danger"
                 href="blog_admin.php?action=delete&id=<?= (int)$p['id'] ?>"
                 onclick="return confirm('Smazat článek?')">
                 Smazat
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </section>

    <!-- PRAVÝ BOX formulář -->
    <section class="admin-card">
      <h2><?= $edit['id'] ? "Edit článku" : "Nový článek" ?></h2>

      <?php if ($error): ?>
        <div class="admin-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form class="admin-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="id" value="<?= (int)$edit['id'] ?>">
        <input type="hidden" name="current_image" value="<?= htmlspecialchars($edit['image']) ?>">

        <label>Titul</label>
        <input type="text" name="title" value="<?= htmlspecialchars($edit['title']) ?>" required>

        <label>Popisek</label>
        <textarea name="excerpt" rows="5"><?= htmlspecialchars($edit['excerpt']) ?></textarea>

        <label>Obsah</label>
        <textarea name="content" rows="10" required><?= htmlspecialchars($edit['content']) ?></textarea>

        <label>Obrázek</label>
        <input type="file" name="image" accept="image/jpeg,image/png,image/webp">

        <?php if (!empty($edit['image'])): ?>
          <div class="admin-hint">Aktuální obrázek:</div>
          <img class="admin-preview" src="/<?= htmlspecialchars($edit['image']) ?>" alt="">
        <?php endif; ?>

        <button class="btn admin-btn" type="submit">Uložit</button>
      </form>
    </section>

  </div>
</div>
<script src="js/app.js"></script>
</body>
</html>
