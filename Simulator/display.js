function createRRFlowVisualization(timeline, timeQuantum) {
    const guideDiv = document.createElement('div');
    guideDiv.className = 'mt-4';
    
    const guideTable = document.createElement('div');
    guideTable.innerHTML = `
        <h3>Round Robin Execution Flow:</h3>
        <div style="overflow-x: auto;">
            <table style="min-width: 600px;">
                <thead>
                    <tr>
                        <th>Process</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Remaining Burst Before</th>
                        <th>Remaining Burst After</th>
                    </tr>
                </thead>
                <tbody>
                    ${timeline.map(step => `
                        <tr>
                            <td>P${step.process}</td>
                            <td>${step.start}</td>
                            <td>${step.end}</td>
                            <td>${step.remainingBefore}</td>
                            <td>${step.remainingAfter}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
    guideTable.style.marginBottom = '40px'; 
    guideTable.style.fontSize = '14px'; 
    guideDiv.appendChild(guideTable);

    const processFlowTitle = document.createElement('h3');
    processFlowTitle.textContent = 'Guide Table:';
    processFlowTitle.style.marginBottom = '20px'; 
    processFlowTitle.style.fontSize = '25px'; 
    guideDiv.appendChild(processFlowTitle);

    const flowContainer = document.createElement('div');
    flowContainer.className = 'flow-container';
    flowContainer.style.position = 'relative';
    flowContainer.style.padding = '40px 20px';
    flowContainer.style.overflowX = 'auto';
    flowContainer.style.whiteSpace = 'nowrap';

    const processFlow = document.createElement('div');
    processFlow.style.display = 'flex';
    processFlow.style.alignItems = 'center';
    processFlow.style.gap = '10px';

    timeline.forEach((step, index) => {
        const processBlock = document.createElement('div');
        processBlock.className = 'process-block';
        processBlock.style.position = 'relative';
        processBlock.style.width = '60px';
        processBlock.style.height = '60px';
        processBlock.style.backgroundColor = getProcessColor(step.process);
        processBlock.style.color = 'white';
        processBlock.style.display = 'flex';
        processBlock.style.alignItems = 'center';
        processBlock.style.justifyContent = 'center';
        processBlock.style.borderRadius = '8px';
        processBlock.style.fontSize = '16px';
        processBlock.style.fontWeight = 'bold';
        processBlock.textContent = `P${step.process}`;

        processFlow.appendChild(processBlock);

        if (index < timeline.length - 1) {
            const arrow = document.createElement('div');
            arrow.innerHTML = '→';
            arrow.style.fontSize = '24px';
            arrow.style.color = '#666';
            arrow.style.marginLeft = '10px';
            processFlow.appendChild(arrow);
        }
    });

    flowContainer.appendChild(processFlow);
    guideDiv.appendChild(flowContainer);

    return guideDiv;
}

