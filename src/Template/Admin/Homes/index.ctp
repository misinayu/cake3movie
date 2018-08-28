<?php $this->prepend('script', $this->Html->script('admin_homes')); ?>
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
echo $this->Form->end();
echo "<div id='main' class='pull-left'>";
echo "<div id='player'>";
echo "</div>";
echo $this->Form->input('playlist_id', ['options' => $playlists ,'label' => ['text' => '']]);
echo $this->Form->button('プレイリストに追加', [
		'type' => 'button',
		'id' => 'addPlaylist',
		'class' => 'btn btn-danger']);
echo "</div>";
echo "<div id='sidebar'></div>";
echo $this->Html->script('https://apis.google.com/js/client.js?onload=googleApiClientReady');