<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fixed Bootstrap Navbar</title>


    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">

    <style>
    .hero {
        height: 100vh;
        background: #0da315;
        background: radial-gradient(circle, rgba(13, 163, 21, 1) 0%, rgba(1, 1, 56, 1) 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .hero h1 {
        font-size: 3rem;
    }

    .hero p {
        font-size: 1.2rem;
    }
    
    </style>
</head>

<body>


    <nav class="navbar navbar-expand-md navbar-dark bg-transparent fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="home.php">
                <img src="https://tailwindflex.com/images/logo.svg" width="50" height="50"
                    class="d-inline-block align-top" alt="Logo">
                <span class="ml-2 font-weight-bold">PET WORLD</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="food.php">Food Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactus.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light ml-md-2" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light text-primary ml-md-2" href="signup.php">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero">
        <div>
            <h1 class="display-4">Welcome to PetWorld</h1>
            <p class="mt-3">We Will Provide Everything your Pet needs </p>
            <a href="home.php" class="btn btn-light text-primary btn-lg mt-4">Get Started</a>
        </div>
    </div>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>

</body>

</html>