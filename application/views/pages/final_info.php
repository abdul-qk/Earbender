<div class="row">
    <div class="col-md-8 bg-image">
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12" style="height: 100vh; background: #fff;">
                <div class="container form">
                    <div class="row">
                        <a href="<?php echo base_url('index.php/signup') ?>">Go Back</a>
                    </div>
                    <h2 style="display: inline-block;" class="form-header">F</h2><div class="box"><p class="letter bounce">&#9679;</p><p class="letter">ı</p></div><h2 style="display: inline-block;" class="form-header">nal Touches</h2>
                    <form style="padding-top: 20px;" action="<?php echo base_url('index.php/login_final') ?>" method="post">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="picture-container">
                                    <div class="picture">
                                        <img src="<?php echo base_url('assets/images/avatar.png') ?>" class="picture-src" id="wizardPicturePreview">
                                        <input type="file" id="wizard-picture" onchange="fileUpload(this)" name="avatar">
                                        <input type="text" id="baseImageString" name="baseImageString" class="d-none">
                                    </div>
                                    <p class="text-muted small pt-2" id="wrong"></p>
                                    <h6 style="padding-top: 20px; padding-bottom: 20px;">Add a Profile Picture</h6>
                                </div>
                                <select multiple data-style="bg-white rounded-pill px-4 py-3 shadow-sm" name="genre[]" class="selectpicker w-100">
                                    <?php foreach ($genres as $genre) : ?>
                                        <option><?php echo $genre['genre_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <br>
                                <br>
                                <div class="form-group">
                                    <textarea placeholder="Tell us something about yourself" class="form-control" id="name" name="bio"></textarea>
                                </div>
                                <!-- <div style="padding-bottom: 10px;" class="form-group">
                                    <input type="text" class="form-control" id="name" placeholder="Address" name="name">
                                </div> -->
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">Finish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function fileUpload(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const filetype = file.type;
            const reader = new FileReader();
            const size = (file.size) / (1024 * 1024);
            if ((filetype == 'image/jpg' || filetype == 'image/jpeg' || filetype == 'image/png' || filetype == 'image/tif') && size < 5) {
                $('.picture').css("border-color", '#2ca8ff');
                $('#wrong').html(" ");
                reader.onload = function(e) {
                    const base64Str = convertBase64(e);
                    const imageSource = 'data:image/' + filetype + ';base64,' + base64Str;
                    // $('#baseImageString').value =  imageSource;
                    document.getElementById("baseImageString").value = imageSource;
                    $('#wizardPicturePreview').attr('src', imageSource).fadeIn('slow');
                };
                reader.readAsBinaryString(input.files[0]);
            } else {
                $('.picture').css("border-color", 'red');
                if (size > 5) {
                    $('#wrong').html("File too large for upload. Should be less than 5mb");
                } else {
                    $('#wrong').html("Wrong input type. Upload jpg, png or tif only");
                }

            }
        }
    }

    function convertBase64(readerEvt) {
        const binaryString = readerEvt.target.result;
        const base64textString = btoa(binaryString);
        return base64textString;
    }
</script>