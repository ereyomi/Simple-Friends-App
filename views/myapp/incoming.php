<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<a href="/index.php?r=myapp">go back</a>

<h1 class="page-header">Incoming Friend request</h1>


<?php if(!empty($user)) : ?>

<ul>
	<?php foreach($user->incomingfriends as $friends) : ?>
		<li class="list-group-item">
			<?= $friends->user->first_name; ?> <?= $friends->user->last_name; ?> 
			<a class="btn btn-primary" href="index.php?r=myapp/accept&id=<?= $friends->friend_id ?>&friend=<?= $user->id ?>">Accept</a>
			<a class="btn btn-warning" href="index.php?r=myapp/reject&id=<?= $friends->friend_id ?>&friend=<?= $user->id ?>">Reject</a>
		</li>

	<?php  endforeach; ?>
</ul>

<?php else: ?>

<p>No user</p>


<?php endif; ?>

