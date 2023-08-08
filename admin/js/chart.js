import Chart from 'chart.js/auto'
if( document.getElementById('msfb-leads-states') ) {
    const chart = new Chart(document.getElementById('msfb-leads-states').getContext('2d'), {
        type: 'line',
        data: {
            labels: JSON.parse(window.msfb_last_7_days).labels,
            datasets: [{
                label: 'Leads per day',
                backgroundColor: '#244A60',
                borderColor: '#244A60',
                fill: false,
                data: JSON.parse(window.msfb_last_7_days).data
            }]
        },
        options: {}
    })
    window.msfb_chart = chart
}