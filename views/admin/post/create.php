<?= $this->form->open('admin/post/store') ?>

    <div>
        <?= $this->form->text('name', '', 'Title') ?>
    </div>

    <div>
        <?= $this->form->textarea('content', '', 'Content') ?>
    </div>    

    <div>
        <?= $this->form->submit('Create') ?>
    </div>

<?= $this->form->close() ?>