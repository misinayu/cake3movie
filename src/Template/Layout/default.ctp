<?php
// 独自css
$this->prepend('css', $this->Html->css([
		'style.css'
]));
// BootstrapをCDNから取得
$this->prepend('css', $this->Html->css([
		'//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'
]));
// BootstrapのJSをCDNから取得
$this->prepend('script', $this->Html->script([
		'//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'
]));
// jQueryをCDNから取得
$this->prepend('script', $this->Html->script([
		'//code.jquery.com/jquery-2.2.4.js'
]));
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('script') ?>
    <?= $this->fetch('css') ?>
    
</head>
<body>
    
    <?= $this->element("menu/" . $menu) ?>
    <?= $this->element('content') ?>
</body>
</html>
