<div class="card">
    <div class="card-body">
        <h5>
            Content
        </h5>
        <div class="card-content">
            <div class="my-3">
                <span>Types</span>:
                <span class="badge text-bg-primary">Page</span>
                <span class="badge text-bg-primary">Article</span>
            </div>
            <div class="my-3">
                <span>Visibility</span>:
                <span class="badge text-bg-success">Published</span>
                <span class="badge text-bg-info">Draft</span>
                <span class="badge text-bg-warning">Scheduled</span>
                <span class="badge text-bg-danger">Trashed</span>
            </div>
            <div class="my-3">
                <span>Categories</span>:
                <span class="badge text-bg-primary">Category A</span>
                <span class="badge text-bg-primary">Category B</span>
                <span class="badge text-bg-primary">Category C</span>
            </div>
            <div class="my-3">
                <ul class="list-group">
                    <li class="list-group-item">
                        3 pages | 15 blog articles | 30 views
                        <i class="fa-solid fa-newspaper"></i>
                    </li>
                    <li class="list-group-item">
                        <span class="badge text-bg-primary">Category A</span>
                        <span class="badge text-bg-success">Published</span>
                        Article title:
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry...
                        <a href="#" target="_blank">
                            See more
                        </a>
                        <div>
                            0 like | 0 dislikes | 0 rating | 0 shares
                        </div>
                    </li>
                    <li class="list-group-item">
                        <span class="badge text-bg-primary">Page</span>
                        <span class="badge text-bg-info">Draft</span>
                        Page title:
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry...
                        <a href="#" target="_blank">
                            See more
                        </a>
                    </li>
                    <li class="list-group-item">
                        <span class="badge text-bg-primary">Category B</span>
                        <span class="badge text-bg-warning">Scheduled</span>
                        Article title:
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry...
                        <a href="#" target="_blank">
                            See more
                        </a>
                        <div>
                            0 like | 0 dislikes | 0 rating | 0 shares
                        </div>
                    </li>
                </ul>
            </div>
            <div class="row my-3">
                <div class="col-6">
                    <canvas id="content_by_type_combo_chart"></canvas>
                </div>
                <div class="col-6">
                    <canvas id="article_by_category_combo_chart"></canvas>
                </div>
            </div>
            <div class="my-3">
                <canvas id="article_line_chart"></canvas>
            </div>
            <div class="my-3">
                <span>Types</span>:
                <span class="badge text-bg-primary">Comment</span>
                <span class="badge text-bg-primary">Reply</span>
            </div>
            <div class="my-3">
                <span>Status</span>:
                <span class="badge text-bg-info">Pending</span>
                <span class="badge text-bg-success">Approved</span>
                <span class="badge text-bg-warning">Spam</span>
                <span class="badge text-bg-danger">Trashed</span>
            </div>
            <div class="my-3">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge text-bg-primary">Comment</span>
                        <span class="badge text-bg-success">Approved</span>
                        John Doe at 20.04.2024: Lorem Ipsum is simply dummy text of the printing and typesetting industry...
                        <a href="#" target="_blank">
                            See more
                        </a>
                        <div>
                            0 like | 0 dislikes
                        </div>
                    </li>
                    <li class="list-group-item">
                        <span class="badge text-bg-primary">Comment</span>
                        <span class="badge text-bg-info">Pending</span>
                        John Doe at 19.04.2024: Lorem Ipsum is simply dummy text of the printing and typesetting industry...
                        <a href="#" target="_blank">
                            See more
                        </a>
                        <div>
                            0 like | 0 dislikes
                        </div>
                    </li>
                    <li class="list-group-item">
                        <span class="badge text-bg-primary">Comment</span>
                        <span class="badge text-bg-danger">Trashed</span>
                        John Doe at 18.04.2024: Lorem Ipsum is simply dummy text of the printing and typesetting industry...
                        <a href="#" target="_blank">
                            See more
                        </a>
                        <div>
                            0 like | 0 dislikes
                        </div>
                    </li>
                </ul>
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
    // Content bar chart by type and visibility
    const contentByTypeBarChartCtx = document.getElementById('content_by_type_combo_chart').getContext('2d');
    const contentByTypeBarChartData = {
        labels: ['Page', 'Article'],
        datasets: [
            {
                label: 'Published',
                type: 'bar',
                data: [120, 200],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Draft',
                type: 'bar',
                data: [80, 140],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Scheduled',
                type: 'bar',
                data: [50, 90],
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            },
            {
                label: 'Trashed',
                type: 'bar',
                data: [30, 60],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
        ]
    };
    const contentByTypeBarChartOptions = {
        aspectRatio: 1.50,
        plugins: {
            title: {
                display: true,
                text: 'Content by types and visibility'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };
    const contentByTypeBarChart = new Chart(contentByTypeBarChartCtx, {
        type: 'bar',
        data: contentByTypeBarChartData,
        options: contentByTypeBarChartOptions
    });

    // Articles bar chart by category
    const articleByCategoryBarChartCtx = document.getElementById('article_by_category_combo_chart').getContext('2d');
    const articleByCategoryBarChartData = {
        labels: ['Category A', 'Category B', 'Category C'],
        datasets: [
            {
                label: 'Content',
                type: 'bar',
                data: [15, 35, 50],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
        ]
    };
    const articleByCategoryBarChartOptions = {
        aspectRatio: 1.50,
        plugins: {
            title: {
                display: true,
                text: 'Article by categories'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };
    const articleByCategoryBarChart = new Chart(articleByCategoryBarChartCtx, {
        type: 'bar',
        data: articleByCategoryBarChartData,
        options: articleByCategoryBarChartOptions
    });

    // Articles line chart
    const articleLineChartCtx = document.getElementById('article_line_chart').getContext('2d');
    const articleLineChartData = {
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
            label: 'Articles',
            data: [100, 150, 200, 223, 150, 196, 250, 125, 175, 199, 149, 201],
            borderColor: 'rgba(54, 162, 235)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderWidth: 1
        }]
    };
    const articleLineChartOptions = {
        aspectRatio: 1.50,
        plugins: {
            title: {
                display: true,
                text: 'Articles over time'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };
    const articleLineChart = new Chart(articleLineChartCtx, {
        type: 'line',
        data: articleLineChartData,
        options: articleLineChartOptions
    });
</script>
