<div class="row">
    <div class="col-md-8 bg-image">
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12" style="height: 100vh; background: #fff;">
                <div class="container form">
                <h2 style="display: inline-block;" class="form-header">S</h2><div class="box"><p class="letter bounce">&#9679;</p><p class="letter">ı</p></div><h2 style="display: inline-block;" class="form-header">gn Up</h2>
                    <form style="padding-top: 20px;" action="<?php echo base_url('index.php/signup_final') ?>" method="post">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" value="<?php echo $this->session->userdata('tempUser')['fullname']?>"placeholder="Enter name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email"value="<?php echo $this->session->userdata('tempUser')['email']?>" placeholder="Enter email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <input type="phone" class="form-control" id="phone"value="<?php echo $this->session->userdata('tempUser')['phone']?>" placeholder="Enter phone" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="uname"value="<?php echo $this->session->userdata('tempUser')['username']?>" placeholder="Enter username" name="uname" required>
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
</div>