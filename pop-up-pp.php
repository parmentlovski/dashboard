<div class="d-none">




<script type="text/javascript">
    function changeImage(a) {
        document.getElementById("img").src=a;
    }
</script>

<a href="test.php"> <img id="img" src="http://placehold.it/110x110"></a>

<div id="thumb_img">
    <img src='http://placehold.it/120x60'  onclick='changeImage("http://placehold.it/120x60");'>
    <img src='http://placehold.it/130x60'  onclick='changeImage("http://placehold.it/130x60");'>
    <img src='http://placehold.it/140x60'  onclick='changeImage("http://placehold.it/140x60");'>
</div>

</div>