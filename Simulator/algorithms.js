function simulateFCFS(processes) {
    const sortedProcesses = [...processes].sort((a, b) => {
        if (a.arrival === b.arrival) {
            return a.id - b.id; 
        }
        return a.arrival - b.arrival;
    });
    
    let currentTime = 0;
    const timeline = [];

    sortedProcesses.forEach(process => {
        if (currentTime < process.arrival) {
            currentTime = process.arrival;
        }

        if (process.startTime === -1) {
            process.startTime = currentTime;
            process.response = currentTime - process.arrival;
        }

        timeline.push({
            process: process.id,
            start: currentTime,
            end: currentTime + process.burst
        });

        process.completion = currentTime + process.burst;
        process.turnaround = process.completion - process.arrival;
        process.waiting = process.turnaround - process.burst;
        currentTime = process.completion;
    });

    return { timeline, processes: sortedProcesses };
}

function simulateSJF(processes) {
    const unfinishedProcesses = [...processes].sort((a, b) => a.arrival - b.arrival);
    const timeline = [];
    let currentTime = 0;
    const readyQueue = [];
    const completedProcesses = [];

    while (unfinishedProcesses.length > 0 || readyQueue.length > 0) {
        while (unfinishedProcesses.length > 0 && unfinishedProcesses[0].arrival <= currentTime) {
            readyQueue.push(unfinishedProcesses.shift());
        }

        if (readyQueue.length === 0) {
            currentTime = unfinishedProcesses[0].arrival;
            continue;
        }

        readyQueue.sort((a, b) => {
            if (a.burst === b.burst) {
                return a.arrival - b.arrival; 
            }
            return a.burst - b.burst;
        });

        const currentProcess = readyQueue.shift();
        if (currentProcess.startTime === -1) {
            currentProcess.startTime = currentTime;
            currentProcess.response = currentTime - currentProcess.arrival;
        }

        timeline.push({
            process: currentProcess.id,
            start: currentTime,
            end: currentTime + currentProcess.burst
        });

        currentTime += currentProcess.burst;
        currentProcess.completion = currentTime;
        currentProcess.turnaround = currentProcess.completion - currentProcess.arrival;
        currentProcess.waiting = currentProcess.turnaround - currentProcess.burst;
        completedProcesses.push(currentProcess);
    }

    return { timeline, processes: completedProcesses };
}

function simulatePriorityP(processes) {
    const timeline = [];
    let currentTime = 0;
    const unfinishedProcesses = [...processes];
    const completedProcesses = new Set();
    let currentProcess = null;

    while (completedProcesses.size < processes.length) {
        const availableProcesses = unfinishedProcesses.filter(p => 
            !completedProcesses.has(p.id) && p.arrival <= currentTime
        );

        if (availableProcesses.length === 0) {
            currentTime++;
            continue;
        }

        availableProcesses.sort((a, b) => {
            if (a.priority !== b.priority) {
                return a.priority - b.priority;
            }
            
            if (a.remainingBurst !== b.remainingBurst) {
                return a.remainingBurst - b.remainingBurst;
            }
            
            return a.arrival - b.arrival;
        });

        const nextProcess = availableProcesses[0];

        if (currentProcess !== nextProcess) {
            if (nextProcess.startTime === -1) {
                nextProcess.startTime = currentTime;
                nextProcess.response = currentTime - nextProcess.arrival;
            }

            if (currentProcess && timeline.length > 0) {
                const lastEntry = timeline[timeline.length - 1];
                if (lastEntry.process === currentProcess.id) {
                    lastEntry.end = currentTime;
                }
            }

            timeline.push({
                process: nextProcess.id,
                start: currentTime,
                end: currentTime + 1
            });

            currentProcess = nextProcess;
        } else {
            const lastEntry = timeline[timeline.length - 1];
            lastEntry.end = currentTime + 1;
        }

        nextProcess.remainingBurst--;
        currentTime++;

        if (nextProcess.remainingBurst === 0) {
            completedProcesses.add(nextProcess.id);
            nextProcess.completion = currentTime;
            nextProcess.turnaround = nextProcess.completion - nextProcess.arrival;
            nextProcess.waiting = nextProcess.turnaround - nextProcess.burst;
            currentProcess = null;
        }
    }

    return { 
        timeline, 
        processes: processes.map(p => {
            const process = processes.find(proc => proc.id === p.id);
            return process;
        })
    };
}

