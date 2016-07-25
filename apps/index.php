<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Redirecting..</title>
	<script type="text/javascript">
	location.href="../?url=<?php echo (isset($_GET['url']))?$_GET['url']:'apps';?>";
	</script>
</head>
<body>
	Redirecting... please wait.
</body>
</html>