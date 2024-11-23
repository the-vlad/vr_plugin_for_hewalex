<?php

namespace Develtio\ZonesHewalex\API\model;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Pv
 */
class ZH_PV
{
    private static $panelsPrices = [
        'jam6' => 958,
        'jam6bf' => 958,
        'jam6bf370' => 958,
        'jam6bf380' => 958,
        'jam6bf385' => 958,
        'qpeak345' => 958,
        'qpeak345g6' => 958,
        'qpeak350g6' => 958
    ];

    private static $kitsBasePrices = [
        'kwp1'      => 4950,
        'kwp2'      => 5811,
        'kwp3'      => 7122,
        'kwp3|3'    => 9146,
        'kwp5'      => 11763,
        'kwp6'      => 12905,
        'kwp8'      => 13329,
        'kwp10'     => 15359,
    ];

    /**
     * Defines kits prices for each panel type separately. Definition pattern:
     *  'kwp0-7' => [
     *      'jap6' => 3624,
     *      'jam6' => 3401
     *  ]
     */
    private static $kitsBasePricesByPanelTypes = [];

    private static $montageSystemsMontagePrices = [
        'blachodachowka'    => 105.63,
        'dachowka'          => 135.99,
        'rabek'             => 127.13,
        'trapez'            => 105.63,
        'gont'              => 123.17,
        'poziomo1'          => 116.38,
        'pionowo1'          => 131.56,
        'poziomo2'          => 110.06,
        'grunt'             => 187.85,
    ];

    /**
     * Defines montage prices for each panel type separately. Definition pattern:
     *  'blachodachowka' => [
     *      'jap6' => 75,
     *      'jam6' => 70
     *  ]
     */
    private static $montageSystemsMontagePricesByPanelTypes = [];

    private static $montageConstCost = 141;

    private static $totalPriceFactor = 1.1 * 0.93;

    /**
     * Defines promotional prices for sets based on inverters. Definition pattern:
     *  'kwp1' => [
     *      'panelsPrices' => [
     *          'jam6' => 666
     *      ],
     *      'basePrice' => [
     *          'jam6' => 3401
     *      ],
     *      'montagePrices' => [
     *          'blachodachowka' => [
     *              'jam6' => 70
     *          ],
     *          'trapez' => [
     *              'jam6' => 70
     *          ]
     *      ]
     *  ]
     */
    private static $promoPrices = [];

    private static $invertersPowerLimitsByPanelTypes = [
        'default' => ['min' => 0.8, 'max' => 1.2],
        'kwp1' => [
            'jam6bf370' => ['min' => 0.74],
            'jam6bf380' => ['min' => 0.76],
            'jam6bf385' => ['min' => 0.76]
        ],
        'kwp2' => [
            'jam6bf' => ['min' => 0.68],
            'jam6bf370' => ['min' => 0.74],
            'jam6bf380' => ['min' => 0.76],
            'jam6bf385' => ['min' => 0.76]
        ],
        'kwp5' => [
            'jam6bf' => ['min' => 0.74],
            'jam6bf370' => ['min' => 0.74],
            'jam6bf380' => ['min' => 0.76],
            'jam6bf385' => ['min' => 0.76]
        ]
    ];

