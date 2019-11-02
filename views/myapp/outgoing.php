<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<a href="/index.php?r=myapp">go back</a>

<h1 class="page-header">outgoing Friend request</h1>


<?php if(!empty($user)) : ?>

<ul>
	<?php foreach($user->outgoingfriends as $friends) : ?>
		<li class="list-group-item">
			<?= $friends->friend->first_name;?> <?= $friends->friend->last_name;?>
		 <a class="btn btn-danger" href="index.php?r=myapp/cancle&id=<?= $user->id ?>&friend=<?= $friends->friend_id ?>">Cancle</a> 
		</li>

	<?php  endforeach; ?>
</ul>

<?php else: ?>

<p>No user</p>


<?php endif; ?>

