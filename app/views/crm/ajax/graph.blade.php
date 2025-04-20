<script>
/*$(function () {
    var jan_total = {{ $jan_total }};
    var feb_total = {{ $feb_total }};
    var mar_total = {{ $mar_total }};
    var apr_total = {{ $apr_total }};
    var may_total = {{ $may_total }};
    var jun_total = {{ $jun_total }};
    var jul_total = {{ $jul_total }};
    var aug_total = {{ $aug_total }};
    var sep_total = {{ $sep_total }};
    var oct_total = {{ $oct_total }};
    var nov_total = {{ $nov_total }};
    var dec_total = {{ $dec_total }};
//alert(sep_total)
    var bar = new GraphBar({
        attachTo: '#graph',
        special: 'combo',
        height: 475,
        width: '100%',
        yDist: 30,
        xDist: 50,
        showPoints: false,
        xGrid: false,
        legend: true,
        averageLineColor:false,
        points: [
          [jan_total, feb_total, mar_total, apr_total, may_total, jun_total, jul_total, aug_total, sep_total, oct_total, nov_total, dec_total],
          [32, 15, 75, 20, 45, 90, 52, 15, 75, 20, 45, 90]
        ],
        colors: ['blue', 'purple'],
        dataNames: ['Total', 'Won'],
        xName: 'Month',
        design: {
            tooltipColor: '#fff',
            gridColor: 'black',
            tooltipBoxColor: 'green',
            averageLineColor: 'green',
        }
    });
  bar.init();
});*/
</script>

<script>
$(function () {
    var jan_total = {{ $jan_total }};
    var feb_total = {{ $feb_total }};
    var mar_total = {{ $mar_total }};
    var apr_total = {{ $apr_total }};
    var may_total = {{ $may_total }};
    var jun_total = {{ $jun_total }};
    var jul_total = {{ $jul_total }};
    var aug_total = {{ $aug_total }};
    var sep_total = {{ $sep_total }};
    var oct_total = {{ $oct_total }};
    var nov_total = {{ $nov_total }};
    var dec_total = {{ $dec_total }};

    //var months = {{ $months }};

    var bar = new GraphBar({
        attachTo: '#graph',
        special: 'combo',
        height: 475,
        width: '100%',
        yDist: 40,
        xDist: 105,
        showPoints: false,
        xGrid: false,
        legend: false,
        averageLineColor:false,
        points: [jan_total, feb_total, mar_total, apr_total, may_total, jun_total, jul_total, aug_total, sep_total, oct_total, nov_total, dec_total],
        x: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
        //x: [ months ],
        colors: ['red'],
        //dataNames: ['Won'],
        xName: 'Month',
        tooltipWidth: 15,
        design: {
            //tooltipColor: '#fff',
            gridColor: 'none',
            tooltipBoxColor: 'none',
            averageLineColor: 'none',
        }
    });
  bar.init();
});
</script>

<div id="graph"></div>
