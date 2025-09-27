<?php
require __DIR__ . '/db.php';
require __DIR__ . '/helpers.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'criar') {
  $titulo   = trim($_POST['titulo'] ?? '');
  $descricao = trim($_POST['descricao'] ?? '');
  $foto     = upload_foto('foto');

  if ($titulo !== '' && $descricao !== '') {
    $st = $pdo->prepare("INSERT INTO tb_sobre (titulo, descricao, foto_path) VALUES (:t,:h,:f)");
    $st->execute([':t'=>$titulo, ':h'=>$descricao, ':f'=>$foto]);
    header("Location: sobre.php"); exit;
  }
}


if (($_GET['acao'] ?? '') === 'del' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $st = $pdo->prepare("SELECT foto_path FROM tb_sobre WHERE id=:id");
  $st->execute([':id'=>$id]);
  if ($row = $st->fetch()) {
    if ($row['foto_path'] && file_exists($row['foto_path'])) @unlink($row['foto_path']);
  }
  $pdo->prepare("DELETE FROM tb_sobre WHERE id=:id")->execute([':id'=>$id]);
  header("Location: sobre.php"); exit;
}


$lista = $pdo->query("SELECT * FROM tb_sobre ORDER BY id DESC")->fetchAll();


$edit = null;
if (($_GET['acao'] ?? '') === 'edit' && isset($_GET['id'])) {
  $st = $pdo->prepare("SELECT * FROM tb_sobre WHERE id=:id");
  $st->execute([':id'=>(int)$_GET['id']]);
  $edit = $st->fetch();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'atualizar') {
  $id       = (int)$_POST['id'];
  $titulo   = trim($_POST['titulo'] ?? '');
  $descricao = trim($_POST['descricao'] ?? '');
  $fotoNova = upload_foto('foto_path');

  if ($titulo !== '' && $descricao !== '') {
    if ($fotoNova) {
      
      $st = $pdo->prepare("SELECT foto_path FROM tb_sobre WHERE id=:id");
      $st->execute([':id'=>$id]);
      if ($row = $st->fetch()) {
        if ($row['foto_path'] && file_exists($row['foto_path'])) @unlink($row['foto_path']);
      }
      $sql = "UPDATE tb_sobre SET titulo=:t, descricao=:h, foto_path=:f WHERE id=:id";
      $args = [':t'=>$titulo, ':h'=>$descricao, ':f'=>$fotoNova, ':id'=>$id];
    } else {
      $sql = "UPDATE tb_sobre SET titulo=:t, descricao=:h WHERE id=:id";
      $args = [':t'=>$titulo, ':h'=>$descricao, ':id'=>$id];
    }
    $pdo->prepare($sql)->execute($args);
    header("Location: tb_sobre.php"); exit;
  }
}
?>
<?php include __DIR__ . '/header.php'; ?>

<h2>Sobre Nós (CRUD)</h2>

<h3>Criar novo</h3>
<form method="post" enctype="multipart/form-data">
  <input type="hidden" name="acao" value="criar">
  <p>Título:<br><input type="text" name="titulo" required></p>
  <p>História:<br><textarea name="descricao" rows="6" cols="60" required></textarea></p>
  <p>Foto: <input type="file" name="foto" accept="image/*"></p>
  <p><button type="submit">Salvar</button></p>
</form>

<?php if ($edit): ?>
<hr>
<h3>Editar registro #<?= e($edit['id']) ?></h3>
<form method="post" enctype="multipart/form-data">
  <input type="hidden" name="acao" value="atualizar">
  <input type="hidden" name="id" value="<?= e($edit['id']) ?>">
  <p>Título:<br><input type="text" name="titulo" value="<?= e($edit['titulo']) ?>" required></p>
  <p>História:<br><textarea name="descricao" rows="6" cols="60" required><?= e($edit['descricao']) ?></textarea></p>
  <p>Foto (enviar nova para substituir): <input type="file" name="foto" accept="image/*"></p>
  <?php if ($edit['foto_path']): ?>
    <p>Atual:<br><img src="<?= e($edit['foto']) ?>" alt="" width="200"></p>
  <?php endif; ?>
  <p><button type="submit">Atualizar</button></p>
</form>
<?php endif; ?>

<hr>
<h3>Lista</h3>
<?php if (!$lista): ?>
  <p>Sem registros.</p>
<?php else: ?>
<table border="1" cellpadding="6" cellspacing="0">
  <tr>
    <th>ID</th><th>Título</th><th>História</th><th>Foto</th><th>Ações</th>
  </tr>
  <?php foreach ($lista as $r): ?>
  <tr>
    <td><?= e($r['id']) ?></td>
    <td><?= e($r['titulo']) ?></td>
    <td><?= nl2br(e($r['descricao'])) ?></td>
    <td><?php if ($r['foto_path']): ?><img src="<?= e($r['foto_path']) ?>" width="120"><?php endif; ?></td>
    <td>
      <a href= tb_sobre.php?acao=edit&id=<?= e($r['id']) ?>">Editar</a> |
      <a href= tb_sobre.php?acao=del&id=<?= e($r['id']) ?>" onclick="return confirm('Apagar?');">Excluir</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>