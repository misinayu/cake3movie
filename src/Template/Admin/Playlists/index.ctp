<h1 class="page-header">マイプレイリスト一覧</h1>
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
				'id' => 'view',
				'class' => 'btn btn-info'
		]) ?>
		<?= $this->Html->link('編集', 
				['action' => 'edit', $playlist->id], 
				['class' => 'btn btn-default']) ?>
</tr>
<?php endforeach;?>
</table>


<div class="paginator">
	<ul class="pagination">
		<?= $this->Paginator->numbers([
				'before' => $this->Paginator->first("<<"),
				'after' => $this->Paginator->last(">>"),
		]) ?>
	</ul>
</div>