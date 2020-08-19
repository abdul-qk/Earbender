<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="avatar">
                        <img src="<?php echo $profile['avatar'] ?>" alt="" class="avatar">
                    </div>
                </div>
                <div class="col-md-8">
                    <h2 class="mt-4"><?php echo $profile['name'] ?></h2>
                    <h4><?php echo '@' . $profile['uname'] ?></h4>
                    <p><?php echo $follow . " Posts" ?> <br />
                        <i><?php echo $profile['bio'] ?></i>
                    </p>
                    <p style="display: inline-block; padding-right: 10px;"><b><?php echo $followers ?></b> Followers</p>
                    <p style="display: inline-block;"><b><?php echo $followings ?></b> Following</p>
                    <h5>Music Interests</h5>
                    <ul class="nav genre-pills">
                        <?php foreach ($genres as $genre) : ?>
                            <li class="genre-item">
                                <?php echo $genre['genre_name']; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-2 mt-4">
                    <?php if (!$check) { ?>
                        <form method="post" action="<?php echo base_url('index.php/followperson') ?>">
                            <input type="hidden" name="follower" value="<?php echo $profile['uname'] ?>">
                            <input class="btn btn-primary btn-edit" type="submit" value="Follow">
                        </form>
                    <?php } else { ?>
                        <form method="post" action="<?php echo base_url('index.php/unfollowperson') ?>">
                            <input type="hidden" name="unfollow" value="<?php echo $profile['uname'] ?>">
                            <input class="btn btn-primary btn-edit" type="submit" value="Unfollow">
                        </form>
                    <?php } ?>
                </div>
            </div>
            <div class="tabs">
                <div class="tab-button-outer">
                    <ul id="tab-button">
                        <li><a href="#tab01">Posts</a></li>
                    </ul>
                </div>

                <div id="tab01" class="tab-contents">
                    <div class="posts">
                        <?php foreach ($postData as $post) : ?>
                            <div class="single_post">
                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="name">
                                            <b><?php echo $post['fullname'] ?></b>
                                        </p>
                                        <p class="uname">
                                            <?php echo "@" . $post['username'] ?>
                                        </p>
                                    </div>
                                    <div style="font-size: 14px; float: right;" class="col-md-2 text-muted">
                                        <?php

                                            $date1 = date_create($post['created_date']);
                                            $date2 = date_create(date("Y/m/d H:i:s"));
                                            $diff = date_diff($date1, $date2);

                                            if ($diff->format("%a") == 0) {
                                                echo "Posted " . $diff->format("%h hours ago");
                                            } else {
                                                echo "Posted " . $diff->format("%a days ago");
                                            }
                                            ?>
                                    </div>
                                </div>
                                <div class="content">
                                    <p class="text">
                                        <?php echo $post['message'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="extras">
                                <button class="icon-bar"><i class="far fa-heart"></i></button>
                                <button class="icon-bar"><i class="far fa-comment"></i></button>
                                <button style="float: right" class="icon-bar"><i class="fas fa-share-alt"></i></button>
                            </div>
                            <div class="seperator"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="tab04" class="tab-contents">
                    <?php foreach ($user_followings as $following) : ?>
                        <h5><b><?php echo $following['fullname'] ?></b></h5>
                        <p>@<?php echo $following['username'] ?></p>
                        <p><?php echo $following['bio'] ?></p>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        var $tabButtonItem = $('#tab-button li'),
            $tabSelect = $('#tab-select'),
            $tabContents = $('.tab-contents'),
            activeClass = 'is-active';

        $tabButtonItem.first().addClass(activeClass);
        $tabContents.not(':first').hide();

        $tabButtonItem.find('a').on('click', function(e) {
            var target = $(this).attr('href');

            $tabButtonItem.removeClass(activeClass);
            $(this).parent().addClass(activeClass);
            $tabSelect.val(target);
            $tabContents.hide();
            $(target).show();
            e.preventDefault();
        });

        $tabSelect.on('change', function() {
            var target = $(this).val(),
                targetSelectNum = $(this).prop('selectedIndex');

            $tabButtonItem.removeClass(activeClass);
            $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
            $tabContents.hide();
            $(target).show();
        });
    });
</script>