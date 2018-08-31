<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<?= $this->Html->link("動画再生アプリ", ["controller" => "Homes"], ["class" => "navbar-brand"]); ?>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<?= $this->Html->link("プレイリスト", "#", ["data-toggle" => "dropdown"]); ?>
					<ul class="dropdown-menu">
						<li><?= $this->Html->link("マイプレイリスト一覧", "/admin/playlists/index"); ?></li>
						<li><?= $this->Html->link("プレイリスト作成", "/admin/playlists/add"); ?></li>
						<li><?= $this->Html->link("公開プレイリスト一覧", "/admin/openplaylists/index"); ?></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<p class="navbar-text">ようこそ、<?= $auth["nickname"]; ?></p>
				<li class="dropdown">
					<?= $this->Html->link("管理", "#", ["data-toggle" => "dropdown"]); ?>
					<ul class="dropdown-menu">
						<li><?= $this->Html->link("ユーザ情報", "/admin/users/edit"); ?></li>
						<li><?= $this->Html->link("ログアウト", "/admin/users/logout"); ?></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>