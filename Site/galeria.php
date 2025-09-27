<?php require __DIR__ . '/db.php'; ?>
<?php include __DIR__ . '/header.php'; ?>

<h3>Galeria</h3>

<?php
$aboutImages = $pdo->query("SELECT * FROM tb_sobre ORDER BY id DESC")->fetchAll();

if ($aboutImages && count($aboutImages) > 0):
    foreach ($aboutImages as $about):
        if (!empty($about['foto_path'])):
?>
        <div style="margin-bottom: 20px;">
            <img src="<?= e($about['foto_path']) ?>" alt="Foto da empresa" width="300">
        </div>
<?php
        endif;
    endforeach;
else:
?>
    <p>Ainda não há conteúdo de “Galeria”.</p>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>
