<div class="row">
    <div class="col-md-8 bg-image">
        <!-- <div class="white-overlay"> -->
        <!-- <h2>Welcome to Earbender</h2>
            <p>Earbender <span style="color: #0069d9; font-weight: 600;">connects</span> you to millions of people listening to the same music. Find your music <span style="color: #0069d9; font-weight: 600;">Soulmate</span>.<br/> Be <span style="color: #0069d9; font-weight: 600;">Amazed</span>. Stay <span style="color: #0069d9; font-weight: 600;">Alive.</span></p> -->
        <!-- </div> -->
    </div>
    <div id="land" class="col-md-4">
        <div class="row">
            <div class="col-md-12" style="height: 100vh; background: #fff;">
                <div class="container form landing">
                    <img src="<?php echo base_url('assets/images/logo_2.png') ?>" alt="" width="50px;">
                    <h2>Welcome to <span class="custom-font"><span style="color: #BD0B0A; font-weight: 600;">Ear</span>bender</span></h2>
                    <p>Earbender <span style="color: #BD0B0A; font-weight: 600;">connects</span> you to millions of <br>people listening to the same music.<br> Find your music <span style="color: #BD0B0A; font-weight: 600;">Soulmate</span>.<br /> Be <span style="color: #BD0B0A; font-weight: 600;">Amazed</span>. Stay <span style="color: #BD0B0A; font-weight: 600;">Alive.</span></p>
                    <!-- <h1 class="mb-5">Enter your World!</h1> -->
                    <!-- <h2 style="display: inline-block;" class="form-header">Log</h2><div class="box"><p class="letter bounce">&#9679;</p><p class="letter">ı</p></div><h2 style="display: inline-block;" class="form-header">n</h2> -->
                    <button id="login_show" type="submit" class="btn btn-land btn-primary btn-submit mb-3">Log In</button>
                    <button id="signup_show" type="submit" class="btn btn-land btn-primary btn-submit">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <div id="login" class="col-md-4">
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
    <div id="signup" class="col-md-4">
        <div class="row">
            <div class="col-md-12" style="height: 100vh; background: #fff;">
                <div class="container form">
                    <h2 style="display: inline-block;" class="form-header">S</h2><div class="box"><p class="letter bounce">&#9679;</p><p class="letter">ı</p></div><h2 style="display: inline-block;" class="form-header">gn Up</h2>
                    <form style="padding-top: 20px;" action="<?php echo base_url('index.php/signup_final') ?>" method="post">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" value="<?php echo $this->session->userdata('tempUser')['fullname'] ?>" placeholder="Enter name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" value="<?php echo $this->session->userdata('tempUser')['email'] ?>" placeholder="Enter email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <input type="phone" class="form-control" id="phone" value="<?php echo $this->session->userdata('tempUser')['phone'] ?>" placeholder="Enter phone" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="uname" value="<?php echo $this->session->userdata('tempUser')['username'] ?>" placeholder="Enter username" name="uname" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="pwd2" placeholder="Enter password again" name="pswd2" required>
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
                    <p>New User? <a href="<?php echo base_url('index.php/login') ?>">Login</a></p>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#login").hide();
            $("#signup").hide();

            $("#login_show").click(function() {
                $("#land").hide(150);
                $("#login").show(550);
            });
            $("#signup_show").click(function() {
                $("#land").hide(150);
                $("#signup").show(550);
            });
        });
    </script>