    private static $products = [
        /* panels */
        'jam6bf385' => [
            'code' => '30.24.00',
            'name' => 'JA Solar JAM60S20-385/MR-BF',
            'group' => ['pv', 'panels'],
            'shortName' => "JA Solar 385W",
            'model' => 'JAM60S20-385/MR-BF',
            'producer' => 'JA Solar',
            'maxPower' => 0.385,
            'maxPowerUnit' => 'kW',
            'surface' => 1.861,
            'efficiency' => 0.207,
            'effLossInYear' => 0.975,
            'link' => '/oferta/panele-fotowoltaiczne/ja-solar-jam60s20-385mr-bf.html',
            'img' => ZH_URL . 'public/images/product/JASolar370_380W_00_850x600_px_20210628_093300.jpg',
            'unit' => 'szt.',
            'order' => 9,
            'hidden' => [
                'calcpv' => false,
                'print' => false
            ],
            'productCard' => 'karta-produktu-modul-fotowoltaiczny-ja-solar-385-mr-bf.pdf'
        ],
        'jam6bf380' => [
            'code' => '30.21.00',
            'name' => 'JA Solar JAM60S20-380/MR-BF',
            'group' => ['pv', 'panels'],
            'shortName' => "JA Solar 380W",
            'model' => 'JAM60S10-380/MR-BF',
            'producer' => 'JA Solar',
            'maxPower' => 0.38,
            'maxPowerUnit' => 'kW',
            'surface' => 1.8684,
            'efficiency' => 0.203,
            'effLossInYear' => 0.975,
            'link' => '/oferta/panele-fotowoltaiczne/ja-solar-jam60s20-380mr-bf.html',
            'img' => ZH_URL . 'public/images/product/JASolar370_380W_00_850x600_px_20201030_102101.jpg',
            'unit' => 'szt.',
            'order' => 9,
            'hidden' => [
                'calcpv' => [
                    'defaultMode' => true,
                    'editMode' => false
                ],
                'print' => true
            ],
            'productCard' => 'karta-produktu-modul-fotowoltaiczny-jam60s20-380-mr-bf.pdf'
        ],
        'jam6bf370' => [
            'code' => '30.18.00',
            'name' => 'JA Solar JAM60S20-370/MR-BF',
            'group' => ['pv', 'panels'],
            'shortName' => "JA Solar 370W",
            'model' => 'JAM60S10-370/MR-BF',
            'producer' => 'JA Solar',
            'maxPower' => 0.37,
            'maxPowerUnit' => 'kW',
            'surface' => 1.8684,
            'efficiency' => 0.198,
            'effLossInYear' => 0.975,
            'link' => '/oferta/panele-fotowoltaiczne/panel-fotowoltaiczny-ja-solar-370w.html',
            'img' => ZH_URL . 'public/img/pv/produkty/panele/ja-solar-340/panel.jpg?v=2',
            'unit' => 'szt.',
            'order' => 9,
            'hidden' => [
                'calcpv' => [
                    'defaultMode' => true,
                    'editMode' => false
                ],
                'print' => false
            ],
            'productCard' => 'karta-produktu-modul-fotowoltaiczny-ja-solar-370-bf.pdf'
        ],
        'jam6bf' => [
            'code' => '30.10.01',
            'name' => 'JA Solar JAM60S10-340/MR-BF',
            'group' => ['pv', 'panels'],
            'shortName' => "JA Solar 340W",
            'model' => 'JAM60S10-340/MR-BF',
            'producer' => 'JA Solar',
            'maxPower' => 0.34,
            'maxPowerUnit' => 'kW',
            'surface' => 1.6876,
            'efficiency' => 0.202,
            'effLossInYear' => 0.975,
            'link' => '/oferta/panele-fotowoltaiczne/panel-fotowoltaiczny-ja-solar-340w.html',
            'img' => ZH_URL . 'public/img/pv/produkty/panele/ja-solar-340/panel.jpg?v=2',
            'unit' => 'szt.',
            'order' => 9,
            'hidden' => [
                'calcpv' => [
                    'defaultMode' => true,
                    'editMode' => false
                ],
                'print' => false
            ],
            'productCard' => 'karta-produktu-modul-fotowoltaiczny-ja-solar-340-bf.pdf'
        ],
        'jam6' => [
            'code' => '30.10.00',
            'name' => 'JA Solar JAM60S10-340/MR',
            'group' => ['pv', 'panels'],
            'shortName' => "JA Solar 340W",
            'model' => 'JAM60S10-340/MR',
            'producer' => 'JA Solar',
            'maxPower' => 0.34,
            'maxPowerUnit' => 'kW',
            'surface' => 1.6876,
            'efficiency' => 0.202,
            'effLossInYear' => 0.975,
            'link' => '/oferta/panele-fotowoltaiczne/panel-fotowoltaiczny-ja-solar-340w.html',
            'img' => ZH_URL . 'public/img/pv/produkty/panele/ja-solar-340/panel.jpg?v=2',
            'unit' => 'szt.',
            'order' => 10,
            'hidden' => [
                'calcpv' => [
                    'defaultMode' => true,
                    'editMode' => false
                ],
                'print' => false
            ],
            'productCard' => 'karta-produktu-modul-fotowoltaiczny-ja-solar-340.pdf'
        ],
        'qpeak345' => [
            'code' => '30.12.00',
            'name' => 'Q CELLS Q.PEAK DUO-G8 345',
            'group' => ['pv', 'panels'],
            'shortName' => "Q CELLS DUO-G8 345",
            'model' => 'Q.PEAK DUO-G8 345',
            'producer' => 'Q CELLS',
            'maxPower' => 0.345,
            'maxPowerUnit' => 'kW',
            'surface' => 1.7977,
            'efficiency' => 0.193,
            'effLossInYear' => 0.98,
            'link' => '/oferta/panele-fotowoltaiczne/panel-fotowoltaiczny-qpeak-duo-g8-345.html',
            'img' => ZH_URL . 'public/images/product/Hanwha_Q_CELLS_QPEAK_DUO-G8_iso_DB.jpg',
            'unit' => 'szt.',
            'order' => 10,
            'hidden' => [
                'calcpv' => true,
                'print' => false
            ],
            'productCard' => 'karta-produktu-modul-fotowoltaiczny-qpeak-duo-g8-345.pdf'
        ],
        'qpeak345g6' => [
            'code' => '30.14.00',
            'name' => 'Q CELLS Q.PEAK DUO-G6 345',
            'group' => ['pv', 'panels'],
            'shortName' => "Q CELLS DUO-G6 345",
            'model' => 'Q.PEAK DUO-G6 345',
            'producer' => 'Q CELLS',
            'maxPower' => 0.345,
            'maxPowerUnit' => 'kW',
            'surface' => 1.7977,
            'efficiency' => 0.193,
            'effLossInYear' => 0.98,
            'link' => '/oferta/panele-fotowoltaiczne/panel-fotowoltaiczny-q-cells-qpeak-duo-g6-345.html',
            'img' => ZH_URL . 'public/images/product/Hanwha_Q_CELLS_QPEAK_DUO-G6_iso_DB.jpg',
            'unit' => 'szt.',
            'order' => 10,
            'hidden' => [
                'calcpv' => true,
                'print' => false
            ],
            'productCard' => 'karta-produktu-panel-q-cells-qpeak-duo-g6-345.pdf'
        ],
        'qpeak350g6' => [
            'code' => '30.15.00',
            'name' => 'Q CELLS Q.PEAK DUO-G6 350',
            'group' => ['pv', 'panels'],
            'shortName' => "Q CELLS DUO-G6 350",
            'model' => 'Q.PEAK DUO-G6 350',
            'producer' => 'Q CELLS',
            'maxPower' => 0.35,
            'maxPowerUnit' => 'kW',
            'surface' => 1.7977,
            'efficiency' => 0.195,
            'effLossInYear' => 0.98,
            'link' => '/oferta/panele-fotowoltaiczne/panel-fotowoltaiczny-q-cells-qpeak-duo-g6-350.html',
            'img' => ZH_URL . 'public/images/product/Hanwha_Q_CELLS_QPEAK_DUO-G6_iso_DB.jpg',
            'unit' => 'szt.',
            'order' => 10,
            'hidden' => [
                'calcpv' => true,
                'print' => false
            ],
            'productCard' => 'karta-produktu-modul-fotowoltaiczny-q-cells-qpeak-duo-g6-350.pdf'
        ],

        /* inverters */
        'kwp1' => [
            'code' => '31.01.00',
            'name' => 'Solis Mini 1000',
            'group' => ['pv', 'inverters'],
            'nominalPower' => 1.0,
            'inverterInfo' => '1,0 kW, 1-fazowy',
            'link' => 'zestaw-1',
            'priceFactor' => 1.1,
            'unit' => 'szt.',
            'order' => 20,
            'productCard' => 'karta-produktu-inwerter-solis-mini-1000-2g.pdf'
        ],
        'kwp2' => [
            'code' => '31.38.00',
            'name' => 'Solis S6-GR1P2K',
            'group' => ['pv', 'inverters'],
            'nominalPower' => 2.0,
            'inverterInfo' => '2,0 kW, 1-fazowy',
            'link' => 'zestaw-2',
            'priceFactor' => 1.1,
            'unit' => 'szt.',
            'order' => 20,
            'productCard' => 'karta-produktu-inwerter-solis-s6-gr1p2k-m.pdf'
        ],
        'kwp3' => [
            'code' => '31.39.00',
            'name' => 'Solis S6-GR1P3K',
            'group' => ['pv', 'inverters'],
            'nominalPower' => 3.0,
            'inverterInfo' => '3,0 kW, 1-fazowy',
            'link' => 'zestaw-3',
            'priceFactor' => 1.1,
            'unit' => 'szt.',
            'order' => 20,
            'productCard' => 'karta-produktu-inwerter-solis-1p3k-4g.pdf'
        ],
        'kwp3|3' => [
            'code' => '31.26.00',
            'name' => 'Solis 3P3K-4G',
            'group' => ['pv', 'inverters'],
            'nominalPower' => 3.0,
            'inverterInfo' => '3,0 kW, 3-fazowy',
            'link' => 'zestaw-3',
            'priceFactor' => 1.1,
            'unit' => 'szt.',
            'order' => 20,
            'productCard' => 'karta-produktu-inwerter-solis-3p3k-4g.pdf',
            'isVariant' => true
        ],
        'kwp5' => [
            'code' => '31.40.00',
            'name' => 'Solis S5-GR3P5K',
            'group' => ['pv', 'inverters'],
            'nominalPower' => 5.0,
            'inverterInfo' => '5,0 kW, 3-fazowy',
            'link' => 'zestaw-5',
            'priceFactor' => 1.11,
            'unit' => 'szt.',
            'order' => 20,
            'productCard' => 'karta-produktu-inwerter-solis-s5-gr3p5k.pdf'
        ],
        'kwp6' => [
            'code' => '31.41.00',
            'name' => 'Solis S5-GR3P6K',
            'group' => ['pv', 'inverters'],
            'nominalPower' => 6.0,
            'inverterInfo' => '6,0 kW, 3-fazowy',
            'link' => 'zestaw-6',
            'priceFactor' => 1.12,
            'unit' => 'szt.',
            'order' => 20,
            'productCard' => 'karta-produktu-inwerter-solis-s5-gr3p6k.pdf'
        ],
        'kwp8' => [
            'code' => '31.42.00',
            'name' => 'Solis S5-GR3P8K',
            'group' => ['pv', 'inverters'],
            'nominalPower' => 8.0,
            'inverterInfo' => '8,0 kW, 3-fazowy',
            'link' => 'zestaw-8',
            'priceFactor' => 1.12,
            'unit' => 'szt.',
            'order' => 20,
            'productCard' => 'karta-produktu-inwerter-solis-s5-gr3p8k.pdf'
        ],
        'kwp10' => [
            'code' => '31.43.00',
            'name' => 'Solis S5-GR3P10K',
            'group' => ['pv', 'inverters'],
            'nominalPower' => 10.0,
            'inverterInfo' => '10,0 kW, 3-fazowy',
            'link' => 'zestaw-10',
            'priceFactor' => 1.12,
            'unit' => 'szt.',
            'order' => 20,
            'productCard' => 'karta-produktu-inwerter-solis-s5-gr3p10k.pdf'
        ],

        /* switchgears */
        'ac1b6a' => [
            'code' => '33.25.00',
            'name' => 'Rozdzielnica AC 1 B6A',
            'group' => ['pv', 'switchgears'],
            'model' => 'AC 1 B6A',
            'inverters' => ['kwp1'],
            'unit' => 'szt.',
            'order' => 30
        ],
        'ac1b10a' => [
            'code' => '33.21.00',
            'name' => 'Rozdzielnica AC 1 B10A',
            'group' => ['pv', 'switchgears'],
            'model' => 'AC 1 B10A',
            'inverters' => ['kwp2'],
            'unit' => 'szt.',
            'order' => 30
        ],
        'ac1b16a' => [
            'code' => '33.22.00',
            'name' => 'Rozdzielnica AC 1 B16A',
            'group' => ['pv', 'switchgears'],
            'model' => 'AC 1 B16A',
            'inverters' => ['kwp3'],
            'unit' => 'szt.',
            'order' => 30
        ],
        'ac1b20a' => [
            'code' => '33.23.00',
            'name' => 'Rozdzielnica AC 1 B20A',
            'group' => ['pv', 'switchgears'],
            'model' => 'AC 1 B20A',
            'inverters' => [],
            'unit' => 'szt.',
            'order' => 30
        ],
        'ac1b25a' => [
            'code' => '33.24.00',
            'name' => 'Rozdzielnica AC 1 B25A',
            'group' => ['pv', 'switchgears'],
            'model' => 'AC 1 B25A',
            'inverters' => [],
            'unit' => 'szt.',
            'order' => 30
        ],
        'ac3b10a' => [
            'code' => '33.26.00',
            'name' => 'Rozdzielnica AC 3 B10A',
            'group' => ['pv', 'switchgears'],
            'model' => 'AC 3 B10A',
            'inverters' => ['kwp3|3', 'kwp5', 'kwp6'],
            'unit' => 'szt.',
            'order' => 30
        ],
        'ac3b16a' => [
            'code' => '33.27.00',
            'name' => 'Rozdzielnica AC 3 B16A',
            'group' => ['pv', 'switchgears'],
            'model' => 'AC 3 B16A',
            'inverters' => ['kwp8', 'kwp10'],
            'unit' => 'szt.',
            'order' => 30
        ],
        'ac3b26a' => [
            'name' => 'Rozdzielnica AC 3 B26A',
            'group' => ['pv', 'switchgears'],
            'model' => 'AC 3 B26A',
            'inverters' => [],
            'unit' => 'szt.',
            'order' => 30
        ],

        /* connectors */
        'mc4' => [
            'code' => '35.06.00',
            'name' => 'KONEKTOR MC-MC4 1500V (PARA)',
            'group' => ['pv', 'connectors'],
            'unit' => 'kpl.',
            'order' => 40
        ],

        /* wires */
        'w50' => [
            'code' => '34.03.00',
            'name' => 'Przewód PV 1x4 Czarny (Rolka 50m)',
            'group' => ['pv', 'wires'],
            'length' => 50,
            'lengthUnit' => 'm',
            'inverters' => ['kwp1', 'kwp2'],
            'unit' => 'szt.',
            'price' => 147,
            'visibleOnSlcList' => true,
            'order' => 50
        ],
        'w50r' => [
            'code' => '34.06.00',
            'name' => 'Przewód PV 1x4 Czerwony (Rolka 50m)',
            'group' => ['pv', 'wires'],
            'length' => 50,
            'lengthUnit' => 'm',
            'inverters' => ['kwp1', 'kwp2'],
            'unit' => 'szt.',
            'price' => 147,
            'isVariant' => true,
            'visibleOnSlcList' => true,
            'order' => 50
        ],
        'w100' => [
            'code' => '34.01.00',
            'name' => 'Przewód PV 1x4 Czarny (Rolka 100m)',
            'group' => ['pv', 'wires'],
            'length' => 100,
            'lengthUnit' => 'm',
            'inverters' => ['kwp3', 'kwp3|3', 'kwp5', 'kwp6', 'kwp8', 'kwp10'],
            'unit' => 'szt.',
            'price' => 294,
            'visibleOnSlcList' => true,
            'order' => 50
        ],

        /* montage systems */
        'blachodachowka' => [
            'name' => 'System montażowy - śruba dwugwintowa',
            'group' => ['pv', 'montageSystems'],
            'roofCoverageName' => 'blachodachówka',
            'usage' => 'roofSlanted',
            'unit' => 'szt.',
            'order' => 60
        ],
        'dachowka' => [
            'name' => 'System montażowy - dachówka',
            'group' => ['pv', 'montageSystems'],
            'roofCoverageName' => 'dachówka',
            'usage' => 'roofSlanted',
            'unit' => 'szt.',
            'order' => 60
        ],
        'rabek' => [
            'name' => 'System montażowy - rąbek stojący',
            'group' => ['pv', 'montageSystems'],
            'roofCoverageName' => 'blacha na rąbek',
            'usage' => 'roofSlanted',
            'unit' => 'szt.',
            'order' => 60
        ],
        'trapez' => [
            'name' => 'System montażowy - trapez',
            'group' => ['pv', 'montageSystems'],
            'roofCoverageName' => 'blacha trapezowa',
            'usage' => 'roofSlanted',
            'unit' => 'szt.',
            'order' => 60
        ],
        'gont' => [
            'name' => 'System montażowy - gont',
            'group' => ['pv', 'montageSystems'],
            'roofCoverageName' => 'gont bitumiczny',
            'usage' => 'roofSlanted',
            'unit' => 'szt.',
            'order' => 60
        ],
        'poziomo1' => [
            'name' => 'System montażowy - dach płaski',
            'exactName' => 'System montażowy - panel poziomo',
            'group' => ['pv', 'montageSystems'],
            'roofCoverageName' => 'pojedyncze poziomo',
            'usage' => 'roofFlat',
            'unit' => 'szt.',
            'order' => 60
        ],
        'pionowo1' => [
            'name' => 'System montażowy - dach płaski',
            'exactName' => 'System montażowy - panele pionowo',
            'group' => ['pv', 'montageSystems'],
            'roofCoverageName' => 'pojedyncze pionowo',
            'usage' => 'roofFlat',
            'unit' => 'szt.',
            'order' => 60
        ],
        'poziomo2' => [
            'name' => 'System montażowy - dach płaski',
            'exactName' => 'System montażowy - 2 panele poziomo',
            'group' => ['pv', 'montageSystems'],
            'roofCoverageName' => 'podwójne poziomo',
            'usage' => 'roofFlat',
            'unit' => 'szt.',
            'order' => 60
        ],
        'grunt' => [
            'name' => 'System montażowy - grunt',
            'group' => ['pv', 'montageSystems'],
            'roofCoverageName' => 'grunt',
            'usage' => 'roofGround',
            'unit' => 'szt.',
            'order' => 60
        ],

        /* additional components */
        'optiEnerSet' => [
            'name' => 'OPTI-ENER',
            'group' => ['pv', 'optiEner'],
            'price' => 949.82,
            'autoconsumptionLevel' => 45,
            'unit' => 'szt.',
            'order' => 70
        ],
        'modem' => [
            'code' => '74.02.04',
            'name' => 'Modem EKO-LAN',
            'group' => ['pv'],
            'unit' => 'szt.',
            'order' => 80
        ],
        'tigoOptimizer' => [
            'code' => '33.40.00',
            'name' => 'Optymalizator TIGO TS4-A-O',
            'group' => ['pv'],
            'price' => 280,
            'unit' => 'szt.',
            'visibleOnSlcList' => true
        ],
        'tigoGate' => [
            'code' => '30.42.00',
            'name' => 'Bramka TIGO',
            'group' => ['pv'],
            'price' => 313,
            'unit' => 'szt.',
            'visibleOnSlcList' => true
        ],
        'tigoMonitoring' => [
            'code' => '39.60.00',
            'name' => 'System monitoringu TIGO',
            'group' => ['pv'],
            'price' => 1162,
            'unit' => 'szt.',
            'visibleOnSlcList' => true
        ],
        'datastick' => [
            'code' => '36.02.02',
            'name' => 'Solis Wi-Fi Datastick',
            'group' => ['pv'],
            'price' => 218,
            'unit' => 'szt.',
            'visibleOnSlcList' => true
        ],
        'op1000' => [
            'code' => '29.05.00',
            'name' => 'Ogranicznik przepięć PV B+C NPE 1000V',
            'group' => ['pv'],
            'price' => 289,
            'unit' => 'szt.',
            'visibleOnSlcList' => true
        ]
    ];

