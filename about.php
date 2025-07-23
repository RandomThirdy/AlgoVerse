<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/logo.png" type="image/png" />

    <!-- fontawesome for icons -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>AlgoVerse: TEAM-BA</title>
</head>

<body>
    <section class="sub-header">
        <!-- Navigation Bar -->
        <nav>
            <a href="index.php"> <img src="images/logo.png" alt="Logo" style="width: 50px; height: 50px; vertical-align: middle; margin-right: 8px;">
                AlgoVerse
            </a>
            <div class="nav-links" id="navLinks">
                <i class="fas fa-window-close" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="docs.php">Resources</a></li>
                    <li><a href="Simulator/index.php">Simulator</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
            </div>
                <i class="fas fa-bars" onclick="showMenu()"></i>
        </nav>
        <h1>Meet the Minds Behind the CPU Scheduling Simulator</h1>  
    </section>

     <!-- About us Section -->
    <div class="container_1">
        <div class="header_1">
            <h1>TEAM-BA</h1>
        </div>

        <div class="sub_container" data-aos="zoom-in-up">

            <!-- 1st Team Member -->
            <div class="teams">
                <img src="about_img/atip.jpg" alt="">
                <div class="name">Christian Atip</div> <br>
                <div class="about">Papasok ng kulang ang tulog, uuwi ng kompleto.</div> <br>
            </div>

            <!-- 2nd Team Member -->
            <div class="teams">
                <img src="about_img/ced.jpg" alt="">
                <div class="name">Paul Cedric Cruto</div> <br>
                <div class="about">Palaging tandaan malian mo ng isa para hindi halata.</div> <br>
            </div>

            <!-- 3rd Team Member -->
            <div class="teams">
                <img src="about_img/toto.jpg" alt="">
                <div class="name">Angelito Decatoria III</div> <br>
                <div class="about">Kung hindi mo alam ang isasagot sa test paper, ilagay mo 'babae' total sila naman ang laging tama.</div> <br>
            </div>
        </div>

        <div class="sub_container" data-aos="zoom-in-up">

            <!-- 4st Team Member -->
            <div class="teams">
                <img src="about_img/el-ano-na.jpg" alt="">
                <div class="name">Jhon Lorence Hilario</div> <br>
                <div class="about">Walang malabong mata sa taong nais kumopya.</div> <br>
            </div>

            <!-- 5nd Team Member -->
            <div class="teams">
                <img src="about_img/gav.jpg" alt="">
                <div class="name">Gavriell Pangan</div> <br>
                <div class="about">Kung kaya ng iba, edi ipagawa mo sa kanila.</div> <br>
            </div>

            <!-- 6rd Team Member -->
            <div class="teams">
                <img src="about_img/gian.jpg" alt="">
                <div class="name">Franklin Gian Sarmiento</div> <br>
                <div class="about">Madali lang maging matalino, di ko lang alam kung paano.</div> <br>
            </div>
        </div>

        <!-- 7th Team Member -->
        <div class="sub_container" data-aos="zoom-in-up">
            <div class="teams">
                <img src="about_img/yuri.jpg" alt="" class="about-img">
                <div class="name">Brainier Andrew Manalo</div> <br>
                <div class="about">Failure is the key to success, kaya lagi akong bagsak.</div> <br>
            </div>

        </div>
    </div>


    <!-- Footer Section  -->
    <section class="footer">
        <p>Made With <i class="far fa-heart"></i> by TEAM-BA</p>
        <p>
            <i class="fa fa-copyright"></i> copyright 2025 || All rights reserved
        </p>
    </section>

    <!-- JavaScript -->
    <script>
        var navLinks = document.getElementById("navLinks");
        function showMenu() {
            navLinks.style.right = "0";
        }

        function hideMenu() {
            navLinks.style.right = "-200px";
        }
    </script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 200, 
            duration: 600
        });
    </script>
    
</body>

</html>