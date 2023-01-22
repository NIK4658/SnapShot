<h1>Create Post</h1>
<form action="../Operations/CreatePost.php" method="post">
    <label for="description">Description:</label>
    <input type="text" id="description" name="description"><br><br>
    <label for="location">Location:</label>
    <input type="location" id="location" name="location"><br><br>
    <label for="device">Device:</label>
    <input type="device" id="device" name="device"><br><br>
    <img id="uploadPreview" style="width: 300px; height: 300px;" />
    <input id="uploadImage" type="file" name="myPhoto" onchange="PreviewImage();"/>
    <script type="text/javascript">
        function PreviewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview").src = oFREvent.target.result;
            };
        };
    </script>
    <input type="submit" value="Submit"><br><br>
</form>
<?php
if (isset($_GET["error"])) {
    echo "Error!";
}
?>