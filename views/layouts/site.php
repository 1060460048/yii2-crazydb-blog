<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 */
$this->beginContent('@app/views/layouts/main.php');
?>
<div class="main">
	<div class="container">
		<div class="col-md-9 list-group post-list no-padding with-shadow">
		<?=$content?>
		</div>
	</div>
</div>
<?php $this->endContent(); ?>