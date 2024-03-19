<?php

// Database connection settings
$servername = "220096670.cs2410-web01pvm.aston.ac.uk"; // Your server hostname
$username = "u-220096670"; // Your MySQL username
$password = "k8SA73C7UFhUiChu"; // Your MySQL password
$database = "u_220096670_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to add a new product
function addProduct() {
    global $conn;
    
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Retrieve product details from POST data
        $productName = $_POST['product_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        
        // Validate input data (you can add more validation checks)
        if (empty($productName) || empty($description) || empty($price) || empty($category_id)) {
            echo "Please fill all fields.";
            return;
        }

        // Prepare SQL statement to insert product into the product table
        $sql = "INSERT INTO product (product_name, description, price, category_id) VALUES (?, ?, ?, ?)";
        
        // Prepare and bind parameters to the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $productName, $description, $price, $category_id);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Product added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Function to remove a product
function removeProduct() {
    global $conn;
    
    // Check if the request method is GET and product ID is provided
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['product_id'])) {
        
        // Retrieve product ID from GET data
        $productId = $_GET['product_id'];
        
        // Prepare SQL statement to delete product from the product table
        $sql = "DELETE FROM product WHERE product_id = ?";
        
        // Prepare and bind parameters to the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Product removed successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Function to edit a product
function editProduct() {
    global $conn;
    
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Retrieve updated product details from POST data
        $productId = $_POST['product_id'];
        $productName = $_POST['product_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        
        // Validate input data (you can add more validation checks)
        if (empty($productId) || empty($productName) || empty($description) || empty($price) || empty($category_id)) {
            echo "Please fill all fields.";
            return;
        }

        // Prepare SQL statement to update product in the product table
        $sql = "UPDATE product SET product_name = ?, description = ?, price = ?, category_id = ? WHERE product_id = ?";
        
        // Prepare and bind parameters to the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiii", $productName, $description, $price, $category_id, $productId);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Product updated successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Function to view user reviews
function viewReviews() {
    global $conn;
    
    // Fetch and display user reviews from the database
    $sql = "SELECT * FROM reviews";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Review ID: " . $row["review_id"]. " - User ID: " . $row["user_id"]. " - Review: " . $row["comments"]. "<br>";
        }
    } else {
        echo "No reviews found.";
    }
}

// Function to view user details
function viewUserDetails() {
    global $conn;
    
    // Fetch and display user details from the database
    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "User ID: " . $row["user_id"]. " - Username: " . $row["Username"]. " - Email: " . $row["Email"]. " - Full Name: " . $row["First_Name"] . " " . $row["Last_Name"] . "<br>";
        }
    } else {
        echo "No users found.";
    }
}

// Function to view order status
function viewOrderStatus() {
    global $conn;
    
    // Fetch and display order status from the database
    $sql = "SELECT * FROM order_statuses";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Order ID: " . $row["order_id"]. " - Status: " . $row["status_type"]. "<br>";
        }
    } else {
        echo "No orders found.";
    }
}

// Function to update order status
function updateOrderStatus() {
    global $conn;
    
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Retrieve order ID and new status from POST data
        $orderId = $_POST['order_id'];
        $newStatus = $_POST['new_status'];
        
        // Validate input data (you can add more validation checks)
        if (empty($orderId) || empty($newStatus)) {
            echo "Please fill all fields.";
            return;
        }

        // Prepare SQL statement to update order status in the orders table
        $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
        
        // Prepare and bind parameters to the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newStatus, $orderId);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Order status updated successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Main logic to handle admin actions
if(isset($_GET['action'])) {
    $action = $_GET['action'];
    switch($action) {
        case 'add_product':
            addProduct();
            break;
        case 'remove_product':
            removeProduct();
            break;
        case 'edit_product':
            editProduct();
            break;
        case 'view_reviews':
            viewReviews();
            break;
        case 'view_user_details':
            viewUserDetails();
            break;
        case 'view_order_status':
            viewOrderStatus();
            break;
        case 'update_order_status':
            updateOrderStatus();
            break;
        default:
            echo "Invalid action";
            break;
    }
}

// Close the database connection
$conn->close();

?>
