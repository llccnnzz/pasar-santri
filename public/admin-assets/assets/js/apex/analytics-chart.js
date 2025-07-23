(function($) {
    "use strict";

    // Audience report Chart JS
    var options = {
        series: [
            {
                name: 'Total User',
                type: 'column',
                data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 45, 35]
            },
            {
                name: 'Bounce Rate',
                type: 'line',
                data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43, 27]
            },
            {
                name: 'Live Visitors',
                type: 'column',
                data: [40, 44, 44, 60, 26, 44, 80, 42, 84, 44, 90, 70]
            },
        ],
        chart: {
            toolbar: {
                show: true,
                tools: {
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false,
                },
            },
            type: 'line',
            height: 250,
        },
        grid: {
            borderColor: '#f1f2f7', 
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
        },
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [1, 1.1],
            curve: ['straight', 'smooth'],
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left', 
            fontWeight: 500,
            labels: {
                colors: ['#8c9097'],
            },
            markers: {
                radius: 2,
                offsetX: 0,
                offsetY: 1.5
            },
        },
        xaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        plotOptions: {
            bar: {
                columnWidth: "20%",
                borderRadius: 2
            }
        },
        colors: ["#5d87ff", '#ffc107', '#28c76f'],
    };
    var chart = new ApexCharts(document.querySelector("#audience_report"), options);
    chart.render();

    // Sessions Bounce
    var options = {
        series: [{
            name: 'Sessions',
            data: [30, 20, 30, 20, 40, 30, 40, 20, 30, 20, 30, 20,]
        }, {
            name: 'Bounce',
            data: [20, 10, 20, 10, 30, 20, 30, 20, 20, 10, 20, 10,]
        }],
        chart: {
            height: 250,
            type: 'area',
            toolbar: {
                show: true,
                tools: {
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false,
                },
            },
        },
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left', 
            fontWeight: 500,
            labels: {
                colors: ['#8c9097'],
            },
            markers: {
                radius: 2,
                offsetX: 0,
                offsetY: 1.5
            },
        },
        xaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: ['#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097', '#8c9097',],
                },
            }
        },
        grid: {
            borderColor: '#f1f2f7', 
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
    };
    var chart = new ApexCharts(document.querySelector("#sessions_bounce"), options);
    chart.render();

    // Sales By Locations Map JS
    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("sales_by_locations");
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        // Create the map chart
        // https://www.amcharts.com/docs/v5/charts/map-chart/
        var chart = root.container.children.push(am5map.MapChart.new(root, {
            panX: "translateX",
            panY: "translateY",
            projection: am5map.geoMercator()
        }));
        
        var cont = chart.children.push(am5.Container.new(root, {
            layout: root.horizontalLayout,
            x: 20,
            y: 40
        }));
        
        // Add labels and controls
        cont.children.push(am5.Label.new(root, {
            centerY: am5.p50,
            text: "Map"
        }));
        
        var switchButton = cont.children.push(am5.Button.new(root, {
            themeTags: ["switch"],
            centerY: am5.p50,
            icon: am5.Circle.new(root, {
                themeTags: ["icon"]
            })
        }));
        
        switchButton.on("active", function() {
            if (!switchButton.get("active")) {
                chart.set("projection", am5map.geoMercator());
                chart.set("panX", "translateX");
                chart.set("panY", "translateY");
            }
            else {
                chart.set("projection", am5map.geoOrthographic());
                chart.set("panX", "rotateX");
                chart.set("panY", "rotateY");
            }
        });
        
        cont.children.push(am5.Label.new(root, {
            centerY: am5.p50,
            text: "Globe"
        }));
        
        // Create main polygon series for countries
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/
        var polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
            geoJSON: am5geodata_worldLow
        }));
        
        var graticuleSeries = chart.series.push(am5map.GraticuleSeries.new(root, {}));
        graticuleSeries.mapLines.template.setAll({
            stroke: root.interfaceColors.get("alternativeBackground"),
            strokeOpacity: 0.08
        });
        
        // Create line series for trajectory lines
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-line-series/
        
        // this will be invisible line (note strokeOpacity = 0) along which invisible points will animate
        var lineSeries = chart.series.push(am5map.MapLineSeries.new(root, {}));
        lineSeries.mapLines.template.setAll({
            stroke: root.interfaceColors.get("alternativeBackground"),
            strokeOpacity: 0
        });
        
        // this will be visible line. Lines will connectg animating points so they will look like animated
        var animatedLineSeries = chart.series.push(am5map.MapLineSeries.new(root, {}));
        animatedLineSeries.mapLines.template.setAll({
            stroke: root.interfaceColors.get("alternativeBackground"),
            strokeOpacity: 0.6
        });
        
        // destination series
        var citySeries = chart.series.push(
            am5map.MapPointSeries.new(root, {})
        );
        
        // visible city circles
        citySeries.bullets.push(function() {
            var circle = am5.Circle.new(root, {
                radius: 5,
                tooltipText: "{title}",
                tooltipY: 0,
                fill: am5.color(0x28c76f),
                stroke: root.interfaceColors.get("background"),
                strokeWidth: 2
            });
        
            return am5.Bullet.new(root, {
                sprite: circle
            });
        });
        
        // invisible series which will animate along invisible lines
        var animatedBulletSeries = chart.series.push(
            am5map.MapPointSeries.new(root, {})
        );
        
        animatedBulletSeries.bullets.push(function() {
            var circle = am5.Circle.new(root, {
                radius: 0
            });
            
            return am5.Bullet.new(root, {
                sprite: circle
            });
        });
        
        var cities = [
            {
                id: "london",
                title: "London",
                geometry: { type: "Point", coordinates: [-0.1262, 51.5002] },
            },
            {
                id: "brussels",
                title: "Brussels",
                geometry: { type: "Point", coordinates: [4.3676, 50.8371] }
            }, {
                id: "prague",
                title: "Prague",
                geometry: { type: "Point", coordinates: [14.4205, 50.0878] }
            }, {
                id: "athens",
                title: "Athens",
                geometry: { type: "Point", coordinates: [23.7166, 37.9792] }
            }, {
                id: "reykjavik",
                title: "Reykjavik",
                geometry: { type: "Point", coordinates: [-21.8952, 64.1353] }
            }, {
                id: "dublin",
                title: "Dublin",
                geometry: { type: "Point", coordinates: [-6.2675, 53.3441] }
            }, {
                id: "oslo",
                title: "Oslo",
                geometry: { type: "Point", coordinates: [10.7387, 59.9138] }
            }, {
                id: "lisbon",
                title: "Lisbon",
                geometry: { type: "Point", coordinates: [-9.1355, 38.7072] }
            }, {
                id: "moscow",
                title: "Moscow",
                geometry: { type: "Point", coordinates: [37.6176, 55.7558] }
            }, {
                id: "belgrade",
                title: "Belgrade",
                geometry: { type: "Point", coordinates: [20.4781, 44.8048] }
            }, {
                id: "bratislava",
                title: "Bratislava",
                geometry: { type: "Point", coordinates: [17.1547, 48.2116] }
            }, {
                id: "ljublana",
                title: "Ljubljana",
                geometry: { type: "Point", coordinates: [14.5060, 46.0514] }
            }, {
                id: "madrid",
                title: "Madrid",
                geometry: { type: "Point", coordinates: [-3.7033, 40.4167] }
            }, {
                id: "stockholm",
                title: "Stockholm",
                geometry: { type: "Point", coordinates: [18.0645, 59.3328] }
            }, {
                id: "bern",
                title: "Bern",
                geometry: { type: "Point", coordinates: [7.4481, 46.9480] }
            }, {
                id: "kiev",
                title: "Kiev",
                geometry: { type: "Point", coordinates: [30.5367, 50.4422] }
            }, {
                id: "paris",
                title: "Paris",
                geometry: { type: "Point", coordinates: [2.3510, 48.8567] }
            }, {
                id: "new york",
                title: "New York",
                geometry: { type: "Point", coordinates: [-74, 40.43] }
            }
        ];
        
        citySeries.data.setAll(cities);
        
        // Prepare line series data
        var destinations = ["reykjavik", "lisbon", "moscow", "belgrade", "ljublana", "madrid", "stockholm", "bern", "kiev", "new york"];
        
        // London coordinates
        var originLongitude = -0.1262;
        var originLatitude = 51.5002;
        
        var londonDataItem = citySeries.getDataItemById("london");
        
        // this will do all the animations
        am5.array.each(destinations, function(did) {
            var destinationDataItem = citySeries.getDataItemById(did);
            var lineDataItem = lineSeries.pushDataItem({});
            lineDataItem.set("pointsToConnect", [londonDataItem, destinationDataItem])
            
            var startDataItem = animatedBulletSeries.pushDataItem({});
            startDataItem.setAll({
                lineDataItem: lineDataItem,
                positionOnLine: 0
            });
            
            var endDataItem = animatedBulletSeries.pushDataItem({});
            endDataItem.setAll({
                lineDataItem: lineDataItem,
                positionOnLine: 1
            });
            
            var animatedLineDataItem = animatedLineSeries.pushDataItem({});
            animatedLineDataItem.set("pointsToConnect", [startDataItem, endDataItem])
            
            var lon0 = londonDataItem.get("longitude");
            var lat0 = londonDataItem.get("latitude");
            
            var lon1 = destinationDataItem.get("longitude");
            var lat1 = destinationDataItem.get("latitude");
            
            var distance = Math.hypot(lon1 - lon0, lat1 - lat0);
            var duration = distance * 100;
            
            animateStart(startDataItem, endDataItem, duration);
        });
        
        function animateStart(startDataItem, endDataItem, duration) {
            var startAnimation = startDataItem.animate({
                key: "positionOnLine",
                from: 0,
                to: 1,
                duration: duration
            });
            
            startAnimation.events.on("stopped", function() {
                animateEnd(startDataItem, endDataItem, duration);
            });
        }
        
        function animateEnd(startDataItem, endDataItem, duration) {
            startDataItem.set("positionOnLine", 0)
            var endAnimation = endDataItem.animate({
                key: "positionOnLine",
                from: 0,
                to: 1,
                duration: duration
            })
            
            endAnimation.events.on("stopped", function() {
                animateStart(startDataItem, endDataItem, duration);
            });
        }
        
        polygonSeries.events.on("datavalidated", function() {
            chart.zoomToGeoPoint({
                longitude: -0.1262,
                latitude: 51.5002
            }, 3);
        });
        
        // Make stuff animate on load
        chart.appear(1000, 100);
    }); // end am5.ready() 

    // Website Overview
    var options = {
        series: [
            {
                name: 'Bounce Rate 37.42%',
                data: [20, 95, 40, 80, 50, 80],
            }, {
                name: 'Page Per Visit 7.56',
                data: [80, 50, 30, 40, 95, 20],
            }, {
                name: 'Avg. Visit Duration 05:48',
                data: [20, 95, 40, 80, 50, 80],
            },
        ],
        chart: {
            height: 358,
            type: 'radar',
        },
        dataLabels: {
            enabled: true
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center', 
            fontWeight: 500,
            labels: {
                colors: ['#8c9097'],
            },
            itemMargin: {
                horizontal: 5,
                vertical: 5,
            },
            markers: {
                radius: 2,
            }
        },
        plotOptions: {
            radar: {
                size: 140,
                polygons: {
                    strokeColors: '#EFEFFE',
                    fill: {
                        colors: ['#f1f2f7', '#fff']
                    }
                }
            }
        },
        colors: ['#5d87ff'],
        tooltip: {
            y: {
                formatter: function(val) {
                    return val
                }
            }
        },
        xaxis: {
            categories: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            labels: {
                style: {
                    colors: ['#d14a43', '#fff243', '#d6569b', '#52ab62', '#e08b44', '#3eb4f0', '#80589e'],
                },
            }
        },
        yaxis: {
            tickAmount: 7,
            labels: {
                formatter: function(val, i) {
                    if (i % 2 === 0) {
                    return val
                    } else {
                        return ''
                    }
                }
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#website_overview"), options);
    chart.render();

    // Website Device
    var options = {
        series: [60.50, 15.50, 18.50, 5.50],
        labels: ["Mobile", "Tablet", "Desktop", "Others"],
        chart: {
            height: 400,
            type: 'donut',
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'round',
            colors: "#fff",
            width: 0,
            dashArray: 0,
        },
        plotOptions: {
            pie: {
                expandOnClick: false,
                donut: {
                    size: '80%',
                    background: 'transparent',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '20px',
                            color: '#495057',
                            offsetY: -4
                        },
                        value: {
                            show: true,
                            fontSize: '20px',
                            color: undefined,
                            offsetY: 8,
                            formatter: function (val) {
                                return val + "%"
                            }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            fontSize: '20px',
                            fontWeight: 700,
                            color: '#2A3547',
                        }

                    }
                }
            }
        },
        colors: ["#5d87ff", "#28c76f", "#ffc107", "#ee368c",],
        responsive: [{
            breakpoint: 1600,
            options: {
                chart: {
                    height: 300,
                },
            },
        }],
    };
    document.querySelector("#website_device").innerHTML = " ";
    var chart = new ApexCharts(document.querySelector("#website_device"), options);
    chart.render();

}(jQuery));