# Air Raid Map | Readme | English
![Thumbnail](https://raw.githubusercontent.com/Puzzak/Air-Raid-Map/893ad3d24377e7925cd8963773380de2f8046217/map-project.png)
 - Simlest air raid map, built with Google Charts API and API єМапа. Contains discard time for every district.
 - You can try this out [HERE](https://puzzak.page/map)
 - Consider [donating](https://puzzak.diaka.ua/frd) if you've found this helpful


## Sources


### Google Charts API
> [Documentation](https://developers.google.com/chart/interactive/docs/gallery/geochart) | [Sample](https://developers.google.com/chart/interactive/docs/gallery/geochart#region-geocharts)


### єМапа
> Data comes from [єМапа](https://vadimklimenko.com/map/) by [@Vadimkin](https://github.com/Vadimkin) (their repo with [Telegram data crawler](https://github.com/Vadimkin/ukrainian-air-raid-sirens-dataset))


## Code

> See code [here](https://github.com/Puzzak/Air-Raid-Map/blob/main/simple.php)

#### File structure
> Simple HTML template for this project:
```html
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        ...
    </script>
  </head>
  <body>
      <div id="regions_div"></div>
    </div>
    ...
  </body>
</html>
```

#### Script the map
> Loading package:
```js
      google.charts.load('current', {
        'packages':['geochart'],
      });
      google.charts.setOnLoadCallback(drawRegionsMap);
      ...
```
> Simpple JSON parser:
```js
      function alertsToData(json){
        const obj = JSON.parse(json);
        return obj;
      }
      ...
```
> Making tooltips with enable/disable air raid siren time:
```js
      function ifNull(string){if( string ) {return string.replace('T', ", ").replace('+00:00', "");}else{return "";}}
      function alertToText(status){if(status){return "Тривога з: ";}else{return "Відбій з: ";}}
      function constructTooltip(state, statuses){
        return alertToText(statuses.states[state].enabled) + ifNull(statuses.states[state].disabled_at) + ifNull(statuses.states[state].enabled_at);
      }
      ...
```
> Getting latest air raid statuses and drawing the map
```js
      function drawRegionsMap() {
        var statusesRaw = alertsToData('<?php echo file_get_contents("https://emapa.fra1.cdn.digitaloceanspaces.com/statuses.json");?>');
        var statusesArray = dataToArray(statusesRaw);
        var data = google.visualization.arrayToDataTable(statusesArray);
        ...
```
> These parameters define how will this map look like - [reference](https://developers.google.com/chart/interactive/docs/gallery/geochart#configuration-options):
```js
        var options = {
            resolution: 'provinces',
            region: 'UA',
            displayMode: 'regions',
            datalessRegionColor:'white',
            colorAxis: {colors: ['009688', 'red']},
            domain:'UA',
        };
        ...
```
> Defining chart frame and drawing into it:
```js
        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
```

> Also we can remove annoying an unnecessary map legend by adding this into `<body>`:
```html
    <style>
      #regions_div > div > div:nth-child(1) > div > svg > g > g:nth-child(3){
        visibility: hidden;
      }
    </style>
```
