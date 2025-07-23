document.addEventListener('DOMContentLoaded', function() {
    const algorithmSelect = document.getElementById('algorithm');
    const timeQuantumContainer = document.getElementById('time_quantum_container');
    const timeQuantumInput = document.getElementById('time_quantum');
    const priorityInput = document.getElementById('priority');
    const addProcessForm = document.querySelector('form[method="POST"]'); 
    const queueLevelContainer = document.createElement('div');
    queueLevelContainer.id = 'queue_level_container';
    queueLevelContainer.style.display = 'none';
    queueLevelContainer.className = 'row g-3 mt-3'; // Add the same class as algorithmSelectionContainer
    queueLevelContainer.innerHTML = `
        <div class="col-md-4"> <!-- Use the same class as algorithm for queue dropdowns -->
            <label for="queue_level" class="form-label">Queue Level (1-3)</label>
            <select class="form-select" id="queue_level" name="queue_level">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </div>
    `;
    timeQuantumContainer.parentNode.insertBefore(queueLevelContainer, timeQuantumContainer.nextSibling);

    function addQLInput() {
        const qlInput = document.createElement('div');
        qlInput.className = 'col-md-3';
        qlInput.innerHTML = `
            <label for="ql" class="form-label">Queue Level </label>
            <input type="number" class="form-control" id="ql" name="ql" min="1" max="3" required>
        `;
        priorityInput.closest('.col-md-3').insertAdjacentElement('afterend', qlInput);
    }

    function removeQLInput() {
        const qlInput = document.getElementById('ql');
        if (qlInput) {
            qlInput.parentElement.remove();
        }
    }

    function addAlgorithmSelectionBoxes(queueLevel) {
        const algorithmSelectionContainer = document.createElement('div');
        algorithmSelectionContainer.id = 'algorithm_selection_container';
        algorithmSelectionContainer.className = 'row g-3 mt-3'; 
        algorithmSelectionContainer.innerHTML = '';

        for (let i = 1; i <= queueLevel; i++) {
            algorithmSelectionContainer.innerHTML += `
                <div class="col-md-4">
                    <label for="algorithm_queue_${i}" class="form-label">Algorithm for Queue ${i}</label>
                    <select class="form-select" id="algorithm_queue_${i}" name="algorithm_queue_${i}">
                        <option value="FCFS">FCFS</option>
                        <option value="SJF">SJF</option>
                        <option value="SRTF">SRTF</option>
                        <option value="NPP">Non-Preemptive Priority</option>
                        <option value="PP">Preemptive Priority</option>
                        <option value="RR">Round Robin</option>
                    </select>
                </div>
            `;
        }

        queueLevelContainer.appendChild(algorithmSelectionContainer);
    }

    function removeAlgorithmSelectionBoxes() {
        const algorithmSelectionContainer = document.getElementById('algorithm_selection_container');
        if (algorithmSelectionContainer) {
            algorithmSelectionContainer.remove();
        }
    }

    if (!localStorage.getItem('selectedAlgorithm')) {
        localStorage.setItem('selectedAlgorithm', algorithmSelect.value);
    } else {
        algorithmSelect.value = localStorage.getItem('selectedAlgorithm');
    }
    
    currentAlgorithm = localStorage.getItem('selectedAlgorithm');

    if (!localStorage.getItem('timeQuantum')) {
        localStorage.setItem('timeQuantum', timeQuantumInput.value);
    } else {
        timeQuantumInput.value = localStorage.getItem('timeQuantum');
    }
    
    algorithmSelect.addEventListener('change', function() {
        const selectedAlgorithm = this.value;
        currentAlgorithm = selectedAlgorithm;
        localStorage.setItem('selectedAlgorithm', selectedAlgorithm);
    
        if (selectedAlgorithm === 'rr') {
            timeQuantumContainer.style.display = 'block';
            queueLevelContainer.style.display = 'none';
            removeQLInput(); 
            removeAlgorithmSelectionBoxes(); 
        } else if (selectedAlgorithm === 'mlq') {
            timeQuantumContainer.style.display = 'none';
            queueLevelContainer.style.display = 'block';
            addQLInput(); 
            const queueLevel = document.getElementById('queue_level').value;
            addAlgorithmSelectionBoxes(queueLevel);
        } else {
            timeQuantumContainer.style.display = 'none';
            queueLevelContainer.style.display = 'none';
            removeQLInput();
            removeAlgorithmSelectionBoxes(); 
        }
    
        if (selectedAlgorithm === 'fcfs' || selectedAlgorithm === 'rr' || selectedAlgorithm === 'sjf' || selectedAlgorithm === 'srtf') {
            priorityInput.disabled = true;
            priorityInput.closest('.col-md-3').style.display = 'none';
        } else {
            priorityInput.disabled = false;
            priorityInput.closest('.col-md-3').style.display = 'block';
        }
    });

    document.getElementById('queue_level')?.addEventListener('change', function() {
        const queueLevel = this.value;
        removeAlgorithmSelectionBoxes(); 
        addAlgorithmSelectionBoxes(queueLevel); 
    });

    timeQuantumInput.addEventListener('change', function() {
        localStorage.setItem('timeQuantum', this.value);
    });

    document.querySelector('button[name="select_algorithm"]').addEventListener('click', function(event) {
        event.preventDefault(); 
        simulate(); 
    }); 

    algorithmSelect.dispatchEvent(new Event('change'));
});

function addProcess() {
    const currentAlg = localStorage.getItem('selectedAlgorithm');
    
    const algorithmSelect = document.getElementById('algorithm');
    algorithmSelect.value = currentAlg;
    currentAlgorithm = currentAlg;

    const qlInput = document.createElement('div');
    qlInput.className = 'col-md-3';
    qlInput.innerHTML = `
        <label for="ql" class="form-label">Queue Level </label>
        <input type="number" class="form-control" id="ql" name="ql" min="1" max="3" required>
    `;
    priorityInput.closest('.col-md-3').insertAdjacentElement('afterend', qlInput);
}