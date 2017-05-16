<html>
<header>
	<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
	      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</header>
<body>
<div class="nav nav-main">
	导航
</div>
<div class="container">
<form action="upload.php" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="file">文件上传</label>
		<input type="file" id="file" name="file">
		<p class="help-block">选择上传的文件</p>
	</div>
	<button type="submit" class="btn btn-danger">Submit</button>
</form>
</div>

</body>
</html>