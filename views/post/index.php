<?php foreach($posts as $post) : ?>
    <h2><?= $post->name ?></h2>
    <p><?= $post->content ?></p>
    <ul>
    <?php foreach ($post->categories as $category): ?>
        <li><?= $category->name ?></li>
    <?php endforeach ?>
    </ul>
<?php endforeach ?>