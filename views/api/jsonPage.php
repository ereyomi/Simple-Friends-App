<h1>Json</h1>
<script type="text/javascript">
	fetch('/index.php?r=api/user')
	.then(response => response.json())
	.then(data => console.log(data))
	.catch(error => console.log("there is an error ", error));
	console.log()
</script>