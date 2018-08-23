<h1 class="page-header">動画再生</h1>
<?php
echo $this->Form->create(null, [
		'class' => 'form-inline'
]);
echo $this->Form->input('search', [
		'label' => [
				'text' => '動画'
		]
]);
echo $this->Form->button('検索');
echo $this->Form->end();

echo $this->Html->div('main');