function simulateSRTF(processes) {
    const processesCopy = processes.map(p => ({
        ...p,
        remainingBurst: p.burst,
        startTime: -1,
        completion: 0,
        turnaround: 0,
        waiting: 0,
        response: -1
    }));

    const timeline = [];
    let currentTime = 0;
    const completedProcesses = new Set();
    let currentProcess = null;

    while (completedProcesses.size < processesCopy.length) {
        const availableProcesses = processesCopy.filter(p => 
            !completedProcesses.has(p.id) && 
            p.arrival <= currentTime
        );

        if (availableProcesses.length === 0) {
            currentTime++;
            timeline.push({ process: 'idle', start: currentTime - 1, end: currentTime });
            continue;
        }

        availableProcesses.sort((a, b) => {
            if (a.remainingBurst === b.remainingBurst) {
                return a.arrival - b.arrival; 
            }
            return a.remainingBurst - b.remainingBurst;
        });

        const nextProcess = availableProcesses[0];

        if (currentProcess !== nextProcess) {
            if (nextProcess.startTime === -1) {
                nextProcess.startTime = currentTime;
                nextProcess.response = currentTime - nextProcess.arrival;
            }

            if (currentProcess && timeline.length > 0) {
                const lastEntry = timeline[timeline.length - 1];
                if (lastEntry.process === currentProcess.id) {
                    lastEntry.end = currentTime;
                }
            }

            timeline.push({
                process: nextProcess.id,
                start: currentTime,
                end: currentTime + 1
            });

            currentProcess = nextProcess;
        } else {
            const lastEntry = timeline[timeline.length - 1];
            lastEntry.end = currentTime + 1;
        }

        nextProcess.remainingBurst--;
        currentTime++;

        if (nextProcess.remainingBurst === 0) {
            completedProcesses.add(nextProcess.id);
            nextProcess.completion = currentTime;
            nextProcess.turnaround = nextProcess.completion - nextProcess.arrival;
            nextProcess.waiting = nextProcess.turnaround - nextProcess.burst;
            currentProcess = null;
        }
    }

    const results = processesCopy.map(p => ({
        id: p.id,
        arrival: p.arrival,
        burst: p.burst,
        completion: p.completion,
        turnaround: p.turnaround,
        waiting: p.waiting,
        response: p.response
    }));

    return {
        timeline,
        processes: results
    };
}

function simulatePriorityNP(processes) {
    let currentTime = 0;
    const timeline = [];
    const completedProcesses = [];
    const remainingProcesses = [...processes].map(process => ({
        ...process,
        remainingBurst: process.burst,
        startTime: -1,
        response: -1,
        completion: -1,
        turnaround: -1,
        waiting: -1
    }));

    while (remainingProcesses.length > 0) {
        const availableProcesses = remainingProcesses.filter(process => 
            process.arrival <= currentTime
        );

        if (availableProcesses.length === 0) {
            const nextArrival = Math.min(...remainingProcesses.map(p => p.arrival));
            currentTime = nextArrival;
            continue;
        }

        const selectedProcess = availableProcesses.reduce((prev, curr) => {
            if (prev.priority !== curr.priority) {
                return prev.priority < curr.priority ? prev : curr;
            }
            if (prev.burst !== curr.burst) {
                return prev.burst < curr.burst ? prev : curr;
            }
            return prev.arrival <= curr.arrival ? prev : curr;
        });

        if (selectedProcess.startTime === -1) {
            selectedProcess.startTime = currentTime;
            selectedProcess.response = currentTime - selectedProcess.arrival;
        }

        timeline.push({
            process: selectedProcess.id,
            start: currentTime,
            end: currentTime + selectedProcess.remainingBurst
        });

        currentTime += selectedProcess.remainingBurst;
        selectedProcess.completion = currentTime;
        selectedProcess.turnaround = selectedProcess.completion - selectedProcess.arrival;
        selectedProcess.waiting = selectedProcess.turnaround - selectedProcess.burst;

        const index = remainingProcesses.findIndex(p => p.id === selectedProcess.id);
        remainingProcesses.splice(index, 1);
        completedProcesses.push(selectedProcess);
    }

    return { timeline, processes: completedProcesses };
}




