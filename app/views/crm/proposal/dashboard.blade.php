<script type="text/javascript">
/////////////barchar width height of canvas 2///////////////////
    var bspacing=25;
    var bardatapacing=50;
    var bspacing2=35;
    var bardatapacing2=10;
    var mobileView=function(){
            var width=$(window).innerWidth();
            var height=$(window).innerHeight();
           
            if(width<=480){
                $("#canvas").attr({"width":800,"height":600});
                $("#canvas2").attr({"width":800,"height":600});
                $("#chart-area3").attr({"width":200,"height":200});
                $("#chart-area3").css({"margin-left":"20px"});
                bspacing=40;
                bardatapacing=20;
                bspacing2=25;
                bardatapacing2=20;
            }
        }

    // $(document).ready(function(){
    //     $(window).load(mobileView());

    // });
</script>
<script>
  ///////////////pie data satrts here ///////////////
 var pieData = [
                {
                    value: <?php echo $due;?>,
                    color:"#F7464A",
                    highlight: "#FF5A5E",
                    label: "Due"
                },
                {
                    value: <?php echo $paid;?>,
                    color: "#46BFBD",
                    highlight: "#5AD3D1",
                    label: "Paid"
                },
                {
                    value: <?php echo $partiallyPaid;?>,
                    color: "#FDB45C",
                    highlight: "#FFC870",
                    label: "Partially Paid"
                },
               /* {
                    value: 40,
                    color: "#949FB1",
                    highlight: "#A8B3C5",
                    label: "Grey"
                },
                {
                    value: 120,
                    color: "#4D5360",
                    highlight: "#616774",
                    label: "Dark Grey"
                }*/

            ];


///////////////////////////////////////////////////////////////////
///////////////////////bar chart starts here //////////////////////
///////////////////////////////////////////////////////////////////
    var barChartData = {
        labels : ["DRAFT","SENT","VIEWED","ACCEPTED","LOST"],
        datasets : [
            {
                fillColor : "#0866C6",
                strokeColor : "#0866C6",
                highlightFill : "#0c90cf",
                highlightStroke : "#0c90cf",
                data : [<?php echo ($emailed!="")?$emailed:0;?>,<?php echo ($downloaded!="")?$downloaded:0;?>,<?php echo ($draft!="")?$draft:0;?>,<?php echo ($invoiced!="")?$invoiced:0;?>,<?php echo ($initiated!="")?$initiated:0;?>]
            }
        ]

    }
    var barChartData2 = {

        labels : ["This Day","This Month","This Year","Till Now"],
        datasets : [
            {

                fillColor : "#0866C6",
                strokeColor : "#0866C6",
                highlightFill : "#0c90cf",
                highlightStroke : "#0c90cf",
                data : [<?php echo ($todaysTotal!="")?$todaysTotal:0;?>,<?php echo ($monthsTotal!="")?$monthsTotal:0;?>,<?php echo ($yearsTotal!="")?$yearsTotal:0;?>,<?php echo ($tillNowTotal!="")? $tillNowTotal:0;?>]
            }
        ]

    }

 

    window.onload = function(){
         //////////pir sarts here//////////
    var ctxr = document.getElementById("chart-area3").getContext("2d");
                window.myPie = new Chart(ctxr).Pie(pieData);

//////////////bar satrs here//////////////
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx).Bar(barChartData, {
            barValueSpacing : bspacing2,//35,
            barDatasetSpacing : bardatapacing2,//10,
            label: "My First dataset",
            responsive : true
        });
        var ctx2 = document.getElementById("canvas2").getContext("2d");
        window.myBar = new Chart(ctx2).Bar(barChartData2, {
            barValueSpacing : bspacing,
            barDatasetSpacing : bardatapacing,
            label: "My Second dataset",
            responsive : true
        });
    }


         
</script>

<style>
    .bar-graph,.pie-chart{
        background-color: #fff;
        padding:10px;
        margin-bottom: 20px;
        border:1px solid #e2e2e2;
    }
    .bar-graph h3,.pie-chart h3{
        margin:5px;
        font-size: 18px;
    }
    .login-header{
        -webkit-border-radius: 4px 4px 0px 0px;
        -moz-border-radius: 4px 4px 0px 0px;
        -ms-border-radius: 4px 4px 0px 0px;
        -o-border-radius: 4px 4px 0px 0px;
        border-radius: 4px 4px 0px 0px;
    }
</style>
 
 
<div class="container">
    <div class="col-md-10 col-md-offset-1 col-xs-12">
        <div class="row" style="margin-top: 10px;">
            <div class="col-md-12">
                <div class="login-header col-md-12" style="margin-bottom:0px;padding:3px;">
                    <div  style="font-size:25px;padding:10px; background-color: #0866C6; color: white">
                        <i class="fa fa-file-text tiny-icon"></i> &nbsp;PROPOSAL STATISTICS
                    </div>

                    <div class="clearfix"></div>

                </div>
                <!-- login-header -->
                <div class="bar-graph">
                    <!-- <h3 align="right">Your Proposal Statistics <br/>Total <?php echo $total;?></h3> -->

                    <div style="width: 100%">
                        <canvas id="canvas" height="250" width="800"></canvas>
                    </div>
                </div>
<!--            bar-graph-->
            </div>
            <!-- col-md-12 -->
            <div class="col-md-12" style="margin:0px; padding:0px;">
                <div class="col-md-7 col-xs-12">
                    <div class="bar-graph">
                        <h3 align="right">Your Income Statistics</h3>
                            <div style="width: 100%">
                                <canvas id="canvas2" height="250" width="400"></canvas>
                            </div>
                        </div>
                        <!--            bar-graph-->
                </div>
                <!-- col-md-7 -->
                <div class="col-md-5 col-xs-12">
                    <div id="canvas-holder " class="pie-chart" >
                        <h3 align="right" style="margin-bottom:20px;">Invoice Statistics</h3>
                        <canvas id="chart-area3" width="300" height="300" style="" />
                    </div>
                    <div id="chartjs-tooltip"></div>
                </div>
                <!-- .col-md-5 -->
            </div>
            <!-- col-md-12 -->

        </div>
        <!--        .row-->
    </div>
    <div class="col-md-1" style="margin-top: 15px;"><span class="search_t">Reset</span></div>
</div>
<!--container col-md-12-->
 