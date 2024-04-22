<div class="card">
    <div class="row card-body">
        <h5>
            Newsletter
        </h5>
        <div class="card-content">
            <div class="my-3">
                <span>Campaigns</span>:
                <span class="badge text-bg-primary">Campaign A</span>
                <span class="badge text-bg-primary">Campaign B</span>
                <span class="badge text-bg-primary">Campaign C</span>
            </div>
            <div class="my-3">
                <ul class="list-group">
                    <li class="list-group-item">
                        45 subscribers | 3 campaigns
                    </li>
                    <li class="list-group-item">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        John Doe subscribed at 20.04.2024 to Campaign A
                        <a href="#" target="_blank">
                            See more
                        </a>
                    </li>
                    <li class="list-group-item">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        John Doe subscribed at 20.04.2024 to Campaign B
                        <a href="#" target="_blank">
                            See more
                        </a>
                    </li>
                    <li class="list-group-item">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        John Doe subscribed at 20.04.2024 to Campaign C
                        <a href="#" target="_blank">
                            See more
                        </a>
                    </li>
                </ul>
            </div>
            <div class="my-3">
                <canvas id="subscribers_line_chart"></canvas>
            </div>
            <div class="my-3">
                <canvas id="subscribers_pie_chart"></canvas>
            </div>
        </div>
    </div>
</div>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"
    integrity="sha512-ZwR1/gSZM3ai6vCdI+LVF1zSq/5HznD3ZSTk7kajkaj4D292NLuduDCO1c/NT8Id+jE58KYLKT7hXnbtryGmMg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
></script>
<script type="text/javascript">
    // Line chart
    const newsletterLineChartCtx = document.getElementById('subscribers_line_chart').getContext('2d');
    const newsletterLineChartData = {
        labels: [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ],
        datasets: [{
            label: 'Subscribers',
            data: [100, 150, 200, 223, 150, 196, 250, 125, 175, 199, 149, 201],
            borderColor: 'rgba(54, 162, 235)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderWidth: 1
        }]
    };
    const newsletterLineChartOptions = {
        plugins: {
            title: {
                display: true,
                text: 'Subscribers per Campaign'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };
    const newsletterLineChart = new Chart(newsletterLineChartCtx, {
        type: 'line',
        data: newsletterLineChartData,
        options: newsletterLineChartOptions
    });

    // Pie chart
    const newsletterPieChartCtx = document.getElementById('subscribers_pie_chart').getContext('2d');
    const newsletterPieChartData = {
        labels: ['Campaign A', 'Campaign B', 'Campaign C'],
        datasets: [{
            label: 'Subscribers',
            data: [168, 98, 200],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    };
    const newsletterPieOptions = {
        aspectRatio: 1.75,
        plugins: {
            title: {
                display: true,
                text: 'Subscribers by newsletter campaigns'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };
    const newsletterPieChart = new Chart(newsletterPieChartCtx, {
        type: 'pie',
        data: newsletterPieChartData,
        options: newsletterPieOptions
    });
</script>