    /*
     * Additional properities:
     *  'discountPrice',
     *  'promotionalImage'
     *  'link' - name of kit custom html template, overrides default 'zestaw.phtml' template
     */
    private static $kitsInfo = [
        'kwp1' => [
            'title'             => 'Instalacja 1 kW',
            'displayStartPrice' => 8602,
            'inverter' => [
                'name' => 'Inwerter Solis Mini 1000',
                'url'  => '/fotowoltaika/inwertery/solis-mini-1000.html',
            ],
            'cableLength' => 50,
            'defaultPanelCount' => [
                'jam6' => 3,
                'jam6bf' => 3,
                'jam6bf370' => 3,
                'jam6bf380' => 3,
                'jam6bf385' => 3,
                'qpeak350g6' => 3
            ],
            'connectors'  => [
                'jam6' => 4,
                'jam6bf' => 4,
                'jam6bf370' => 4,
                'jam6bf380' => 4,
                'jam6bf385' => 4,
                'qpeak350g6' => 4
            ],
            'description' => 'Dla gospodarstwa domowego',
            'inhabitants' => 2,
        ],
        'kwp2' => [
            'title'             => 'Instalacja 2 kW',
            'displayStartPrice' => 11886,
            'inverter' => [
                'name' => 'Inwerter Solis S6-GR1P2K',
                'url'  => '/oferta/inwertery/solis-s6-gr1p2k-m.html',
            ],
            'cableLength' => 50,
            'defaultPanelCount' => [
                'jam6' => 6,
                'jam6bf' => 6,
                'jam6bf370' => 6,
                'jam6bf380' => 5,
                'jam6bf385' => 5,
                'qpeak350g6' => 6
            ],
            'connectors'  => [
                'jam6' => 4,
                'jam6bf' => 4,
                'jam6bf370' => 4,
                'jam6bf380' => 4,
                'jam6bf385' => 4,
                'qpeak350g6' => 4
            ],
            'description' => 'Dla gospodarstwa domowego',
            'inhabitants' => 3,
        ],
        'kwp3' => [
            'title'             => 'Instalacja 3 kW',
            'displayStartPrice' => 16833,
            'inverter' => [
                'name' => 'Inwerter Solis S6-GR1P3K',
                'url'  => '/fotowoltaika/inwertery/solis-3.html',
            ],
            'cableLength' => 50,
            'defaultPanelCount' => [
                'jam6' => 9,
                'jam6bf' => 9,
                'jam6bf370' => 8,
                'jam6bf380' => 8,
                'jam6bf385' => 8,
                'qpeak350g6' => 9
            ],
            'connectors'  => [
                'jam6' => 4,
                'jam6bf' => 4,
                'jam6bf370' => 4,
                'jam6bf380' => 4,
                'jam6bf385' => 4,
                'qpeak350g6' => 4
            ],
            'description' => 'Dla gospodarstwa domowego',
            'inhabitants' => 4,
        ],
        'kwp5' => [
            'title'             => 'Instalacja 5 kW',
            'displayStartPrice' => 27296,
            'inverter' => [
                'name' => 'Inwerter Solis S5-GR3P5K',
                'url'  => '/oferta/inwertery/solis-s5-gr3p5k.html',
            ],
            'cableLength' => 100,
            'defaultPanelCount' => [
                'jam6' => 15,
                'jam6bf' => 15,
                'jam6bf370' => 14,
                'jam6bf380' => 13,
                'jam6bf385' => 13,
                'qpeak350g6' => 15
            ],
            'connectors'  => [
                'jam6' => 4,
                'jam6bf' => 4,
                'jam6bf370' => 4,
                'jam6bf380' => 4,
                'jam6bf385' => 4,
                'qpeak350g6' => 4
            ],
            'description' => 'Dla gospodarstwa domowego',
            'inhabitants' => 5,
        ],
        'kwp6' => [
            'title'             => 'Instalacja 6 kW',
            'displayStartPrice' => 31744,
            'inverter' => [
                'name' => 'Inwerter Solis S5-GR3P6K',
                'url'  => '/oferta/inwertery/solis-s5-gr3p6k.html',
            ],
            'cableLength' => 100,
            'defaultPanelCount' => [
                'jam6' => 18,
                'jam6bf' => 18,
                'jam6bf370' => 16,
                'jam6bf380' => 16,
                'jam6bf385' => 16,
                'qpeak350g6' => 18
            ],
            'connectors'  => [
                'jam6' => 4,
                'jam6bf' => 4,
                'jam6bf370' => 4,
                'jam6bf380' => 4,
                'jam6bf385' => 4,
                'qpeak350g6' => 4
            ],
            'description' => 'Dla dużego gospodarstwa domowego',
        ],
        'kwp8' => [
            'title'             => 'Instalacja 8 kW',
            'displayStartPrice' => 38103,
            'inverter' => [
                'name' => 'Inwerter Solis S5-GR3P8K',
                'url'  => '/oferta/inwertery/solis-s5-gr3p8k.html',
            ],
            'cableLength' => 100,
            'defaultPanelCount' => [
                'jam6' => 24,
                'jam6bf' => 24,
                'jam6bf370' => 22,
                'jam6bf380' => 21,
                'jam6bf385' => 21,
                'qpeak350g6' => 24
            ],
            'connectors'  => [
                'jam6' => 4,
                'jam6bf' => 4,
                'jam6bf370' => 4,
                'jam6bf380' => 4,
                'jam6bf385' => 4,
                'qpeak350g6' => 4
            ],
            'description' => 'Dla dużego gospodarstwa domowego',
        ],
        'kwp10' => [
            'title'             => 'Instalacja 10 kW',
            'displayStartPrice' => 44859,
            'inverter' => [
                'name' => 'Inwerter Solis S5-GR3P10K',
                'url'  => '/oferta/inwertery/solis-s5-gr3p10k.html',
            ],
            'cableLength' => 100,
            'defaultPanelCount' => [
                'jam6' => 29,
                'jam6bf' => 29,
                'jam6bf370' => 27,
                'jam6bf380' => 26,
                'jam6bf385' => 25,
                'qpeak350g6' => 29
            ],
            'connectors'  => [
                'jam6' => 8,
                'jam6bf' => 8,
                'jam6bf370' => 8,
                'jam6bf380' => 8,
                'jam6bf385' => 8,
                'qpeak350g6' => 8
            ],
            'description' => 'Dla dużego gospodarstwa domowego',
        ],
    ];

