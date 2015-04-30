<?php

namespace Libs;

use \Libs\interfaces\SessionInterface;

class Form 
{
    protected $session;
    
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Ouvre un nouveau formulaire
     * @param  $url    Lien vers l'action du formulaire
     * @param  $method Méthode du formulaire
     * @param  $token  Valeur du token
     * @param  $file   Formulaire pour envoyer des fichiers
     */
    public function open($url, $method = 'POST', $token = false, $file = false)
    {
        ?>
            <form action="<?= WEBROOT . $url ?>" method="POST"<?php if($file) { ?> enctype="multipart/form-data"<?php } ?>>
                <input type="hidden" name="_method" value="<?= $method ?>">
            <?php if($token) { ?>
                <input type="hidden" name="token" value="<?= 'token' ?>">
            <?php } ?>
        <?php
    }

    /**
     * Ferme le formulaire
     */
    public function close()
    {
        $this->session->destroy('input');
        ?>
            </form>
        <?php
    }

    /**
     * Champ input
     * @param  $type        Type du champ
     * @param  $name        Nom du champ
     * @param  $value       Valeur du champs
     * @param  $placeholder Valeur du placeholder
     */
    public function input($type, $name, $value = '', $placeholder = '')
    {
        ?>
            <input type="<?= $type ?>"<?php if($name != '') { ?> name="<?= $name ?>"<?php } $input = $this->session->get('input'); if(isset($input, $input[$name]) && $type != 'password') { ?> value="<?= $input[$name] ?>"<?php } else { ?> value="<?= $value ?>"<?php } if($placeholder != '') { ?> placeholder="<?= $placeholder ?>"<?php } ?>>
        <?php
    }

    /**
     * Champ textarea
     * @param $name        Nom du champ
     * @param $value       Valeur du champ
     * @param $placeholder Valeur du placeholder
     */
    public function textarea($name, $value = '', $placeholder = '')
    {
        ?>
            <textarea<?php $input = $this->session->get('input'); if(isset($input, $input[$name])) { ?> name="<?= $input[$name] ?>"<?php } else { ?> name="<?= $name ?>"<?php } if($placeholder != '') { ?> placeholder="<?= $placeholder ?>" <?php } ?>><?= $value ?></textarea>
        <?php
    }

    /**
     * Champ input de type text
     * @param  $name        Nom du champ
     * @param  $value       Valeur du champs
     * @param  $placeholder Valeur du placeholder
     */
    public function text($name, $value = '', $placeholder = '')
    {
        $this->input('text', $name, $value, $placeholder);
    }

    /**
     * Champ input de type email
     * @param  $name        Nom du champ
     * @param  $value       Valeur du champs
     * @param  $placeholder Valeur du placeholder
     */
    public function email($name, $value = '', $placeholder = '')
    {
        $this->input('email', $name, $value, $placeholder);
    }

    /**
     * Champ input de type password
     * @param  $name        Nom du champ
     * @param  $value       Valeur du champs
     * @param  $placeholder Valeur du placeholder
     */
    public function password($name, $value = '', $placeholder = '')
    {
        $this->input('password', $name, $value, $placeholder);
    }

    /**
     * Champ input de type number
     * @param  $name        Nom du champ
     * @param  $value       Valeur du champs
     * @param  $placeholder Valeur du placeholder
     */
    public function number($name, $value = '', $placeholder = '')
    {
        $this->input('number', $name, $value, $placeholder);
    }

    /**
     * Champ input de type file
     * @param  $name        Nom du champ
     * @param  $value       Valeur du champs
     * @param  $placeholder Valeur du placeholder
     */
    public function file($name, $value = '', $placeholder = '')
    {
        $this->input('file', $name, $value, $placeholder);
    }

    /**
     * Champ input de type submit
     * @param  $name        Nom du champ
     * @param  $value       Valeur du champs
     */
    public function submit($value = 'Envoyer')
    {
        $this->input('submit', '', $value);
    }

}
