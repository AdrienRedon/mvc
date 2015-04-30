<?php

namespace Libs;

class Html
{
    public function link($url, $text = null)
    {
        if(!$text)
        {
            $text = WEBROOT . $url;
        }

        ?>
            <a href="<?= WEBROOT . $url ?>"><?= $text ?></a>
        <?php
    }

    public function image($src, $alt = '')
    {
        ?>
            <img src="<?= WEBROOT . $src ?>" alt="<?= $alt ?>">
        <?php
    }
}
