import Chart from 'chart.js/auto'
const chart = new Chart(document.getElementById('msfb-leads-states').getContext('2d'), {
    type: 'line',
    data: {
        labels: window.msfb_all_data.labels,
        datasets: [{
            label: 'Leads per day',
            backgroundColor: '#244A60',
            borderColor: '#244A60',
            fill: false,
            data: window.msfb_all_data.data
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
})
window.msfb_chart = chart