<?php
session_start();

$userId = $_SESSION['user_id'] ?? 1;

$name = $_SESSION['name'] ?? 'User Name';
$email = $_SESSION['email'] ?? 'user@example.com';
$phone = $_SESSION['phone'] ?? '+880 1XXXXXXXXX';
$role = $_SESSION['role'] ?? 'User';
$status = $_SESSION['status'] ?? 'Active';
$createdAt = $_SESSION['created_at'] ?? '2026';

$totalSessions = $_SESSION['total_sessions'] ?? 28;
$lastLogin = $_SESSION['last_login'] ?? 'Today';
$profileUpdated = $_SESSION['profile_updated'] ?? 'Yesterday';




function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}



$profileMessage = "";
$profileMessageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_profile"])) {

    $newName = trim($_POST["name"] ?? "");
    $newEmail = trim($_POST["email"] ?? "");
    $newPhone = trim($_POST["phone"] ?? "");

   
    if ($newName === "" || strlen($newName) < 3) {

        $profileMessage = "Name must contain at least 3 characters.";
        $profileMessageType = "error";

    }

    elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {

        $profileMessage = "Please enter a valid email address.";
        $profileMessageType = "error";

    }

    else {

 

        $_SESSION["name"] = $newName;
        $_SESSION["email"] = $newEmail;
        $_SESSION["phone"] = $newPhone;
        $_SESSION["profile_updated"] = "Just now";

        $name = $newName;
        $email = $newEmail;
        $phone = $newPhone;

        $profileUpdated = "Just now";

        $profileMessage = "Profile updated successfully.";
        $profileMessageType = "success";
    }
}



$settingsMessage = "";
$settingsMessageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["save_settings"])) {

    $_SESSION["email_notifications"] =
        isset($_POST["email_notifications"]);

    $_SESSION["login_notifications"] =
        isset($_POST["login_notifications"]);

    $_SESSION["two_factor"] =
        isset($_POST["two_factor"]);

    $settingsMessage = "Settings saved successfully.";
    $settingsMessageType = "success";
}




$emailNotifications =
    $_SESSION["email_notifications"] ?? true;

$loginNotifications =
    $_SESSION["login_notifications"] ?? true;

$twoFactor =
    $_SESSION["two_factor"] ?? false;




$avatar = strtoupper(substr(trim($name), 0, 1));

if ($avatar === "") {
    $avatar = "U";
}

