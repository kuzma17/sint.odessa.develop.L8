<canvas id="{{$id}}" width="400" height="200"></canvas>
<script>
    $(function () {
        var ctx = document.getElementById("{{$id}}").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $data['labelArray'] !!},
                datasets: [
                    {
                        label: "Orders",
                        borderColor: "rgba(220,220,220,1)",
                        borderWidth: 1,
                        backgroundColor: "rgba(0,255,0,0.2)",
                        data: {!! $data['dataArray'] !!}
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    });
</script>