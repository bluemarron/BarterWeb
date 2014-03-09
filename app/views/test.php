<script>
function preview(input) {
	document.getElementById("test").src = document.getElementById("file_1").value;
	
}
</script>
<img id="test" src="">
<input type="file" id="file_1" onchange="preview(this)">