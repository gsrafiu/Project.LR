<?php
include 'lib/user.php';
include 'inc/header.php';
Session::checkSesssion();
?>

<?php
    if(isset($_GET['id'])){
        $userid = (int)$_GET['id'];
    }
    $user = new User();
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['updatepass'])){
        $updatepass = $user->updatepassword($userid, $_POST);
    }
?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Change Password <span class="pull-right"> <a class="btn btn-primary" href="profile.php">Back</a></span></h2>
        </div>

        <div class="panel-body"panel-body>
            <div style="max-width: 600px; margin: 0 auto ">

            <?php
                if(isset($updatepass)){
                    echo $updatepass;
                }
            ?>


            <form action="" method="POST">


                <div class="form-group">
                    <lable for="old_password">Old Pasword</lable>
                    <input type="password" id="old_password" name="old_password" class="form-control"/>
                </div>

                <div class="form-group">
                    <lable for="password">New Password</lable>
                    <input type="password" id="password" name="password" class="form-control"/>
                </div>

                <button type="submit" name="updatepass" class="btn btn-success">Update</button>
            </form>       
    </div>
<?php
    include 'inc/footer.php';
?>