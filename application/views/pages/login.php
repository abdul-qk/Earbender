<div class="row">
    <div class="col-md-8 bg-image">
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12" style="height: 100vh; background: #fff;">
                <div class="container form">
                    <h2 style="display: inline-block;" class="form-header">Log</h2><div class="box"><p class="letter bounce">&#9679;</p><p class="letter">ı</p></div><h2 style="display: inline-block;" class="form-header">n</h2>
                    <form style="padding-top: 20px;" action="<?php echo base_url('index.php/Home') ?>" method="post">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                        <p style="color:red; margin-top: 20px;">
                            <?php
                            if (isset($msg)) {
                                echo $msg;
                            }
                            ?>
                        </p>
                    </form>
                    <br>
                    <p>Already a User? <a href="<?php echo base_url('index.php/signup') ?>">Sign up</a></p>
                </div>
            </div>
        </div>
    </div>
</div>