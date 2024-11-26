<!DOCTYPE html>
<html lang="en">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS Files/Accounts.css?v=1.5">
    <script src="../JS Files/Accounts.js"></script>
    <title>ACCOUNTS</title>
    <style>
        body{
            overflow: hidden; /* Disable scrolling on both */
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

 
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
                        <div class="selected" data-default="All" data-one="Admin" data-two="Driver">
                          <svg height="1em" viewBox="0 0 512 512" class="arrow">
                            <path
                              d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"
                            ></path>
                          </svg>
                        </div>
                        <div class="options">
    <div title="dd-all">
        <input id="dd-all" name="option" type="radio" value="all" checked />
        <label class="option" for="dd-all" data-txt="All"></label>
    </div>
    <div title="dd-admin">
        <input id="dd-admin" name="option" type="radio" value="admin" />
        <label class="option" for="dd-admin" data-txt="Admin"></label>
    </div>
    <div title="dd-driver">
        <input id="dd-driver" name="option" type="radio" value="driver" />
        <label class="option" for="dd-driver" data-txt="Driver"></label>
    </div>
</div>

                </div>

            </div>     
        </nav>
    </div>
 
    <div class="table-container" id="searchresult">
        <?php
        require "GetAccount.php";
        START($conn);
        ?>
    </div>

    <script src="../JS Files/AccountSearch.js?v=1.1"></script>
</body>
</html>


