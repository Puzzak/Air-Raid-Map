<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
      });

      google.charts.setOnLoadCallback(drawRegionsMap);

      function alertsToData(json){
        const obj = JSON.parse(json);
        return obj;
      }

      function ifNull(string){if( string ) {return string.replace('T', ", ").replace('+00:00', "");}else{return "";}}
      function alertToText(status){if(status){return "Тривога з: ";}else{return "Відбій з: ";}}
      function constructTooltip(state, statuses){
        return alertToText(statuses.states[state].enabled) + ifNull(statuses.states[state].disabled_at) + ifNull(statuses.states[state].enabled_at);
      }
      function dataToArray(statuses){
        var obj = [
            ['Region', 'Text label', 'Повітряна тривога', {role: 'tooltip', p:{html:true}}],
            ['UA-43', 'АР Крим',                    0,                                                      ""                                                        ],  // UA-43	 Avtonomna Respublika Krym	republic
            ['UA-40', 'Севастополь',                0,                                                      ""                                                        ],  // UA-40	 Sevastopol	city
            ['UA-30', 'Київ',                       statuses.states["м. Київ"].enabled,                     constructTooltip("м. Київ", statuses)                     ],  // UA-30	 Kyiv	city
            ['UA-71', 'Черкаська область',          statuses.states["Черкаська область"].enabled,           constructTooltip("Черкаська область", statuses)           ],  // UA-71	 Cherkaska oblast	region
            ['UA-74', 'Чернігівська область',       statuses.states["Чернігівська область"].enabled,        constructTooltip("Чернігівська область", statuses)        ],  // UA-74	 Chernihivska oblast	region
            ['UA-77', 'Чернівецька область',        statuses.states["Чернівецька область"].enabled,         constructTooltip("Чернівецька область", statuses)         ],  // UA-77	 Chernivetska oblast	region
            ['UA-12', 'Дніпропетровська область',   statuses.states["Дніпропетровська область"].enabled,    constructTooltip("Дніпропетровська область", statuses)    ],  // UA-12	 Dnipropetrovska oblast	region
            ['UA-14', 'Донецька область',           statuses.states["Донецька область"].enabled,            constructTooltip("Донецька область", statuses)            ],  // UA-14	 Donetska oblast	region
            ['UA-26', 'Івано-Франківська область',  statuses.states["Івано-Франківська область"].enabled,   constructTooltip("Івано-Франківська область", statuses)   ],  // UA-26	 Ivano-Frankivska oblast	region
            ['UA-63', 'Харківська область',         statuses.states["Харківська область"].enabled,          constructTooltip("Харківська область", statuses)          ],  // UA-63	 Kharkivska oblast	region
            ['UA-65', 'Херсонська область',         statuses.states["Херсонська область"].enabled,          constructTooltip("Херсонська область", statuses)          ],  // UA-65	 Khersonska oblast	region
            ['UA-68', 'Хмельницька область',        statuses.states["Хмельницька область"].enabled,         constructTooltip("Хмельницька область", statuses)         ],  // UA-68	 Khmelnytska oblast	region
            ['UA-35', 'Кіровоградська область',     statuses.states["Кіровоградська область"].enabled,      constructTooltip("Кіровоградська область", statuses)      ],  // UA-35	 Kirovohradska oblast	region
            ['UA-32', 'Київська область',           statuses.states["Київська область"].enabled,            constructTooltip("Київська область", statuses)            ],  // UA-32	 Kyivska oblast	region
            ['UA-09', 'Луганська область',          statuses.states["Луганська область"].enabled,           constructTooltip("Луганська область", statuses)           ],  // UA-09	 Luhanska oblast	region
            ['UA-46', 'Львівська область',          statuses.states["Львівська область"].enabled,           constructTooltip("Львівська область", statuses)           ],  // UA-46	 Lvivska oblast	region
            ['UA-48', 'Миколаївська область',       statuses.states["Миколаївська область"].enabled,        constructTooltip("Миколаївська область", statuses)        ],  // UA-48	 Mykolaivska oblast	region
            ['UA-51', 'Одеська область',            statuses.states["Одеська область"].enabled,             constructTooltip("Одеська область", statuses)             ],  // UA-51	 Odeska oblast	region
            ['UA-53', 'Полтавська область',         statuses.states["Полтавська область"].enabled,          constructTooltip("Полтавська область", statuses)          ],  // UA-53	 Poltavska oblast	region
            ['UA-56', 'Рівненська область',         statuses.states["Рівненська область"].enabled,          constructTooltip("Рівненська область", statuses)          ],  // UA-56	 Rivnenska oblast	region
            ['UA-59', 'Сумська область',            statuses.states["Сумська область"].enabled,             constructTooltip("Сумська область", statuses)             ],  // UA-59	 Sumska oblast	region
            ['UA-61', 'Тернопільська область',      statuses.states["Тернопільська область"].enabled,       constructTooltip("Тернопільська область", statuses)       ],  // UA-61	 Ternopilska oblast	region
            ['UA-05', 'Вінницька область',          statuses.states["Вінницька область"].enabled,           constructTooltip("Вінницька область", statuses)           ],  // UA-05	 Vinnytska oblast	region
            ['UA-07', 'Волинська область',          statuses.states["Волинська область"].enabled,           constructTooltip("Волинська область", statuses)           ],  // UA-07	 Volynska oblast	region
            ['UA-21', 'Закарпатська область',       statuses.states["Закарпатська область"].enabled,        constructTooltip("Закарпатська область", statuses)        ],  // UA-21	 Zakarpatska oblast	region
            ['UA-23', 'Запорізька область',         statuses.states["Запорізька область"].enabled,          constructTooltip("Запорізька область", statuses)          ],  // UA-23	 Zaporizka oblast	region
            ['UA-18', 'Житомирська область',        statuses.states["Житомирська область"].enabled,         constructTooltip("Житомирська область", statuses)         ]  // UA-18	 Zhytomyrska oblast	region

      ];
        return obj;
      }

      function drawRegionsMap() {
        var statusesRaw = alertsToData('<?php echo file_get_contents("https://emapa.fra1.cdn.digitaloceanspaces.com/statuses.json");?>');
        var statusesArray = dataToArray(statusesRaw);
        var data = google.visualization.arrayToDataTable(statusesArray);
        var options = {
            resolution: 'provinces',
            region: 'UA',
            displayMode: 'regions',
            datalessRegionColor:'white',
            colorAxis: {colors: ['009688', 'red']},
            domain:'UA',
        };

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
      <div id="regions_div"></div>
    </div>
    <style>
      #regions_div > div > div:nth-child(1) > div > svg > g > g:nth-child(3){
        visibility: hidden;
      }
    </style>
  </body>
</html>
