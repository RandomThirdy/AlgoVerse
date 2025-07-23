class Process {
    constructor(id, arrival, burst, priority = 0, queueLevel = 1) {
        this.id = id;
        this.arrival = parseInt(arrival);
        this.burst = parseInt(burst);
        this.priority = parseInt(priority);
        this.queueLevel = parseInt(queueLevel); 
        this.remainingBurst = parseInt(burst);
        this.completion = 0;
        this.turnaround = 0;
        this.waiting = 0;
        this.response = -1;
        this.startTime = -1;
    }
}