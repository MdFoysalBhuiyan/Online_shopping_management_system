<?php
session_start();
if(isset($_SESSION['user_id']))
    {
        if($_SESSION['user_role'] == "admin")
            {
                
            }
        else
            {
                echo "GO to home page";   
            }
    }
else
    {
        header("Location: /index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <div class="shell">
        <header class="topbar">
            <div class="brand">
                <button class="brand-mark" id="brandMark" title="Admin menu" aria-label="Admin menu">A</button>
                <span class="brand-name">Admin Panel</span>
            </div>
            <div class="manager-pill">
                <span class="dot"></span> ADMIN
            </div>
        </header>
        <div class="layout">
            <nav class="sidebar" id="sidebar">
                <button class="nav-item active" data-page="Dashboard">
                    <span class="bullet"></span>Dashboard
                </button>
                <button class="nav-item" data-page="Users">
                    <span class="bullet"></span>Users
                </button>
                <button class="nav-item" data-page="Analytics">
                    <span class="bullet"></span>Analytics
                </button>
                <button class="nav-item" onclick="window.location.href='logout.php'">
                <span class="bullet"></span>Log out
                </button>
            </nav>
            <main class="content">
                <div class="content-header">
                    <div>
                        <h1>Dashboard</h1>
                    </div>
                    <button class="add-btn" id="createUserBtn">
                        + Create User
                    </button>
                </div>
                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-label">Total Users</div>
                        <div class="stat-value" id="statUsers">1,412</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Active Now</div>
                        <div class="stat-value" id="statActive">89</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Monthly Revenue</div>
                        <div class="stat-value" id="statRevenue">$12,450</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Pending Tickets</div>
                        <div class="stat-value" id="statTickets">4</div>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Role</th>
                            <th>Joined Date</th>
                            <th>Last Active</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr>
                            <td><strong>Anik Rahman</strong><br><small>anik@example.com</small></td>
                            <td>Editor</td>
                            <td>Aug 15, 2026</td>
                            <td>2 mins ago</td>
                            <td><span class="badge active-badge">Active</span></td>
                            <td><button class="action-link">Edit</button></td>
                        </tr>
                        <tr>
                            <td><strong>Sadia Islam</strong><br><small>sadia@example.com</small></td>
                            <td>Moderator</td>
                            <td>Jul 22, 2026</td>
                            <td>1 hour ago</td>
                            <td><span class="badge active-badge">Active</span></td>
                            <td><button class="action-link">Edit</button></td>
                        </tr>
                        <tr>
                            <td><strong>Rakib Hasan</strong><br><small>rakib@example.com</small></td>
                            <td>User</td>
                            <td>Jan 10, 2026</td>
                            <td>3 weeks ago</td>
                            <td><span class="badge inactive-badge">Suspended</span></td>
                            <td><button class="action-link">Edit</button></td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <div class="overlay" id="overlay">
        <div class="modal">
            <h2 id="modalTitle">Create New User</h2>
        </div>
    </div>
    <div class="toast" id="toast"></div>
</body>
</html>
