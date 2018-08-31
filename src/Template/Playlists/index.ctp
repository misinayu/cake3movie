<?php $this->prepend('script', $this->Html->script('playlists')); ?>
<h1 class="page-header">プレイリスト一覧</h1>
<table class="table table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th scope="col"><?= $this->Paginator->sort('id') ?></th>
	<th scope="col"><?= $this->Paginator->sort('プレイリスト名') ?></th>
	<th scope="col"><?= $this->Paginator->sort('ユーザ名') ?></th>
	<th scope="col"><?= $this->Paginator->sort('最終更新日時') ?></th>
	<th scope="col"><?= $this->Paginator->sort('登録日') ?></th>
	<th scope="col">操作</th>
</tr>
<?php foreach($playlists as $playlist):?>
<tr>
	<td><?= $this->Number->format($playlist->id) ?></td>
	<td><?= h($playlist->name) ?></td>
	<td><?= h($playlist->user->nickname) ?></td>
	<td><?= h($playlist->modified->format("Y年m月d日 H時i分")) ?></td>
	<td><?= h($playlist->created->format("Y年m月d日 H時i分")) ?></td>
	<td>
		<?= $this->Form->button('開く', [
				'type' => 'button',
				'name' => 'viewPlaylist',
				'value' => $playlist->id,
				'class' => 'btn btn-info'
		]) ?>
</tr>
<?php endforeach;?>
</table>

<div id="movie">
	<div id="main" class="pull-left">
		<div id="player"></div>
	</div>
	<div id="sidebar" class="pull-left"></div>
</div>

<div class="paginator">
	<ul class="pagination">
		<?= $this->Paginator->numbers([
				'before' => $this->Paginator->first("<<"),
				'after' => $this->Paginator->last(">>"),
		]) ?>
	</ul>
</div>
<?php echo $this->Html->script('https://apis.google.com/js/client.js?onload=googleApiClientReady');