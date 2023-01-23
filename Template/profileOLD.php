<?php
// foreach ($Posts as $post):
$post = $Posts[0];
?>
    <p>Username: <?php echo $post["Username"]; ?></p>
    <img src="<?php echo $post["profilepic"] ?>"></img>
    <p>nposts: <?php echo $post["nposts"]; ?></p>
    <p>followers: <?php echo $post["followers"]; ?></p>
    <p>following: <?php echo $post["following"]; ?></p>
    <p>bio: <?php echo $post["bio"]; ?></p>

    <?php
    foreach ($post["images"] as $image):
    ?>
        <img src="<?php echo $image ?>"></img>
    <?php
    endforeach
// endforeach
?>
