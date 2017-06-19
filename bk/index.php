<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="lib/jqgrid/jquery.js">
    </script>
    <script>
    function changeSelect(x) {
        var y = document.getElementById(x).value;
        if (y=='box1'){
            document.getElementById('box1').style.display='block';
            document.getElementById('box2').style.display='none';
        }else
        {
            document.getElementById('box2').style.display='block';
            document.getElementById('box1').style.display='none';
        }
    }
    </script>
</head>
<body>
<?php
echo $_GET['select'];

?>





<form action="index.php" method="get">
<select name="select" id="mySelect" onchange="changeSelect(this.id)">
    <option  value="box1">one</option>
    <option  value="box2" selected="selected">two</option>
    <option value="3">three</option>
</select>
    <input type="submit" value="提交">
</form>
<div id="box1" style="display: block">
    box1
</div>
<div id="box2" style="display: none">
    box2
</div>



</body>
</html>