<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
		<?= $this->Html->link("動画再生アプリ", "/homes/index", ["class" => "navbar-brand"]); ?>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li>
					<?= $this->Html->link("プレイリスト一覧", "/playlists/index"); ?>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<?= $this->Html->link("ログイン", "/users/login"); ?>
				</li>
				<li class="dropdown">
					<?= $this->Html->link("ユーザ登録", "/users/register"); ?>
				</li>
			</ul>
		</div>
	</div>
</div>