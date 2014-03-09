<style type="text/css">
    #prevImage {
        border: 8px solid #ccc;
        width: 300px;
        height: 200px;
    }
</style>
<script type="text/javascript">
    function setImage(file) {
        if(document.all)
            document.getElementById('prevImage').src = file.value;
        else
            document.getElementById('prevImage').src = file.files.item(0).getAsDataURL();
        if(document.getElementById('prevImage').src.length > 0) 
            document.getElementById('prevImage').style.display = 'block';
    }
</script>
<pre>
     IE8 needs a security settings change: internet settings, security, custom level :

     [] Include local directory path when uploading files to a server
 ( ) Disable
 (o) Enable 
</pre>
<form>
    <input type="file" name="myImage" onchange="setImage(this);" />
</form>
<img id="prevImage" style="display:none;" />