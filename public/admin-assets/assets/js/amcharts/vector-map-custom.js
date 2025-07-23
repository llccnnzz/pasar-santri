(function($) {
	'use strict';


    // amcharts-map-1
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("amcharts-map-1");
        
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
        
        // Create main polygon series for countries
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/
        var polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
            geoJSON: am5geodata_worldLow,
            exclude: ["AQ"]
        }));
        
        polygonSeries.mapPolygons.template.setAll({
            tooltipText: "{name}",
            toggleKey: "active",
            interactive: true
        });
        
        polygonSeries.mapPolygons.template.states.create("hover", {
            fill: root.interfaceColors.get("primaryButtonHover")
        });
        
        polygonSeries.mapPolygons.template.states.create("active", {
            fill: root.interfaceColors.get("primaryButtonHover")
        });
        
        // US Series
        // Create main polygon series for countries
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/
        var polygonSeriesUS = chart.series.push(am5map.MapPolygonSeries.new(root, {
            geoJSON: am5geodata_usaLow
        }));
        
        polygonSeriesUS.mapPolygons.template.setAll({
            tooltipText: "{name}",
            toggleKey: "active",
            interactive: true
        });
        
        var colors = am5.ColorSet.new(root, {});
        
        polygonSeriesUS.mapPolygons.template.set("fill", colors.getIndex(3));
        
        polygonSeriesUS.mapPolygons.template.states.create("hover", {
            fill: root.interfaceColors.get("primaryButtonHover")
        });
        
        polygonSeriesUS.mapPolygons.template.states.create("active", {
            fill: root.interfaceColors.get("primaryButtonHover")
        });
        
        // Add zoom control
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-pan-zoom/#Zoom_control
        chart.set("zoomControl", am5map.ZoomControl.new(root, {}));
        
        // Set clicking on "water" to zoom out
        chart.chartContainer.get("background").events.on("click", function () {
            chart.goHome();
        })
        
        // Make stuff animate on load
        chart.appear(1000, 100);
        
    }); // end am5.ready()

    // amcharts-map-2
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("amcharts-map-2");
        
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
        
        // Create main polygon series for countries
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/
        var polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
            geoJSON: am5geodata_worldLow,
            exclude: ["AQ"]
        }));
        
        polygonSeries.mapPolygons.template.setAll({
            tooltipText: "{name}",
            toggleKey: "active",
            interactive: true
        });
        
        polygonSeries.mapPolygons.template.states.create("hover", {
            fill: root.interfaceColors.get("primaryButtonHover")
        });
        
        polygonSeries.mapPolygons.template.states.create("active", {
            fill: root.interfaceColors.get("primaryButtonHover")
        });
        
        var previousPolygon;
        
        polygonSeries.mapPolygons.template.on("active", function (active, target) {
            if (previousPolygon && previousPolygon != target) {
                previousPolygon.set("active", false);
            }
            if (target.get("active")) {
                polygonSeries.zoomToDataItem(target.dataItem );
            }
            else {
                chart.goHome();
            }
            previousPolygon = target;
        });
        
        // Add zoom control
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-pan-zoom/#Zoom_control
        chart.set("zoomControl", am5map.ZoomControl.new(root, {}));
        
        // Set clicking on "water" to zoom out
        chart.chartContainer.get("background").events.on("click", function () {
            chart.goHome();
        })
        
        // Make stuff animate on load
        chart.appear(1000, 100);
        
    }); // end am5.ready()

    // amcharts-map-3
    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("amcharts-map-3");
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        // Create the map chart
        // https://www.amcharts.com/docs/v5/charts/map-chart/
        // setting rotationX to -154.8 makes the map Pacific-centered
        var chart = root.container.children.push(am5map.MapChart.new(root, {
            panX: "rotateX",
            panY: "none",
            projection: am5map.geoNaturalEarth1(),
            rotationX: -154.8
        }));
        
        // Create main polygon series for countries
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/
        var polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
            geoJSON: am5geodata_worldLow
        }));
        
        polygonSeries.mapPolygons.template.setAll({
            tooltipText: "{name}",
            fillOpacity: 0.8
        });
        
        var colorSet = am5.ColorSet.new(root, {});
        
        var i = 0;
        polygonSeries.mapPolygons.template.adapters.add("fill", function (fill, target) {
            if (i < 10) {
                i++;
            }
            else {
                i = 0;
            }
            var dataContext = target.dataItem.dataContext;
            if (!dataContext.colorWasSet) {
                dataContext.colorWasSet = true;
                var color = am5.Color.saturate(colorSet.getIndex(i), 0.3);
                target.setRaw("fill", color);
                return color;
            }
            else {
                return fill;
            }
        })
        
        polygonSeries.mapPolygons.template.states.create("hover", { fillOpacity: 1 });
        
        var graticuleSeries = chart.series.push(am5map.GraticuleSeries.new(root, {}));
        graticuleSeries.mapLines.template.setAll({
            stroke: root.interfaceColors.get("alternativeBackground"),
            strokeOpacity: 0.1
        });
        
        // Add zoom control
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-pan-zoom/#Zoom_control
        chart.set("zoomControl", am5map.ZoomControl.new(root, {}));
        
        
        // Set clicking on "water" to zoom out
        chart.chartContainer.get("background").events.on("click", function() {
            chart.goHome();
        })
        
        // Make stuff animate on load
        chart.appear(1000, 100);
        
    }); // end am5.ready()

    // amcharts-map-4
    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("amcharts-map-4");
        
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
        var lineSeries = chart.series.push(am5map.MapLineSeries.new(root, {}));
        lineSeries.mapLines.template.setAll({
            stroke: root.interfaceColors.get("alternativeBackground"),
            strokeOpacity: 0.6
        });
        
        // destination series
        var citySeries = chart.series.push(
            am5map.MapPointSeries.new(root, {})
        );
        
        citySeries.bullets.push(function() {
            var circle = am5.Circle.new(root, {
                radius: 5,
                tooltipText: "{title}",
                tooltipY: 0,
                fill: am5.color(0xffba00),
                stroke: root.interfaceColors.get("background"),
                strokeWidth: 2
            });
            
            return am5.Bullet.new(root, {
                sprite: circle
            });
        });
        
        // arrow series
        var arrowSeries = chart.series.push(
            am5map.MapPointSeries.new(root, {})
        );
        
        arrowSeries.bullets.push(function() {
            var arrow = am5.Graphics.new(root, {
                fill: am5.color(0x000000),
                stroke: am5.color(0x000000),
                draw: function (display) {
                display.moveTo(0, -3);
                display.lineTo(8, 0);
                display.lineTo(0, 3);
                display.lineTo(0, -3);
                }
            });
            
            return am5.Bullet.new(root, {
                sprite: arrow
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
        }];
        
        citySeries.data.setAll(cities);
        
        // prepare line series data
        var destinations = ["reykjavik", "lisbon", "moscow", "belgrade", "ljublana", "madrid", "stockholm", "bern", "kiev", "new york"];
        // London coordinates
        var originLongitude = -0.1262;
        var originLatitude = 51.5002;
        
        am5.array.each(destinations, function (did) {
            var destinationDataItem = citySeries.getDataItemById(did);
            var lineDataItem = lineSeries.pushDataItem({ geometry: { type: "LineString", coordinates: [[originLongitude, originLatitude], [destinationDataItem.get("longitude"), destinationDataItem.get("latitude")]] } });
            
            arrowSeries.pushDataItem({
                lineDataItem: lineDataItem,
                positionOnLine: 0.5,
                autoRotate: true
            });
        })
        
        polygonSeries.events.on("datavalidated", function () {
            chart.zoomToGeoPoint({ longitude: -0.1262, latitude: 51.5002 }, 3);
        })
        
        // Make stuff animate on load
        chart.appear(1000, 100);
        
    }); // end am5.ready()

    // amcharts-map-5
    am5.ready(function() {
        // Create root and chart
        var root = am5.Root.new("amcharts-map-5"); 
        
        // Set themes
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        var chart = root.container.children.push(
            am5map.MapChart.new(root, {
                panX: "rotateX",
                projection: am5map.geoNaturalEarth1()
            })
        );
        
        // Create polygon series
        var polygonSeries = chart.series.push(
            am5map.MapPolygonSeries.new(root, {
                geoJSON: am5geodata_continentsLow,
                exclude: ["antarctica"]
            })
        );
        
        polygonSeries.mapPolygons.template.setAll({
            tooltipText: "{name}",
            interactive: true,
            templateField: "settings"
        });
        
        polygonSeries.mapPolygons.template.states.create("hover", {
            fill: am5.color(0x677935)
        });
        
        var colors = am5.ColorSet.new(root, {});
        
        polygonSeries.data.setAll([{
            id: "europe",
            settings: {
                fill: colors.next(),
                fillPattern: am5.LinePattern.new(root, {
                    color: am5.color(0xffffff),
                    rotation: 45,
                    strokeWidth: 1
                })
            }
            }, {
            id: "asia",
            settings: {
                fill: colors.next(),
                fillPattern: am5.RectanglePattern.new(root, {
                    color: am5.color(0xffffff),
                    checkered: true
                })
            }
            }, {
            id: "africa",
            settings: {
                fill: colors.next(),
                fillPattern: am5.CirclePattern.new(root, {
                    color: am5.color(0xffffff),
                    checkered: true
                })
            }
            }, {
            id: "northAmerica",
            settings: {
                fill: colors.next(),
                fillPattern: am5.CirclePattern.new(root, {
                    color: am5.color(0xffffff)
                })
            }
            }, {
            id: "southAmerica",
            settings: {
                fill: colors.next(),
                fillPattern: am5.LinePattern.new(root, {
                    color: am5.color(0xffffff),
                    rotation: 90,
                    strokeWidth: 2
                })
            }
            }, {
            id: "oceania",
            settings: {
                fill: colors.next(),
                fillPattern: am5.LinePattern.new(root, {
                    color: am5.color(0xffffff),
                })
            }
        }])
        
    }); // end am5.ready()

    // amcharts-map-6
    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("amcharts-map-6");
        
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        // Create the map chart
        // https://www.amcharts.com/docs/v5/charts/map-chart/
        var chart = root.container.children.push(
            am5map.MapChart.new(root, {
                panX: "translateX",
                panY: "translateY",
                projection: am5map.geoMercator()
            })
        );
        
        // Add labels and controls
        var cont = chart.children.push(
            am5.Container.new(root, {
                layout: root.horizontalLayout,
                x: 20,
                y: 40
            })
        );
        
        cont.children.push(
            am5.Label.new(root, {
                centerY: am5.p50,
                text: "Map"
            })
        );
        
        var switchButton = cont.children.push(
            am5.Button.new(root, {
                themeTags: ["switch"],
                centerY: am5.p50,
                icon: am5.Circle.new(root, {
                themeTags: ["icon"]
                })
            })
        );
        
        switchButton.on("active", function () {
            if (!switchButton.get("active")) {
                chart.set("projection", am5map.geoMercator());
                chart.set("panX", "translateX");
                chart.set("panY", "translateY");
            } else {
                chart.set("projection", am5map.geoOrthographic());
                chart.set("panX", "rotateX");
                chart.set("panY", "rotateY");
            }
        });
        
        cont.children.push(
            am5.Label.new(root, {
                centerY: am5.p50,
                text: "Globe"
            })
        );
        
        // Create main polygon series for countries
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/
        var polygonSeries = chart.series.push(
            am5map.MapPolygonSeries.new(root, {
                geoJSON: am5geodata_worldLow
            })
        );
        
        var graticuleSeries = chart.series.push(am5map.GraticuleSeries.new(root, {}));
        graticuleSeries.mapLines.template.setAll({
            stroke: root.interfaceColors.get("alternativeBackground"),
            strokeOpacity: 0.08
        });
        
        // Create line series for trajectory lines
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-line-series/
        var lineSeries = chart.series.push(am5map.MapLineSeries.new(root, {}));
        lineSeries.mapLines.template.setAll({
            stroke: root.interfaceColors.get("alternativeBackground"),
            strokeOpacity: 0.6
        });
        
        // Create point series for markers
        // https://www.amcharts.com/docs/v5/charts/map-chart/map-point-series/
        var originSeries = chart.series.push(
            am5map.MapPointSeries.new(root, { idField: "id" })
        );
        
        originSeries.bullets.push(function () {
            var circle = am5.Circle.new(root, {
                radius: 7,
                tooltipText: "{title} (Click me!)",
                cursorOverStyle: "pointer",
                tooltipY: 0,
                fill: am5.color(0xffba00),
                stroke: root.interfaceColors.get("background"),
                strokeWidth: 2
            });
            
            circle.events.on("click", function (e) {
                selectOrigin(e.target.dataItem.get("id"));
            });
            return am5.Bullet.new(root, {
                sprite: circle
            });
        });
        
        // destination series
        var destinationSeries = chart.series.push(am5map.MapPointSeries.new(root, {}));
        
        destinationSeries.bullets.push(function () {
            var circle = am5.Circle.new(root, {
                radius: 5,
                tooltipText: "{title}",
                tooltipY: 0,
                fill: am5.color(0xffba00),
                stroke: root.interfaceColors.get("background"),
                strokeWidth: 2
            });
            
            return am5.Bullet.new(root, {
                sprite: circle
            });
        });
        
        var button = root.container.children.push(
            am5.Button.new(root, {
                x: am5.p50,
                y: 60,
                centerX: am5.p50,
                label: am5.Label.new(root, {
                    text: "Change origin",
                    centerY: am5.p50
                }),
                icon: am5.Graphics.new(root, {
                    svgPath: "m2,106h28l24,30h72l-44,-133h35l80,132h98c21,0 21,34 0,34l-98,0 -80,134h-35l43,-133h-71l-24,30h-28l15,-47",
                    scale: 0.1,
                    centerY: am5.p50,
                    centerX: am5.p50,
                    fill: am5.color(0xffffff)
                })
            })
        );
        
        button.events.on("click", function () {
            if (currentId == "vilnius") {
                selectOrigin("london");
            } else {
                selectOrigin("vilnius");
            }
        });
        
        var originCities = [
            {
                id: "london",
                title: "London",
                destinations: [
                "vilnius",
                "reykjavik",
                "lisbon",
                "moscow",
                "belgrade",
                "ljublana",
                "madrid",
                "stockholm",
                "bern",
                "kiev",
                "new york"
                ],
                geometry: { type: "Point", coordinates: [-0.1262, 51.5002] },
                zoomLevel: 2.74,
                zoomPoint: { longitude: -20.1341, latitude: 49.1712 }
            },
            {
                id: "vilnius",
                title: "Vilnius",
                destinations: [
                "london",
                "brussels",
                "prague",
                "athens",
                "dublin",
                "oslo",
                "moscow",
                "bratislava",
                "belgrade",
                "madrid"
                ],
                geometry: { type: "Point", coordinates: [25.2799, 54.6896] },
                zoomLevel: 4.92,
                zoomPoint: { longitude: 15.4492, latitude: 50.2631 }
            }
        ];
        
        var destinationCities = [
            {
                id: "brussels",
                title: "Brussels",
                geometry: { type: "Point", coordinates: [4.3676, 50.8371] }
            },
            {
                id: "prague",
                title: "Prague",
                geometry: { type: "Point", coordinates: [14.4205, 50.0878] }
            },
            {
                id: "athens",
                title: "Athens",
                geometry: { type: "Point", coordinates: [23.7166, 37.9792] }
            },
            {
                id: "reykjavik",
                title: "Reykjavik",
                geometry: { type: "Point", coordinates: [-21.8952, 64.1353] }
            },
            {
                id: "dublin",
                title: "Dublin",
                geometry: { type: "Point", coordinates: [-6.2675, 53.3441] }
            },
            {
                id: "oslo",
                title: "Oslo",
                geometry: { type: "Point", coordinates: [10.7387, 59.9138] }
            },
            {
                id: "lisbon",
                title: "Lisbon",
                geometry: { type: "Point", coordinates: [-9.1355, 38.7072] }
            },
            {
                id: "moscow",
                title: "Moscow",
                geometry: { type: "Point", coordinates: [37.6176, 55.7558] }
            },
            {
                id: "belgrade",
                title: "Belgrade",
                geometry: { type: "Point", coordinates: [20.4781, 44.8048] }
            },
            {
                id: "bratislava",
                title: "Bratislava",
                geometry: { type: "Point", coordinates: [17.1547, 48.2116] }
            },
            {
                id: "ljublana",
                title: "Ljubljana",
                geometry: { type: "Point", coordinates: [14.506, 46.0514] }
            },
            {
                id: "madrid",
                title: "Madrid",
                geometry: { type: "Point", coordinates: [-3.7033, 40.4167] }
            },
            {
                id: "stockholm",
                title: "Stockholm",
                geometry: { type: "Point", coordinates: [18.0645, 59.3328] }
            },
            {
                id: "bern",
                title: "Bern",
                geometry: { type: "Point", coordinates: [7.4481, 46.948] }
            },
            {
                id: "kiev",
                title: "Kiev",
                geometry: { type: "Point", coordinates: [30.5367, 50.4422] }
            },
            {
                id: "paris",
                title: "Paris",
                geometry: { type: "Point", coordinates: [2.351, 48.8567] }
            },
            {
                id: "new york",
                title: "New York",
                geometry: { type: "Point", coordinates: [-74, 40.43] }
            }
        ];
        
        originSeries.data.setAll(originCities);
        destinationSeries.data.setAll(destinationCities);
        
        function selectOrigin(id) {
            currentId = id;
            var dataItem = originSeries.getDataItemById(id);
            var dataContext = dataItem.dataContext;
            chart.zoomToGeoPoint(dataContext.zoomPoint, dataContext.zoomLevel, true);
            
            var destinations = dataContext.destinations;
            var lineSeriesData = [];
            var originLongitude = dataItem.get("longitude");
            var originLatitude = dataItem.get("latitude");
            
            am5.array.each(destinations, function (did) {
                var destinationDataItem = destinationSeries.getDataItemById(did);
                if (!destinationDataItem) {
                destinationDataItem = originSeries.getDataItemById(did);
                }
                lineSeriesData.push({
                geometry: {
                    type: "LineString",
                    coordinates: [
                    [originLongitude, originLatitude],
                    [
                        destinationDataItem.get("longitude"),
                        destinationDataItem.get("latitude")
                    ]
                    ]
                }
                });
            });
            lineSeries.data.setAll(lineSeriesData);
        }
        
        var currentId = "london";
        
        destinationSeries.events.on("datavalidated", function () {
            selectOrigin(currentId);
        });
        
        // Make stuff animate on load
        chart.appear(1000, 100);
        
    }); // end am5.ready()

    // amcharts-map-7
    am5.ready(function() {
        // Create root and chart
        var root = am5.Root.new("amcharts-map-7"); 
        
        // Set themes
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        
        // ====================================
        // Create map
        // ====================================
        
        var map = root.container.children.push(
            am5map.MapChart.new(root, {
                panX: "none",
                projection: am5map.geoNaturalEarth1()
            })
        );
        
        // Create polygon series
        var polygonSeries = map.series.push(
            am5map.MapPolygonSeries.new(root, {
                geoJSON: am5geodata_continentsLow,
                exclude: ["antarctica"],
                fill: am5.color(0xbbbbbb)
            })
        );
        
        var pointSeries = map.series.push(
            am5map.MapPointSeries.new(root, {})
        );
        
        var colorSet = am5.ColorSet.new(root, {step:2});
        
        pointSeries.bullets.push(function(root, series, dataItem) {
            var value = dataItem.dataContext.value;
            
            var container = am5.Container.new(root, {});
            var color = colorSet.next();
            var radius = 15 + value / 20 * 20;
            var circle = container.children.push(am5.Circle.new(root, {
                radius: radius,
                fill: color,
                dy: -radius * 2
            }))
            
            var pole = container.children.push(am5.Line.new(root, {
                stroke: color,
                height: -40,
                strokeGradient: am5.LinearGradient.new(root, {
                stops:[
                    { opacity: 1 },
                    { opacity: 1 },
                    { opacity: 0 }
                ]
                })
            }));
            
            var label = container.children.push(am5.Label.new(root, {
                text: value + "%",
                fill: am5.color(0xffffff),
                fontWeight: "400",
                centerX: am5.p50,
                centerY: am5.p50,
                dy: -radius * 2
            }))
            
            var titleLabel = container.children.push(am5.Label.new(root, {
                text: dataItem.dataContext.title,
                fill: color,
                fontWeight: "500",
                fontSize: "1em",
                centerY: am5.p50,
                dy: -radius * 2,
                dx: radius
            }))
            
            return am5.Bullet.new(root, {
                sprite: container
            });
        });
        
        // ====================================
        // Create pins
        // ====================================
        
        var data = [{
            "title": "United States",
            "latitude": 39.563353,
            "longitude": -99.316406,
            "width": 100,
            "height": 100,
            "value":12
        }, {
            "title": "European Union",
            "latitude": 50.896104,
            "longitude": 19.160156,
            "width": 50,
            "height": 50,
            "value":15
        }, {
            "title": "Asia",
            "latitude": 47.212106,
            "longitude": 103.183594,
            "width": 80,
            "height": 80,
            "value":8  
        }, {
            "title": "Africa",
            "latitude": 11.081385,
            "longitude": 21.621094,
            "width": 50,
            "height": 50,
            "value":5
        }];
        
        for (var i = 0; i < data.length; i++) {
          var d = data[i];
          pointSeries.data.push({
            geometry: { type: "Point", coordinates: [d.longitude, d.latitude] },
            title: d.title,
            value: d.value
          });
        }
    }); // end am5.ready()

    // amcharts-map-8
    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("amcharts-map-8");
        
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
                fill: am5.color(0xffba00),
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

})(jQuery);