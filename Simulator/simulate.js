function simulate() {
    const algorithm = currentAlgorithm;
    const timeQuantum = parseInt(document.getElementById('time_quantum').value);
    const queueLevel = parseInt(document.getElementById('queue_level').value);
    const processes = Array.from(document.querySelectorAll('.process-row')).map(row => {
        const id = row.dataset.id;
        const arrival = parseInt(row.children[1].textContent);
        const burst = parseInt(row.children[2].textContent);
        const priority = (algorithm === 'fcfs' || algorithm === 'rr') ? 0 : parseInt(row.children[3].textContent);
        const queueLevel = parseInt(row.children[4].textContent); 
        return new Process(id, arrival, burst, priority, queueLevel);
    });

    let result;
    switch (algorithm) {
        case 'fcfs':
            result = simulateFCFS(processes);
            break;
        case 'sjf':
            result = simulateSJF(processes);
            break;
        case 'srtf':
            result = simulateSRTF(processes);
            break;
        case 'priority_np':
            result = simulatePriorityNP(processes);
            break;
        case 'priority_p':
            result = simulatePriorityP(processes);
            break;
        case 'rr':
            result = simulateRR(processes, timeQuantum);
            break;
        case 'mlq':
            const schedulingAlgorithms = [];
            for (let i = 1; i <= queueLevel; i++) {
                const algorithmSelect = document.getElementById(`algorithm_queue_${i}`);
                schedulingAlgorithms.push(algorithmSelect.value);
            }
            result = simulateMLQ(processes, queueLevel, schedulingAlgorithms);
            break;
        default:
            alert('Invalid algorithm selected');
            return;
    }

    displayResults(result.timeline, result.processes, algorithm);
    
}