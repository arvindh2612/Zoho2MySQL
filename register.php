<?php 
$conn = new mysqli("localhost", "root", "", "company_db"); 
if ($conn->connect_error) die("Connection failed");  

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $name = trim($_POST["name"]); 
    $email = trim($_POST["email"]); 
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); 

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)"); 
    if ($stmt) { 
        $stmt->bind_param("sss", $name, $email, $password); 
        if ($stmt->execute()) { 
            header("Location: login.php"); 
            exit; 
        } else { 
            $error = "Email already exists!"; 
        } 
    } 
} 
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
     background: linear-gradient(135deg, #c2e9fb, #a1c4fd);

      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    .register-card {
      background: #ffffff;
      color: #333;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .register-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .form-control:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
      transition: all 0.3s ease-in-out;
    }

    .btn-primary {
      background-color: #3b82f6;
      border: none;
    }

    .btn-primary:hover {
      background-color: #2563eb;
      transition: background-color 0.3s ease;
    }

    .alert {
      animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-10px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>

  <div class="col-md-6 col-lg-4 register-card">
    <h4 class="text-center mb-4 text-primary">Create Your Account</h4>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post" autocomplete="off">
      <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="Full Name" required>
      </div>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button class="btn btn-primary w-100" type="submit">Register</button>
    </form>
    <div class="mt-3 text-center text-muted">
      Already registered? <a href="login.php" class="text-decoration-none text-primary">Login here</a>
    </div>
  </div>

</body>
</html>
