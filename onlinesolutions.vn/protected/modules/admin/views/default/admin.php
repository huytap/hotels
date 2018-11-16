<?php
$this_month = array('year' => date('Y'), 'month' => date('m'));
$month = date('Y-m');
$last_month = array('year' => date('Y'), 'month' => date('m', strtotime("$month -1month")));
$this_month_booking = Bookings::model()->getOrderByMonth($this_month,Yii::app()->session['hotel']);
$last_month_booking = Bookings::model()->getOrderByMonth($last_month,Yii::app()->session['hotel']);

$contact_this_month = date('Y-m');
$contact_last_month = date('Y-m', strtotime("$month -1month"));
?>
<div class="padding-md">
    <div class="row">
        <h3>Statistic <?=date('Y');?></h3>
        <div class="done"><i class="fa fa-square" style="color:rgba(220,220,220,1);"></i> Booking Done</div>
        <div class="cancel"><i class="fa fa-square" style="color:rgba(151,187,205,1);"></i> Booking Cancelled</div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <canvas id="canvas" height="300" width="600"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">        
        </div>
    </div>
</div>
<!-- Flot -->
<script src='<?php echo Yii::app()->theme->baseUrl?>/js/jquery.flot.min.js'></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/js/app/app_dashboard.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/js/Chart.min.js"></script>
<script>
<?php
    $filter['year'] = date('Y');
    $arr_data = array();
    /*done*/
    for($i=1;$i<=12;$i++){
        $filter['month']=$i;
        $data = Bookings::model()->getOrderByMonth($filter);
        if(!$data['total']){
            array_push($arr_data, 0);    
        }else{
            array_push($arr_data, $data['total']);
        }
        
    }
    $data_by_month = implode(',', $arr_data);

    /*cancel*/
    $arr_data2 = array();
    for($i=1;$i<=12;$i++){
        $filter['month']=$i;
        $data = Bookings::model()->getOrderByMonth($filter, 'cancelled');
        if(!$data['total']){
            array_push($arr_data2, 0);    
        }else{
            array_push($arr_data2, $data['total']);
        }
        
    }
    $data_by_month2 = implode(',', $arr_data2);?>
    var lineChartData = {
        labels : ["January","February","March","April","May","June","July", "August", "September", "October", "November", "December"],
        datasets : [
            {
                label: "Ok",
                fillColor : "rgba(220,220,220,0.2)",
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                data : [<?php echo $data_by_month?>]
            },
            {
                label: "Cancel",
                fillColor : "rgba(151,187,205,0.2)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
                data : [<?php echo $data_by_month2?>]
            }
        ]

    }

    window.onload = function(){
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).Line(lineChartData, {
            responsive: true
        });
    }

</script>