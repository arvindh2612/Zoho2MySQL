<?php
// dashboard.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Dashboard</title>
<style>
  /* Reset and base */
  * {
    box-sizing: border-box;
  }
  body, html {
    margin: 0; padding: 0; height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f7fa;
    color: #333;
  }

  /* Layout */
  .container {
    display: flex;
    height: 100vh;
  }

  /* Sidebar */
  .sidebar {
    width: 220px;
    background: #222d42;
    color: #fff;
    display: flex;
    flex-direction: column;
  }
  .sidebar h2 {
    margin: 20px;
    font-weight: 700;
    font-size: 1.5rem;
    letter-spacing: 1px;
    border-bottom: 1px solid #394a70;
    padding-bottom: 15px;
  }
  .nav-links {
    flex-grow: 1;
  }
  .nav-links a {
    display: block;
    padding: 15px 20px;
    color: #aab8d3;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.3s, color 0.3s;
  }
  .nav-links a:hover,
  .nav-links a.active {
    background: #3b4a77;
    color: #fff;
  }

  /* Main content */
  .main-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  /* Header */
  header {
    background: #fff;
    padding: 15px 30px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    font-size: 1.6rem;
    font-weight: 700;
    color: #222d42;
  }

  /* Dashboard grid */
  .dashboard {
    flex-grow: 1;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    padding: 40px 50px;
    background: #f9fbfd;
  }

  /* Box styles */
  .box {
    background: white;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 140px;
    font-size: 1.5rem;
    font-weight: 700;
    color: #222d42;
    cursor: pointer;
    position: relative;
    text-align: center;
    text-decoration: none;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease, color 0.3s ease;
  }
  .box:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    background: linear-gradient(135deg, #4a90e2 0%, #357ABD 100%);
    color: white;
  }
  .box::after {
    content: "";
    position: absolute;
    bottom: 12px;
    left: 50%;
    width: 60px;
    height: 4px;
    background: #357ABD;
    border-radius: 3px;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  .box:hover::after {
    opacity: 1;
  }

  /* Responsive */
  @media (max-width: 600px) {
    .sidebar {
      width: 60px;
    }
    .sidebar h2 {
      display: none;
    }
    .nav-links a {
      padding: 15px 10px;
      font-size: 0;
      position: relative;
    }
    .nav-links a::before {
      content: attr(data-label);
      position: absolute;
      left: 70px;
      top: 50%;
      transform: translateY(-50%);
      color: white;
      font-weight: 600;
      font-size: 1rem;
      white-space: nowrap;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.2s ease;
    }
    .nav-links a:hover::before {
      opacity: 1;
    }
  }
</style>
</head>
<body>

<div class="container">
  <nav class="sidebar">
    <h2>Admin</h2>
    <div class="nav-links">
      <a href="import_csv.php" class="active" data-label="Company">Company</a>
      <a href="proposal.php" data-label="Proposal">Proposal</a>
      <a href="prior_policies.php" data-label="Prior Policies">Prior Policies</a>
      <a href="cover_details.php" data-label="Cover Details">Cover Details</a>
    </div>
  </nav>

  <div class="main-content">
    <header>Dashboard</header>
    <header><center><H1>Welcome, Admin</H1></center></header>
    <div class="dashboard">
      <a href="import_csv.php" class="box">Company</a>
      <a href="proposal.php" class="box">Proposal</a>
      <a href="prior_policies.php" class="box">Prior Policies</a>
      <a href="cover_details.php" class="box">Cover Details</a>
    </div>
    
  </div>
</div>

</body>
</html>
