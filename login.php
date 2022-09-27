<?php
include 'inc/header.php';
include 'lib/user.php';
Session::checkloginn();
?>

<?php
    $user = new user();
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['login'])){
        $userLogin = $user->userLogin($_POST);
    }
?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>User Login</h2>
        </div>
        <div class=""panel-body>
            <div style="max-width: 600px; margin: 0 auto ">
<?php
    if(isset($userLogin)){
        echo $userLogin;
    }
?>
            <form action="" method="POST">
                <div class="form-group">
                    <lable for="email">Email</lable>
                    <input type="text" id="email" name="email" class="form-control" required=""/>
                </div>
                <div class="form-group">
                    <lable for="password">password</lable>
                    <input type="password" id="password" name="password" class="form-control"required=""/>
                </div>
                <button type="submit" name="login" class="btn btn-success">Login</button>
            </form>
            </div>
        </div>
    </div>
<?php
    include 'inc/footer.php';
?>