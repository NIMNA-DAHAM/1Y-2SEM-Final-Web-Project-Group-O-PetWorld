<?php
session_start();
require_once 'config/database.php';
require_once 'utils/functions.php';


if (is_logged_in()) {
    
    if (is_admin()) {
        redirect('admin/index.php');
    } else {
        redirect('home.php');
    }
}

$error = '';
$email = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        
        $database = new Database();
        $db = $database->getConnection();
        
        
        $query = "SELECT user_id, full_name, email, password, role FROM users WHERE email = :email";
        $stmt = $db->prepare($query);
        
        
        $stmt->bindParam(':email', $email);
        
        
        $stmt->execute();
        
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            
            if (password_verify($password, $row['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['full_name'] = $row['full_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                
                
                if ($row['role'] === 'admin') {
                    redirect('admin/index.php');
                } else {
                    redirect('home.php');
                }
            } else {
                $error = 'Invalid password';
            }
        } else {
            $error = 'User not found';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Pet World</title>
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
    <style>
    body {
        background: #0da315;
        background: radial-gradient(circle, rgba(13, 163, 21, 1) 0%, rgba(1, 1, 56, 1) 100%);
        color: white;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border-radius: 1rem;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
    }

    h1 {
        text-align: center;
    }
    </style>
</head>

<body>

    <div class="container">
        <h1><b>Pet World</b></h1>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <h3 class="text-center text-primary">Login</h3>
                    <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="form-group mt-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email"
                                value="<?php echo $email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
                        <p class="text-center mt-3">Don't have an account?
                            <a href="signup.php">
                                <center>Sign Up</center>
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>