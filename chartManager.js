
  $(document).ready(function () {
     $.getJSON('/phpClasses/getChartData.php', {"catID": '1',"chartType": 'remaining'}, function(data) {
        remainingChart = new Highcharts.Chart( {
            chart: {
              renderTo:'remBeverages',
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
          series: data
        });

      });

      $.getJSON('/phpClasses/getChartData.php', {"catID": '2',"chartType": 'remaining'}, function(data) {
        remainingChart = new Highcharts.Chart( {
            chart: {
              renderTo:'remFood',
                type: 'column'
            },
            title: {
                text: 'Food Items Remaining'
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
          series: data
        });

      });

    Highcharts.setOptions({
      global: {
        useUTC: false
      }
    });

    $.getJSON('/phpClasses/getChartData.php', {"catID": '1',"chartType": 'timeline',"days":'35'}, function(data) {
        remainingChart = new Highcharts.Chart( {
            chart: {
              renderTo:'timeline',
                type: 'bubble',
                zoomType:"xy"
            },

            yAxis: {
                lineWidth: 0,
               minorGridLineWidth: 0,
                  lineColor: 'transparent',
                labels: {
                      enabled: false
                   },
               minorTickLength: 0,
               tickLength: 0,
             title:{ text:''}
            },

            xAxis: {
                type: 'datetime',

                title: {
                    text: 'Time'
                }
            },
            subtitle: {
              align: 'left',
              text: 'Click and drag or pinch to zoom'
            },
           tooltip: {
               headerFormat: '<b>{series.name}</b><br>',
               pointFormat: 'Items Removed: {point.z}'

           },
           credits: {
              enabled: false
            },

	        title: {
	    	    text: 'Timeline of Beverage Item Removal'
	        },
          series: data

        });

    });

    timeLineChartGen(1);
 });

  function updateTimeline(days){
    timeLineChartGen(days);
  }

  function timeLineChartGen(days){
    $.getJSON('/phpClasses/getChartData.php', {"catID": '1',"chartType": 'timeline',"days": days}, function(data) {
        remainingChart = new Highcharts.Chart( {
            chart: {
              renderTo:'timeline',
                type: 'bubble',
                zoomType:"xy"
            },

            yAxis: {
                lineWidth: 0,
               minorGridLineWidth: 0,
                  lineColor: 'transparent',
                labels: {
                      enabled: false
                   },
               minorTickLength: 0,
               tickLength: 0,
             title:{ text:''}
            },

            xAxis: {
                type: 'datetime',

                title: {
                    text: 'Time'
                }
            },
            subtitle: {
              align: 'left',
              text: 'Click and drag or pinch to zoom'
            },
           tooltip: {
               headerFormat: '<b>{series.name}</b><br>',
               pointFormat: 'Items Removed: {point.z}'

           },
           credits: {
              enabled: false
            },

	        title: {
	    	    text: 'Timeline of Beverage Item Removal'
	        },
          series: data

        });

    });
  }