$isActive = strtolower($status) === "active";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>User Panel</title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }


        body {
            background-color: #f8fafc;
            color: #1e293b;
        }



        .topbar {
            background-color: #ffffff;

            height: 65px;

            padding: 0 24px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            border-bottom: 1px solid #e2e8f0;
        }


        .brand {
            display: flex;

            align-items: center;

            gap: 12px;
        }


        .brand-mark {
            background-color: #0f172a;

            color: white;

            border: none;

            width: 38px;

            height: 38px;

            border-radius: 8px;

            font-weight: bold;

            font-size: 20px;

            cursor: pointer;
        }


        .brand-name {
            font-weight: 700;

            font-size: 19px;

            letter-spacing: -0.5px;
        }


        .manager-pill {
            background-color: #f1f5f9;

            padding: 6px 14px;

            border-radius: 9999px;

            font-size: 11px;

            font-weight: 700;

            display: flex;

            align-items: center;

            gap: 8px;

            border: 1px solid #e2e8f0;
        }


        .dot {
            width: 8px;

            height: 8px;

            background-color: #10b981;

            border-radius: 50%;
        }



        .layout {
            display: flex;

            min-height: calc(100vh - 65px);
        }


        .sidebar {
            width: 250px;

            background-color: #ffffff;

            padding: 24px 12px;

            border-right: 1px solid #e2e8f0;
        }


        .nav-item {
            display: flex;

            align-items: center;

            width: 100%;

            padding: 12px 16px;

            background: none;

            border: none;

            border-radius: 8px;

            text-align: left;

            font-size: 14px;

            font-weight: 500;

            color: #64748b;

            cursor: pointer;

            margin-bottom: 6px;

            transition: all 0.2s ease;
        }


        .nav-item:hover {
            background-color: #f1f5f9;

            color: #1e293b;
        }


        .nav-item.active {
            background-color: #0f172a;

            color: white;
        }


        .bullet {
            width: 6px;

            height: 6px;

            background-color: currentColor;

            border-radius: 50%;

            margin-right: 12px;
        }


  

        .content {
            flex: 1;

            padding: 32px;
        }


        .content-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 32px;
        }


        .content-header h1 {
            font-size: 26px;

            font-weight: 700;

            color: #0f172a;
        }


        .sub {
            font-size: 14px;

            color: #64748b;

            margin-top: 4px;
        }


        .add-btn {
            background-color: #0f172a;

            color: white;

            border: none;

            padding: 11px 20px;

            border-radius: 8px;

            font-weight: 600;

            font-size: 14px;

            cursor: pointer;

            transition: background 0.2s;
        }


        .add-btn:hover {
            background-color: #1e293b;
        }


  

        .stats {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 24px;

            margin-bottom: 32px;
        }


        .stat-card {
            background-color: white;

            padding: 24px;

            border-radius: 12px;

            border: 1px solid #e2e8f0;
        }


        .stat-label {
            font-size: 13px;

            font-weight: 600;

            color: #64748b;

            text-transform: uppercase;

            letter-spacing: 0.5px;

            margin-bottom: 8px;
        }


        .stat-value {
            font-size: 30px;

            font-weight: 700;

            color: #0f172a;
        }




        table {
            width: 100%;

            border-collapse: collapse;

            background-color: white;

            border-radius: 12px;

            overflow: hidden;

            border: 1px solid #e2e8f0;
        }


        th,
        td {
            padding: 16px 24px;

            text-align: left;
        }


        th {
            background-color: #f8fafc;

            color: #64748b;

            font-size: 12px;

            text-transform: uppercase;

            font-weight: 600;

            letter-spacing: 0.5px;

            border-bottom: 1px solid #e2e8f0;
        }


        td {
            border-bottom: 1px solid #f1f5f9;

            font-size: 14px;
        }


        td small {
            color: #64748b;
        }


        tr:last-child td {
            border-bottom: none;
        }


        tr:hover td {
            background-color: #f8fafc;
        }



        .badge {
            padding: 4px 8px;

            border-radius: 6px;

            font-size: 12px;

            font-weight: 600;

            display: inline-block;
        }


        .active-badge {
            background-color: #d1fae5;

            color: #065f46;
        }


        .inactive-badge {
            background-color: #fee2e2;

            color: #991b1b;
        }



        .profile-card {
            background-color: white;

            border: 1px solid #e2e8f0;

            border-radius: 12px;

            padding: 24px;

            margin-bottom: 32px;

            display: flex;

            align-items: center;

            gap: 20px;
        }


        .profile-avatar {
            width: 70px;

            height: 70px;

            border-radius: 50%;

            background-color: #0f172a;

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 25px;

            font-weight: 700;
        }


        .profile-info h2 {
            color: #0f172a;

            font-size: 20px;

            margin-bottom: 6px;
        }


        .profile-info p {
            color: #64748b;

            font-size: 14px;

            margin-bottom: 8px;
        }




        .info-grid {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 24px;

            margin-bottom: 32px;
        }


        .info-card {
            background-color: white;

            padding: 24px;

            border-radius: 12px;

            border: 1px solid #e2e8f0;
        }


        .info-card h2 {
            font-size: 18px;

            color: #0f172a;

            margin-bottom: 20px;
        }


        .info-row {
            display: flex;

            justify-content: space-between;

            padding: 12px 0;

            border-bottom: 1px solid #f1f5f9;

            font-size: 14px;

            gap: 20px;
        }


        .info-row:last-child {
            border-bottom: none;
        }


        .info-row span {
            color: #64748b;
        }


        .info-row strong {
            color: #1e293b;

            text-align: right;
        }




        .settings-card {
            background-color: white;

            border: 1px solid #e2e8f0;

            border-radius: 12px;

            padding: 24px;
        }


        .settings-card h2 {
            font-size: 18px;

            margin-bottom: 20px;

            color: #0f172a;
        }


        .setting-row {
            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 18px 0;

            border-bottom: 1px solid #f1f5f9;
        }


        .setting-row:last-child {
            border-bottom: none;
        }


        .setting-row h3 {
            font-size: 14px;

            margin-bottom: 5px;
        }


        .setting-row p {
            font-size: 13px;

            color: #64748b;
        }




        .switch {
            position: relative;

            width: 45px;

            height: 24px;
        }


        .switch input {
            opacity: 0;

            width: 0;

            height: 0;
        }


        .slider {
            position: absolute;

            cursor: pointer;

            inset: 0;

            background-color: #cbd5e1;

            border-radius: 20px;

            transition: 0.3s;
        }


        .slider:before {
            content: "";

            position: absolute;

            height: 18px;

            width: 18px;

            left: 3px;

            bottom: 3px;

            background-color: white;

            border-radius: 50%;

            transition: 0.3s;
        }


        .switch input:checked + .slider {
            background-color: #0f172a;
        }


        .switch input:checked + .slider:before {
            transform: translateX(21px);
        }




        .edit-form {
            display: none;

            margin-top: 24px;

            padding-top: 24px;

            border-top: 1px solid #e2e8f0;
        }


        .form-group {
            margin-bottom: 16px;
        }


        .form-group label {
            display: block;

            font-size: 13px;

            font-weight: 600;

            color: #475569;

            margin-bottom: 7px;
        }


        .form-group input {
            width: 100%;

            padding: 11px 13px;

            border: 1px solid #cbd5e1;

            border-radius: 8px;

            font-size: 14px;

            outline: none;
        }


        .form-group input:focus {
            border-color: #0f172a;
        }


        .form-actions {
            display: flex;

            gap: 10px;

            margin-top: 18px;
        }


        .cancel-btn {
            background: #e2e8f0;

            color: #1e293b;

            border: none;

            padding: 11px 20px;

            border-radius: 8px;

            font-weight: 600;

            cursor: pointer;
        }




        .message {
            padding: 12px 15px;

            border-radius: 8px;

            margin-bottom: 20px;

            font-size: 14px;
        }


        .message.success {
            background-color: #d1fae5;

            color: #065f46;
        }


        .message.error {
            background-color: #fee2e2;

            color: #991b1b;
        }




        .toast {
            position: fixed;

            bottom: 24px;

            right: 24px;

            background-color: #0f172a;

            color: white;

            padding: 14px 24px;

            border-radius: 8px;

            font-size: 14px;

            display: none;

            z-index: 100;
        }




        @media (max-width: 900px) {

            .sidebar {
                width: 210px;
            }


            .stats {
                grid-template-columns: repeat(2, 1fr);
            }


            .info-grid {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 650px) {

            .layout {
                flex-direction: column;
            }


            .sidebar {
                width: 100%;

                display: flex;

                overflow-x: auto;

                padding: 12px;
            }


            .nav-item {
                min-width: 130px;

                margin-right: 5px;

                margin-bottom: 0;
            }


            .content {
                padding: 20px;
            }


            .stats {
                grid-template-columns: 1fr;
            }


            .content-header {
                flex-direction: column;

                align-items: flex-start;

                gap: 15px;
            }


            .profile-card {
                flex-direction: column;

                align-items: flex-start;
            }


            table {
                display: block;

                overflow-x: auto;

                white-space: nowrap;
            }

        }

    </style>

</head>


<body>


<div class="shell">



    <header class="topbar">

        <div class="brand">

            <button
                class="brand-mark"
                id="brandMark">

                <?php echo e($avatar); ?>

            </button>

            <span class="brand-name">
                User Panel
            </span>

        </div>


        <div class="manager-pill">

            <span class="dot"></span>

            USER

        </div>

    </header>




    <div class="layout">



        <nav class="sidebar"
             id="sidebar">


            <button
                class="nav-item active"
                data-page="dashboard">

                <span class="bullet"></span>

                Dashboard

            </button>


            <button
                class="nav-item"
                data-page="profile">

                <span class="bullet"></span>

                Profile

            </button>


            <button
                class="nav-item"
                data-page="activity">

                <span class="bullet"></span>

                Activity

            </button>


            <button
                class="nav-item"
                data-page="settings">

                <span class="bullet"></span>

                Settings

            </button>


            <button
                class="nav-item"
                onclick="window.location.href='logout.php'">

                <span class="bullet"></span>

                Log out

            </button>


        </nav>




        <main class="content">



            <section
                id="dashboard"
                class="page">


                <div class="content-header">

                    <div>

                        <h1>
                            Dashboard
                        </h1>

                        <p class="sub">
                            Welcome back to your account.
                        </p>

                    </div>

                </div>



                <div class="profile-card">

                    <div class="profile-avatar">

                        <?php echo e($avatar); ?>

                    </div>


                    <div class="profile-info">

                        <h2>
                            <?php echo e($name); ?>
                        </h2>

                        <p>
                            <?php echo e($email); ?>
                        </p>

                        <?php if ($isActive): ?>

                            <span class="badge active-badge">
                                Active
                            </span>

                        <?php else: ?>

                            <span class="badge inactive-badge">
                                <?php echo e($status); ?>
                            </span>

                        <?php endif; ?>

                    </div>

                </div>


                <div class="stats">


                    <div class="stat-card">

                        <div class="stat-label">
                            Account Status
                        </div>

                        <div class="stat-value">
                            <?php echo e($status); ?>
                        </div>

                    </div>


                    <div class="stat-card">

                        <div class="stat-label">
                            Total Sessions
                        </div>

                        <div class="stat-value">
                            <?php echo e($totalSessions); ?>
                        </div>

                    </div>


                    <div class="stat-card">

                        <div class="stat-label">
                            Member Since
                        </div>

                        <div class="stat-value">
                            <?php echo e($createdAt); ?>
                        </div>

                    </div>


                </div>



                <div class="info-grid">


                    <div class="info-card">

                        <h2>
                            Account Information
                        </h2>


                        <div class="info-row">

                            <span>
                                User Name
                            </span>

                            <strong>
                                <?php echo e($name); ?>
                            </strong>

                        </div>


                        <div class="info-row">

                            <span>
                                Email
                            </span>

                            <strong>
                                <?php echo e($email); ?>
                            </strong>

                        </div>


                        <div class="info-row">

                            <span>
                                Role
                            </span>

                            <strong>
                                <?php echo e($role); ?>
                            </strong>

                        </div>


                        <div class="info-row">

                            <span>
                                Status
                            </span>

                            <strong>
                                <?php echo e($status); ?>
                            </strong>

                        </div>


                    </div>


                    <div class="info-card">

                        <h2>
                            Recent Activity
                        </h2>


                        <div class="info-row">

                            <span>
                                Last Login
                            </span>

                            <strong>
                                <?php echo e($lastLogin); ?>
                            </strong>

                        </div>


                        <div class="info-row">

                            <span>
                                Profile Updated
                            </span>

                            <strong>
                                <?php echo e($profileUpdated); ?>
                            </strong>

                        </div>


                        <div class="info-row">

                            <span>
                                Sessions
                            </span>

                            <strong>
                                <?php echo e($totalSessions); ?>
                            </strong>

                        </div>


                        <div class="info-row">

                            <span>
                                Account
                            </span>

                            <strong>
                                Secure
                            </strong>

                        </div>


                    </div>


                </div>


            </section>




            <section
                id="profile"
                class="page"
                style="display:none;">


                <div class="content-header">

                    <div>

                        <h1>
                            My Profile
                        </h1>

                        <p class="sub">
                            View and manage your profile information.
                        </p>

                    </div>

                </div>


                <?php if ($profileMessage !== ""): ?>

                    <div
                        class="message <?php echo e($profileMessageType); ?>">

                        <?php echo e($profileMessage); ?>

                    </div>

                <?php endif; ?>


                <div class="profile-card">


                    <div class="profile-avatar">

                        <?php echo e($avatar); ?>

                    </div>


                    <div class="profile-info">

                        <h2>
                            <?php echo e($name); ?>
                        </h2>

                        <p>
                            <?php echo e($email); ?>
                        </p>


                        <?php if ($isActive): ?>

                            <span class="badge active-badge">
                                Active
                            </span>

                        <?php else: ?>

                            <span class="badge inactive-badge">
                                <?php echo e($status); ?>
                            </span>

                        <?php endif; ?>


                    </div>


                </div>


                <div class="info-card">

                    <h2>
                        Personal Information
                    </h2>


                    <div class="info-row">

                        <span>
                            Full Name
                        </span>

                        <strong>
                            <?php echo e($name); ?>
                        </strong>

                    </div>


                    <div class="info-row">

                        <span>
                            Email Address
                        </span>

                        <strong>
                            <?php echo e($email); ?>
                        </strong>

                    </div>


                    <div class="info-row">

                        <span>
                            Phone Number
                        </span>

                        <strong>
                            <?php echo e($phone); ?>
                        </strong>

                    </div>


                    <div class="info-row">

                        <span>
                            Role
                        </span>

                        <strong>
                            <?php echo e($role); ?>
                        </strong>

                    </div>


                    <br>


                    <button
                        class="add-btn"
                        id="editProfileBtn"
                        type="button">

                        Edit Profile

                    </button>




                    <div
                        class="edit-form"
                        id="editForm">


                        <form
                            method="POST"
                            action="user.php">


                            <div class="form-group">

                                <label>
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="<?php echo e($name); ?>"
                                    minlength="3"
                                    required>

                            </div>


                            <div class="form-group">

                                <label>
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="<?php echo e($email); ?>"
                                    required>

                            </div>


                            <div class="form-group">

                                <label>
                                    Phone Number
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    id="phone"
                                    value="<?php echo e($phone); ?>">

                            </div>


                            <div class="form-actions">

                                <button
                                    type="submit"
                                    name="update_profile"
                                    class="add-btn">

                                    Save Profile

                                </button>


                                <button
                                    type="button"
                                    class="cancel-btn"
                                    id="cancelEditBtn">

                                    Cancel

                                </button>

                            </div>


                        </form>


                    </div>


                </div>


            </section>




            <section
                id="activity"
                class="page"
                style="display:none;">


                <div class="content-header">

                    <div>

                        <h1>
                            Activity
                        </h1>

                        <p class="sub">
                            View your recent account activities.
                        </p>

                    </div>

                </div>


                <table>

                    <thead>

                        <tr>

                            <th>
                                Activity
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <tr>

                            <td>
                                Login
                            </td>

                            <td>
                                Today, 12:30 AM
                            </td>

                            <td>

                                <span class="badge active-badge">
                                    Successful
                                </span>

                            </td>

                        </tr>


                        <tr>

                            <td>
                                Profile Viewed
                            </td>

                            <td>
                                Yesterday, 09:20 PM
                            </td>

                            <td>

                                <span class="badge active-badge">
                                    Completed
                                </span>

                            </td>

                        </tr>


                        <tr>

                            <td>
                                Password Updated
                            </td>

                            <td>
                                3 days ago
                            </td>

                            <td>

                                <span class="badge active-badge">
                                    Completed
                                </span>

                            </td>

                        </tr>


                    </tbody>

                </table>


            </section>



            <section
                id="settings"
                class="page"
                style="display:none;">


                <div class="content-header">

                    <div>

                        <h1>
                            Settings
                        </h1>

                        <p class="sub">
                            Manage your account preferences.
                        </p>

                    </div>

                </div>


                <?php if ($settingsMessage !== ""): ?>

                    <div
                        class="message <?php echo e($settingsMessageType); ?>">

                        <?php echo e($settingsMessage); ?>

                    </div>

                <?php endif; ?>


                <div class="settings-card">


                    <h2>
                        Account Settings
                    </h2>


                    <form
                        method="POST"
                        action="user.php">



                        <div class="setting-row">


                            <div>

                                <h3>
                                    Email Notifications
                                </h3>

                                <p>
                                    Receive important account notifications.
                                </p>

                            </div>


                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="email_notifications"
                                    <?php echo $emailNotifications ? "checked" : ""; ?>>

                                <span class="slider"></span>

                            </label>


                        </div>



                        <div class="setting-row">


                            <div>

                                <h3>
                                    Login Notifications
                                </h3>

                                <p>
                                    Receive notification when your account is accessed.
                                </p>

                            </div>


                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="login_notifications"
                                    <?php echo $loginNotifications ? "checked" : ""; ?>>

                                <span class="slider"></span>

                            </label>


                        </div>



                        <div class="setting-row">


                            <div>

                                <h3>
                                    Two Factor Authentication
                                </h3>

                                <p>
                                    Add extra security to your account.
                                </p>

                            </div>


                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="two_factor"
                                    <?php echo $twoFactor ? "checked" : ""; ?>>

                                <span class="slider"></span>

                            </label>


                        </div>


                        <br>


                        <button
                            type="submit"
                            name="save_settings"
                            class="add-btn"
                            id="saveSettingsBtn">

                            Save Settings

                        </button>


                    </form>


                </div>


            </section>


        </main>


    </div>


</div>


<!-- TOAST -->

<div
    class="toast"
    id="toast">
</div>


<script>



    const navItems =
        document.querySelectorAll(".nav-item");

    const pages =
        document.querySelectorAll(".page");

    const brandMark =
        document.getElementById("brandMark");

    const editProfileBtn =
        document.getElementById("editProfileBtn");

    const cancelEditBtn =
        document.getElementById("cancelEditBtn");

    const editForm =
        document.getElementById("editForm");

    const toast =
        document.getElementById("toast");




    function showPage(pageName) {


        pages.forEach(function(page) {

            page.style.display = "none";

        });



        const selectedPage =
            document.getElementById(pageName);


        if (selectedPage) {

            selectedPage.style.display = "block";

        }


        navItems.forEach(function(item) {

            item.classList.remove("active");

        });



        navItems.forEach(function(item) {

            if (
                item.getAttribute("data-page")
                === pageName
            ) {

                item.classList.add("active");

            }

        });

    }


    navItems.forEach(function(item) {

        item.addEventListener(
            "click",
            function() {

                const pageName =
                    item.getAttribute("data-page");


                if (!pageName) {

                    return;

                }


                showPage(pageName);

            }
        );

    });




    if (brandMark) {

        brandMark.addEventListener(
            "click",
            function() {

                showPage("dashboard");

            }
        );

    }




    if (editProfileBtn) {

        editProfileBtn.addEventListener(
            "click",
            function() {

                editForm.style.display = "block";

                editProfileBtn.style.display = "none";

                showToast("Profile edit option selected.");

            }
        );

    }


    if (cancelEditBtn) {

        cancelEditBtn.addEventListener(
            "click",
            function() {

                editForm.style.display = "none";

                editProfileBtn.style.display = "inline-block";

            }
        );

    }




    const profileForm =
        document.querySelector("#editForm form");


    if (profileForm) {

        profileForm.addEventListener(
            "submit",
            function(event) {

                const name =
                    document.getElementById("name").value.trim();

                const email =
                    document.getElementById("email").value.trim();


                if (name.length < 3) {

                    event.preventDefault();

                    showToast(
                        "Name must contain at least 3 characters."
                    );

                    return;

                }


                const emailPattern =
                    /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


                if (!emailPattern.test(email)) {

                    event.preventDefault();

                    showToast(
                        "Please enter a valid email address."
                    );

                    return;

                }

            }
        );

    }




    function showToast(message) {

        toast.textContent = message;

        toast.style.display = "block";


        setTimeout(
            function() {

                toast.style.display = "none";

            },
            2500
        );

    }



    showPage("dashboard");


    <?php if ($profileMessage !== ""): ?>

        showPage("profile");

        showToast(
            <?php echo json_encode($profileMessage); ?>
        );

    <?php endif; ?>


    <?php if ($settingsMessage !== ""): ?>

        showPage("settings");

        showToast(
            <?php echo json_encode($settingsMessage); ?>
        );

    <?php endif; ?>

</script>


</body>

</html>