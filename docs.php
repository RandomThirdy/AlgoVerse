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
    <link rel="stylesheet" href="docs.css">

    <title>AlgoVerse: Rsources</title>
</head>

<body>
    <section class="sub-header">
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
        <h1>Exploring CPU Scheduling Methods and Strategies</h1>
    </section>


    <!-- Question Section -->
    <section class="container_docs">
        <h2>What is CPU Scheduling?</h2>
        <p>CPU scheduling is the process of determining which process will be allocated the CPU for execution while other processes remain on hold. 
            The main objective of CPU scheduling is to ensure that when the CPU is idle, the operating system selects a process from the ready queue for execution. 
            This selection is handled by the CPU scheduler, which picks one of the processes in memory that are ready to execute.
        </p>
    </section>

    <section class="container_docs" data-aos="zoom-in-up">
        <h2>Why CPU Scheduling?</h2>
        <p>A typical process involves both I/O time and CPU time. In a uni programming system like MS-DOS, time spent
            waiting for I/O is wasted and CPU is free during this time. In multi programming systems, one process can
            use CPU while another is waiting for I/O. This is possible only with process scheduling.<br><br>
            <strong>Objectives of Process Scheduling Algorithm</strong>
            <li>Max CPU utilization [Keep CPU as busy as possible]</li>
            <li>Fair allocation of CPU.</li>
            <li>Max throughput [Number of processes that complete their execution per time unit]</li>
            <li>Min turnaround time [Time taken by a process to finish execution]</li>
            <li>Min waiting time [Time a process waits in ready queue]</li>
            <li>Min response time [Time when a process produces first response]</li>

        </p>
    </section>

    <section class="container_docs special" data-aos="zoom-in-up">
        <h2>Important CPU scheduling Terminologies</h2>
        <li><strong>Burst Time/Execution Time:</strong> It is a time required by the process to complete execution. It
            is also called running time.</li>
        <li><strong>Arrival Time:</strong> when a process enters in a ready state</li>
        <li><strong>Finish Time:</strong> when process complete and exit from a system</li>
        <li><strong>Multiprogramming:</strong> A number of programs which can be present in memory at the same time.
        </li>
        <li><strong>Jobs:</strong> It is a type of program without any kind of user interaction.</li>
        <li><strong>User:</strong> It is a kind of program having user interaction.</li>
        <li><strong>Process:</strong> It is the reference that is used for both job and user.</li>
        <li><strong>CPU/IO burst cycle:</strong> Characterizes process execution, which alternates between CPU and I/O
            activity. CPU times are shorter than the time of I/O.</li>

        </p>
    </section>

    <section class="container_docs" data-aos="zoom-in-up">
        <h2>Types of CPU Scheduling</h2>
        <p>There is mainly two major types of CPU Scheduling which is listed below.There is sub-types of this algorithm
            also. we have discussed all algorithm in details below. </p>
        <li>Preemptive Algorithm</li>
        <li>Non Preemptive Algorithm</li>
        <br>

        <p><strong class="bold">Preemptive Scheduling</strong><br>
            In Preemptive Scheduling, the tasks are mostly assigned with their priorities. Sometimes it is important to
            run a task with a higher priority before another lower priority task, even if the lower priority task is
            still running. The lower priority task holds for some time and resumes when the higher priority task
            finishes its execution.<br>
            <br>
            <strong class="bold">Non-Preemptive Scheduling</strong><br>
            In this type of scheduling method, the CPU has been allocated to a specific process. The process that keeps
            the CPU busy will release the CPU either by switching context or terminating. It is the only method that can
            be used for various hardware platforms. That’s because it doesn’t need special hardware (for example, a
            timer) like preemptive scheduling.
        </p>
    </section>


    <section class="container_docs" data-aos="zoom-in-up">
        <h2>Types of CPU scheduling Algorithm</h2>
        <p>There are mainly six types of process scheduling algorithm</p>
        <li>First Come First Serve (FCFS)</li>
        <li>Shortest-Job-First (SJF) </li>
        <li>Shortest Remaining Time</li>
        <li>Priority Scheduling</li>
        <li>Round Robin Scheduling</li>
        <li>Multilevel Queue Scheduling</li>
        <br>
    </section>


    <!-- FCFS -->
    <section class="container_docs" data-aos="zoom-in-up">
        <h2>First Come First Serve</h2>
        <p>First Come First Serve is the full form of FCFS. It is the easiest and most simple CPU scheduling algorithm.
            In this type of algorithm, the process which requests the CPU gets the CPU allocation first. This scheduling
            method can be managed with a FIFO queue.<br><br>

            As the process enters the ready queue, its PCB (Process Control Block) is linked with the tail of the queue.
            So, when CPU becomes free, it should be assigned to the process at the beginning of the queue.</p>

        <h4>
            <li>Advantages</li>
        </h4>
        <p>1. It is simple and easy to understand.<br></p>

        <h4>
            <li>Disadvantages</li>
        </h4>
        <p>1. The process with less execution time suffer i.e. waiting time is often quite long.<br><br>
            2. Favors CPU Bound process then I/O bound process.<br><br>
            3. FCFS algorithm is particularly troublesome for time-sharing systems, where it is important that each user
            get a share of the CPU at regular intervals.</p>
        <button class="btn_1" onclick="gotoFCFS();">Go to FCFS</button>
        <br>
    </section>

    <!-- SRTF -->
    <section class="container_docs" data-aos="zoom-in-up">
        <h2>Shortest Remaining Time</h2>
        <p>The full form of SRT is Shortest remaining time. It is also known as SJF preemptive scheduling. In this
            method, the process will be allocated to the task, which is closest to its completion. This method prevents
            a newer ready state process from holding the completion of an older process.<br></p>

        <h4>
            <li>Advantages</li>
        </h4>
        <p>1. The main advantage of the SRTF algorithm is that it makes the processing of the jobs faster than the SJF
            algorithm, mentioned it’s overhead charges are not counted.</p>

        <h4>
            <li>Disadvantages</li>
        </h4>
        <p>1. In SRTF, the context switching is done a lot more times than in SJN due to more consumption of the CPU's
            valuable time for processing. The consumed time of CPU then adds up to its processing time and which then
            diminishes the advantage of fast processing of this algorithm.<br></p>
        <button class="btn_1" onclick="gotoSRTF();">Go to SRTF</button>
        <br>
    </section>

    <!-- Priority -->
    <section class="container_docs" data-aos="zoom-in-up">
        <h2>Priority Based Scheduling</h2>
        <p>Priority scheduling is a method of scheduling processes based on priority. In this method, the scheduler
            selects the tasks to work as per the priority.<br><br>
            Priority scheduling also helps OS to involve priority assignments. The processes with higher priority should
            be carried out first, whereas jobs with equal priorities are carried out on a round-robin or FCFS basis.
            Priority can be decided based on memory requirements, time requirements, etc.<br><br>
        </p>
        <h4>
            <li>Advantages</li>
        </h4>
        <p>1. This provides a good mechanism where the relative importance of each process maybe precisely defined.<br>
        </p>
        <h4>
            <li>Disadvantages</li>
        </h4>
        <p>1. If high priority processes use up a lot of CPU time, lower priority processes may starve and be postponed
            indefinitely.The situation where a process never gets scheduled to run is called starvation<br><br>
            2. Another problem is deciding which process gets which priority level assigned to it..<br></p>
        <button class="btn_1" onclick="gotoPriority();">Go to Priority</button>
        <br>
    </section>

    <!-- Round Robin -->
    <section class="container_docs" data-aos="zoom-in-up">
        <h2>Round-Robin Scheduling</h2>
        <p>Round robin is the oldest, simplest scheduling algorithm. The name of this algorithm comes from the
            round-robin principle, where each person gets an equal share of something in turn. It is mostly used for
            scheduling algorithms in multitasking. This algorithm method helps for starvation free execution of
            processes.<br><br></p>

        <h4>
            <li>Advantages</li>
        </h4>
        <p>1. Every process gets an equal share of the CPU.<br><br>
            2. RR is cyclic in nature, so there is no starvation.</p>

        <h4>
            <li>Disadvantages</li>
        </h4>
        <p>1. Setting the quantum too short, increases the overhead and lowers the CPU efficiency, but setting it too
            long may cause poor response to short processes.<br><br>
            2. Average waiting time under the RR policy is often long.<br>
        </p>
        <button class="btn_1" onclick="gotoWorking();">Go to RR</button>
        <br>
    </section>

    <!-- SJF -->
    <section class="container_docs" data-aos="zoom-in-up">
        <h2>Shortest Job First</h2>
        <p>SJF is a full form of (Shortest job first) is a scheduling algorithm in which the process with the shortest
            execution time should be selected for execution next. This scheduling method can be preemptive or
            non-preemptive. It significantly reduces the average waiting time for other processes awaiting
            execution.<br></p>

        <h4>
            <li>Advantages</li>
        </h4>
        <p>1. Shortest jobs are favored.<br><br>
            2. It is provably optimal, in that it gives the minimum average waiting time for a given set of processes.
        </p>

        <h4>
            <li>Disadvantages</li>
        </h4>
        <p>1. SJF may cause starvation, if shorter processes keep coming. This problem is solved by aging..<br><br>
            2. It cannot be implemented at the level of short term CPU scheduling.<br></p>

        <button class="btn_1" onclick="gotoSJF();">Go to SJF</button>
        <br>
    </section>

    <!--Footer Section  -->
    <section class="footer">
        <p>Made With <i class="far fa-heart"></i> by TEAM-BA</p>
        <p>
            <i class="fa fa-copyright"></i> copyright 2025 || All rights reserved
        </p>
    </section>


    <!--JavaScript  -->
    <script>
        var navLinks = document.getElementById("navLinks");
        function showMenu() {
            navLinks.style.right = "0";
        }

        function hideMenu() {
            navLinks.style.right = "-200px";
        }

        function gotoSimulator() {
            location.href = ("Simulator/index.php");
        }

        function gotoFCFS() {
            location.href = ("Simulator/index.php");
        }

        function gotoSRTF() {
            location.href = ("Simulator/index.php");
        }

        function gotoPriority() {
            location.href = ("Simulator/index.php");
            
        }

        function gotoSJF() {
            location.href = ("Simulator/index.php");
        }

        function gotoWorking() {
            location.href = ("Simulator/index.php");
        }

    </script>


    <!-- For the animation -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 200, 
            duration: 800
        });
    </script>
</body>

</html>