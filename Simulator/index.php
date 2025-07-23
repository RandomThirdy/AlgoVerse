<?php
    session_start();

    if (!isset($_SESSION['processes'])) {
        $_SESSION['processes'] = [];
    }

    if (!isset($_SESSION['selected_algorithm'])) {
        $_SESSION['selected_algorithm'] = 'fcfs'; 
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_process'])) {
            $existingIds = array_column($_SESSION['processes'], 'id');
            $newId = 1;
            while (in_array($newId, $existingIds)) {
                $newId++;
            }

            $newProcess = [
                'id' => $newId,
                'arrival_time' => $_POST['arrival_time'],
                'burst_time' => $_POST['burst_time'],
                'priority' => $_POST['priority'],
                'queue_level' => $_POST['ql'] 
            ];
            $_SESSION['processes'][] = $newProcess;
            $_SESSION['process_added'] = true; 
        } elseif (isset($_POST['delete_process'])) {
            $processId = $_POST['process_id'];

            $_SESSION['processes'] = array_filter($_SESSION['processes'], function($p) use ($processId) {
                return $p['id'] != $processId;
            });

            $_SESSION['processes'] = array_values($_SESSION['processes']);

            foreach ($_SESSION['processes'] as $index => &$process) {
                $process['id'] = $index + 1;
            }
        } elseif (isset($_POST['edit_process'])) {
            $processId = $_POST['process_id'];
            $arrivalTime = $_POST['arrival_time'];
            $burstTime = $_POST['burst_time'];
            $priority = $_POST['priority'];
            $queueLevel = $_POST['queue_level'];

            foreach ($_SESSION['processes'] as &$process) {
                if ($process['id'] == $processId) {
                    $process['arrival_time'] = $arrivalTime;
                    $process['burst_time'] = $burstTime;
                    $process['priority'] = $priority;
                    $process['queue_level'] = $queueLevel;
                    break;
                }
            }

            $_SESSION['process_updated'] = true; // Set the session variable
        } elseif (isset($_POST['clear_all'])) {
            $_SESSION['processes'] = [];
        } elseif (isset($_POST['algorithm'])) {
            $_SESSION['selected_algorithm'] = $_POST['algorithm'];
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    include 'header.php';
?>


    

    <div class="container" style="margin-top: 30px;">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Add New Process</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="" class="row g-3">
                    <div class="col-md-3">
                        <label for="arrival_time" class="form-label">Arrival Time</label>
                        <input type="number" class="form-control" id="arrival_time" name="arrival_time" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label for="burst_time" class="form-label">Burst Time</label>
                        <input type="number" class="form-control" id="burst_time" name="burst_time" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <label for="priority" class="form-label">Priority</label>
                        <input type="number" class="form-control" id="priority" name="priority" min="1" required>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" name="add_process" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Add Process
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Process List</h3>
                <form method="POST" action="" style="display: inline;">
                    <button type="submit" name="clear_all" class="btn btn-danger" <?php echo empty($_SESSION['processes']) ? 'disabled' : ''; ?>>
                        <i class="fas fa-trash"></i> Clear All
                    </button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Process ID</th>
                                <th>Arrival Time</th>
                                <th>Burst Time</th>
                                <th>Priority</th>
                                <th>Queue Level</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($_SESSION['processes'])): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No Processes Added Yet</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($_SESSION['processes'] as $process): ?>
                                    <tr class="process-row" data-id="<?php echo htmlspecialchars($process['id']); ?>">
                                        <td>P<?php echo htmlspecialchars($process['id']); ?></td>
                                        <td><?php echo htmlspecialchars($process['arrival_time']); ?></td>
                                        <td><?php echo htmlspecialchars($process['burst_time']); ?></td>
                                        <td><?php echo htmlspecialchars($process['priority']); ?></td>
                                        <td><?php echo htmlspecialchars($process['queue_level']); ?></td>
                                        <td>
                                            <form method="POST" action="" style="display: inline;">
                                                <input type="hidden" name="process_id" value="<?php echo htmlspecialchars($process['id']); ?>">
                                                <button type="submit" name="delete_process" class="btn btn-link text-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-link text-primary" data-bs-toggle="modal" data-bs-target="#editProcessModal" data-id="<?php echo htmlspecialchars($process['id']); ?>" data-arrival="<?php echo htmlspecialchars($process['arrival_time']); ?>" data-burst="<?php echo htmlspecialchars($process['burst_time']); ?>" data-priority="<?php echo htmlspecialchars($process['priority']); ?>" data-queue="<?php echo htmlspecialchars($process['queue_level']); ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Edit Process Modal -->
        <div class="modal fade" id="editProcessModal" tabindex="-1" aria-labelledby="editProcessModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProcessModalLabel">Edit Process</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" id="editProcessForm">
                            <input type="hidden" name="process_id" id="editProcessId">
                            <div class="mb-3">
                                <label for="editArrivalTime" class="form-label">Arrival Time</label>
                                <input type="number" class="form-control" id="editArrivalTime" name="arrival_time" min="0">
                            </div>
                            <div class="mb-3">
                                <label for="editBurstTime" class="form-label">Burst Time</label>
                                <input type="number" class="form-control" id="editBurstTime" name="burst_time" min="1">
                            </div>
                            <div class="mb-3">
                                <label for="editPriority" class="form-label">Priority</label>
                                <input type="number" class="form-control" id="editPriority" name="priority" min="1">
                            </div>
                            <div class="mb-3">
                                <label for="editQueueLevel" class="form-label">Queue Level</label>
                                <input type="number" class="form-control" id="editQueueLevel" name="queue_level" min="1">
                            </div>
                            <button type="submit" name="edit_process" class="btn btn-primary">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Scheduling Algorithm Selection</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="" class="row g-3">
                    <div class="col-md-6">
                        <label for="algorithm" class="form-label">Select Algorithm</label>
                        <select class="form-select" id="algorithm" name="algorithm">
                            <option value="fcfs" <?php echo ($_SESSION['selected_algorithm'] === 'fcfs') ? 'selected' : ''; ?>>First Come First Served (FCFS)</option>
                            <option value="sjf" <?php echo ($_SESSION['selected_algorithm'] === 'sjf') ? 'selected' : ''; ?>>Shortest Job First (SJF)</option>
                            <option value="srtf" <?php echo ($_SESSION['selected_algorithm'] === 'srtf') ? 'selected' : ''; ?>>Shortest Remaining Time First (SRTF)</option>
                            <option value="priority_np" <?php echo ($_SESSION['selected_algorithm'] === 'priority_np') ? 'selected' : ''; ?>>Non-Preemptive Priority</option>
                            <option value="priority_p" <?php echo ($_SESSION['selected_algorithm'] === 'priority_p') ? 'selected' : ''; ?>>Preemptive Priority</option>
                            <option value="rr" <?php echo ($_SESSION['selected_algorithm'] === 'rr') ? 'selected' : ''; ?>>Round Robin (RR)</option>
                            <option value="mlq" <?php echo ($_SESSION['selected_algorithm'] === 'mlq') ? 'selected' : ''; ?>>Multi-Level Queue (MLQ)</option>
                        </select>
                    </div>
                    <div class="col-md-4" id="time_quantum_container" style="display: none;">
                        <label for="time_quantum" class="form-label">Time Quantum (for RR)</label>
                        <input type="number" class="form-control" id="time_quantum" name="time_quantum" min="1" value="2">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" name="select_algorithm" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Save Algorithm
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="results" class="card shadow-sm mt-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Simulation Results</h3>
            </div>
            <div class="card-body">
                <h4>Calculations:</h4>
                <div id="calculations" class="mt-4"></div>

                <h4><br>Gantt Chart:</h4>
                <div id="gantt-chart" class="gantt-chart mt-4"></div>

                <h4>Average Metrics:</h4>
                <div id="average-metrics" class="metrics-grid mt-4"></div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <?php if (isset($_SESSION['process_added']) && $_SESSION['process_added']): ?>
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="2000">
        <div class="toast-header bg-primary text-white">
            <strong class="me-auto"><i class="fas fa-check-circle"></i> Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Process Added Successfully!
        </div>
    </div>

    <?php 
        unset($_SESSION['process_added']); 
        endif;
    ?>

    <?php if (isset($_SESSION['process_updated']) && $_SESSION['process_updated']): ?>
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="2000">
        <div class="toast-header bg-primary text-white">
            <strong class="me-auto"><i class="fas fa-check-circle"></i> Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Process Updated Successfully!
        </div>
    </div>


    <?php 
        unset($_SESSION['process_updated']);
        endif; 
        include 'footer.php';
    ?>

    