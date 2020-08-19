<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-8 mt-4 text-center">
                    <form action="<?php echo base_url('index.php/saveprofile') ?>" method="post">
                        <div class="row text-left">
                            <div class="col-md-6">
                                <div class="picture-container">
                                    <div class="picture">
                                        <img src="<?php echo $profile['avatar'] ?>" class="picture-src" id="wizardPicturePreview">
                                        <input type="file" id="wizard-picture" onchange="fileUpload(this)" name="avatar_edit">
                                        <input type="text" id="baseImageString" name="baseImageString" class="d-none">
                                    </div>
                                    <p class="text-muted small pt-2" id="wrong"> </p>
                                    <h6 style="padding-top: 10px; padding-bottom: 10px;">@<?php echo $profile['uname'] ?></h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bio_edit">Bio:</label>
                                    <textarea class="form-control" rows="6" name="bio_edit" id="bio_edit"><?php echo $profile['bio'] ?></textarea><br />
                                </div>

                            </div>
                        </div>
                        <div class="row text-left">
                            <div class="form-group col-md-6">
                                <label for="name_edit">Fullname:</label>
                                <input class="form-control" type="text" name="name_edit" id="name_edit" value="<?php echo $profile['name'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone_edit">Phone Number:</label>
                                <input class="form-control" type="text" name="phone_edit" id="phone_edit" value="<?php echo $profile['phone'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email_edit">Email:</label>
                                <input class="form-control" type="text" name="email_edit" id="email_edit" value="<?php echo $profile['email'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address_edit">Address:</label>
                                <input class="form-control" type="text" name="address_edit" id="address_edit" value="<?php echo $profile['address'] ?>">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address_edit">Update Genres:</label>
                                <select multiple data-style="bg-white rounded-pill px-4 py-3 shadow-sm" name="genre[]" class="selectpicker mb-4 w-100">
                                    <?php foreach ($allGenres as $allGenre) : ?>
                                        <?php if (in_array($allGenre['genre_name'], $genres)) : ?>
                                            <option class="form-control" selected><?php echo $allGenre['genre_name']; ?></option>
                                        <?php else : ?>
                                            <option class="form-control"><?php echo $allGenre['genre_name']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">Update Profile</button>
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
            const size = (file.size) / (1024 * 1024 * 1024);
            $('.picture').css("border-color", '#2ca8ff');
            $('#wrong').html(" ");
            if ((filetype == 'image/jpg' || filetype == 'image/jpeg' || filetype == 'image/png' || filetype == 'image/tif') && size < 5) {
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
                if (size > 50) {
                    $('#wrong').html("File too large for upload. Should be less than 50kb");
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