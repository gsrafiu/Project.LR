<?php
include 'inc/header.php';
include 'lib/user.php';
?>

<?php
    $user = new user();
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['register'])){
        $userReg = $user->userRegistration($_POST);
    }
?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>User Register</h2>
        </div>
        <div class="panel-body"panel-body>
            <div style="max-width: 600px; margin: 0 auto ">
<?php
    if(isset($userReg)){
        echo $userReg;
    }
?>

            <form action="" method="POST">

                <div class="form-group">
                    <lable for="name">Name</lable>
                    <input type="text" id="name" name="name" class="form-control" />
                </div>

                <div class="form-group">
                    <lable for="username">Uasername</lable>
                    <input type="text" id="username" name="username" class="form-control" />
                </div>

                <div class="form-group">
                    <lable for="email">Email</lable>
                    <input type="text" id="email" name="email" class="form-control" />
                </div>
                <div class="form-group">
                    <lable for="password">Password</lable>
                    <input type="password" id="password" name="password" class="form-control"/>
                </div>
                <button type="submit" name="register" class="btn btn-success">Sign Up</button>
            </form>
            </div>
        </div>
    </div>
<?php
    include 'inc/footer.php';
?>