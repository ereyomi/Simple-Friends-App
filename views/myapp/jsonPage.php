<h1>Jsonn</h1>
<div class="json">
</div>

<script type="text/javascript">
	fetch('/index.php?r=api/user')
	.then(response => response.json())
	.then(data => {
		//document.querySelector('.json').innerHTML =
		data.foreach(res=> {
			console.log(res.id);
			//document.querySelector('.json').innerHTML = res;
		}
	})
	.catch(error => console.log("there is an error ", error));
	console.log()
</script>