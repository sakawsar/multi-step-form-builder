import Chart from 'chart.js/auto';
import jQuery from 'jquery';
const chart = new Chart(document.getElementById('msfb-leads-states').getContext('2d'), {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
            label: 'Leads per day',
            backgroundColor: '#244A60',
            borderColor: '#244A60',
            data: [0, 10, 5, 2, 20, 30, 45]
        }]
    },
    options: {}
});
jQuery(document).ready(function ($) {
    console.log('working')
});