<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

?>

<a href="/index.php?r=myapp">go back</a>

<h1 class="page-header">My Friend</h1>


<?php if(!empty($query)) : ?>

<ul>
	<?php foreach($query as $key) : ?>
		<?php if($key->status == $status_PENDING || $key->status == $status_REJECTED) : ?>
			<?php continue;?>
			
			<?php elseif($key->user_id == Yii::$app->user->identity->id) : ?>
			<li class="list-group-item"><?= $key->friend->first_name; ?> <?= $key->friend->last_name; ?> </li>
			<?php else: ?>
			<li class="list-group-item"><?= $key->user->first_name; ?> <?= $key->user->last_name; ?> </li>
			<?php endif; ?>
		

	<?php  endforeach; ?>
</ul>

<?php else: ?>

<p>You have no friend</p>


<?php endif; ?>

