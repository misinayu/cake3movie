<h1 class="page-header">プレイリスト編集</h1>
<?php
echo $this->Form->create($playlist);
echo $this->Form->input('name');
echo $this->Form->input('is_open', [
		'label' => ['text' => '公開設定'],
		'options' => [false => '非公開', true => '公開']
]);
echo $this->Form->button('登録');
echo $this->Form->end();