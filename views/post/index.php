<?php foreach($posts as $post) : ?>
    <h2><?= $post->name ?></h2>
    <p><?= $post->content ?></p>
<?php endforeach ?>