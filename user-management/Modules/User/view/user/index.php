<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/cropperjs"></script>
<style>

    .image_area {
        position: relative;
    }

    img {
        display: block;
        max-width: 100%;
    }

    .preview {
        overflow: hidden;
        width: 160px;
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }

    .modal-lg{
        max-width: 1000px !important;
    }

    .overlay {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        background-color: rgba(255, 255, 255, 0.5);
        overflow: hidden;
        height: 0;
        transition: .5s ease;
        width: 55%;
    }

    .image_area:hover .overlay {
        height: 50%;
        cursor: pointer;
    }

    .text {
        color: #333;
        font-size: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
    }

</style>

<div class="container-fluid">
    <h1 class="mt-4">User Customization</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?php echo PROJECT_PATH.'/user/view/'; ?>">Dashboard</a></li>
        <?php
        /**
         * @var $user \User\Model\User
         */
        if(!$user->id){ ?>
        <li class="breadcrumb-item active">Add a User</li>
        <?php } else{ ?>
            <li class="breadcrumb-item active">Edit a User (ID: <?php echo $user->id ?>)</li>
        <?php }?>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <div id="addForm">

            <form method="post" action="<?php echo PROJECT_PATH ?>/user/index<?php echo ($user->id?'/'.$user->id:''); ?>">
                <div class="image_area">
                <label for="upload_image">
                    <?php
                    if($user->photo){
                        $imgSrc = PROJECT_PATH.'/user/image/'.$user->photo;
                    } else{
                        $imgSrc=PROJECT_PATH.'/images/user.jpg';
                    }
                    ?>
                    <img src="<?php echo $imgSrc; ?>" id="uploaded_image" class="img-responsive img-circle" />
                    <div class="overlay">
                        <div class="text">Click to Change Profile Image</div>
                    </div>
                    <input type="file" name="image" class="image" id="upload_image" style="display:none" />
                    <input id="photo" type="hidden" value="<?php echo $user->photo; ?>" name="photo">
                </label>
                </div>
                <label for="name">Name:</label><br>
                <input required type="text" id="name" name="name" value="<?php echo $user->name; ?>"><br>
                <label for="dob">DOB:</label><br>
                <input required type="date" id="dob" name="dob" value="<?php echo $user->dob; ?>"><br>
                <label for="mobile">Mobile:</label><br>
                <input required type="text" id="mobile" name="mobile" value="<?php echo $user->mobile; ?>"><br><br>
                <label for="fatherName">Father Name:</label><br>
                <input required type="text" id="fatherName" name="fatherName" value="<?php echo $user->fatherName; ?>"><br><br>
                <label for="motherName">Mother Name:</label><br>
                <input required type="text" id="motherName" name="motherName" value="<?php echo $user->motherName; ?>"><br><br>
                <label for="address">Address:</label><br>
                <input required type="text" id="address" name="address" value="<?php echo $user->address; ?>"><br><br>
                <input class="btn btn-dark" id="submitButton" type="submit" value="<?php echo ($user->id?"Update": "Add"); ?>">
            </form>
        </div>
        </div>
    </div>
    <div style="height: 100vh;"></div>
    <div class="card mb-4"><div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div></div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image Before Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="" id="sample_image" />
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="crop" class="btn btn-primary">Crop</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function(){

        var $modal = $('#modal');

        var image = document.getElementById('sample_image');

        var cropper;

        $('#upload_image').change(function(event){
            var files = event.target.files;

            var done = function(url){
                image.src = url;
                $modal.modal('show');
            };

            if(files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function(event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview:'.preview'
            });
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null;
        });

        $('#crop').click(function(){
            canvas = cropper.getCroppedCanvas({
                width:400,
                height:400
            });

            canvas.toBlob(function(blob){
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function(){
                    var base64data = reader.result;
                    $.ajax({
                        url:'<?php echo PROJECT_PATH ?>/user/upload',
                        method:'POST',
                        data:{image:base64data},
                        success:function(data) {
                            $modal.modal('hide');
                            $('#uploaded_image').attr('src', "<?php echo PROJECT_PATH.'/user/image/'?>"+data);
                            $('#photo').val(data);
                        }
                    });
                };
            });
        });

    });
</script>