<?php
function __autoload($name) {
    include_once $name . '.php';
}
$page = new PageMaker();
$form = new FormMaker();
$page->displayHeadMatter();
$form->loginForm();
$page->displayEndMatter();
