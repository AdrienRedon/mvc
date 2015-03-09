<?php

return array(
    /**
     * Shortcut
     */
    'login'  => ['Session', 'login'],
    'logout' => ['Session', 'logout'],

    /**
     * Admin pages
     */
    'admin/post'        => ['Admin\Post', 'index'],
    'admin/post/index'  => ['Admin\Post', 'index'],
    'admin/post/create' => ['Admin\Post', 'create'],
    'admin/post/update' => ['Admin\Post', 'update'],
    'admin/post/delete' => ['Admin\Post', 'delete'],
);