    private static $panelsBaseData = [];
    private static $kitsBaseData = [];
    private static $montageSystems = [];

    public static $CALCPV_DESTINATION = 'calcpv';
    private $destination = '';

    public function setDestination(string $destination = '')
    {
        $this->destination = $destination;
        return $this;
    }

    private function init()
    {
        foreach (self::$products as $productId => $product) {
            $product['id'] = $productId;
            $product = array_merge($product, $this->getProductPricing($product));
            $product = array_merge($product, $this->getInverterPowerLimits($product));

            self::$products[$productId] = $product;
        }

        self::$panelsBaseData = array_filter(self::$products, function ($product) {
            return $product['group'] == ['pv', 'panels'];
        });
        self::$kitsBaseData = array_filter(self::$products, function ($product) {
            return $product['group'] == ['pv', 'inverters'];
        });
        self::$montageSystems = array_filter(self::$products, function ($product) {
            return $product['group'] == ['pv', 'montageSystems'];
        });
    }

    private function getProductPricing($product)
    {
        /* montage systems */
        if ($product['group'] == ['pv', 'montageSystems']) {
            $montagePricing = self::$montageSystemsMontagePricesByPanelTypes[$product['id']]
                ?? array_fill_keys(array_keys(self::$panelsPrices), self::$montageSystemsMontagePrices[$product['id']]);
            return ['price' => $montagePricing];
        }

        /* inverters */
        if ($product['group'] == ['pv', 'inverters']) {
            $kitBasePrice = self::$kitsBasePricesByPanelTypes[$product['id']] ?? self::$kitsBasePrices[$product['id']];
            $kitBasePrice = $this->getInverterPriceByDestination($kitBasePrice, $product);
            if (is_array($kitBasePrice)) {
                return ['price' => array_combine(array_keys(self::$panelsPrices), $kitBasePrice)];
            }
            return ['price' => array_fill_keys(array_keys(self::$panelsPrices), $kitBasePrice)];
        }

        /* panels */
        if ($product['group'] == ['pv', 'panels']) {
            return ['price' => self::$panelsPrices[$product['id']]];
        }

        return [];
    }