function displayResults(timeline, processes, algorithm) {
    const resultsDiv = document.getElementById('results');
    resultsDiv.style.display = 'block'; 

    const calculationsDiv = document.getElementById('calculations');
    const ganttChart = document.getElementById('gantt-chart');
    const averageMetricsDiv = document.getElementById('average-metrics');

    calculationsDiv.innerHTML = '';
    ganttChart.innerHTML = '';
    averageMetricsDiv.innerHTML = '';

    const sortedProcesses = processes.slice().sort((a, b) => a.id - b.id);

    const sortedTimeline = [...timeline].sort((a, b) => {
        if (a.start === b.start) {
            return a.process - b.process;
        }
        return a.start - b.start;
    });

    const calculationsTable = document.createElement('div');
    calculationsTable.innerHTML = `
        <div style="overflow-x: auto;">
            <table style="min-width: 600px;">
                <thead>
                    <tr>
                        <th>Process</th>
                        <th>Arrival Time</th>
                        <th>Burst Time</th>
                        <th>Completion Time</th>
                        <th>Turnaround Time</th>
                        <th>Waiting Time</th>
                    </tr>
                </thead>
                <tbody>
                    ${sortedProcesses.map(process => `
                        <tr>
                            <td>P${process.id}</td>
                            <td>${process.arrival}</td>
                            <td>${process.burst}</td>
                            <td>${process.completion}</td>
                            <td>${process.turnaround}</td>
                            <td>${process.waiting}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
    calculationsDiv.appendChild(calculationsTable);

    if (algorithm === 'rr') {
        const flowVisualization = createRRFlowVisualization(timeline, processes);
        calculationsDiv.appendChild(flowVisualization);
    }
    
    let mergedTimeline = [];
    let currentTime = 0;

    sortedTimeline.forEach((item, index) => {
        if (item.start > currentTime) {
            mergedTimeline.push({
                process: 'idle',
                start: currentTime,
                end: item.start
            });
        }

        if (mergedTimeline.length > 0 &&
            mergedTimeline[mergedTimeline.length - 1].process === item.process &&
            mergedTimeline[mergedTimeline.length - 1].end === item.start) {
            mergedTimeline[mergedTimeline.length - 1].end = item.end;
        } else {
            mergedTimeline.push(item);
        }

        currentTime = item.end;
    });

    const totalTime = Math.max(...sortedTimeline.map(t => t.end));
    const timeUnit = 800 / totalTime;
    
    
    const chart = document.createElement('div');
    chart.style.position = 'relative';
    chart.style.height = '180px';
    chart.style.marginBottom = '20px';

    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.style.position = 'absolute';
    svg.style.top = '0';
    svg.style.left = '0';
    svg.style.width = '100%';
    svg.style.height = '100%';
    svg.style.pointerEvents = 'none';

    const defs = document.createElementNS('http://www.w3.org/2000/svg', 'defs');
    const marker = document.createElementNS('http://www.w3.org/2000/svg', 'marker');
    marker.setAttribute('id', 'arrowhead');
    marker.setAttribute('markerWidth', '10');
    marker.setAttribute('markerHeight', '7');
    marker.setAttribute('refX', '9');
    marker.setAttribute('refY', '3.5');
    marker.setAttribute('orient', 'auto');
    
    const polygon = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
    polygon.setAttribute('points', '0 0, 10 3.5, 0 7');
    polygon.setAttribute('fill', '#ff4444');
    
    marker.appendChild(polygon);
    defs.appendChild(marker);
    svg.appendChild(defs);
    chart.appendChild(svg);

    mergedTimeline.forEach((item, index) => {
        const block = document.createElement('div');
        block.style.position = 'absolute';
        block.style.left = `${Math.floor(item.start * timeUnit)}px`; 
        block.style.width = `${Math.ceil((item.end - item.start) * timeUnit)}px`; 
        block.style.top = '0';
        block.style.height = '50px';

        if (index > 0 && item.start !== mergedTimeline[index-1].end) {
            const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
            line.setAttribute('x1', `${mergedTimeline[index-1].end * timeUnit}`);
            line.setAttribute('y1', '35');
            line.setAttribute('x2', `${item.start * timeUnit}`);
            line.setAttribute('y2', '35');
            line.setAttribute('stroke', '#ff4444');
            line.setAttribute('stroke-width', '2');
            line.setAttribute('marker-end', 'url(#arrowhead)');
            svg.appendChild(line);
        }

        if (item.process === 'idle') {
            block.style.backgroundColor = '#f0f0f0';
            block.style.border = '1px dashed #999';
            block.style.background = 'repeating-linear-gradient(45deg, #f0f0f0, #f0f0f0 10px, #e0e0e0 10px, #e0e0e0 20px)';
            block.textContent = 'IDLE';
        } else {
            block.style.backgroundColor = getProcessColor(item.process);
            block.style.border = '1px solid #333';
            block.textContent = `P${item.process}`;
        }

        block.style.display = 'flex';
        block.style.alignItems = 'center';
        block.style.justifyContent = 'center';
        block.style.fontSize = '12px';
        block.style.whiteSpace = 'nowrap';
        block.style.overflow = 'hidden';
        block.style.textOverflow = 'ellipsis';
        block.style.padding = '2px';
        chart.appendChild(block);
    });







    const timeMarkerContainer = document.createElement('div');
    timeMarkerContainer.style.position = 'absolute';
    timeMarkerContainer.style.top = '60px';
    timeMarkerContainer.style.left = '0';
    timeMarkerContainer.style.right = '0';
    timeMarkerContainer.style.height = '20px';

    const initialMarker = document.createElement('div');
    initialMarker.style.position = 'absolute';
    initialMarker.style.left = '0';
    initialMarker.style.top = '0';
    initialMarker.textContent = '0';
    initialMarker.style.fontSize = '12px';
    timeMarkerContainer.appendChild(initialMarker);

    mergedTimeline.forEach(item => {
        const marker = document.createElement('div');
        marker.style.position = 'absolute';
        marker.style.left = `${Math.floor(item.end * timeUnit)}px`; 
        marker.style.top = '0';
        marker.textContent = item.end;
        marker.style.fontSize = '12px';
        timeMarkerContainer.appendChild(marker);
    });





    const readyQueueContainer = document.createElement('div');
    readyQueueContainer.style.position = 'absolute';
    readyQueueContainer.style.top = '100px';
    readyQueueContainer.style.left = '0';
    readyQueueContainer.style.right = '0';
    readyQueueContainer.style.height = '60px';
    readyQueueContainer.style.borderTop = '1px dashed #ccc';

    let lastReadyProcesses = [];
    for (let time = 0; time <= totalTime; time++) {
        const readyProcesses = processes
            .filter(p => p.arrival <= time && 
                      (p.completion > time || !p.completion) && 
                      !timeline.some(t => t.process === p.id && t.start <= time && t.end > time))
            .map(p => p.id)
            .sort((a, b) => a - b);

        if (time === 0 || time === totalTime || 
            JSON.stringify(readyProcesses) !== JSON.stringify(lastReadyProcesses)) {
            
            const markerContainer = document.createElement('div');
            markerContainer.style.position = 'absolute';
            markerContainer.style.left = `${time * timeUnit}px`;
            markerContainer.style.display = 'flex';
            markerContainer.style.flexDirection = 'column';
            markerContainer.style.alignItems = 'center';
            markerContainer.style.fontSize = '12px';

            readyProcesses.forEach(id => {
                const processDiv = document.createElement('div');
                processDiv.textContent = `P${id}`;
                processDiv.style.color = getProcessColor(id);
                processDiv.style.margin = '2px 0';
                markerContainer.appendChild(processDiv);
            });
            
            const timeLabel = document.createElement('div');
            timeLabel.textContent = time;
            timeLabel.style.fontSize = '10px';
            timeLabel.style.color = '#666';
            timeLabel.style.marginTop = '4px';
            markerContainer.appendChild(timeLabel);

            readyQueueContainer.appendChild(markerContainer);
            lastReadyProcesses = readyProcesses;
        }
    }

    chart.appendChild(readyQueueContainer);







    chart.appendChild(timeMarkerContainer);
    ganttChart.appendChild(chart);

    const totalIdleTime = mergedTimeline
        .filter(item => item.process === 'idle')
        .reduce((sum, item) => sum + (item.end - item.start), 0);

    const totalTurnaround = sortedProcesses.reduce((sum, p) => sum + p.turnaround, 0);
    const totalWaiting = sortedProcesses.reduce((sum, p) => sum + p.waiting, 0);
    const totalBurst = sortedProcesses.reduce((sum, p) => sum + p.burst, 0);
    const cpuUtilization = ((totalBurst / totalTime) * 100).toFixed(2);
    const idlePercentage = ((totalIdleTime / totalTime) * 100).toFixed(2);

    const metrics = [
        { title: 'Average Turnaround Time', value: (totalTurnaround / sortedProcesses.length).toFixed(2) },
        { title: 'Average Waiting Time', value: (totalWaiting / sortedProcesses.length).toFixed(2) },
        { title: 'CPU Utilization', value: `${cpuUtilization}%` },
        { title: 'CPU Idle Time', value: `${idlePercentage}%` }
    ];

    metrics.forEach(metric => {
        const card = document.createElement('div');
        card.className = 'metric-card';
        card.innerHTML = `
            <h4>${metric.title}</h4>
            <p>${metric.value}</p>
        `;
        averageMetricsDiv.appendChild(card);
    });
}

function getProcessColor(processId) {
    const colors = [
        '#4361ee', '#3f37c9', '#4bb543', '#dc3545', '#ff6b6b', '#ff9f43', '#feca57', '#54a0ff', '#00d2d3', '#5f27cd'
    ];
    return colors[processId % colors.length];
}