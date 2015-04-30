<?= $this->form->open('admin/post/' . $post->id) ?>
    <input type="hidden" name="_method" value="PUT">
    <div>
        <?= $this->form->text('name', $post->name, 'Title') ?>
    </div>

    <div>
        <?= $this->form->textarea('content', $post->content, 'Content') ?>
    </div>    

    <div>
        <?= $this->form->submit('Update') ?>
    </div>

<?= $this->form->close() ?>