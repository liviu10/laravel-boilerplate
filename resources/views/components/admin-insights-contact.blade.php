<div class="card">
    <div class="row card-body">
        <h5>
            Contact
        </h5>
        <div class="card-content">
            <div class="my-3">
                <span>Subjects</span>:
                <span class="badge text-bg-primary">Subject A</span>
                <span class="badge text-bg-primary">Subject B</span>
                <span class="badge text-bg-primary">Subject C</span>
            </div>
            <div class="my-3">
                <ul class="list-group">
                    <li class="list-group-item">
                        500 messages | 402 responses | 93.1% respond ratio
                    </li>
                    <li class="list-group-item">
                        <i class="fa-solid fa-comments"></i>
                        John Doe at 20.04.2024: Lorem Ipsum is simply dummy text of the printing and typesetting industry...
                        <a href="#" target="_blank">
                            See more
                        </a>
                    </li>
                    <li class="list-group-item">
                        <i class="fa-solid fa-reply"></i>
                        User Webmaster at 21.04.2024: Lorem Ipsum is simply dummy text of the printing and typesetting industry...
                        <a href="#" target="_blank">
                            See more
                        </a>
                    </li>
                </ul>
            </div>
            <div class="my-3">
                <canvas id="contact_combo_chart"></canvas>
            </div>
            <div class="my-3">
                <canvas id="contact_pie_chart"></canvas>
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
    // Combo bar chart
    const contactBarChartCtx = document.getElementById('contact_combo_chart').getContext('2d');
    const contactBarChartData = {
        labels: ['Subject A', 'Subject B', 'Subject C'],
        datasets: [
            {
                label: 'Messages',
                type: 'bar',
                data: [120, 200, 180],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Responses',
                type: 'bar',
                data: [100, 150, 130],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }
        ]
    };
    const contactBarChartOptions = {
        aspectRatio: 1.75,
        plugins: {
            title: {
                display: true,
                text: 'Contact messages vs. responses over time'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };
    const contactBarChart = new Chart(contactBarChartCtx, {
        type: 'bar',
        data: contactBarChartData,
        options: contactBarChartOptions
    });

    // Pie chart
    const contactPieChartCtx = document.getElementById('contact_pie_chart').getContext('2d');
    const contactPieChartData = {
        labels: ['Messages', 'Responses'],
        datasets: [{
            label: 'Messages',
            data: [402, 98],
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
    const contactPieOptions = {
        aspectRatio: 1.75,
        plugins: {
            title: {
                display: true,
                text: 'Respond ratio'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };
    const contactPieChart = new Chart(contactPieChartCtx, {
        type: 'pie',
        data: contactPieChartData,
        options: contactPieOptions
    });
</script>
