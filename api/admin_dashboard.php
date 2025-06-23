<?php
session_start();

// You can add authentication here if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      height: 100vh;
      overflow: hidden;
    }
    #sidebar {
      height: 100vh;
      background-color: #343a40;
      color: white;
      padding-top: 1rem;
    }
    #sidebar .nav-link {
      color: white;
      font-weight: 500;
    }
    #sidebar .nav-link.active {
      background-color: #495057;
      font-weight: 700;
    }
    #main-content {
      padding: 2rem;
      overflow-y: auto;
      height: 100vh;
    }
  </style>
</head>
<body>
<div class="d-flex">
  <nav id="sidebar" class="d-flex flex-column flex-shrink-0 p-3" style="width: 220px;">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none fs-4">
      <strong>Admin Panel</strong>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto" id="menu">
      <li class="nav-item">
        <a href="#" class="nav-link active" data-section="company">Company</a>
      </li>
      <li>
        <a href="#" class="nav-link" data-section="proposal">Proposal</a>
      </li>
      <li>
        <a href="#" class="nav-link" data-section="prior_policies">Prior Policies</a>
      </li>
      <li>
        <a href="#" class="nav-link" data-section="cover_details">Cover Details</a>
      </li>
    </ul>
  </nav>

  <main id="main-content" class="flex-grow-1">
    <div id="content-company" class="content-section">
      <h2>Company</h2>
      <p>Manage company details here...</p>
    </div>
    <div id="content-proposal" class="content-section d-none">
      <h2>Proposal</h2>
      <p>Manage proposals here...</p>
    </div>
    <div id="content-prior_policies" class="content-section d-none">
      <h2>Prior Policies</h2>
      <p>View and edit prior policies here...</p>
    </div>
    <div id="content-cover_details" class="content-section d-none">
      <h2>Cover Details</h2>
      <p>Manage cover details here...</p>
    </div>
  </main>
</div>

<script>
  const menuLinks = document.querySelectorAll('#menu .nav-link');
  const sections = document.querySelectorAll('.content-section');

  menuLinks.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();

      // Remove active class from all links
      menuLinks.forEach(l => l.classList.remove('active'));
      // Hide all content sections
      sections.forEach(s => s.classList.add('d-none'));

      // Add active class to clicked link
      link.classList.add('active');

      // Show corresponding section
      const sectionId = 'content-' + link.dataset.section;
      document.getElementById(sectionId).classList.remove('d-none');
    });
  });
</script>

</body>
</html>
