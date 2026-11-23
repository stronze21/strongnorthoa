/* Export the complete displayed month, including horizontally scrolled days. */
window.downloadBookingCalendar = async function (root) {
    const title = root.querySelector('#calendar-title').textContent.trim().replace(/\s+/g, ' ');
    const table = root.querySelector('table');
    const weeks = Array.from(table.tBodies[0].rows).map(row => Array.from(row.cells).map(cell => ({
        day: cell.querySelector('time').textContent.trim(),
        today: cell.querySelector('time').hasAttribute('aria-current'),
        outside: cell.classList.contains('calendar-outside'),
        events: Array.from(cell.querySelectorAll('.calendar-event')).map(event => ({
            text: event.textContent.trim().replace(/\s+/g, ' '),
            kind: event.classList.contains('calendar-follow-up') ? 'followup' :
                (event.classList.contains('calendar-amount') ? 'amount' : 'other')
        }))
    })));
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    if (!ctx) throw new Error('Canvas is unavailable');
    const width = 1960, margin = 28, columnWidth = (width - margin * 2) / 7;
    const font = 'Arial, sans-serif';
    ctx.font = `15px ${font}`;
    function wrap(text, maxWidth) {
        const lines = [];
        let line = '';
        for (const word of text.split(/\s+/)) {
            const candidate = line ? line + ' ' + word : word;
            if (ctx.measureText(candidate).width <= maxWidth) { line = candidate; continue; }
            if (line) { lines.push(line); line = ''; }
            // Split long names or unbroken content rather than clipping it.
            for (const char of word) {
                if (line && ctx.measureText(line + char).width > maxWidth) { lines.push(line); line = ''; }
                line += char;
            }
        }
        if (line) lines.push(line);
        return lines;
    }
    const summary = root.querySelector('.calendar-filter-summary');
    const summaryLines = summary ? wrap(summary.textContent.trim().replace(/\s+/g, ' ').replace(/\. Browse months.*$/, ''), width - margin * 2) : [];
    const summaryHeight = summaryLines.length ? summaryLines.length * 20 + 10 : 0;
    const heights = weeks.map(week => Math.max(160, ...week.map(cell => {
        cell.events.forEach(event => { event.lines = wrap(event.text, columnWidth - 32); });
        return 44 + cell.events.reduce((sum, event) => sum + event.lines.length * 21 + 22, 0);
    })));
    const height = 166 + summaryHeight + heights.reduce((sum, rowHeight) => sum + rowHeight, 0) + margin;
    // Keep large booking months within common canvas size limits.
    const scale = Math.min(2, 16000 / Math.max(width, height), Math.sqrt(60000000 / (width * height)));
    canvas.width = Math.floor(width * scale);
    canvas.height = Math.floor(height * scale);
    ctx.scale(scale, scale);
    ctx.fillStyle = '#ffffff'; ctx.fillRect(0, 0, width, height);
    ctx.textBaseline = 'top';
    ctx.fillStyle = '#374151'; ctx.font = `bold 44px ${font}`;
    ctx.fillText(title, margin, 26);
    ctx.font = `15px ${font}`;
    [['#fee2e2', '#991b1b', 'Follow up / For follow up'], ['#dbeafe', '#1e40af', 'With amount']].forEach((item, i) => {
        const x = margin + i * 290;
        ctx.fillStyle = item[0]; ctx.fillRect(x, 88, i === 0 ? 265 : 160, 30);
        ctx.fillStyle = item[1]; ctx.fillText(item[2], x + 10, 95);
    });
    ctx.fillStyle = '#526078'; ctx.font = `15px ${font}`;
    summaryLines.forEach((line, index) => ctx.fillText(line, margin, 130 + index * 20));
    const weekdayTop = 130 + summaryHeight;
    Array.from(table.tHead.rows[0].cells).forEach((cell, column) => {
        const x = margin + column * columnWidth;
        ctx.fillStyle = '#f3f4f6'; ctx.fillRect(x, weekdayTop, columnWidth, 36);
        ctx.strokeStyle = '#d1d5db'; ctx.strokeRect(x, weekdayTop, columnWidth, 36);
        ctx.font = `bold 16px ${font}`; ctx.fillStyle = '#374151';
        ctx.fillText(cell.textContent.trim(), x + 10, weekdayTop + 10);
    });
    let top = 166 + summaryHeight;
    weeks.forEach((week, index) => {
        week.forEach((cell, column) => {
            const x = margin + column * columnWidth;
            ctx.fillStyle = cell.outside ? '#f9fafb' : '#ffffff';
            ctx.fillRect(x, top, columnWidth, heights[index]);
            ctx.strokeStyle = '#d1d5db'; ctx.strokeRect(x, top, columnWidth, heights[index]);
            if (cell.today) { ctx.fillStyle = '#374151'; ctx.fillRect(x + 8, top + 8, 32, 25); }
            ctx.fillStyle = cell.today ? '#ffffff' : '#526078'; ctx.font = `bold 15px ${font}`;
            ctx.fillText(cell.day, x + 14, top + 12);
            let eventTop = top + 42;
            cell.events.forEach(event => {
                const colors = { followup: ['#fee2e2', '#991b1b'], amount: ['#dbeafe', '#1e40af'], other: ['#f3f4f6', '#374151'] }[event.kind];
                const eventHeight = event.lines.length * 21 + 14;
                ctx.fillStyle = colors[0]; ctx.fillRect(x + 8, eventTop, columnWidth - 16, eventHeight);
                ctx.fillStyle = colors[1]; ctx.font = `15px ${font}`;
                event.lines.forEach((line, n) => ctx.fillText(line, x + 16, eventTop + 7 + n * 21));
                eventTop += eventHeight + 8;
            });
        });
        top += heights[index];
    });
    const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));
    if (!blob) throw new Error('PNG conversion failed');
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '') + '.png';
    document.body.appendChild(link); link.click(); link.remove();
    setTimeout(() => URL.revokeObjectURL(url), 1000);
};
