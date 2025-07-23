(function($) {
    "use strict";

    // Smoothed Line Chart
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("smoothed_line_chart");
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX:true
        }));
        
        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
            behavior: "none"
        }));
        cursor.lineY.set("visible", false);
        
        
        // Generate random data
        var date = new Date();
        date.setHours(0, 0, 0, 0);
        var value = 100;
        
        function generateData() {
            value = Math.round((Math.random() * 10 - 5) + value);
            am5.time.add(date, "day", 1);
            return {
                date: date.getTime(),
                value: value
            };
        }
        
        function generateDatas(count) {
            var data = [];
            for (var i = 0; i < count; ++i) {
                data.push(generateData());
            }
            return data;
        }
        
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
            maxDeviation: 0.5,
            baseInterval: {
                timeUnit: "day",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(root, {
            pan:"zoom"
            }),
            tooltip: am5.Tooltip.new(root, {})
        }));
        
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            maxDeviation:1,
            renderer: am5xy.AxisRendererY.new(root, {
                pan:"zoom"
            })
        }));
        
        
        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.SmoothedXLineSeries.new(root, {
            name: "Series",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            valueXField: "date",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{valueY}"
            })
        }));
        
        series.fills.template.setAll({
            visible: true,
            fillOpacity: 0.2
        });
        
        series.bullets.push(function() {
            return am5.Bullet.new(root, {
                locationY: 0,
                sprite: am5.Circle.new(root, {
                    radius: 4,
                    stroke: root.interfaceColors.get("background"),
                    strokeWidth: 2,
                    fill: series.get("fill")
                })
            });
        });
        
        // Add scrollbar
        // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
        chart.set("scrollbarX", am5.Scrollbar.new(root, {
          orientation: "horizontal"
        }));
        
        var data = generateDatas(50);
        series.data.setAll(data);
        
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);
    }); // end am5.ready()


    // Comparing Different
    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("comparing_different");
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX:true
        }));
        
        chart.get("colors").set("step", 3);
        
        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);
        
        
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
            maxDeviation: 0.3,
            baseInterval: {
                timeUnit: "day",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(root, {}),
            tooltip: am5.Tooltip.new(root, {})
        }));
        
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            maxDeviation: 0.3,
            renderer: am5xy.AxisRendererY.new(root, {})
        }));
        
        
        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.LineSeries.new(root, {
            name: "Series 1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value1",
            valueXField: "date",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{valueX}: {valueY}\n{previousDate}: {value2}"
            })
        }));
        
        series.strokes.template.setAll({
            strokeWidth: 2
        });
        
        series.get("tooltip").get("background").set("fillOpacity", 0.5);
        
        var series2 = chart.series.push(am5xy.LineSeries.new(root, {
            name: "Series 2",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value2",
            valueXField: "date"
        }));
        series2.strokes.template.setAll({
            strokeDasharray: [2, 2],
            strokeWidth: 2
        });
        
        // Set date fields
        // https://www.amcharts.com/docs/v5/concepts/data/#Parsing_dates
        root.dateFormatter.setAll({
            dateFormat: "yyyy-MM-dd",
            dateFields: ["valueX"]
        });
        
        
        // Set data
        var data = [{
            date: new Date(2019, 5, 12).getTime(),
            value1: 50,
            value2: 48,
            previousDate: new Date(2019, 5, 5)
        }, {
            date: new Date(2019, 5, 13).getTime(),
            value1: 53,
            value2: 51,
            previousDate: "2019-05-06"
        }, {
            date: new Date(2019, 5, 14).getTime(),
            value1: 56,
            value2: 58,
            previousDate: "2019-05-07"
        }, {
            date: new Date(2019, 5, 15).getTime(),
            value1: 52,
            value2: 53,
            previousDate: "2019-05-08"
        }, {
            date: new Date(2019, 5, 16).getTime(),
            value1: 48,
            value2: 44,
            previousDate: "2019-05-09"
        }, {
            date: new Date(2019, 5, 17).getTime(),
            value1: 47,
            value2: 42,
            previousDate: "2019-05-10"
        }, {
            date: new Date(2019, 5, 18).getTime(),
            value1: 59,
            value2: 55,
            previousDate: "2019-05-11"
        }]
        
        series.data.setAll(data);
        series2.data.setAll(data);
        
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        series2.appear(1000);
        chart.appear(1000, 100);
        
    }); // end am5.ready()


    // Images As Categories
    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("images_as_categories");
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: "panX",
            wheelY: "zoomX",
            layout: root.verticalLayout
        }));
        
        // Data
        var colors = chart.get("colors");
        
        var data = [{
            country: "US",
            visits: 725,
            icon: "https://www.amcharts.com/wp-content/uploads/flags/united-states.svg",
            columnSettings: { fill: colors.next() }
        }, {
            country: "UK",
            visits: 625,
            icon: "https://www.amcharts.com/wp-content/uploads/flags/united-kingdom.svg",
            columnSettings: { fill: colors.next() }
        }, {
            country: "China",
            visits: 602,
            icon: "https://www.amcharts.com/wp-content/uploads/flags/china.svg",
            columnSettings: { fill: colors.next() }
        }, {
            country: "Japan",
            visits: 509,
            icon: "https://www.amcharts.com/wp-content/uploads/flags/japan.svg",
            columnSettings: { fill: colors.next() }
        }, {
            country: "Germany",
            visits: 322,
            icon: "https://www.amcharts.com/wp-content/uploads/flags/germany.svg",
            columnSettings: { fill: colors.next() }
        }, {
            country: "France",
            visits: 214,
            icon: "https://www.amcharts.com/wp-content/uploads/flags/france.svg",
            columnSettings: { fill: colors.next() }
        }, {
            country: "India",
            visits: 204,
            icon: "https://www.amcharts.com/wp-content/uploads/flags/india.svg",
            columnSettings: { fill: colors.next() }
        }, {
            country: "Spain",
            visits: 198,
            icon: "https://www.amcharts.com/wp-content/uploads/flags/spain.svg",
            columnSettings: { fill: colors.next() }
        }, {
            country: "Netherlands",
            visits: 165,
            icon: "https://www.amcharts.com/wp-content/uploads/flags/netherlands.svg",
            columnSettings: { fill: colors.next() }
        }, {
            country: "South Korea",
            visits: 93,
            icon: "https://www.amcharts.com/wp-content/uploads/flags/south-korea.svg",
            columnSettings: { fill: colors.next() }
        }, {
            country: "Canada",
            visits: 41,
            icon: "https://www.amcharts.com/wp-content/uploads/flags/canada.svg",
            columnSettings: { fill: colors.next() }
        }];
        
        
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, {
            minGridDistance: 30
        })
        
        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            categoryField: "country",
            renderer: xRenderer,
            bullet: function(root, axis, dataItem) {
                return am5xy.AxisBullet.new(root, {
                location: 0.5,
                    sprite: am5.Picture.new(root, {
                        width: 24,
                        height: 24,
                        centerY: am5.p50,
                        centerX: am5.p50,
                        src: dataItem.dataContext.icon
                    })
                });
            }
        }));
        
        xRenderer.grid.template.setAll({
            location: 1
        })
        
        xRenderer.labels.template.setAll({
            paddingTop: 20
        });
        
        xAxis.data.setAll(data);
        
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {
                strokeOpacity: 0.1
            })
        }));
        
        
        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "visits",
            categoryXField: "country"
        }));
        
        series.columns.template.setAll({
            tooltipText: "{categoryX}: {valueY}",
            tooltipY: 0,
            strokeOpacity: 0,
            templateField: "columnSettings"
        });
        
        series.data.setAll(data);
        
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear();
        chart.appear(1000, 100);
        
    }); // end am5.ready()

    // Column with Rotated Labels
    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("column_with_rotated_labels");
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true
        }));
        
        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);
        
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
        xRenderer.labels.template.setAll({
            rotation: -90,
            centerY: am5.p50,
            centerX: am5.p100,
            paddingRight: 15
        });
        
        xRenderer.grid.template.setAll({
            location: 1
        })
        
        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            maxDeviation: 0.3,
            categoryField: "country",
            renderer: xRenderer,
            tooltip: am5.Tooltip.new(root, {})
        }));
        
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            maxDeviation: 0.3,
            renderer: am5xy.AxisRendererY.new(root, {
                strokeOpacity: 0.1
            })
        }));
        
        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: "Series 1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            sequencedInterpolation: true,
            categoryXField: "country",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{valueY}"
            })
        }));
        
        series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
        series.columns.template.adapters.add("fill", function(fill, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
        });
        
        series.columns.template.adapters.add("stroke", function(stroke, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
        });
        
        // Set data
        var data = [{
            country: "USA",
            value: 2025
        }, {
            country: "China",
            value: 1882
        }, {
            country: "Japan",
            value: 1809
        }, {
            country: "Germany",
            value: 1322
        }, {
            country: "UK",
            value: 1122
        }, {
            country: "France",
            value: 1114
        }, {
            country: "India",
            value: 984
        }, {
            country: "Spain",
            value: 711
        }, {
            country: "Netherlands",
            value: 665
        }, {
            country: "South Korea",
            value: 443
        }, {
            country: "Canada",
            value: 441
        }];
        
        xAxis.data.setAll(data);
        series.data.setAll(data);
        
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);
        
    }); // end am5.ready()

    
    // XY Chart with Date-Based Axis
    am5.ready(function() {
        
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("xy_chart");
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        root.dateFormatter.setAll({
            dateFormat: "yyyy-MM-dd",
            dateFields: ["valueX"]
        });
        
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelY: "zoomXY"
        }));
        
        chart.get("colors").set("step", 2);
        
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
            baseInterval: { timeUnit: "day", count: 1 },
            renderer: am5xy.AxisRendererX.new(root, { minGridDistance: 50 }),
            tooltip: am5.Tooltip.new(root, {})
        }));
        
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {}),
            tooltip: am5.Tooltip.new(root, {})
        }));
        
        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series0 = chart.series.push(am5xy.LineSeries.new(root, {
          calculateAggregates: true,
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "ay",
            valueXField: "date",
            valueField: "aValue",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{valueX}, y: {valueY}, value: {value}"
            })
        }));
        
        // Add bullet
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/#Bullets
        var circleTemplate = am5.Template.new({});
            series0.bullets.push(function() {
            var graphics = am5.Circle.new(root, {
                fill: series0.get("fill"),
            }, circleTemplate);
            return am5.Bullet.new(root, {
                sprite: graphics
            });
        });
        
        // Add heat rule
        // https://www.amcharts.com/docs/v5/concepts/settings/heat-rules/
        series0.set("heatRules", [{
            target: circleTemplate,
            min: 3,
            max: 35,
            dataField: "value",
            key: "radius"
        }]);
        
        var starTemplate = am5.Template.new({});
        // Create second series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series1 = chart.series.push(am5xy.LineSeries.new(root, {
            calculateAggregates: true,
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "by",
            valueXField: "date",
            valueField: "bValue",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{valueX}, y: {valueY}, value: {value}"
            })
        }));
        
        // Add bullet
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/#Bullets
        series1.bullets.push(function() {
            var graphics = am5.Star.new(root, {
                fill: series1.get("fill"),
                spikes: 4,
                innerRadius: am5.percent(70),
            }, starTemplate);
            return am5.Bullet.new(root, {
                sprite: graphics
            });
        });
        
        
        // Add heat rule
        // https://www.amcharts.com/docs/v5/concepts/settings/heat-rules/
        series1.set("heatRules", [{
            target: starTemplate,
            min: 3,
            max: 50,
            dataField: "value",
            key: "radius"
        }]);
        
        series0.strokes.template.set("strokeOpacity", 0);
        series1.strokes.template.set("strokeOpacity", 0);
        
        series0.data.processor = am5.DataProcessor.new(root, {
            dateFields: ["date"], dateFormat: "yyyy-MM-dd"
        });
        
        series1.data.processor = am5.DataProcessor.new(root, {
            dateFields: ["date"], dateFormat: "yyyy-MM-dd"
        });
        
        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        chart.set("cursor", am5xy.XYCursor.new(root, {
            xAxis: xAxis,
            yAxis: yAxis,
            behavior: "zoomXY",
            snapToSeries: [series0, series1]
        }));
        
        // Add scrollbars
        // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
        chart.set("scrollbarX", am5.Scrollbar.new(root, {
            orientation: "horizontal"
        }));
        
        chart.set("scrollbarY", am5.Scrollbar.new(root, {
            orientation: "vertical"
        }));
        
        var data = [{
            "date": "2015-01-01",
            "ay": 6.5,
            "by": 2.2,
            "aValue": 15,
            "bValue": 10
        }, {
            "date": "2015-01-02",
            "ay": 12.3,
            "by": 4.9,
            "aValue": 8,
            "bValue": 3
        }, {
            "date": "2015-01-03",
            "ay": 12.3,
            "by": 5.1,
            "aValue": 16,
            "bValue": 4
        }, {
            "date": "2015-01-04",
            "ay": 2.8,
            "by": 13.3,
            "aValue": 9,
            "bValue": 13
        }, {
            "date": "2015-01-05",
            "ay": 3.5,
            "by": 6.1,
            "aValue": 5,
            "bValue": 2
        }, {
            "date": "2015-01-06",
            "ay": 5.1,
            "by": 8.3,
            "aValue": 10,
            "bValue": 17
        }, {
            "date": "2015-01-07",
            "ay": 6.7,
            "by": 10.5,
            "aValue": 3,
            "bValue": 10
        }, {
            "date": "2015-01-08",
            "ay": 8,
            "by": 12.3,
            "aValue": 5,
            "bValue": 13
        }, {
            "date": "2015-01-09",
            "ay": 8.9,
            "by": 4.5,
            "aValue": 8,
            "bValue": 11
        }, {
            "date": "2015-01-10",
            "ay": 9.7,
            "by": 15,
            "aValue": 15,
            "bValue": 10
        }, {
            "date": "2015-01-11",
            "ay": 10.4,
            "by": 10.8,
            "aValue": 1,
            "bValue": 11
        }, {
            "date": "2015-01-12",
            "ay": 1.7,
            "by": 19,
            "aValue": 12,
            "bValue": 3
        }]
        
        series0.data.setAll(data);
        series1.data.setAll(data);
        
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series0.appear(1000);
        series1.appear(1000);
        
        chart.appear(1000, 100);
    }); // end am5.ready()


    // Variable Radius Pie Chart
    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("variable_radius_pie_chart");
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
          am5themes_Animated.new(root)
        ]);
        
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
        var chart = root.container.children.push(am5percent.PieChart.new(root, {
          layout: root.verticalLayout
        }));
        
        // Create series
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
        var series = chart.series.push(am5percent.PieSeries.new(root, {
            alignLabels: true,
            calculateAggregates: true,
            valueField: "value",
            categoryField: "category"
        }));
        
        series.slices.template.setAll({
            strokeWidth: 3,
            stroke: am5.color(0xffffff)
        });
        
        series.labelsContainer.set("paddingTop", 30)
        
        // Set up adapters for variable slice radius
        // https://www.amcharts.com/docs/v5/concepts/settings/adapters/
        series.slices.template.adapters.add("radius", function (radius, target) {
            var dataItem = target.dataItem;
            var high = series.getPrivate("valueHigh");
            
            if (dataItem) {
                var value = target.dataItem.get("valueWorking", 0);
                return radius * value / high
            }
            return radius;
        });
        
        // Set data
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
        series.data.setAll([{
            value: 10,
            category: "One"
        }, {
            value: 9,
            category: "Two"
        }, {
            value: 6,
            category: "Three"
        }, {
            value: 5,
            category: "Four"
        }, {
            value: 4,
            category: "Five"
        }, {
            value: 3,
            category: "Six"
        }]);
        
        // Create legend
        // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
        var legend = chart.children.push(am5.Legend.new(root, {
            centerX: am5.p50,
            x: am5.p50,
            marginTop: 15,
            marginBottom: 15
        }));
        
        legend.data.setAll(series.dataItems);
        
        // Play initial series animation
        // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
        series.appear(1000, 100);
    }); // end am5.ready()

    // Pie Chart
    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("pie_chart");
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
        var chart = root.container.children.push(
            am5percent.PieChart.new(root, {
                endAngle: 270
            })
        );
        
        // Create series
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
        var series = chart.series.push(
            am5percent.PieSeries.new(root, {
                valueField: "value",
                categoryField: "category",
                endAngle: 270
            })
        );
        
        series.states.create("hidden", {
            endAngle: -90
        });
        
        // Set data
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
        series.data.setAll([{
            category: "Lithuania",
            value: 501.9
        }, {
            category: "Czechia",
            value: 301.9
        }, {
            category: "Ireland",
            value: 201.1
        }, {
            category: "Germany",
            value: 165.8
        }, {
            category: "Australia",
            value: 139.9
        }, {
            category: "Austria",
            value: 128.3
        }, {
            category: "UK",
            value: 99
        }]);
        
        series.appear(1000, 100);
    }); // end am5.ready()

    // Bubble Chart
    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("bubble_chart");
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelY: "zoomXY",
            pinchZoomX:true,
            pinchZoomY:true
        }));
        
        chart.get("colors").set("step", 2);
        
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererX.new(root, { minGridDistance: 50 }),
            tooltip: am5.Tooltip.new(root, {})
        }));
        
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {}),
            tooltip: am5.Tooltip.new(root, {})
        }));
        
        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series0 = chart.series.push(am5xy.LineSeries.new(root, {
            calculateAggregates: true,
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "y",
            valueXField: "x",
            valueField: "value",
            tooltip: am5.Tooltip.new(root, {
                labelText: "x: {valueX}, y: {valueY}, value: {value}"
            })
        }));
        
        
        // Add bullet
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/#Bullets
        var circleTemplate = am5.Template.new({});
            series0.bullets.push(function() {
            var graphics = am5.Circle.new(root, {
                fill: series0.get("fill"),
            }, circleTemplate);
            return am5.Bullet.new(root, {
                sprite: graphics
            });
        });
        
        // Add heat rule
        // https://www.amcharts.com/docs/v5/concepts/settings/heat-rules/
        series0.set("heatRules", [{
            target: circleTemplate,
            min: 3,
            max: 35,
            dataField: "value",
            key: "radius"
        }]);
        
        
        // Create second series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series1 = chart.series.push(am5xy.LineSeries.new(root, {
            calculateAggregates: true,
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "y2",
            valueXField: "x2",
            valueField: "value",
            tooltip: am5.Tooltip.new(root, {
                labelText: "x: {valueX}, y: {valueY}, value: {value}"
            })
        }));
        
        // Add bullet
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/#Bullets
        var starTemplate = am5.Template.new({});
            series1.bullets.push(function() {
            var graphics = am5.Star.new(root, {
                fill: series1.get("fill"),
                spikes: 8,
                innerRadius: am5.percent(70),
            }, starTemplate);
            return am5.Bullet.new(root, {
                sprite: graphics
            });
        });
        
        // Add heat rule
        // https://www.amcharts.com/docs/v5/concepts/settings/heat-rules/
        series1.set("heatRules", [{
            target: starTemplate,
            min: 3,
            max: 50,
            dataField: "value",
            key: "radius"
        }]);
        
        series0.strokes.template.set("strokeOpacity", 0);
        series1.strokes.template.set("strokeOpacity", 0);
        
        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        chart.set("cursor", am5xy.XYCursor.new(root, {
            xAxis: xAxis,
            yAxis: yAxis,
            snapToSeries: [series0, series1]
        }));
        
        // Add scrollbars
        // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
        chart.set("scrollbarX", am5.Scrollbar.new(root, {
          orientation: "horizontal"
        }));
        
        chart.set("scrollbarY", am5.Scrollbar.new(root, {
          orientation: "vertical"
        }));
        
        var data = [{
            "y": 10,
            "x": 14,
            "value": 59,
            "y2": -5,
            "x2": -3,
            "value2": 44
        }, {
            "y": 5,
            "x": 3,
            "value": 50,
            "y2": -15,
            "x2": -8,
            "value2": 12
        }, {
            "y": -10,
            "x": 8,
            "value": 19,
            "y2": -4,
            "x2": 6,
            "value2": 35
        }, {
            "y": -6,
            "x": 5,
            "value": 65,
            "y2": -5,
            "x2": -6,
            "value2": 168
        }, {
            "y": 15,
            "x": -4,
            "value": 92,
            "y2": -10,
            "x2": -8,
            "value2": 102
        }, {
            "y": 13,
            "x": 1,
            "value": 8,
            "y2": -2,
            "x2": 0,
            "value2": 41
        }, {
            "y": 1,
            "x": 6,
            "value": 35,
            "y2": 0,
            "x2": -3,
            "value2": 16
        }]
        
        series0.data.setAll(data);
        series1.data.setAll(data);
        
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series0.appear(1000);
        series1.appear(1000);
        
        chart.appear(1000, 100);
    }); // end am5.ready()

}(jQuery));