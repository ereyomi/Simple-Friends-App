<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<br>
<span class=" pull-right">
<a class="btn btn-success" href="/index.php?r=myapp/myfriends&id=<?= Yii::$app->user->identity->id ?>">friends
	<span class="badge badge-light"><?=$user->getAcceptedfriends()->count() +  $user->getfriendsAccepted()->count()?></span>
</a>
</span>

<h1 class="page-header">Suggested Friends 
<span class=" pull-right">

<a class="btn btn-primary" href="/index.php?r=myapp/outgoing&id=<?= Yii::$app->user->identity->id ?>">outgoing 
	<span class="badge badge-light"><?=$user->getOutgoingfriends()->count() ?></span>
</a>

<a class="btn btn-warning" href="/index.php?r=myapp/incoming&id=<?= Yii::$app->user->identity->id ?>">incoming
<span class="badge badge-light"><?=$user->getIncomingfriends()->count() ?></span>
</a>
</span>
</h1>


<?php if(!empty($users)) : ?>

<ul>
	<?php foreach($users as $toBeFriend) : ?>
		<?php if(($FRIENDquery->where(['user_id' => $toBeFriend->id, 'status' => $status_ACCEPTED])->count() == 0) || ($FRIENDquery->where(['friend_id' => $toBeFriend->id, 'status' => $status_ACCEPTED])->count() == 0) || ($FRIENDquery->where(['user_id' => $toBeFriend->id, 'status' => $status_PENDING])->count() == 0) || ($FRIENDquery->where(['friend_id' => $toBeFriend->id, 'status' => $status_PENDING])->count() == 0)): ?>

		<li class="list-group-item"><?= $toBeFriend->first_name; ?> <?= $toBeFriend->last_name; ?> <a class="btn btn-primary" href="index.php?r=myapp/add&id=<?= $toBeFriend->id ?>">Add</a></li>

		<?php else: ?>

		<?php if(($FRIENDquery->where(['user_id' => $toBeFriend->id, 'status' => $status_ACCEPTED])->count() > 0) || ($FRIENDquery->where(['friend_id' => $toBeFriend->id, 'status' => $status_ACCEPTED])->count() > 0) || ($FRIENDquery->where(['user_id' => $toBeFriend->id, 'status' => $status_PENDING])->count() > 0) || ($FRIENDquery->where(['friend_id' => $toBeFriend->id, 'status' => $status_PENDING])->count() > 0)) : ?>
			<?php continue;?>

		<?php else: ?>
			<li class="list-group-item"><?= $toBeFriend->first_name; ?> <?= $toBeFriend->last_name; ?> <a class="btn btn-primary" href="index.php?r=myapp/add&id=<?= $toBeFriend->id ?>">Add</a></li>

		<?php endif; ?>

	<?php endif?>
	<?php  endforeach; ?>
</ul>

<?php else: ?>

<p>No user</p>


<?php endif; ?>

<?= LinkPager::widget(['pagination'=>$pagination]);?>