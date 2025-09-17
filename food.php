<?php
session_start();
require_once 'config/database.php';
require_once 'utils/functions.php';


$database = new Database();
$db = $database->getConnection();


$query = "SELECT * FROM categories ORDER BY name";
$stmt = $db->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


$selected_category = isset($_GET['category']) ? clean_input($_GET['category']) : '';


$where_clause = '';
$params = [];

if (!empty($selected_category)) {
    $where_clause = " WHERE p.category_id = :category_id";
    $params[':category_id'] = $selected_category;
}

$query = "SELECT p.*, c.name as category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.category_id" . 
          $where_clause . 
          " ORDER BY p.name";
$stmt = $db->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet World - Food Items</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style type="text/css">
    .bg-gray-50 .bg-green-600.text-white.py-20.text-center {
        background-color: #060221;
        color: #FFFFFF;
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    </style>

<body class="bg-gray-50">

    <nav class="bg-green-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2"> <a href="#" class="text-xl font-bold">PET WORLD&nbsp;</a>
            </div>

            <div class="hidden md:flex space-x-6">
                <a href="home.php" class="hover:text-green-200"><b>Home</b></a>
                <a href="food.php" class="hover:text-green-200"><b>Food</b></a>
                <a href="aboutus.php" class="hover:text-green-200"><b>About Us</b></a>
                <a href="contactus.php" class="hover:text-green-200"><b>Contact Us</b></a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="#" class="hover:text-green-200">
                    <i class="fas fa-search"></i>
                </a>
                <?php if (is_logged_in()): ?>
                <a href="profile.php" class="hover:text-green-200">
                    <i class="fas fa-user"></i>
                </a>
                <a href="logout.php" class="hover:text-green-200">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
                <?php else: ?>
                <a href="login.php" class="hover:text-green-200">
                    <i class="fas fa-user"></i>
                </a>
                <?php endif; ?>

                <button class="md:hidden focus:outline-none" id="menuButton">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>


    <section class="bg-green-600 text-white py-20 text-center">
        <h2 class="text-4xl font-bold mb-4">Welcome to Pet World</h2>
        <p class="text-lg mb-6">Your one-stop shop for pets, food, toys, and more!</p>
        <a href="#" class="bg-yellow-400 text-black font-bold py-2 px-6 rounded hover:bg-yellow-500 transition"
            style="background-color: green">Shop Now</a>
    </section>



    <section class="py-12 container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Food Items</h2>


        <div class="mb-8 flex justify-center">
            <div class="inline-flex rounded-md shadow-sm">
                <a href="food.php"
                    class="px-4 py-2 text-sm font-medium <?php echo empty($selected_category) ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?> rounded-l-lg border border-gray-200">
                    All
                </a>
                <?php foreach ($categories as $category): ?>
                <a href="food.php?category=<?php echo $category['category_id']; ?>"
                    class="px-4 py-2 text-sm font-medium <?php echo $selected_category == $category['category_id'] ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?> border-t border-b border-r border-gray-200">
                    <?php echo htmlspecialchars($category['name']); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative">
                    <img src="<?php echo !empty($product['image']) ? 'image/' . htmlspecialchars($product['image']) : 'image/sad-pet.svg'; ?>"
                        alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-60 object-cover">
                    <span class="absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded">
                        <?php echo htmlspecialchars($product['category_name']); ?>
                    </span>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-1"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="text-gray-600 text-sm mb-2"><?php echo htmlspecialchars($product['description']); ?></p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-green-700">LKR
                            <?php echo number_format($product['price'], 2); ?></span>
                        <a href="#"
                            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 inline-block">
                            Add to Cart
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500 text-lg">No products found in this category.</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <br><br><br>
    <br><br><br>
    <footer class="bg-gray-900 text-white pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">


                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center">PET WORLD</h3>
                    <p class="text-gray-400">Connecting communities through local food trading since 2023.</p>
                </div>


                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="home.php" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="food.php" class="text-gray-400 hover:text-white">Browse Items</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">List an Item</a></li>
                        <li><a href="aboutus.php" class="text-gray-400 hover:text-white">How It Works</a></li>
                    </ul>
                </div>


                <div>
                    <h4 class="font-bold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Safety Tips</a></li>
                        <li><a href="contactus.php" class="text-gray-400 hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>


                <div>
                    <h4 class="font-bold mb-4">Connect With Us</h4>
                    <div class="flex space-x-4 mb-4">
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-pinterest"></i></a>
                    </div>
                    <p class="text-gray-400">Subscribe to our newsletter</p>
                    <div class="flex mt-2">
                        <input type="email" placeholder="Your email"
                            class="bg-gray-800 text-white px-3 py-2 rounded-l focus:outline-none w-full">
                        <button class="bg-green-600 text-white px-4 py-2 rounded-r hover:bg-green-700"><i
                                class="fas fa-paper-plane"></i></button>
                    </div>
                </div>

            </div>


            <div class="border-t border-gray-800 pt-6 text-center text-gray-400">
                <p>&copy; 2023 PET WORLD. All rights reserved.</p>
            </div>
        </div>
    </footer>


    <div class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden" id="mobileMenu">
        <div class="bg-green-600 h-full w-3/4 max-w-sm p-4">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-2">
                    <span class="text-xl font-bold">PET WORLD</span>
                </div>
                <button id="closeMenu" class="text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="space-y-4">
                <a href="#" class="block py-2 px-4 bg-green-700 rounded">Home</a>
                <a href="#" class="block py-2 px-4 hover:bg-green-700 rounded">Browse</a>
                <a href="#" class="block py-2 px-4 hover:bg-green-700 rounded">Sell/Trade</a>
                <a href="#" class="block py-2 px-4 hover:bg-green-700 rounded">About</a>
                <a href="#" class="block py-2 px-4 hover:bg-green-700 rounded">Contact</a>
                <a href="#" class="block py-2 px-4 hover:bg-green-700 rounded">My Account</a>
            </nav>
        </div>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenu = document.getElementById('mobileMenu');
        const menuButton = document.getElementById('menuButton');
        const closeButton = document.getElementById('closeMenu');

        if (menuButton) {
            menuButton.addEventListener('click', function() {
                mobileMenu.classList.remove('hidden');
            });
        }

        if (closeButton) {
            closeButton.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
            });
        }
    });
    </script>
</body>

</html>