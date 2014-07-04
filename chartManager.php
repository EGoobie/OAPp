  <script src="js\highcharts.js"></script>
  <!--<script src="js\dark-unica.js"></script>-->
  <script src="js\exporting.js"></script>
<script type="text/javascript">
  $(function () {
        $('#remBeverages').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Cases Remaining'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                lineWidth: 0,
               minorGridLineWidth: 0,
                  lineColor: 'transparent',
                labels: {
                      enabled: false
                   },
               minorTickLength: 0,
               tickLength: 0
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Items'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px"></span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true,
                positioner: function () {
	    		        return { x: 80, y: 35 };
	    	        }
            },
            credits: {
              enabled: false
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [<?php $data->prepRemainingChart('1');?>]
        });
    });

  </script>