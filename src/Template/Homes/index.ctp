<?php $this->prepend('script', $this->Html->script('homes')); ?>
<h1 class="page-header">動画検索</h1>
<?php
echo $this->Form->create(null, [
		'id' => 'homeSearch',
		'class' => 'form-inline',
		'onsubmit' => 'return false'
]);
echo $this->Form->input('search', [
		'label' => false,
		'placeholder' => '検索'
]);
echo $this->Form->button($this->Html->icon('search'), [
		'type' => 'button',
		'id' => 'adminHomesSearchButton',
		'disabled' => true
]);
echo $this->Form->button($this->Html->icon('backward'), [
		'type' => 'button',
		'id' => 'prev'
]);
echo $this->Form->button($this->Html->icon('pause'), [
		'type' => 'button',
		'id' => 'exe'
]);
echo $this->Form->button($this->Html->icon('forward'), [
		'type' => 'button',
		'id' => 'next'
]);
echo $this->Form->end();
echo "<div id='main' class='pull-left'>";
echo "<div id='player'>";
echo "</div></div>";
echo "<div id='sidebar'></div>";
echo $this->Html->script('https://apis.google.com/js/client.js?onload=googleApiClientReady');