    private function getInverterPowerLimits($product)
    {
        if (!($product['group'] == ['pv', 'inverters'])) {
            return [];
        }

        $panels = array_filter(self::$products, function ($item) {
            return $item['group'] == ['pv', 'panels'];
        });
        $panelTypes = array_keys($panels);
        $deafaultLimits = array_fill_keys($panelTypes, self::$invertersPowerLimitsByPanelTypes['default']);
        $limits = array_replace_recursive($deafaultLimits, self::$invertersPowerLimitsByPanelTypes[$product['id']] ?? []);

        return ['powerLimits' => $limits];
    }

    private function getInverterPriceByDestination($kitBasePrice, $product)
    {
        if ($this->destination === self::$CALCPV_DESTINATION) {
            $wire = array_first(self::$products, function ($item) use ($product) {
                return in_array('wires', $item['group']) && in_array($product['id'], $item['inverters']) && !($item['isVariant'] ?? false);
            });
            if (is_array($kitBasePrice)) {
                return array_map(function ($item) use ($wire) {
                    return $item -= $wire['price'] ?? 0;
                }, $kitBasePrice);
            }
            return $kitBasePrice -= $wire['price'] ?? 0;
        }
        return $kitBasePrice;
    }

    public function getSetsInfo()
    {
        $this->init();

        $data = [];

        foreach (self::$kitsInfo as $key => $set) {
            $setData = $this->getCustomSetInfo($set);
            if ($setData) {
                $link = $set['link'];
                $data[$link] = $setData;
                continue;
            }

            $link = self::$kitsBaseData[$key]['link'];

            $data[$link] = $set;
            $data[$link]['key'] = $key;
            $data[$link]['basePrice'] = $this->getKitBasePrice($key);
            $data[$link]['panelsData'] = self::$panelsBaseData;
            $data[$link]['panelPrices'] = isset(self::$kitsInfo[$key]['panelPrices']) ? self::$kitsInfo[$key]['panelPrices'] : self::$panelsPrices;
            $data[$link]['montagePrices'] = $this->getMontageSystemsMontagePrices();
            $data[$link]['montageConstCost'] = self::$montageConstCost;
            $data[$link]['power'] = self::$kitsBaseData[$key]['nominalPower'] * 1000;
            $data[$link]['powerLimits'] = self::$kitsBaseData[$key]['powerLimits'];
            $data[$link]['setPriceFactor'] = self::$kitsBaseData[$key]['priceFactor'];
            $data[$link]['totalPriceFactor'] = self::$totalPriceFactor;
        }

        $data = $this->getSetsWithPromoPrices($data);

        return $data;
    }

