<?= $this->html->link('admin/post/new', 'Ajouter') ?>

<br>

<?php foreach($posts as $post) : ?>
    <?= $this->html->link('admin/post/delete/'. $post->id, 'Supprimer') ?>
    <?= $this->html->link('admin/post/update/'. $post->id, 'Modifier') ?>
    
    <h2><?= $post->name ?></h2>
    <p><?= $post->content ?></p>
<?php endforeach ?>