function simulateRR(processes, quantum) {
    const timeline = [];
    let currentTime = 0;
    const readyQueue = [];
    const unfinishedProcesses = [...processes].sort((a, b) => a.arrival - b.arrival);
    const completedProcesses = new Set();

    while (completedProcesses.size < processes.length || readyQueue.length > 0) {
        while (unfinishedProcesses.length > 0 && unfinishedProcesses[0].arrival <= currentTime) {
            readyQueue.push(unfinishedProcesses.shift());
        }

        if (readyQueue.length === 0) {
            if (unfinishedProcesses.length > 0) {
                currentTime = unfinishedProcesses[0].arrival;
                continue;
            }
            break;
        }

        const currentProcess = readyQueue.shift();
        
        if (currentProcess.startTime === -1) {
            currentProcess.startTime = currentTime;
            currentProcess.response = currentTime - currentProcess.arrival;
        }

        const executeTime = Math.min(quantum, currentProcess.remainingBurst);
        
        timeline.push({
            process: currentProcess.id,
            start: currentTime,
            end: currentTime + executeTime,
            remainingBefore: currentProcess.remainingBurst,
            remainingAfter: currentProcess.remainingBurst - executeTime
        });

        currentProcess.remainingBurst -= executeTime;
        currentTime += executeTime;

        while (unfinishedProcesses.length > 0 && unfinishedProcesses[0].arrival <= currentTime) {
            readyQueue.push(unfinishedProcesses.shift());
        }

        if (currentProcess.remainingBurst === 0) {
            currentProcess.completion = currentTime;
            currentProcess.turnaround = currentProcess.completion - currentProcess.arrival;
            currentProcess.waiting = currentProcess.turnaround - currentProcess.burst;
            completedProcesses.add(currentProcess.id);
        } else {
            readyQueue.push(currentProcess);
        }
    }

    return { timeline, processes };
}

function simulateMLQ(processes, queueLevels, schedulingAlgorithms, timeQuantum) {
    const queues = Array.from({ length: queueLevels }, () => []);

    processes.forEach(process => {
        const queueIndex = Math.min(process.priority, queueLevels - 1);
        queues[queueIndex].push(process);
    });

    let timeline = [];
    let allProcesses = [];
    let currentTime = 0; 

    for (let i = 0; i < queues.length; i++) {
        const queue = queues[i];
        const algorithm = schedulingAlgorithms[i];

        queue.sort((a, b) => {
            if (a.arrival !== b.arrival) {
                return a.arrival - b.arrival; 
            }
            if (a.priority !== b.priority) {
                return a.priority - b.priority; 
            }
            return a.burst - b.burst; 
        });

        let result;
        switch (algorithm) {
            case "FCFS":
                result = simulateFCFS(queue, currentTime);
                break;
            case "SJF":
                result = simulateSJF(queue, currentTime);
                break;
            case "SRTF":
                result = simulateSRTF(queue, currentTime);
                break;
            case "PP":
                result = simulatePriorityP(queue, currentTime);
                break;
            case "NPP":
                result = simulatePriorityNP(queue, currentTime);
                break;
            case "RR":
                result = simulateRR(queue, timeQuantum, currentTime);
                break;
            default:
                throw new Error(`Unknown scheduling algorithm: ${algorithm}`);
        }

        result.timeline = result.timeline.map(event => ({
            ...event,
            start: event.start + currentTime,
            end: event.end + currentTime,
        }));

        if (result.timeline.length > 0) {
            currentTime = result.timeline[result.timeline.length - 1].end;
        }

        timeline = timeline.concat(result.timeline);
        allProcesses = allProcesses.concat(result.processes);
    }

    return { timeline, processes: allProcesses };
}