    private function getCustomSetInfo($set)
    {
        $customKit = $set['customKit'] ?? false;
        if (!$customKit) {
            return null;
        }

        switch ($set['link']) {
            case 'zestaw-3-tigo':
                $key = $set['parentKit'];
                $data = [
                    'key' => $set['link'],
                    'basePrice' => $this->getKitBasePrice($key),
                    'panelsData' => [
                        'jam6' => [
                            'name' => "JA SOLAR JAM60S04-315/PR TIGO",
                            'maxPower' => 0.315,
                            'link' => '/oferta/panele-fotowoltaiczne/panel-fotowoltaiczny-ja-solar-315-tigo.html'
                        ]
                    ],
                    'panelPrices' => isset(self::$kitsInfo[$key]['panelPrices']) ? self::$kitsInfo[$key]['panelPrices'] : self::$panelsPrices,
                    'montagePrices' => $this->getMontageSystemsMontagePrices(),
                    'montageConstCost' => self::$montageConstCost,
                    'power' => self::$kitsBaseData[$key]['nominalPower'] * 1000,
                    'setPriceFactor' => self::$kitsBaseData[$key]['priceFactor'],
                    'totalPriceFactor' => self::$totalPriceFactor
                ];
                break;
        }
        $result = array_merge($set, $data);

        return $result;
    }

