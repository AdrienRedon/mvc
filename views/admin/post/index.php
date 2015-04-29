<?= $this->html->link('admin/post/create', 'Ajouter') ?>

<br>

<?php foreach($posts as $post) : ?>
    <?= $this->html->link('admin/post/' . $post->id . '/delete', 'Supprimer') ?>
    <?= $this->html->link('admin/post/' . $post->id . '/edit', 'Modifier') ?>
    
    <h2><?= $post->name ?></h2>
    <p><?= $post->content ?></p>
<?php endforeach ?>