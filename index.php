<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="images/logo.png" type="image/png" />
    <!-- fontawesome for icons -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
        <title> AlgoVerse </title>
</head>

<body>
    <section class="header">
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

        <div class="text-box">
            <h1>CPU Scheduling Algorithm Simulator</h1>
            <p>
                Discover the core principles of CPU scheduling through our interactive simulator. 
                <br>This platform provides an immersive experience to explore, analyze, and visualize a range of scheduling algorithms in action. 
                <br>Begin your simulation journey today and deepen your understanding of CPU scheduling concepts.
            </p>
            <a href="Simulator/index.php" class="hero-btn">GET STARTED</a>
        </div>
    </section>

    <section class="course">
        <h1>Need of Algorithm</h1>
        <p>The main purposes of a CPU scheduling algorithm are listed below:</p>

        <div class="row" data-aos="zoom-in-up">
            <div class="course-colomn">
                <h3>CPU Utilization</h3>
                <p>
                    CPU scheduling is the process by which the CPU is allocated to various processes in a way that ensures maximum utilization. 
                    While one process is executing, others may be on hold due to factors such as resource unavailability (e.g., I/O operations). 
                    The goal of CPU scheduling is to optimize CPU utilization, ensuring the system operates efficiently, quickly, and fairly.
                </p>
            </div>
            <div class="course-colomn">
                <h3>Max Performance</h3>
                <p>
                    To achieve optimal CPU performance and avoid wasting any CPU cycles, the CPU should ideally be utilized as much as possible, 
                    with the goal of working 100% of the time. In a real system, CPU usage typically ranges from 40% (lightly loaded) to 90% (heavily loaded).
                </p>
            </div>
            <div class="course-colomn">
                <h3>Time Minimizing</h3>
                <p>
                    There are various algorithms designed for different tasks, each aimed at minimizing waiting time, response time, and turnaround time. 
                    For example, turnaround time can be minimized if most processes complete their next CPU burst within a single time quantum.
                </p>
            </div>
        </div>
    </section>

    <section class="cta" data-aos="zoom-in-up">
        <h1>
            Learn about all types Algorithm<br />
            Click Below to Explore!
        </h1>
        <a href="docs.php" class="hero-btn">Click Here</a>
    </section>


    
    <!--Footer Section  -->
    <section class="footer">
        <p>Made With <i class="far fa-heart"></i> by TEAM-BA</p>
        <p>
            <i class="fa fa-copyright"></i> copyright 2025 || All rights reserved
        </p>
    </section>

    <!-- JavaScript :-  -->
    <script>
        var navLinks = document.getElementById("navLinks");
        function showMenu() {
            navLinks.style.right = "0";
        }

        function hideMenu() {
            navLinks.style.right = "-200px";
        }

        function gotoDocs() {
            location.href = "docs.php";
        }
    </script>

    <!-- animation for cards -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 100, 
            duration: 800,
        });
    </script>
</body>

</html>