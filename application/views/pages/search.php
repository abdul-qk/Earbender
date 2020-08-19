<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div style="margin-top: 30px;" class="col-md-1">
                    <a href="<?php echo base_url('index.php/Dashboard') ?>">
                        <i style="font-size: 30px; line-height: 1.5;" class="fas fa-long-arrow-alt-left"></i>
                    </a>
                </div>
                <div class="col-md-11">
                    <div class="form-group" style="background: #fff; border: 1px #fff; border-radius: 20px; margin-top: 30px;">
                        <form action="<?php echo base_url('index.php/search') ?>" method="post" autocomplete="off">
                            <!-- <input id="search" name="search" type="text" class="form-control" placeholder="Search" /> -->
                            <input style="width:92%" type="text" name="search" id="search_profile" placeholder="Search by Genre" value="<?php echo $search[0]['genre_name']; ?>">
                            <button style="background: none; border: none; cursor: pointer;" type="submit"><span class="fa fa-search form-control-feedback"></span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div id="result" style="margin-top: 20px;">
                <?php foreach ($search as $genre) : ?>
                    <div class="single row">
                        <div class="col-md-10">
                            <form method="post" action="<?php echo base_url('index.php/public') ?>">
                                <h3 onclick="javascript:this.parentNode.submit();" style="margin-bottom: 0; cursor: pointer; color: #BD0B0A;"><?php echo $genre['fullname'] ?></h3>
                                <p style="margin-bottom:20px;" class="text-muted"><?php echo '@' . $genre['username'] ?></p>
                                <input type="hidden" name="username_public" value="<?php echo $genre['username'] ?>">
                            </form>
                        </div>
                        <div style="padding-top: 15px;" class="col-md-2">
                            <form method="post" action="<?php echo base_url('index.php/public') ?>">
                                <button type="submit" class="btn btn-primary">View Profile</button>
                                <input type="hidden" name="username_public" value="<?php echo $genre['username'] ?>">
                            </form>
                        </div>
                        <div class="br"></div>
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