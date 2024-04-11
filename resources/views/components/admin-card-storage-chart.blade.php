<div class="component component-storage-chart">
    <div class="card">
        <div class="card-body">
            <div id="storage_pie_chart" style=""></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        const data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Work',     11],
            ['Eat',      2],
            ['Commute',  2],
            ['Watch TV', 2],
            ['Sleep',    7]
        ]);

        const options = {
            title: 'Storage used vs total'
        };

        const chart = new google.visualization.PieChart(document.getElementById('storage_pie_chart'));

        chart.draw(data, options);
    }
</script>
