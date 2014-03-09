<script>
function preview(input) {
	//document.getElementById("test").src = input.value;
	document.getElementById("test").src = 	"http://img.naver.net/static/www/u/2013/0731/nmms_224940510.gif";

}
</script>
<img id="test" src="">
<input type="file" id="file_1" onchange="preview(this)">