<div class="container home">
    <div class="row">
        <div class="col-md-8">
            <form class="post_section" action="<?php echo base_url('index.php/Home-Post') ?>" method="post">
                <input type="text" id="post_text" autocomplete="off" name="post_msg" placeholder="What's cooking?" required>
                <input type="submit" value="Send Post" id="post_btn">
            </form>
            <hr>
            <div class="posts">
                <?php foreach ($postData as $post) : ?>
                    <div class="single_post">
                        <div class="row">
                            <div class="col-md-9">
                                <p class="name">
                                    <b><?php echo $post['fullname'] ?></b>
                                </p>
                                <p class="uname">
                                    <?php echo "@" . $post['username'] ?>
                                </p>
                            </div>
                            <div style="font-size: 14px; float: right;" class="col-md-3 text-muted">
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
        <div class="col-md-4">
            <div class="form-group" style="background: #fff; border: 1px #fff; border-radius: 20px;">
                <form action="<?php echo base_url('index.php/search') ?>" method="post" autocomplete="off">
                    <input style="width:85%" type="text" name="search_genre" id="search_profile" placeholder="Search by Genre">
                    <button style="background: none; border: none; cursor: pointer;" type="submit"><span class="fa fa-search form-control-feedback"></span></button>
                </form>
            </div>
            <div id="follow" class="follow">
                <h4 style="padding: 20px 30px 10px 20px;"><span class="color-secondary">Latest</span> Musicians</h4>
                <?php foreach ($recFollowData as $recFollower) : ?>
                    <hr style="margin-top: 8px;">
                    <div class="to_follow">
                        <div class="row">
                            <div class="col-md-6">
                                <form method="post" action="<?php echo base_url('index.php/public') ?>">
                                    <p onclick="javascript:this.parentNode.submit();" class="name">
                                        <?php echo $recFollower['fullname'] ?>
                                    </p>
                                    <p style="display: block;" class="uname">
                                        @<?php echo $recFollower['username'] ?>
                                        <input type="hidden" name="username_public" value="<?php echo $recFollower['username'] ?>">
                                    </p>
                                </form>
                            </div>
                            <form method="post" action="<?php echo base_url('index.php/public') ?>">
                                <div style="margin-left: -20px;" class="col-md-6">
                                    <input type="submit" id="follow_btn" value="View Profile">
                                    <input type="hidden" name="username_public" value="<?php echo $recFollower['username'] ?>">
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script>
    var BASE_URL = "<?php echo base_url(); ?>";

    $(document).ready(function() {
        $("#search_profile").autocomplete({

            source: function(request, response) {
                console.log(request.term);
                $.ajax({
                    url: BASE_URL + "index.php/Search/autocomplete",
                    data: {
                        term: request.term
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        var resp = $.map(data, function(obj) {
                            return obj.genre_name;
                        });
                        console.log(resp);

                        response(resp);

                    }
                });
            },
            minLength: 1
        });
    });
</script>