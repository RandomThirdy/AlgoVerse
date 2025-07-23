<!-- Footer Section  -->
<section class="footer">
        <p>Made With <i class="far fa-heart"></i> by TEAM-BA</p>
        <p><i class="fa fa-copyright"></i> copyright 2025 || All rights reserved</p>
    </section>

    <!-- JavaScript :-  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="process.js"></script>
    <script src="algorithms.js"></script>
    <script src="simulate.js"></script>
    <script src="display.js"></script>
    <script src="displayMLQ.js"></script>
    <script src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastEl = document.querySelector('.toast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            var editProcessModal = document.getElementById('editProcessModal');
            editProcessModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var processId = button.getAttribute('data-id');
                var arrivalTime = button.getAttribute('data-arrival');
                var burstTime = button.getAttribute('data-burst');
                var priority = button.getAttribute('data-priority');
                var queueLevel = button.getAttribute('data-queue');

                var modal = this;
                modal.querySelector('#editProcessId').value = processId;
                modal.querySelector('#editArrivalTime').value = arrivalTime;
                modal.querySelector('#editBurstTime').value = burstTime;
                modal.querySelector('#editPriority').value = priority;
                modal.querySelector('#editQueueLevel').value = queueLevel;
            });
        });
    </script>

    <script>
        var navLinks = document.getElementById("navLinks");
        function showMenu() {
            navLinks.style.right = "0";
        }
        function hideMenu() {
            navLinks.style.right = "-200px";
        }
        function gotoDocs() {
            location.href = "../docs.php";
        }
    </script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 100, 
            duration: 800,
        });
    </script>


</body>
</html>