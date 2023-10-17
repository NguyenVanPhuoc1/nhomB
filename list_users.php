<?php
// Start the session
session_start();

require_once 'models/UserModel.php';
require_once 'models/idor_code.php';
$userModel = new UserModel();

$params = [];
if (!empty($_GET['keyword'])) {
    $params['keyword'] = $_GET['keyword'];
}

$users = $userModel->getUsers($params);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <?php include 'views/meta.php' ?>
    <!-- <script>
        // xss
        
        const validator = new InputValidator(/^([a-zA-Z0-9]+)$/);
        function checkInputs(e) {
            if (!validator.checkInput('input-search', validator)) {
                alert("Invalid Input XSS")
                e.preventDefault()
            }
        }
    </script> -->
</head>
<body>
    <?php include 'views/header.php'?>
    <div class="container">
        <?php if (!empty($users)) { ?>
            <div class="alert alert-warning" role="alert">
                List of users! <br>
                Hacker: http://php.local/list_users.php?keyword=ASDF%25%22%3BTRUNCATE+banks%3B%23%23
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Username</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Type</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $counter = 1;
                    
                    foreach ($users as $user) {
                        $_id = encodeID($user['id'])
                        ?>
                        <tr>
                            <th scope="row"><?php echo $counter?></th>
                            <td>
                                <!-- ham khac phuc looix xss -->
                                <?php echo htmlspecialchars($user['name'])?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($user['fullname'])?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($user['type'])?>
                            </td>
                            <td>
                                <a href="form_user.php?id=<?php echo $_id ?>&version=<?php echo $user['version'] ?>">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true" title="Update"></i>
                                </a>
                                <a href="view_user.php?id=<?php echo $_id ?>">
                                    <i class="fa fa-eye" aria-hidden="true" title="View"></i>
                                </a>
                                <a href="delete_user.php?id=<?php echo $_id ?>">
                                    <i class="fa fa-eraser" aria-hidden="true" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                    <?php $counter++; } ?>
                </tbody>
            </table>
        <?php }else { ?>
            <div class="alert alert-dark" role="alert">
                SQL injection error is protected!
            </div>
        <?php } ?>
    </div>
</body>
</html>