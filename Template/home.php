<?php
foreach ($Posts as $post):
?>
    <div class="post">
        <?php
        if ($post["location"] != null) { ?>
                <div class="username_location">
                    <img class="profilepic" src="<?php echo $post["profilepic"]; ?>"></img>
                    <div class="name_location">
                        <p class="name"><?php echo $post["Username"]; ?></p>
                        <p class="location"><?php echo $post["location"]; ?></p>
                    </div>
                </div>
        <?php } else { ?>
                <div class="username">
                    <img class="profilepic" src="<?php echo $post["profilepic"]; ?>"></img>
                    <p class="name"><?php echo $post["Username"]; ?></p>
                </div>
        <?php } ?>
        <img class="image" src="<?php echo $post["image"]; ?>"></img>
        <div class="bottom">
            <div class="buttons">
                <button class="love"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
                <button class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i></button>
                <button class="info"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
            </div>
            <p class="n_loves">
                <?php echo $post["n_loves"] . " likes"; ?>
            </p>
            <div class="description_content">
                <p class="namesmall">
                    <?php echo $post["Username"] ?>
                </p>
                <p class="description">
                    <?php echo $post["description"]; ?>
                </p>
            </div>
            <p class="n_comments">
                <?php echo "View all " . $post["n_comments"] . " comments"; ?>
            </p>
            <p class="date">
                <?php echo $post["date"]; ?>
            </p>
            <!-- <p class="device">
                <?php echo $post["device"]; ?>
            </p> -->
        </div>
    </div>
<?php
endforeach;
?>