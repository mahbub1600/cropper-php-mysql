<style>
    .image-resizer{
        width: auto;
        height: auto;
        max-width: 100px;
        max-height: 150px;
    }
    .center-text{
        text-align: center;
        min-width: 50px;
    }
    td{
        padding: 4px;
    }
</style>
<div class="container-fluid">
    <h1 class="mt-4">User Information</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?php echo PROJECT_PATH.'/user/view/'; ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">All User</li>
    </ol>
    <div class="card mb-4">
        <div class="message">
<?php if(isset($query['status'])) {
    if($query['status']=='success'){
        echo 'Information Updated';
    } elseif($query['status']=='failed'){
        echo 'Information Could not be Updated';
    }
} ?>
        </div>
        <div class="card-body">
            <a class="btn btn-secondary" data-caption="My caption" href="<?php echo PROJECT_PATH.'/user/index'; ?>">Add a user</a>
            <div id="viewContent">
                <?php if(count($users)){ ?>
                    <table>
                        <thead>
                        <tr><th>Action</th><th>ID</th><th>Photo</th><th>Name</th><th>DOB</th><th>Mobile</th><th>Father Name</th><th>Mother Name</th><th>Address</th></tr>
                        </thead>
                        <tbody>
                        <?php
                        $editUrl = function($id){
                            return PROJECT_PATH.'/user/index/'. $id;
                        };
                        $deleteUrl = function($id){
                            return PROJECT_PATH.'/user/delete/'. $id;
                        };
                        $imageUrl = function($id){
                            return PROJECT_PATH.'/user/image/'. $id;
                        };
                        /**
                         * @var $user \User\Model\User
                         */
                        foreach($users as $user) { ?>
                        <tr><td><a class="btn btn-sm btn-info" href="<?php echo $editUrl($user->id) ?>">Edit</a> <a class="btn btn-sm btn-danger" href="<?php echo $deleteUrl($user->id) ?>">Remove</a></td><td class="center-text"><?php echo $user->id; ?></td><td><?php if($user->photo){?> <img class="image-resizer" src="<?php echo $imageUrl($user->photo); ?>" title="<?php echo $imageUrl($user->name); ?>"><?php } ?></td><td><?php echo $user->name; ?></td><td><?php echo $user->dob; ?></td><td><?php echo $user->mobile; ?></td><td><?php echo $user->fatherName; ?></td><td><?php echo $user->motherName; ?></td><td><?php echo $user->address; ?></td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } else{ ?>
                    <div>There is no user at this time</div>
                <?php } ?>

            </div>
        </div>
    </div>
    <div style="height: 100vh;"></div>
    <div class="card mb-4"><div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div></div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('#submitButton').click(function(e){
            /*e.preventDefault();*/
        });
    });
</script>
