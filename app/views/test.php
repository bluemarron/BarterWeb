<script>
function preview(input) {
	document.getElementById("test").src = input.value;
}
</script>
<img id="test" src="">
<input type="file" id="file_1" onchange="preview(this)">