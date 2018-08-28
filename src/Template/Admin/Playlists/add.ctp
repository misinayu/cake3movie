<h1 class="page-header">プレイリスト作成</h1>
<?php
echo $this->Form->create($playlist);
echo $this->Form->input('name', [
		'label' => [
				'text' => 'プレイリスト名'
		]
]);
echo $this->Form->button('作成');
echo $this->Form->end();