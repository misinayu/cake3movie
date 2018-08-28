<div class="container-fluid">
	<div class="row">
		<div class="col-sm-13 main">
			<?= $this->Flash->render("auth") ?>
			<?= $this->Flash->render() ?>
			<?= $this->fetch('content') ?>
		</div>
	</div>
</div>