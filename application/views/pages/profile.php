<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="avatar">
                        <img src="<?php echo $profile['avatar'] ?>" alt="" class="avatar">
                    </div>
                </div>
                <div class="col-md-7 mt-4">
                    <h2 id="name"><?php echo $profile['name'] ?></h2>
                    <h4><?php echo '@' . $profile['uname'] ?></h4>
                    <p><?php echo $follow . " Posts" ?> <br />
                        <i id="bio"><?php echo $profile['bio'] ?></i>
                    </p>
                    </form>
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
                <div class="col-md-1 mr-4 mt-4">
                    <a href="<?php echo base_url('index.php/editprofile') ?>">
                        <button id="edit_profile" class="btn btn-primary btn-edit" type="submit">Edit Profile</button>
                    </a>
                </div>
                <div class="col-md-1 mt-4">
                    <a href="<?php echo base_url('index.php/Contact') ?>">
                        <button id="contact" class="btn btn-primary btn-edit" type="submit">View Contacts</button>
                    </a>
                </div>
            </div>
            <div class="tabs">
                <div class="tab-button-outer">
                    <ul id="tab-button">
                        <li><a href="#tab01">Your Posts</a></li>
                        <li><a href="#tab02">Followers</a></li>
                        <li><a href="#tab03">Followings</a></li>
                        <li><a href="#tab04">Friends</a></li>
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
                                <form action="<?php echo base_url('index.php/deletepost') ?>" method="post">
                                    <button onclick="javascript:this.parentNode.submit();" style="float: right; margin-top: -35px; cursor: pointer;" class="icon-bar"><i class="fas fa-trash-alt"></i></button>
                                    <input type="hidden" name="post_id" value="<?php echo $post['post_id'] ?>">
                                </form>
                            </div>
                            <div class="seperator"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="tab02" class="tab-contents">
                    <?php if (empty($user_followers)) {
                        echo "<p class='text-muted big'><i>No Followers</i></p>";
                    } ?>
                    <?php foreach ($user_followers as $follower) : ?>
                        <form action="<?php echo base_url('index.php/public') ?>" method="post">
                            <h5 onclick="javascript:this.parentNode.submit();" class="name"><b><?php echo $follower['fullname'] ?></b></h5>
                            <input type="hidden" name="username_public" value="<?php echo $follower['username'] ?>">
                            <p>@<?php echo $follower['username'] ?></p>
                            <p><?php echo $follower['bio'] ?></p>
                        </form>
                        <hr>
                    <?php endforeach; ?>
                </div>
                <div id="tab03" class="tab-contents">
                    <?php if (empty($user_followings)) {
                        echo "<p class='text-muted big'><i>No Followings</i></p>";
                    } ?>
                    <?php foreach ($user_followings as $following) : ?>
                        <form action="<?php echo base_url('index.php/public') ?>" method="post">
                            <h5 onclick="javascript:this.parentNode.submit();" class="name"><b><?php echo $following['fullname'] ?></b></h5>
                            <input type="hidden" name="username_public" value="<?php echo $following['username'] ?>">
                            <p>@<?php echo $following['username'] ?></p>
                            <p><?php echo $following['bio'] ?></p>
                        </form>
                        <hr>
                    <?php endforeach; ?>
                </div>
                <div id="tab04" class="tab-contents">
                    <?php if (empty($friends)) {
                        echo "<p class='text-muted big'><i>No Friends</i></p>";;
                    } ?>
                    <?php if (isset($friends)) : ?>
                        <?php foreach ($friends as $friend) : ?>
                            <h5><b><?php echo $friend[0]['fullname']; ?></b></h5>
                            <p>@<?php echo $friend[0]['username']; ?></p>
                            <p><?php echo $friend[0]['bio'] ?></p>
                            <hr>
                        <?php endforeach; ?>
                    <?php endif ?>
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