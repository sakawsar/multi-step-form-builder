import Chart from 'chart.js/auto'
const chart = new Chart(document.getElementById('msfb-leads-states').getContext('2d'), {
    type: 'line',
    data: {},
    options: {}
})
window.msfb_chart = chart