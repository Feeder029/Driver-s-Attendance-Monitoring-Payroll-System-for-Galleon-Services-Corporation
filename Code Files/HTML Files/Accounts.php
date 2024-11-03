<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS Files/Accounts.css">
    <title>ACCOUNTS</title>
</head>
<body>
    <div class="navbar">
        <nav>
            
            <h3>ACCOUNTS LIST</h3>

            <div class="navbar-input">
                <div class="category-btn">
                    <div class="btn-option">
                        <input class="input" type="radio" name="btn" value="btn-all" checked="">
                        <div class="btn">
                            <span class="span">ALL</span>
                        </div>
                    </div>
                    <div class="btn-option">
                        <input class="input" type="radio" name="btn" value="btn-active">
                        <div class="btn">
                            <span class="span">ACTIVE</span>
                        </div>  </div>
                    <div class="btn-option">
                        <input class="input" type="radio" name="btn" value="btn-pending">
                        <div class="btn">
                            <span class="span">&nbsp;PENDING&nbsp;</span>
                        </div>  
                    </div>
                </div>

                <div class="search-bar">
                    <i class='bx bx-search'></i>
                    <input type="search" name="search" id="search" placeholder="Search" > 
                    
                    <div class="dropdown-category">
                        <div class="selected" data-default="All" data-one="Active" data-two="Pending">
                          <svg height="1em" viewBox="0 0 512 512" class="arrow">
                            <path
                              d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"
                            ></path>
                          </svg>
                        </div>
                        <div class="options">
                            <div title="dd-all">
                                <input id="dd-all" name="option" type="radio" checked="" />
                                <label class="option" for="dd-all" data-txt="All"></label>
                            </div>
                            <div title="dd-active">
                                <input id="dd-active" name="option" type="radio" />
                                <label class="option" for="dd-active" data-txt="Active"></label>
                            </div>
                            <div title="dd-pending">
                                <input id="dd-pending" name="option" type="radio" />
                                <label class="option" for="dd-pending" data-txt="Pending"></label>
                            </div>
                        </div>
                </div>

            </div>     
        </nav>
    </div>

                
    <div class="table-container">
        <table class="table-accounts">
            <tr>
                <td>
                    <div class="td-content">
                        <div class="td-left">
                            <i class='bx bx-user-circle' ></i>
                            <div class="td-name">
                                <h3 id="username">USERNAME</h3>
                                <h5 id="fullname">FULLNAME</h5>
                                <h5 id="position-name">(<span id="position">Position</span>&nbsp;:&nbsp;<span id="type">Type</span>)</h5>
                            </div>
                        </div>
                        <div class="td-right">
                            <h3 id="date">Created on <span id="date-created">MM DD YYYY</span></h3>
                            <div class="td-btn">
                                <button id="accept-btn" >ACCEPT</button>
                                <button id="decline-btn">DECLINE</button>
                                <button id="view-btn">VIEW MORE</button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>asdasdasdasdasdasd</td>
            </tr>
           
        </table>
    </div>
</body>
</html>


<?php

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayrolltest";
    $conn = "";

    $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);

    if ($conn) {
        
    } else {
        die("Connection failed: " . mysqli_connect_error());
    }
?>