    private function getKitBasePrice(string $key)
    {
        $kitBasePrice = self::$kitsBasePricesByPanelTypes[$key] ?? self::$kitsBasePrices[$key];
        if (is_array($kitBasePrice)) {
            return array_combine(array_keys(self::$panelsPrices), $kitBasePrice);
        }
        return array_fill_keys(array_keys(self::$panelsPrices), $kitBasePrice);
    }

    private function getMontageSystemsMontagePrices()
    {
        $montagePrices = [];

        foreach (self::$montageSystemsMontagePrices as $montageSystem => $montagePrice) {
            $montagePricing = self::$montageSystemsMontagePricesByPanelTypes[$montageSystem]
                ?? array_fill_keys(array_keys(self::$panelsPrices), $montagePrice);

            $montagePrices[$montageSystem] = $montagePricing;
        }

        return $montagePrices;
    }

    private function getSetsWithPromoPrices($data)
    {
        foreach ($data as $link => $values) {
            $promoPrices = isset(self::$promoPrices[$values['key']]) ? self::$promoPrices[$values['key']] : [];
            if (!$promoPrices) {
                return $data;
            }

            if (isset($promoPrices['panelsPrices'])) {
                $data[$link]['panelPrices'] = $promoPrices['panelsPrices'];
            }
            if (isset($promoPrices['basePrice'])) {
                $data[$link]['basePrice'] = $promoPrices['basePrice'];
            }
            if (isset($promoPrices['montagePrices'])) {
                $data[$link]['montagePrices'] = array_merge($data[$link]['montagePrices'], $promoPrices['montagePrices']);
            }
        }

        return $data;
    }

    public function getKitsInfoForCalcPv()
    {
        $this->init();

        return [
            'panelsData' =>  array_values(self::$panelsBaseData),
            'kitsData' => array_values(self::$kitsBaseData),
            'montageData' => array_values(self::$montageSystems),
            'montageConstCost' => self::$montageConstCost,
            'promoPrices' => self::$promoPrices,
            'totalPriceFactor' => self::$totalPriceFactor,
            'products' => self::$products,
            'wires' => array_values(array_filter(self::$products, function ($product) {
                return in_array('wires', $product['group']);
            }))
        ];
    }

    public function getProducts()
    {
        $this->init();
        return self::$products;
    }
}
