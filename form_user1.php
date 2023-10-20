<?php
// Start the session
session_start();


require_once 'models/UserModel.php';
$userModel = new UserModel();

$user = NULL; //Add new user
$_id = NULL;
$_version = NULL;

if (!empty($_GET['id'])) {
    $_id = $_GET['id'];

    $_version = $_GET['version'];
    $user = $userModel->findUserById($_id);//Update existing user
}

// optimis locking
if (!empty($_POST['submit'])) {
        if (!empty($_id)) {
            if ($_version === $user[0]['version']) {
                $userModel->updateUser($_POST);
                header('location: list_users.php');
            } else {
                
                echo '<script>
                    alert("Dữ liệu đã được sửa đổi bởi người khác. Không thể sửa lần thứ hai.");
                    
                </script>';
            } 
            
        } else {
            $userModel->insertUser($_POST);
        }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>User form</title>
    <?php include 'views/meta.php' ?>
    <script>
        // xss
        
        /*function checkInputs(e) {
            const isNameValid = validator.checkInput('input-name');
            // const isSearchValid = validator.checkInput('input-search');

            if (!isNameValid ) {
                alert("Invalid Input XSS");
                e.preventDefault();
            }
        }
    </script>
</head>
<body>
    <?php include 'views/header.php'?>
    <div class="container">

            <?php if ($user || !isset($_id)) { ?>
                <div class="alert alert-warning" role="alert">
                    User form
                </div>
                <!-- onsubmit="return checkInputs(event)" -->
                <form method="post" enctype="multipart/form-data" >
                        <input type="hidden" name="id" value="<?php echo $_id ?>">
                        <input type="hidden" name="version" value="<?php echo $_version ?>">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" id="input-name" name="name" placeholder="Name" value='<?php if (!empty($user[0]['name'])) echo $user[0]['name'] ?>'>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <button type="submit" name="submit" value="submit" class="btn btn-primary"?>Submit</button>
                    </form>
            <?php } else { ?>
                <div class="alert alert-success" role="alert">
                    User not found!
                </div>
            <?php } ?>
    </div>

</body>
</html>