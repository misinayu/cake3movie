<h1 class="page-header">ユーザ情報編集</h1>
<?php
echo $this->Form->create($user);
echo $this->Form->input('nickname');
echo $this->Form->input('email');
echo $this->Form->input('password');
echo $this->Form->button("登録");
echo $this->Form->end();