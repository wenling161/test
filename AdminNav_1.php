<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html lang="en" dir="" ltr>

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Css/admin.css" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <i class='bx bx-run'></i>
                <div class="logo_name">Dashboard</div>
            </div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav_list">
            <li>
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Search...">
                <span class="tooltip">Search</span>
            </li>
            <li>
                <a href="event-admin.php">
                    <i class='bx bxs-hot'></i>
                    <span class="links_name">Event</span>
                </a>
                <span class="tooltip">Event</span>
            </li>
            <li>
                <a href="MemberList.php">
                    <i class='bx bxs-user-account'></i>
                    <span class="links_name">Member</span>
                </a>
                <span class="tooltip">Member</span>
            </li>
            <li>
                <a href="AdminList.php">
                    <i class='bx bx-face'></i>
                    <span class="links_name">Staff</span>
                </a>
                <span class="tooltip">Staff</span>
            </li>
           
            <li>
                <a href="admin-volunteer.php">
                    <i class='bx bx-donate-heart'></i>
                    <span class="links_name">Volunteer</span>
                </a>
                <span class="tooltip">Volunteer</span>
            </li>
            <li>
                <a href="Paymentlist.php">
                    <i class='bx bxs-wallet'></i>
                    <span class="links_name">Order</span>
                </a>
                <span class="tooltip">Order</span>
            </li>
            <li>
                <a href="logout-2.php?role=staff">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>
        </ul>

    </div>
    <script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");
        let searchBtn = document.querySelector(".bx-search");

        btn.onclick = function () {
            sidebar.classList.toggle("active");
        }
        searchBtn.onclick = function () {
            sidebar.classList.toggle("active");
        }

    </script>
</body>

</html>