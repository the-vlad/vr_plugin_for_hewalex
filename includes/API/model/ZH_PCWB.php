<?php

namespace Develtio\ZonesHewalex\API\model;

use Phpml\Regression\LeastSquares;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_PCWB
 */
class ZH_PCWB
{
    private $cells;
    private $formModels;
    private $productsParams = [];
    private $regression;

    public static $configTa = [
        'PCWB' => [2, 7, 15, 24, 27, 35, 42],
        'PCCO' => [-15, -7, 2, 7, 12]
    ];

    public static $reference = [
        'tempOfvaporization' => [
            7 => 2485,
            18	=> 2460.2,
            24	=> 2444.6,
            25	=> 2441.52,
            26	=> 2439.15,
            27	=> 2436.79,
            28	=> 2433.1,
            30	=> 2429.67,
            32	=> 2423.8,
            34	=> 2420.16,
            36	=> 2416,
            37	=> 2413.02,
            38	=> 2410.63,
            39	=> 2409.2,
            40	=> 2405.86,
            41	=> 2403.2,
        ],

        'tempOfWaterVaporPressure' => [
            0 => 0.61129,
            1 => 0.65716,
            2 => 0.70605,
            3 => 0.75813,
            4 => 0.81359,
            5 => 0.8726,
            6 => 0.93537,
            7 => 1.0021,
            8 => 1.073,
            9 => 1.1482,
            10 => 1.2281,
            11 => 1.3129,
            12 => 1.4027,
            13 => 1.4979,
            14 => 1.5988,
            15 => 1.7056,
            16 => 1.8185,
            17 => 1.938,
            18 => 2.0644,
            19 => 2.1978,
            20 => 2.3388,
            21 => 2.4877,
            22 => 2.6447,
            23 => 2.8104,
            24 => 2.985,
            25 => 3.169,
            26 => 3.3629,
            27 => 3.567,
            28 => 3.7818,
            29 => 4.0078,
            30 => 4.2455,
            31 => 4.4953,
            32 => 4.7578,
            33 => 5.0335,
            34 => 5.3229,
            35 => 5.6267,
            36 => 5.9453,
            37 => 6.2795,
            38 => 6.6298,
            39 => 6.9969,
            40 => 7.3814,
            41 => 7.784,
            42 => 8.2054,
            43 => 8.6463,
            44 => 9.1075,
            45 => 9.5898,
            46 => 10.094,
            47 => 10.62,
            48 => 11.171,
            49 => 11.745,
            50 => 12.344,
            51 => 12.97,
            52 => 13.623,
            53 => 14.303,
            54 => 15.012,
            55 => 15.752,
            56 => 16.522,
            57 => 17.324,
            58 => 18.159,
            59 => 19.028,
            60 => 19.932,
            61 => 20.873,
            62 => 21.851,
            63 => 22.868,
            64 => 23.925,
            65 => 25.022,
            66 => 26.163,
            67 => 27.347,
            68 => 28.576,
            69 => 29.852,
            70 => 31.176,
            71 => 32.549,
            72 => 33.972,
            73 => 35.448,
            74 => 36.978,
            75 => 38.563,
            76 => 40.205,
            77 => 41.905,
            78 => 43.665,
            79 => 45.487,
            80 => 47.373,
            81 => 49.324,
            82 => 51.342,
            83 => 53.428,
            84 => 55.585,
            85 => 57.815,
            86 => 60.119,
            87 => 62.499,
            88 => 64.958,
            89 => 67.496,
            90 => 70.117,
            91 => 72.823,
            92 => 75.614,
            93 => 78.494,
            94 => 81.465,
            95 => 84.529,
            96 => 87.688,
            97 => 90.945,
            98 => 94.301,
            99 => 97.759,
            100 => 101.32,
            101 => 104.99,
            102 => 108.77,
            103 => 112.66,
            104 => 116.67,
            105 => 120.79,
            106 => 125.03,
            107 => 129.39,
            108 => 133.88,
            109 => 138.5,
            110 => 143.24,
            111 => 148.12,
            112 => 153.13,
            113 => 158.29,
            114 => 163.58,
            115 => 169.02,
            116 => 174.61,
            117 => 180.34,
            118 => 186.23,
            119 => 192.28,
            120 => 198.48,
            121 => 204.85,
            122 => 211.38,
            123 => 218.09,
            124 => 224.96,
            125 => 232.01,
            126 => 239.24,
            127 => 246.66,
            128 => 254.25,
            129 => 262.04,
            130 => 270.02,
            131 => 278.2,
            132 => 286.57,
            133 => 295.15,
            134 => 303.93,
            135 => 312.93,
            136 => 322.14,
            137 => 331.57,
            138 => 341.22,
            139 => 351.09,
            140 => 361.19,
            141 => 371.53,
            142 => 382.11,
            143 => 392.92,
            144 => 403.98,
            145 => 415.29,
            146 => 426.85,
            147 => 438.67,
            148 => 450.75,
            149 => 463.1,
            150 => 475.72,
            151 => 488.61,
            152 => 501.78,
            153 => 515.23,
            154 => 528.96,
            155 => 542.99,
            156 => 557.32,
            157 => 571.94,
            158 => 586.87,
            159 => 602.11,
            160 => 617.66,
            161 => 633.53,
            162 => 649.73,
            163 => 666.25,
            164 => 683.1,
            165 => 700.29,
            166 => 717.83,
            167 => 735.7,
            168 => 753.94,
            169 => 772.52,
            170 => 791.47,
            171 => 810.78,
            172 => 830.47,
            173 => 850.53,
            174 => 870.98,
            175 => 891.8,
            176 => 913.03,
            177 => 934.64,
            178 => 956.66,
            179 => 979.09,
            180 => 1001.9,
            181 => 1025.2,
            182 => 1048.9,
            183 => 1073,
            184 => 1097.5,
            185 => 1122.5,
            186 => 1147.9,
            187 => 1173.8,
            188 => 1200.1,
            189 => 1226.1,
            190 => 1254.2,
            191 => 1281.9,
            192 => 1310.1,
            193 => 1338.8,
            194 => 1368,
            195 => 1397.6,
            196 => 1427.8,
            197 => 1458.5,
            198 => 1489.7,
            199 => 1521.4,
            200 => 1553.6,
            201 => 1568.4,
            202 => 1619.7,
            203 => 1653.6,
            204 => 1688,
            205 => 1722.9,
            206 => 1758.4,
            207 => 1794.5,
            208 => 1831.1,
            209 => 1868.4,
            210 => 1906.2,
            211 => 1944.6,
            212 => 1983.6,
            213 => 2023.2,
            214 => 2063.4,
            215 => 2104.2,
            216 => 2145.7,
            217 => 2187.8,
            218 => 2230.5,
            219 => 2273.8,
            220 => 2317.8,
            221 => 2362.5,
            222 => 2407.8,
            223 => 2453.8,
            224 => 2500.5,
            225 => 2547.9,
            226 => 2595.9,
            227 => 2644.6,
            228 => 2694.1,
            229 => 2744.2,
            230 => 2795.1,
            231 => 2846.7,
            232 => 2899,
            233 => 2952.1,
            234 => 3005.9,
            235 => 3060.4,
            236 => 3115.7,
            237 => 3171.8,
            238 => 3288.6,
            239 => 3286.3,
            240 => 3344.7,
            241 => 3403.9,
            242 => 3463.9,
            243 => 3524.7,
            244 => 3586.3,
            245 => 3648.8,
            246 => 3712.1,
            247 => 3776.2,
            248 => 3841.2,
            249 => 3907,
            250 => 3973.6,
            251 => 4041.2,
            252 => 4109.6,
            253 => 4178.9,
            254 => 4249.1,
            255 => 4320.2,
            256 => 4392.2,
            257 => 4465.1,
            258 => 4539,
            259 => 4613.7,
            260 => 4689.4,
            261 => 4766.1,
            262 => 4843.7,
            263 => 4922.3,
            264 => 5001.8,
            265 => 5082.3,
            266 => 5163.8,
            267 => 5246.3,
            268 => 5329.8,
            269 => 5414.3,
            270 => 5499.9,
            271 => 5586.4,
            272 => 5674,
            273 => 5762.7,
            274 => 5852.4,
            275 => 5943.1,
            276 => 6035,
            277 => 6127.9,
            278 => 6221.9,
            279 => 6317.2,
            280 => 6413.2,
            281 => 6510.5,
            282 => 6608.9,
            283 => 6708.5,
            284 => 6809.2,
            285 => 6911.1,
            286 => 7014.1,
            287 => 7118.3,
            288 => 7223.7,
            289 => 7330.2,
            290 => 7438,
            291 => 7547,
            292 => 7657.2,
            293 => 7768.6,
            294 => 7881.3,
            295 => 7995.2,
            296 => 8110.3,
            297 => 8226.8,
            298 => 8344.5,
            299 => 8463.5,
            300 => 8583.8,
            301 => 8705.4,
            302 => 8828.3,
            303 => 8952.6,
            304 => 9078.2,
            305 => 9205.1,
            306 => 9333.4,
            307 => 9463.1,
            308 => 9594.2,
            309 => 9726.7,
            310 => 9860.5,
            311 => 9995.8,
            312 => 10133,
            313 => 10271,
            314 => 10410,
            315 => 10551,
            316 => 10694,
            317 => 10838,
            318 => 10984,
            319 => 11131,
            320 => 11279,
            321 => 11429,
            322 => 11581,
            323 => 11734,
            324 => 11889,
            325 => 12046,
            326 => 12204,
            327 => 12364,
            328 => 12525,
            329 => 12688,
            330 => 12852,
            331 => 13019,
            332 => 13187,
            333 => 13357,
            334 => 13528,
            335 => 13701,
            336 => 13876,
            337 => 14053,
            338 => 14232,
            339 => 14412,
            340 => 14594,
            341 => 14778,
            342 => 14964,
            343 => 15152,
            344 => 15342,
            345 => 15533,
            346 => 15727,
            347 => 15922,
            348 => 16120,
            349 => 16320,
            350 => 16521,
            351 => 16825,
            352 => 16932,
            353 => 17138,
            354 => 17348,
            355 => 17561,
            356 => 17775,
            357 => 17992,
            358 => 18211,
            359 => 18432,
            360 => 18655,
            361 => 18881,
            362 => 19110,
            363 => 19340,
            364 => 19574,
            365 => 19809,
            366 => 20048,
            367 => 20289,
            368 => 20533,
            369 => 20780,
            370 => 21030,
            371 => 21286,
            372 => 21539,
            373 => 21803,
        ]
    ];

    public static $PCWB_DESTINATION = 'pcwb';

    public function __construct($cells = [])
    {
        $this->cells = $cells;
        $this->regression = new LeastSquares();
        $this->prepareProductsParams();
    }

    public function setCells($cells)
    {
        $this->cells = $cells;
    }


    public function getCells()
    {
        return $this->cells;
    }

    public function setFormModels($formModels)
    {
        $this->formModels = $formModels;
    }

    public function preparePagesReport()
    {
        $pages = [];

        $fontPage = [
            'template' => ZH_DIR . 'public/views/_pdf/offerform/pcwb/clientoffer/pageFront.phtml',
            'params' => $this->preparePageFrontParams(),
        ];

        $summaryPage = [
            'template' => ZH_DIR . 'public/views/_pdf/offerform/pcwb/clientoffer/pageLast.phtml',
            'params' => $this->preparePageLastParams($this->getCell('C', 40)),
        ];


        $pages[] = $fontPage;
        $pages[] = $this->preparePageParams('C', 40);

        if ($this->getCell('C', 41)) {
            $pages[] = $this->preparePageParams('C', 41);
        }
        if ($this->getCell('C', 42)) {
            $pages[] = $this->preparePageParams('C', 42);
        }
        if ($this->getCell('C', 43)) {
            $pages[] = $this->preparePageParams('C', 43);
        }

        $pages[] = $summaryPage;
        $pages[] = $this->preparePageRodo();

        return $pages;
    }

    public function preparePageParams($x, $y)
    {
        $path = ZH_DIR . 'public/views/_pdf/offerform/pcwb/clientoffer/';

        return [
            'template' => $path . ($this->formModels['poolUsagePeriod']['selectedId'] == 'year'
                    ? 'pageSplit.phtml' : 'pagePcwb.phtml'),
            'params' => $this->preparePumpParams($this->getCell($x, $y))
        ];
    }

    public function preparePageRodo()
    {
        return [
            'template' => ZH_DIR . 'public/views/_pdf/offerform/pcwb/clientoffer/pageRodo.phtml',
            'params' => [],
        ];
    }

    public function preparePagesReportHistory()
    {
        $pages = [];

        $fontPage = [
            'template' => ZH_DIR . 'public/views/_pdf/offerform/pcwb/history/clientoffer/pageFront.phtml',
            'params' => $this->preparePageFrontParams(),
        ];

        $summaryPage = [
            'template' => ZH_DIR . 'public/views/_pdf/offerform/pcwb/history/clientoffer/pageLast.phtml',
            'params' => $this->preparePageLastParams($this->getCell('C', 40)),
        ];


        $pages[] = $fontPage;
        $pages[] = $this->preparePageParamsHistory('C', 40);

        if ($this->getCell('C', 41)) {
            $pages[] = $this->preparePageParamsHistory('C', 41);
        }
        if ($this->getCell('C', 42)) {
            $pages[] = $this->preparePageParamsHistory('C', 42);
        }
        if ($this->getCell('C', 43)) {
            $pages[] = $this->preparePageParamsHistory('C', 43);
        }

        $pages[] = $summaryPage;
        $pages[] = $this->preparePageRodoHistory();

        return $pages;
    }

    public function preparePageParamsHistory($x, $y)
    {
        $path = ZH_DIR . 'public/views/_pdf/offerform/pcwb/history/clientoffer/';

        return [
            'template' => $path . ($this->formModels['poolUsagePeriod']['selectedId'] == 'year'
                    ? 'pageSplit.phtml' : 'pagePcwb.phtml'),
            'params' => $this->preparePumpParams($this->getCell($x, $y))
        ];
    }

    public function preparePageRodoHistory()
    {
        return [
            'template' => ZH_DIR . 'public/views/_pdf/offerform/pcwb/history/clientoffer/pageRodo.phtml',
            'params' => [],
        ];
    }

    public function preparePageFrontParams()
    {
        return [
            'pumpOffer' => $this->getPumpOffer(),
            'pumpParams' => $this->getPumpParams(),
            'pumpHeatPower' => $this->getPumpHeatPowerParams(),
        ];
    }

    public function prepareOneOfferParams()
    {
        $offer = $this->getPumpOffer1();
        $pumpParams = $this->preparePumpParams($this->getCell('C', 40));
        $pumpParams['pump'] = array_only($pumpParams['pump'], ['img', 'img1']);
        if (array_key_exists('img1', $pumpParams['pump'])) {
            $pumpParams['pump']['img'] = $pumpParams['pump']['img1'];
        }
        return array_merge(['offer' => $this->convertToValueLabel($offer[0])], $pumpParams);
    }

    public function convertToValueLabel($params)
    {
        $keys = [
            'model' => 'Model',
            'sku' => 'Numer katalogowy',
            'price' => 'Cena kat. netto',
            'quantity' => 'Ilość sztuk',
            'total_price' => 'Cena kat. netto łącznie',
        ];
        $values = [];
        foreach($keys as $key => $label) {
            if (array_key_exists($key, $params)) {
                $values[] = [
                    'label' => strip_tags($label),
                    'value' => strip_tags($params[$key]),
                    'unit' =>  in_array($key, ['price', 'total_price']) ? 'zł' : false,
                ];
            }
        }

        return $values;
    }

    public function getPumpOffer()
    {
        $offer = array_merge($this->getPumpOffer1(), $this->getPumpOffer2());
        $offer = array_filter($offer, function($item) {
            return $item['sku'];
        });

        usort($offer, function ($item1, $item2) {
            return $item1['total_price'] <=> $item2['total_price'];
        });

        $min = min($this->array_columns($offer, 'total_price'));
        $max = max($this->array_columns($offer, 'total_price'));
        $summary = [
            'quantity' => $this->getCell('D', 40),
            'price' => count($offer) > 1 ? sprintf('%s - %s zł', $min['total_price'], $max['total_price']) : sprintf('%s zł', $min['total_price']),
        ];

        return [
            'item' => $offer,
            'summary' => $summary,
        ];
    }

    public function getPumpOffer1()
    {
        $product = $this->getProductByType($this->getCell('C', 40));
        $product2 = $this->getProductByType($this->getCell('C', 42));
        $offer = [
            [
                'prefix' => '',
                'model' => $this->getCell('C', 40),
                'sku' => $product['sku'],
                'quantity' => $this->getCell('D', 40),
                'price' => $product['price'],
                'total_price' => $product['price'] * $this->getCell('D', 40),
            ],
            [
                'prefix' => $this->getCell('B', 42),
                'model' => $this->getCell('C', 42),
                'sku' => $product2['sku'],
                'quantity' => $this->getCell('D', 42),
                'price' => $product2['price'],
                'total_price' => $product2['price'] * ($this->getCell('D', 42) ?: 1),
            ],
        ];

        return $offer;
    }

    public function getPumpOffer2()
    {
        $C41 = $this->getCell('C', 41);
        if (!$C41) {
            return [];
        }

        $product = $this->getProductByType($this->getCell('C', 41));
        $product2 = $this->getProductByType($this->getCell('C', 43));
        $offer = [
            [
                'prefix' => '',
                'model' => $this->getCell('C', 41),
                'sku' => $product['sku'],
                'quantity' => $this->getCell('D', 41),
                'price' => $product['price'],
                'total_price' => $product['price'] * $this->getCell('D', 41),
            ],
            [
                'prefix' => $this->getCell('B', 43),
                'model' => $this->getCell('C', 43),
                'sku' => $product2['sku'],
                'quantity' => $this->getCell('D', 43),
                'price' => $product2['price'],
                'total_price' => $product2['price'] * $this->getCell('D', 43),
            ],
        ];

        return $offer;
    }

    public function getPumpParams()
    {
        return [
            [
                'label' => 'Lokalizacja',
                'value' => $this->getCell('C', 7)
            ],
            [
                'label' => 'Powierzchnia [m<sup>2</sup>]',
                'value' => $this->getCell('C', 9)
            ],
            [
                'label' => 'Głębokość [m<sup>2</sup>]',
                'value' => $this->getCell('C', 11)
            ],
            [
                'label' => 'Przeznaczenie basenu',
                'value' => $this->getCell('C', 12)
            ],
            [
                'label' => 'Odległość pomiędzy basenem i pompą ciepła',
                'value' => $this->getCell('F', 8)
            ],
            [
                'label' => 'Okres użytkowania basenu',
                'value' => $this->getCell('F', 9)
            ],
            [
                'label' => 'Czy istnieje dodatkowe źródło grzewcze do pierwszego ogrzewania wody basenowej?',
                'value' => $this->getCell('F', 12)
            ],
            [
                'label' => $this->getCell('E', 10) . '&nbsp;',
                'value' => $this->getCell('E', 10) ? $this->getCell('F', 10) : '',
            ],
            [
                'label' => 'Zakładana długość pierwszego ogrzewania wody basenowej [godz]',
                'value' => $this->getCell('C', 13),
            ],
            [
                'label' => 'Zadana temperatura wody basenowej [&deg;C]',
                'value' => $this->formModels['poolExpectedWaterTemp']['value'],
            ],
            [
                'label' => 'Min. temperatura otoczenia przy pompie ciepła [&deg;C]',
                'value' => $this->getCell('C', 15),
            ],
            [
                'label' => 'Temperatura świeżej wody [&deg;C]',
                'value' => $this->getCell('C', 17),
            ],
            [
                'label' => 'Ilośc dodatkowej świeżej wody dziennie [%]',
                'value' => ZH_OfferFormBase::getDatasetItemValue($this->formModels, 'poolUsage.options', $this->formModels['poolUsage']['selectedId']),
            ],
            [
                'label' => $this->getCell('E', 11). '&nbsp;',
                'value' => $this->getCell('E', 11) ? $this->getCell('F', 11) : '',
            ],
        ];
    }

    public function getPumpHeatPowerParams()
    {
        return [
            [
                'label' => 'Czas potrzebny do obniżenia temp. wody basenowej o 1&deg;C - bez ogrzewania [godz]',
                'value' => number_format($this->getCell('F', 23), 1, '.', ''),
            ],
            [
                'label' => 'Czas potrzebny do podwyższenia temp. wody basenowej o 1&deg;C - pompą ciepła',
                'value' => number_format($this->getCell('F', 24), 1, '.', ''),
            ],
        ];
    }

    public function preparePumpParams($pumpType)
    {
        $pump =  $this->getProductByType($pumpType);
        $head = $this->productsParams['pumpsHeadCaption'][$pump['category']];
        $keys = ['heatingPower', 'voltageFrequency', 'supplyPower', 'dimensions', 'cop', 'waterConnections',
            'compressorType', 'weightNet', 'typeRefrigerant', 'guarantee'];

        $params = [];
        foreach($keys as $key) {
            $params[] = [
                'label' => $head[$key],
                'value' => $pump[$key],
            ];
        }

        return [
            'pump' => $pump,
            'pumpParams' => $params
        ];
    }

    public function preparePageLastParams($pumpType)
    {
        $pump =  $this->getProductByType($pumpType);
        return [
            'pumpAdditional' => $this->getPumpAdditional(),
            'pump' => $pump,
        ];
    }

    public function getPumpAdditional()
    {
        $allowedSKU = [];
        $products = $this->getProductsBySku($allowedSKU);

        $pumps = $this->getPumpOffer();
        foreach($pumps['item'] as $item) {
            $products = array_merge($products,
                $this->findProductCover($item['sku']),
                $this->findConstruction($item['sku']),
                $this->findBypass($item['sku'])
            );
        }
        $uniqueProducts = [];
        foreach($products as $product) {
            $uniqueProducts[$product['sku']] = $product;
        }
        return array_values($uniqueProducts);
    }

    public function findProductCover($sku)
    {
        $productsCover = $this->getProductsByCategory(['COVER']);
        return array_filter($productsCover, function($item) use ($sku) {
            return in_array($sku, $item['products']);
        });
    }

    public function findConstruction($sku)
    {
        $productConstruction = $this->getProductsByCategory(['CONSTRUCTION']);
        return array_filter($productConstruction, function($item) use ($sku) {
            return in_array($sku, $item['products']);
        });
    }

    public function findBypass($sku)
    {
        $productBypass = $this->getProductsByCategory(['BYPASS']);
        return array_filter($productBypass, function($item) use ($sku) {
            return in_array($sku, $item['products']);
        });
    }

    public function getCell($x,$y)
    {
        $methodName = 'get' .$x . '' . $y;
        if (method_exists($this, $methodName)) {
            return call_user_func([$this, $methodName]);
        }
        return $this->cells[$x][$y] ?? '';
    }

    public function getC13()
    {
        switch ($this->formModels['poolUsagePeriod']['selectedId']) {
            case 'jc':
                return 30;

            case 'pb':
            case 'hs':
                return 72;

            default:
                return 72;
        }
    }

    public function getC14()
    {
        $value = $this->formModels['poolExpectedWaterTemp']['value'];
        $valueOptions = $this->formModels['poolExpectedWaterTemp']['valueOptions'];
        if (in_array($value, $valueOptions)) {
            return $value;
        }

        $filtered = array_filter($valueOptions, function($item) use($value) {
            return $item > $value;
        });

        $value = $filtered ? min($filtered) : max($valueOptions);
        return $value;
    }

    private function getC15()
    {
        if ($this->formModels['poolUsagePeriod']['selectedId'] == 'year') {
            return $this->getF15();
        }
        $option = ZH_OfferFormBase::getDatasetItem($this->formModels, 'poolUsagePeriod.options', $this->formModels['poolUsagePeriod']['selectedId']);
        return $option['value'];
    }

    private function getC16()
    {
        switch($this->formModels['poolLocation']['selectedId']) {
            case 'inc':
                return $this->getCell('F', 14);

            case 'onc':
                return $this->getC16onc();

            case 'ic':
                return $this->getCell('F', 14);

            case 'oc':
                return $this->getC16oc();

            case 'oct':
                if ($this->formModels['poolUsagePeriod']['selectedId'] == 'year') {
                    return '';
                }
                return 7;
        }
        return '';
    }

    private function getC16onc()
    {
        switch ($this->formModels['poolUsagePeriod']['selectedId']) {
            case 'year':
                return '';

            case '3-11':
                return ZH_OfferFormBase::getDatasetItemValue($this->formModels,'poolUsagePeriod.options', $this->formModels['poolUsagePeriod']['selectedId']);

            default:
                return 15;
        }
    }

    private function getC16oc()
    {
        $value = ZH_OfferFormBase::getDatasetItemValue($this->formModels,'poolUsagePeriod.options', $this->formModels['poolUsagePeriod']['selectedId']);

        switch ($this->formModels['poolUsagePeriod']['selectedId']) {
            case 'year':
                return '';

            case '3-11':
                return $value + 3;

            default:
                return 20;
        }
    }

    private function getC17()
    {
        //zapytac dzial pomp ciepla, brakuje w formule okresu calorocznego.
        //$option = OfferForm::getDatasetItem($this->formModels, 'poolUsagePeriod.options', $this->formModels['poolUsagePeriod']['selectedId']);
        //return $option['value'];

        switch ($this->formModels['poolUsagePeriod']['selectedId']) {
            case '3-11':
                return 10;
                break;

            case '5-10':
                return 15;
                break;

            case 'summer':
                return 20;
                break;

            default:
                return 20;
                break;
        }
    }

    private function getC18()
    {
        $option = ZH_OfferFormBase::getDatasetItem($this->formModels, 'poolUsage.options', $this->formModels['poolUsage']['selectedId']);
        return $option['value'] / 100; // %
    }

    private function getF13()
    {
        if ($this->getE11() == '') {
            return 24;
        }
        return $this->getCell('F', 11);
    }

    private function getF15()
    {
        if (data_get($this->formModels, 'outsideTempHeaterRun.selectedId', null)) {
            $option = ZH_OfferFormBase::getDatasetItem($this->formModels, 'outsideTempHeaterRun.options', $this->formModels['outsideTempHeaterRun']['selectedId']);
            return $option['value'];
        }
        if (data_get($this->formModels, 'outsideTempHeaterRun.value', null)) {
            return data_get($this->formModels, 'outsideTempHeaterRun.value', null);
        }
        return '';
    }

    private function getF16()
    {
        $option = ZH_OfferFormBase::getDatasetItem($this->formModels, 'poolLocation.options', $this->formModels['poolLocation']['selectedId']);
        return $option['air_humidity'];
    }

    //Zamienia na potrzeby testu - funkcja nie potrzebna
    private function getF12()
    {
        $option = ZH_OfferFormBase::getDatasetItem($this->formModels, 'pumpAsOnlyHeatingDevice.options',
            $this->formModels['pumpAsOnlyHeatingDevice']['selectedId'] == 'y' ? 'n' : 'y');
        return $option['displayName'];
    }

    private function getC21()
    {
        return max([$this->getC22() + $this->getC33() + $this->getC34(), 1]);
    }

    private function getC22()
    {
        $result = (1 / $this->getC23())
            * $this->getC24()
            * $this->getC25()
            * 0.2390057361
            * (0.0174 * $this->getC26() + 0.0229)
            * ($this->getC27() - $this->getC28())
            * $this->getC29()
            * ($this->getC30() / $this->getC31())
            * 0.00116222222;

        return $result;
    }

    private function getC23()
    {
        return 133.32;
    }

    private function getC24()
    {
        return 1;
    }

    private function getC25()
    {
        $C14 = $this->getCell('C',14);

        return data_get(self::$reference['tempOfvaporization'], $C14);
    }

    private function getC26()
    {
        if ($this->winterOuter()) {
            if ( ($this->formModels['poolInHardConditions']['selectedId'] ?? 'n') == 'y' ) {
                if ($this->winterWithoutCover()) {
                    return 2;
                }
                return max([0.2, 2*$this->getCell('F', '11')/24]);
            }
        }
        return 0.2;
    }

    private function getC27()
    {
        $C14 = $this->getCell('C',14);

        return data_get(self::$reference['tempOfWaterVaporPressure'], $C14) * 1000;
    }

    private function getC28()
    {
        $C16 = $this->getC16();
        if ($C16 <= 0) {
            return self::$reference['tempOfWaterVaporPressure'][0];
        }

        return data_get(self::$reference['tempOfWaterVaporPressure'], $C16) * 10 * $this->getF16();
    }

    private function getC29()
    {
        return $this->getCell('C',9);
    }

    private function getC30()
    {
        return 101325;
    }

    private function getC31()
    {
        return 101325;
    }

    private function getC33()
    {
        return $this->getC22() * $this->getE33();
    }

    private function getE33()
    {
        switch($this->formModels['poolLocation']['selectedId']) {
            case 'inc':
            case 'ic':
                $option = ZH_OfferFormBase::getDatasetItem($this->formModels, 'poolInGround.options', 'y');
                break;

            default:
                $option = ZH_OfferFormBase::getDatasetItem($this->formModels, 'poolInGround.options', $this->formModels['poolInGround']['selectedId'] ?? 'n');
                break;
        }
        $option2 = ZH_OfferFormBase::getDatasetItem($this->formModels, 'poolToPumpDistance.options', $this->formModels['poolToPumpDistance']['selectedId']);

        return (($option['value'] ?? null) + ($option2['value'] ?? null)) / 100;
    }

    private function getC34()
    {
        $result = $this->getCell('C', 9)
            * $this->getCell('C', 11)
            * 1000
            * ($this->getCell('C', 14) - $this->getCell('C', 17))
            * $this->getCell('C', 18)
            * 4.19 / 3600 / 24;

        return $result;
    }

    private function getC36()
    {
        //Pamietać że w excelu jest na odwrót
        if ($this->formModels['pumpAsOnlyHeatingDevice']['selectedId'] == 'y') {
            $result = ($this->getC37()
                    * $this->getC22()
                    + 4.19 * ($this->getCell('C', 14) - $this->getCell('C', 17))
                    * $this->getCell('C', 9)
                    * $this->getCell('C', 11)
                    * 1000 / 3600 )
                / $this->getCell('C', 13);

            return $result;
        }

        return 0;
    }

    private function  getC37()
    {
        return 0.3; //30%
    }

    private function getC39()
    {
        $C21 = $this->getC21();
        $C36 = $this->getC36();

        return $C21 > $C36 ? $C21 : $C36;
    }

    private function getC40()
    {
        if ($this->formModels['poolUsagePeriod']['selectedId'] == 'year') {
            $selected = $this->sheetOptionsAW13();
            return $selected['type'];

        }
        $selected = $this->sheetOptionsZ13();
        return $selected['type'];
    }

    private function getC41()
    {
        if ($this->formModels['poolUsagePeriod']['selectedId'] == 'year') {
            $selected = $this->sheetOptionsBB13();
            return $selected['type'] ?? '';
        }
        $selected = $this->getAlternativePCWB();

        return data_get($selected, 'type');
    }

    private function getC42()
    {
        $C40 = $this->getC40();
        $product = $this->getProductByType($C40);

        if ($this->formModels['poolUsagePeriod']['selectedId'] == 'year') {
            $selected = $this->getOptionSplitProduct($product['sku']);
            return $selected['type'] ?? '';
        }

        //$selected = $this->getOptionPcwbiBProduct($product['sku']);
        $selected = $this->getOptionPcwbProduct($product['sku']);

        return $selected['type'] ?? '';
    }

    private function getC43()
    {
        $C41 = $this->getC41();
        $product = $this->getProductByType($C41);
        if (!is_array($product) || !array_key_exists('sku', $product)) {
            return '';
        }

        if ($this->formModels['poolUsagePeriod']['selectedId'] == 'year') {
            $selected = $this->getOptionSplitProduct($product['sku']);
            return $selected['type'] ?? '';
        }

        $selected = $this->getOptionPcwbProduct($product['sku']);
        //$selected = $this->getOptionPcwbiBProduct($product['sku']);
        return $selected['type'] ?? '';
    }

    private function getC44()
    {
        $C41 = $this->getC40();
        $product = $this->getProductByType($C41);
        if (!is_array($product) || !array_key_exists('sku', $product)) {
            return '';
        }

        $selected = $this->getOptionPcwbiBProduct($product['sku']);
        return $selected['type'] ?? '';
    }

    private function getD40()
    {
        if ($this->formModels['poolUsagePeriod']['selectedId'] == 'year') {
            return $this->sheetOptionsAX13();
        }
        return $this->sheetOptionsAA13();
    }
    private function getD41()
    {
        if ($this->formModels['poolUsagePeriod']['selectedId'] == 'year') {
            return $this->sheetOptionsBC13();
        }
        return $this->sheetOptionsAF13();
    }

    private function getD42()
    {
        return $this->getC42()
            ? $this->sheetOptionsM($this->getProductByType($this->getC42()))
            : '';
    }

    private function getD43()
    {
        return $this->getC43()
            ? $this->sheetOptionsM($this->getProductByType($this->getC43()))
            : '';
    }

    private function getF23()
    {
        $result = $this->getCell('C',9)
            * $this->getCell('C', 11)
            * 1 / 3600
            * 4.19 * 1000
            / $this->getCell('C', 21);

        return $result;
    }

    private function getF24()
    {
        $divisor = ($this->getCell('F', 40) * $this->getCell('E', 40) + $this->getCell('E', 41));
        if (!$divisor) {
            return 0;
        }
        $result = $this->getCell('C', 9)
            * $this->getCell('C', 11)
            * 1 / 3600
            * 4.19 * 1000
            / $divisor;

        return $result;
    }

    private function getF25()
    {
        if ( $this->formModels['poolLocation']['selectedId'] == 'inc' ||
            ($this->getCell('F', 23) > $this->getCell('F', 13)
                && $this->getCell('E', 11) != '')) {
            return 0;
        }
        return 1;
    }

    private function getE40()
    {
        $OO = array_filter($this->sheetOptionsPowerAndTemp(), function($item) {
            return array_key_exists('powerFor26C', $item);
        });

        $maxPower = 0;
        foreach($OO as $item) {
            if ($item['powerFor26C'] > $maxPower) {
                $maxPower = $item['powerFor26C'];
            }
        }
        $C39 = $this->getC39();
        if ($OO >= $C39) {
            return 1;
        }
        return floor($C39 / $this->getF40());
    }

    private function getF40()
    {
        $D40 = $this->getD40();
        $C40 = $this->getC40();
        $product = $this->getProductByType($C40);
        $options = $this->sheetOptionsPowerAndTemp($product['sku']);

        if ($this->formModels['poolUsagePeriod']['selectedId'] == 'year') {
            return $options['powerFor35C'] * $D40;
        }

        return $options['powerFor28C'] * $D40;
    }

    private function getE41()
    {
        $C41 = $this->getC41();
        $product = $this->getProductByType($C41);
        $options = $this->sheetOptionsPowerAndTemp($product['sku'] ?? '');
        $options2 = $this->sheetOptionsPowerAndTemp('91.10.87');

        if (!($options['powerFor26C'] ?? 0) || !($options2['powerFor26C'] ?? 0)) {
            return 0;
        }

        return max($options['powerFor26C'], $options2['powerFor26C']);
    }

    private function getF41()
    {
        $result = ($this->getC39() - $this->getF40() * $this->getE40() ) / $this->getC39();
        return $result;
    }

    private function getE10()
    {
        if (  $this->formModels['poolLocation']['selectedId'] == 'onc' )  {
            return 'Czy basen jest zlokalizowany w bardzo wietrznym miejscu?';
        }
        return '';
    }

    private function getE11()
    {
        if (  in_array($this->formModels['poolLocation']['selectedId'], ['oc', 'ic', 'oct']) )  {
            return 'Ilość godzin bez przykrycia basenu w ciągu dnia';
        }
        return '';
    }

    private function getB42()
    {
        $C40 = $this->getC40();
        $product = $this->getProductByType($C40);

        $selected = $this->getOptionPcwbProduct($product['sku']);
        return $selected ? 'Lub' : '';
    }

    private function getB43()
    {
        $C41 = $this->getC41();
        $product = $this->getProductByType($C41);

        $selected = $this->getOptionPcwbProduct($product['sku']);
        return $selected ? 'Lub' : '';
    }

    private function sheetOptionsX1()
    {
        $C39 = $this->getC39();
        $maxS = $this->sheetOptionsMaxS();

        if ($C39 > $maxS) {
            return 0;
        }

        return $this->getF25() * 0.3;
    }

    private function sheetOptionsMaxS()
    {
        $max = 0;
        $groups = ['PCWB', 'PCWBi'];
        $pumps = $this->getProductsByCategory($groups);

        foreach($pumps as &$pump) {
            $powerOptions = $this->sheetOptionsPowerAndTemp($pump['sku']);
            $power = $powerOptions['powerFor28C'] ?? $powerOptions['powerFor26C'];

            if ($power > $max) {
                $max = $power;
            }
        }
        return $max;
    }

    private function sheetOptionsBC13()
    {
        $AW13 = $this->sheetOptionsAW13();
        $BB14 = $this->sheetOptionsBB14();
        if ($AW13['sku'] == $BB14['sku']) {
            return '';
        }
        return $this->sheetOptionsBC14();
    }

    private function sheetOptionsBB13()
    {
        $AW13 = $this->sheetOptionsAW13();
        $BB14 = $this->sheetOptionsBB14();
        if ($AW13['sku'] == $BB14['sku']) {
            return '';
        }
        return $BB14;
    }

    private function sheetOptionsBB14()
    {
        $groups = ['PCCO'];
        $pumps = $this->getProductsByCategory($groups);

        $min = 99999999999999;
        foreach($pumps as &$pump) {
            $pump['sum'] = $this->sheetOptionsAJ($pump);

            if ($pump['sum'] < $min) {
                $min = $pump['sum'];
                $bestPump = $pump;
            }
        }

        return $bestPump;
    }

    private function sheetOptionsBC14()
    {
        $BB14 = $this->sheetOptionsBB14();
        return $this->sheetOptionsAJ($BB14);
    }

    private function sheetOptionsAE13()
    {
        $Z13 = $this->sheetOptionsZ13();
        $AE14 = $this->sheetOptionsAE14();

        return $Z13['sku'] == $AE14['sku'] ? '' : $AE14;
    }

    /**
     * xls - ta,moc -> AI19
     * @return mixed|string
     */
    private function getAlternativePCWB()
    {
        $firstPump = $this->sheetOptionsZ13();
        $alternativeProduct = $this->getAlternativePCWBProduct();

        return $firstPump['sku'] == $alternativeProduct['sku'] ? '' : $alternativeProduct;
    }

    private function getAlternativePCWBProduct()
    {
        $groups = ['PCWB', 'PCWBi'];

        $pumps = $this->getProductsByCategory($groups);

        $min = 99999999999999;
        foreach($pumps as &$pump) {
            $pump['sum'] =  $this->sheetOptionsM($pump);

            if ($pump['sum'] < $min) {
                $min = $pump['sum'];
                $bestPump = $pump;
            }
        }
        return $bestPump;
    }

    private function sheetOptionsAE14()
    {
        return $this->getAlternativePCWBProduct();
    }

    private function sheetOptionsAF13()
    {
        $Z13 = $this->sheetOptionsZ13();
        $AE14 = $this->sheetOptionsAE14();
        if ($Z13['sku'] == $AE14['sku']) {
            return '';
        }
        return $this->sheetOptionsAF14();
    }

    private function sheetOptionsAF14()
    {
        $AE14 = $this->sheetOptionsAE14();
        return $this->sheetOptionsM($AE14);
    }


    private function sheetOptionsAX13()
    {
        $AW13 = $this->sheetOptionsAW13();
        return $this->sheetOptionsAJ($AW13);
    }

    private function sheetOptionsAA13()
    {
        $Z13 = $this->sheetOptionsZ13();
        return $this->sheetOptionsM($Z13);
    }

    private function sheetOptionsAW13()
    {
        $groups = ['PCCO'];
        $pumps = $this->getProductsByCategory($groups);

        $min = 99999999999999;
        foreach($pumps as &$pump) {
            $pump['sum'] = $pump['price'] * $this->sheetOptionsAJ($pump); // * AJ2

            if ($pump['sum'] < $min) {
                $min = $pump['sum'];
                $bestPump = $pump;
            }
        }

        return $bestPump;
    }

    private function sheetOptionsZ13()
    {
        $groups = ['PCWB', 'PCWBi'];
        $pumps = $this->getProductsByCategory($groups);

        $min = 99999999999999;
        foreach($pumps as $key => $pump) {
            $pumps[$key]['sum'] = $pump['price'] * $this->sheetOptionsM($pump); // * M2
            if ($pumps[$key]['sum'] < $min) {
                $min = $pumps[$key]['sum'];
                $bestPump = $pumps[$key];
            }
        }
        return $bestPump;
    }

    private function sheetOptionsAJ($pump)
    {
        $powerOptions = $this->sheetOptionsPowerAndTemp($pump['sku']);
        $result = ceil($this->getC39() / $powerOptions['powerFor45C'] - 0.3);

        return $result > 1 ? $result : 1;
    }

    private function sheetOptionsM($pump)
    {
        $powerOptions = $this->sheetOptionsPowerAndTemp($pump['sku']);
        $power = $powerOptions['power'];

        switch ($pump['sku']) {
            case '91.13.08':
            case 'HPBY178B':
            case 'HPBY210B':
                $wsk = 0.05;
                break;
            case '91.13.09':
            case '91.13.10':
                $wsk = 0;
                break;
            default:
                $wsk = 0.2;
                break;
        }

        if ($pump['sku'] == '91.13.00') { //PCWB 4.0
            $result = in_array($this->formModels['poolUsagePeriod']['selectedId'], ['3-11'])
                ? 999999
                : ceil($this->getC39() / $power - $wsk + $this->sheetOptionsX1());
        } else {
            $result = ceil($this->getC39() / $power - $wsk);
        }

        return $result > 1 ? $result : 1;
    }

    private function removeWithoutIndex($data, $index)
    {
        return array_filter($data, function($item) use ($index) {
            return array_key_exists($index, $item);
        });
    }

    private function sheetOptionsPowerAndTemp($sku = null)
    {
        $C14 = $this->getC14();
        $C15 = $this->getC15();
        $C39 = $this->getC39();

        $config = [];
        foreach($this->productsParams['products'] as $product) {
            if (array_key_exists('forecast', $product)) {
                foreach($product['forecast'] as $powerKey => $item) {
                    //$config[$product['sku']][$powerKey] = $this->calculateForecastA($item['samples'], $item['targets'], $category);
                    $config[$product['sku']][$powerKey] = $item == null ? null : $item['variableA'] * $C15 + $item['variableB'];
                }

                if ($product['category'] != 'PCCO') {
                    $config[$product['sku']]['power'] = $C14 > 26
                        ? ($config[$product['sku']]['powerFor26C'] - $product['powerDrop'] * $config[$product['sku']]['powerFor26C'] * ($C14 - 26))
                        : $config[$product['sku']]['powerFor26C'];
                }
            }
        }

        foreach($config as &$item) {
            if (array_key_exists('powerFor45C', $item)) {
                $item['temp45C'] = abs($item['powerFor45C'] / $C39 - 1);
            }
            if (array_key_exists('powerFor35C', $item)) {
                $item['temp35C'] = abs($item['powerFor35C'] / $C39 - 1);
            }
            if (array_key_exists('powerFor28C', $item)) {
                $item['temp28C'] = abs($item['powerFor28C'] / $C39 - 1);
            }
            if (array_key_exists('powerFor26C', $item)) {
                $item['temp26C'] = abs($item['power'] / $C39 - 1);
            }
        }

        return $sku ? $config[$sku] : $config;
    }

    private function winterWithoutCover()
    {
        return in_array($this->formModels['poolLocation']['selectedId'], ['onc', 'inc']);
    }

    private function winterOuter()
    {
        return in_array($this->formModels['poolLocation']['selectedId'], ['oc', 'onc', 'oct']);
    }

    private function calculateForecastA($samples = null, $targets, $category)
    {
        if (!$samples) {
            return 0;
        }

        $forecastData = [];
        foreach(self::$configTa[$category] as $Ta) {
            $key = array_search($Ta, $samples);
            $forecastData[] = $key !== false ? $targets[$key] : $this->forecast($samples, $targets, $Ta);
        }
    }

    private function forecast($samples, $targets, $predict = null)
    {
        if (!$predict) {
            return null;
        }

        $this->regression->train($this->prepareRegressionSamples($samples), $targets);
        return round($this->regression->predict([$predict]) , 2);
    }

    private function prepareRegressionSamples($samples)
    {
        return array_map(function($item){
            return [$item];
        }, $samples);
    }

    private function getProductsByCategory($category = [])
    {
        $pumps = array_filter($this->productsParams['products'], function($item) use ($category) {
            if ( in_array($item['category'], $category) ) {
                return $item;
            }
        });

        //wyrzucic pompe pingwin dla okresu od marca do pazdziernika lub caloroczny
        if ( in_array($this->formModels['poolUsagePeriod']['selectedId'], ['3-11', 'year']) ) {
            $pumps = array_filter($pumps, function($item) {
                return $item['sku'] != '91.13.00';
            });
        }
        //wyrzucic pompe pingwin dla jacuzzi
        if ( in_array($this->formModels['poolUsage']['selectedId'], ['jc']) ) {
            $pumps = array_filter($pumps, function($item) {
                return $item['sku'] != '91.13.00';
            });
        }
        //--------------

        return $pumps;
    }


    /*
     *
     *
     *
     */

    private function prepareProductsParams()
    {
        $pumps = [
            [
                'category' => 'PCWB',
                'type' => 'PCWB 4,0kW-A',
                'img' => ZH_URL. 'public/images/product/850_600_PCWB-4-kW-PINGWIN-1.jpeg',
                'heatingPower' => '4',
                'supplyPower' => '0,79',
                'cop' => '5,06',
                'compressorType' => 'rotacyjna',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '525×530×603',
                'waterConnections' => '32',
                'weightNet' => '36',
                'guarantee' => '4 lata',
                'symbol' => 'PCWB 4,0kW-A',
                'sku' => '91.13.00',
                'price' => 2900,
                'icons' => [
                    'zbiornik-pcwb.jpeg?v=2',
                    'pingwin_abs.jpeg',
                    'r32.jpeg?v=2',
                    'funkcje.jpeg?v=2',
                    'aqua-temp.jpeg',
                    'bluetooth.jpeg'
                ],
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [15, 27],
                        'targets' => [3.1, 4],
                        'variableA' => 0.075,
                        'variableB' => 1.975,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.015,

            ],[
                'category' => 'PCWB',
                'type' => 'PCWB 5,4kW-A',
                'img' => ZH_URL. 'public/images/product/PCWB-5.jpeg',
                'heatingPower' => '5,3',
                'supplyPower' => '0,94',
                'cop' => '5,64',
                'compressorType' => 'rotacyjna',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '791×341×574',
                'waterConnections' => '50',
                'weightNet' => '36',
                'guarantee' => '4 lata',
                'symbol' => 'PCWB 5,4kW-A',
                'sku' => '91.13.01',
                'price' =>  4285,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [2,15,24,27],
                        'targets' => [1.9,3.5,4.4,5.3],
                        'variableA' => 0.127777778,
                        'variableB' => 1.602777778,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.01,
            ],[
                'category' => 'PCWB',
                'type' => 'PCWB 7,6kW-A',
                'img' => ZH_URL. 'public/images/product/PCWB-10-_20200303_020316.jpeg',
                'heatingPower' => '7,5',
                'supplyPower' => '1,28',
                'cop' => '5,86',
                'compressorType' => 'rotacyjna',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1001×418×605',
                'waterConnections' => '50',
                'weightNet' => '50',
                'guarantee' => '4 lata',
                'symbol' => 'PCWB 7,6kW-A',
                'sku' => '91.13.02',
                'price' => 5115,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [2,15,24,27],
                        'targets' => [3.8,6,7.4,8.4],
                        'variableA' => 0.176719577,
                        'variableB' => 3.395767196,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.01,
            ],[
                'category' => 'PCWB',
                'type' => 'PCWB 10,0kW-A',
                'img' => ZH_URL. 'public/images/product/PCWB-10-.jpeg',
                'heatingPower' => '10,4',
                'supplyPower' => '1,83',
                'cop' => '5,68',
                'compressorType' => 'rotacyjna',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1001×418×605',
                'waterConnections' => '50',
                'weightNet' => '57',
                'guarantee' => '4 lata',
                'symbol' => 'PCWB 10,0kW-A',
                'sku' => '91.13.03',
                'price' => 5790,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [2,15,24,27],
                        'targets' => [5,7.9,10,11.5],
                        'variableA' => 0.249206349,
                        'variableB' => 4.363492063,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.01,
            ],[
                'category' => 'PCWB',
                'type' => 'PCWB 13,0kW-A',
                'img' => ZH_URL. 'public/images/product/PCWB-13.jpeg',
                'heatingPower' => '13,5',
                'supplyPower' => '2,38',
                'cop' => '5,67',
                'compressorType' => 'rotacyjna',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1001×418×605',
                'waterConnections' => '50',
                'weightNet' => '63',
                'guarantee' => '4 lata',
                'symbol' => 'PCWB 13,0kW-A',
                'sku' => '91.13.04',
                'price' => 6690,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [2,15,24,27],
                        'targets' => [5.4,9.1,11.2,13.5],
                        'variableA' => 0.302116402,
                        'variableB' => 4.664021164,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.01,
            ],[
                'category' => 'PCWB',
                'type' => 'PCWB 16,0kW-A',
                'img' => ZH_URL . 'public/images/product/PCWB-13.jpeg',
                'heatingPower' => '14,6',
                'supplyPower' => '2,44',
                'cop' => '5,98',
                'compressorType' => 'rotacyjna',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1163×490×862',
                'waterConnections' => '50',
                'weightNet' => '80',
                'guarantee' => '4 lata',
                'symbol' => 'PCWB 16,0kW-A',
                'sku' => '91.13.05',
                'price' => 7870,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [2,15,24,27],
                        'targets' => [7.6,10.2,12.7,14.6],
                        'variableA' => 0.265873016,
                        'variableB' => 6.75515873,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.01,
            ],
            /*
                [
                'category' => 'PCWBi',
                'type' => 'PCWBi 9,0 kW-A',
                'img' => ZH_DIR. 'public/images/product/PCWBi_9_12.jpg',
                'heatingPower' => '2.23-9.0',
                'supplyPower' => '0.18-1.54',
                'cop' => '12.39-5.84',
                'compressorType' => 'rotacyjna- inwerterowa',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1000×418×605',
                'waterConnections' => '50',
                'weightNet' => '45',
                'guarantee' => '4 lata',
                'symbol' => 'PCWBi 9,0 kW-A',
                'sku' => '91.13.06',
                'price' => 6090,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [2,10,15,27],
                        'targets' => [4.5,5.2,7,9],
                        'variableA' => 0.188601824,
                        'variableB' => 3.87887538,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCWBi',
                'type' => 'PCWBi 12,0 kW-A',
                'img' => ZH_DIR . 'public/images/product/PCWBi_9_12_20190513_114756.jpg',
                'heatingPower' => '1.97-11.7',
                'supplyPower' => '0.16-2.00',
                'cop' => '12.57-5.84',
                'compressorType' => 'rotacyjna- inwerterowa',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1000×418×605',
                'waterConnections' => '50',
                'weightNet' => '46',
                'guarantee' => '4 lata',
                'symbol' => 'PCWBi 12,0 kW-A',
                'sku' => '91.13.07',
                'price' => 6570,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [2,10,15,27],
                        'targets' => [4.6,6.6,8.6,11.7],
                        'variableA' => 0.288297872,
                        'variableB' => 3.982978723,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCWBi',
                'type' => 'PCWBi 19,5 kW-A',
                'img' => ZH_DIR . 'public/images/product/PCWBi_19.jpg',
                'heatingPower' => '4.6-19.5',
                'supplyPower' => '0.37-3.94',
                'cop' => '12.43-4.95',
                'compressorType' => 'rotacyjna- inwerterowa',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1160×490×870',
                'waterConnections' => '50',
                'weightNet' => '89',
                'guarantee' => '4 lata',
                'symbol' => 'PCWBi 19,5 kW-A',
                'sku' => '91.13.08',
                'price' => 10570,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [10,15,27],
                        'targets' => [14.4,15.4,19.5],
                        'variableA' => 0.307641921,
                        'variableB' => 11.10087336,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCWBi',
                'type' => 'PCWBi 24,2 kW-A',
                'img' => ZH_DIR . 'public/images/product/PCWBi_19_24_28_20190513_120559.jpg',
                'heatingPower' => '5.70-24.2',
                'supplyPower' => '0.46-4.80',
                'cop' => '12.39-5.04',
                'compressorType' => 'rotacyjna- inwerterowa',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1160×490×1274',
                'waterConnections' => '50',
                'weightNet' => '111',
                'guarantee' => '4 lata',
                'symbol' => 'PCWBi 24,2 kW-A',
                'sku' => '91.13.09',
                'price' => 17390,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [10,15,27],
                        'targets' => [17.8,19.9,24.2],
                        'variableA' => 0.373144105,
                        'variableB' => 14.16550218,
                    ],
                    'powerFor28C' => [
                        'samples' => [2,7,15,24],
                        'targets' => [10.626,15.663,19.673,20.643],
                        'variableA' => 0.43942446,
                        'variableB' => 11.37815647,
                    ],
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCWBi',
                'type' => 'PCWBi 28,3 kW-A',
                'img' => ZH_DIR . 'public/images/product/PCWBi_19_24_28_20190513_122056.jpg',
                'heatingPower' => '6.70-28.3',
                'supplyPower' => '0.54-5.57',
                'cop' => '12.41-5.08',
                'compressorType' => 'rotacyjna- inwerterowa',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1160×490×1274',
                'waterConnections' => '50',
                'weightNet' => '120',
                'guarantee' => '4 lata',
                'symbol' => 'PCWBi 28,3 kW-A',
                'sku' => '91.13.10',
                'price' => 19800,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [10,15,27],
                        'targets' => [20.8,23.3,28.3],
                        'variableA' => 0.436681223,
                        'variableB' => 16.56419214,
                    ],
                    'powerFor28C' => [
                        'samples' => [2,7,15,24],
                        'targets' => [11.613,17.565,23.628,25.844],
                        'variableA' => 0.636895683,
                        'variableB' => 12.0197518,
                    ],
                ],
                'powerDrop' => 0.005,
            ],
            */
            /**** PCWBi - B *****/

            [
                'category' => 'PCWBi',
                'type' => 'PCWBi 7,1kW-B',
                'img' => ZH_URL . 'public/images/product/PCWBi-B.jpeg',
                'heatingPower' => '1.4-7.1',
                'supplyPower' => '0.087-1.09',
                'cop' => '6.5-16',
                'compressorType' => 'inwerterowa rotacyjna Mitsubishi',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1000x439x622',
                'waterConnections' => '50',
                'weightNet' => '61',
                'guarantee' => '4 lata',
                'symbol' => 'PCWBi 7,1kW-B',
                'sku' => 'HPBY071B',
                'price' => 6095,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [10,15,27],
                        'targets' => [4,5.5,7.1],
                        'variableA' => 0.173362445,
                        'variableB' => 2.528384279,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCWBi',
                'type' => 'PCWBi 9,5kW-B',
                'img' => ZH_URL . 'public/images/product/PCWBi-B.jpeg',
                'heatingPower' => '1.9-9.5',
                'supplyPower' => '0.118-1.39',
                'cop' => '6.8-16.1',
                'compressorType' => 'inwerterowa rotacyjna Mitsubishi',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1000x439x622',
                'waterConnections' => '50',
                'weightNet' => '61',
                'guarantee' => '4 lata',
                'symbol' => 'PCWBi 9,5kW-B',
                'sku' => 'HPBY095B',
                'price' => 6920,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [10,15,27],
                        'targets' => [5.5,7,9.5],
                        'variableA' => 0.230349345,
                        'variableB' => 3.340611354,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCWBi',
                'type' => 'PCWBi 13,0kW-B',
                'img' => ZH_URL . 'public/images/product/PCWBi-B.jpeg',
                'heatingPower' => '2.4-13',
                'supplyPower' => '0.145-1.96',
                'cop' => '6.6-16.5',
                'compressorType' => 'inwerterowa rotacyjna Mitsubishi',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1000x439x622',
                'waterConnections' => '50',
                'weightNet' => '66',
                'guarantee' => '4 lata',
                'symbol' => 'PCWBi 13,0kW-B',
                'sku' => 'HPBY130B',
                'price' => 7230,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [10,15,27],
                        'targets' => [7.2,9.1,13],
                        'variableA' => 0.338209607,
                        'variableB' => 3.904366812,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCWBi',
                'type' => 'PCWBi 17,8kW-B',
                'img' => ZH_URL . 'public/images/product/PCWBi-B.jpeg',
                'heatingPower' => '2.5-17.8',
                'supplyPower' => '0.151-2.78',
                'cop' => '6.4-16.5',
                'compressorType' => 'inwerterowa rotacyjna Mitsubishi',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1020x503x768',
                'waterConnections' => '50',
                'weightNet' => '87',
                'guarantee' => '4 lata',
                'symbol' => 'PCWBi 17,8kW-B',
                'sku' => 'HPBY178B',
                'price' => 8780,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [10,15,27],
                        'targets' => [9.8,12.8,17.8],
                        'variableA' => 0.46069869,
                        'variableB' => 5.481222707,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCWBi',
                'type' => 'PCWBi 20,0kW-B',
                'img' => ZH_URL . 'public/images/product/PCWBi-B.jpeg',
                'heatingPower' => '3.5-20',
                'supplyPower' => '0.214-3.07',
                'cop' => '6.5-16.3',
                'compressorType' => 'inwerterowa rotacyjna Mitsubishi',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => '1151x506x860',
                'waterConnections' => '50',
                'weightNet' => '99',
                'guarantee' => '4 lata',
                'symbol' => 'PCWBi 20,0kW-B',
                'sku' => 'HPBY210B',
                'price' => 10820,
                'forecast' => [
                    'powerFor26C' => [
                        'samples' => [10,15,27],
                        'targets' => [11.3,14.7,20],
                        'variableA' => 0.498908297,
                        'variableB' => 6.68558952,
                    ],
                    'powerFor28C' => NULL,
                ],
                'powerDrop' => 0.005,
            ],
            /*******************/

            /***** MONO ********/
            [
                'category' => 'PCCO',
                'type' => 'Pompa ciepła PCCO MONO 6 <br/>z grzałką 6 kW',
                'img1' => ZH_URL . 'public/images/product/pcco-mono-6-bez-grzalki.jpeg',
                'img2' => '',
                'heatingPower' => '6.33',
                'supplyPower' => '1.40',
                'cop' => '4.53',
                'compressorType' => 'podwójna rotacyjna inwerterowa / Mitsubishi',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => 'Jedn.zew.:1008x417x728 <br/>Jedn. wew.:500x267x720',
                'waterConnections' => 'GZ 1"',
                'weightNet' => 'Jedn.zew.: 65; Jedn. wew.: 45',
                'guarantee' => '5 lat',
                'symbol' => 'Pompa ciepła PCCO MONO 6',
                'sku' => 'HPOM006Z0A HPOM020W6A',
                'price' => 25285,
                'forecast' => [
                    'powerFor35C' => [
                        'samples' => [-15,-7,2,7],
                        'targets' => [4.4,5.71,7.878,9.22],
                        'variableA' => 0.220375768,
                        'variableB' => 7.518221247,
                    ],
                    'powerFor45C' => [
                        'samples' => [-7,2,7,12],
                        'targets' => [4.44,5.87,6.8,6.76],
                        'variableA' => 0.131142132,
                        'variableB' => 5.508502538,
                    ],
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCCO',
                'type' => 'Pompa ciepła PCCO MONO 9 <br/>z grzałką 6 kW',
                'img1' => ZH_URL . 'public/images/product/pcco-mono-9-bez-grzalki.jpeg',
                'img2' => '',
                'heatingPower' => '9.22',
                'supplyPower' => '1.89',
                'cop' => '4.88',
                'compressorType' => 'podwójna rotacyjna inwerterowa / Mitsubishi',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => 'Jedn.zew.:1170x417x876 <br/>Jedn. wew.:500x267x720',
                'waterConnections' => 'GZ 1"',
                'weightNet' => 'Jedn.zew.: 78; Jedn. wew.: 45',
                'guarantee' => '5 lat',
                'symbol' => 'Pompa ciepła PCCO MONO 9',
                'sku' => 'HPOM009Z0A HPOM020W6A',
                'price' => 27125,
                'forecast' => [
                    'powerFor35C' => [
                        'samples' => [-15,-7,2,7],
                        'targets' => [4.4,5.71,7.878,9.22],
                        'variableA' => 0.220375768,
                        'variableB' => 7.518221247,
                    ],
                    'powerFor45C' => [
                        'samples' => [-7,2,7,12],
                        'targets' => [5.29,7.4,8.68,8.63],
                        'variableA' => 0.188274112,
                        'variableB' => 6.841040609,
                    ],
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCCO',
                'type' => 'Pompa ciepła PCCO MONO 11 <br/>z grzałką 6 kW',
                'img1' => ZH_URL . 'public/images/product/pcco-mono-11-bez-grzalki.jpeg',
                'img2' => '',
                'heatingPower' => '11.60',
                'supplyPower' => '2.37',
                'cop' => '4.90',
                'compressorType' => 'podwójna rotacyjna inwerterowa / Mitsubishi',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '230/50',
                'dimensions' => 'Jedn.zew.:1170x417x876 <br/>Jedn. wew.:500x267x720',
                'waterConnections' => 'GZ 1"',
                'weightNet' => 'Jedn.zew.: 78; Jedn. wew.: 45',
                'guarantee' => '5 lat',
                'symbol' => 'Pompa ciepła PCCO MONO 11',
                'sku' => 'HPOM011Z0A HPOM020W6A',
                'price' => 28875,
                'forecast' => [
                    'powerFor35C' => [
                        'samples' => [-15,-7,2,7],
                        'targets' => [5.927,7.647,10.17,11.6],
                        'variableA' => 0.259785777,
                        'variableB' => 9.680303775,
                    ],
                    'powerFor45C' => [
                        'samples' => [-7,2,7,12],
                        'targets' => [7.12,9.8,11.25,10.69],
                        'variableA' => 0.207005076,
                        'variableB' => 8.990482234,
                    ],
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCCO',
                'type' => 'Pompa ciepła PCCO MONO 15 <br/>z grzałką 6 kW',
                'img1' => ZH_URL . 'public/images/product/pcco-mono-15-bez-grzalki.jpeg',
                'img2' => '',
                'heatingPower' => '15.00',
                'supplyPower' => '3.13',
                'cop' => '4.80',
                'compressorType' => 'podwójna rotacyjna inwerterowa / Mitsubishi',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '400/50',
                'dimensions' => 'Jedn.zew.:1095x435x1475 <br/>Jedn. wew.:500x267x720',
                'waterConnections' => 'GZ 1-1/4"',
                'weightNet' => 'Jedn.zew.: 122; Jedn. wew.: 45',
                'guarantee' => '5 lat',
                'symbol' => 'Pompa ciepła PCCO MONO 15',
                'sku' => 'HPOM015Z0A HPOM020W6A',
                'price' => 35675,
                'forecast' => [
                    'powerFor35C' => [
                        'samples' => [-15,-7,2,7],
                        'targets' => [8.026,10.569,13.82,15],
                        'variableA' => 0.32437489,
                        'variableB' => 12.90796839,
                    ],
                    'powerFor45C' => [
                        'samples' => [-7,2,7,12],
                        'targets' => [9.61,12.9,14.48,13.91],
                        'variableA' => 0.247005076,
                        'variableB' => 11.86048223,
                    ],
                ],
                'powerDrop' => 0.005,
            ],[
                'category' => 'PCCO',
                'type' => 'Pompa ciepła PCCO MONO 18 <br/>z grzałką 6 kW',
                'img1' => ZH_URL . 'public/images/product/pcco-mono-18-bez-grzalki.jpeg',
                'img2' => '',
                'heatingPower' => '15.58',
                'supplyPower' => '3.53',
                'cop' => '4.41',
                'compressorType' => 'podwójna rotacyjna inwerterowa / Mitsubishi',
                'typeRefrigerant' => 'R32',
                'voltageFrequency' => '400/50',
                'dimensions' => 'Jedn.zew.:1095x435x1475 <br/>Jedn. wew.:500x267x720',
                'waterConnections' => 'GZ 1-1/4"',
                'weightNet' => 'Jedn.zew.: 142; Jedn. wew.: 45',
                'guarantee' => '5 lat',
                'symbol' => 'Pompa ciepła PCCO MONO 18',
                'sku' => 'HPOM018Z0A HPOM020W0A',
                'price' => 39575,
                'forecast' => [
                    'powerFor35C' => [
                        'samples' => [-15,-7,2,7],
                        'targets' => [9.729,12.571,16.22,15.58],
                        'variableA' => 0.292863916,
                        'variableB' => 14.47680773,
                    ],
                    'powerFor45C' => [
                        'samples' => [-7,2,7,12],
                        'targets' => [11.67,15.7,18.22,17.41],
                        'variableA' => 0.333350254,
                        'variableB' => 14.58327411,
                    ],
                ],
                'powerDrop' => 0.005,
            ],
        ];

        $headCaption = [
            'PCWB' => [
                'type' => 'Model',
                'heatingPower' => 'Moc grzewcza (wg EN 14511, A27-24.3/W26):',
                'supplyPower' => 'Moc zasilania (EN 14511, A27-24.3/W26):',
                'cop' => 'Efektywność COP (EN 14511, A27-24.3/W26):',
                'compressorType' => 'Typ sprężarki:',
                'typeRefrigerant' => 'Rodzaj czynnika chłodniczego:',
                'voltageFrequency' => 'Napięcie/Częstotliwość zasilania:',
                'dimensions' => 'Wymiary urządzenia:',
                'waterConnections' => 'Przyłącza wody:',
                'weightNet' => 'Ciężar netto:',
                'guarantee' => 'Okres gwarancji:',
                'symbol' => 'Symbol urządzenia',
                'sku' => 'Numer katalogowy',
                'price' => 'Cena katalogowa netto',
            ],
            'PCWBi' => [
                'type' => 'Model',
                'heatingPower' => 'Moc grzewcza (wg EN 14511, A27-24.3/W26):',
                'supplyPower' => 'Moc zasilania (wg EN 14511, A27-24.3/W26):',
                'cop' => 'Efektywność COP (wg EN 14511, A27-24.3/W26):',
                'compressorType' => 'Typ sprężarki:',
                'typeRefrigerant' => 'Rodzaj czynnika chłodniczego:',
                'voltageFrequency' => 'Napięcie/Częstotliwość zasilania:',
                'dimensions' => 'Wymiary urządzenia:',
                'waterConnections' => 'Przyłącza wody:',
                'weightNet' => 'Ciężar netto:',
                'guarantee' => 'Okres gwarancji:',
                'symbol' => 'Symbol urządzenia',
                'sku' => 'Numer katalogowy',
                'price' => 'Cena katalogowa netto',
            ],
            'PCCO' => [
                'type' => 'Model',
                'heatingPower' => 'Moc grzewcza (wg EN 14511, A7W35):',
                'supplyPower' => 'Moc zasilania (wg EN 14511, A7W35):',
                'cop' => 'Efektywność COP (wg EN 14511, A7W35):',
                'compressorType' => 'Typ sprężarki:',
                'typeRefrigerant' => 'Rodzaj czynnika chłodniczego:',
                'voltageFrequency' => 'Napięcie/Częstotliwość zasilania:',
                'dimensions' => 'Wymiary urządzenia:',
                'waterConnections' => 'Przyłącza wody:',
                'weightNet' => 'Ciężar netto:',
                'guarantee' => 'Okres gwarancji:',
                'symbol' => 'Symbol urządzenia',
                'sku' => 'Numer katalogowy',
                'price' => 'Cena katalogowa netto',
            ],
        ];

        $pumpCover = [
            [
                'category' => 'CONSTRUCTION',
                'type' => 'Konstrukcja wibroizolacyjna PCCO 6/9/10/11',
                'sku' => '90.00.28',
                'price' => 580,
                'products' => ['HPOM006Z0A HPOM020W6A', 'HPOM009Z0A HPOM020W6A', 'HPOM011Z0A HPOM020W6A', 'HPOM015Z0A HPOM020W6A', 'HPOM018Z0A HPOM020W0A'],
                'img' => ZH_URL . 'public/images/pcwb-form/clientoffer/konstrukcja_wibroizolacyjna.jpeg?v=1'
            ],
            [
                'category' => 'COVER',
                'type' => 'Pokrowiec zimowy PCWB 5,4 kW-A',
                'sku' => '91.09.91',
                'price' => 105,
                'products' => ['91.13.01'],
                'img' => ZH_URL . 'public/images/pcwb-form/clientoffer/pokrowiec-na-pompie.jpeg?v=1'
            ],
            [
                'category' => 'COVER',
                'type' => 'Pokrowiec zimowy PCWB 7,6 kW-A/10,0 kW-A/13,0 kW-A',
                'sku' => '91.09.92',
                'price' => 105,
                'products' => ['91.13.02', '91.13.03', '91.13.04'],
                'img' => ZH_URL . 'public/images/pcwb-form/clientoffer/pokrowiec-na-pompie.jpeg?v=1'
            ],
            [
                'category' => 'COVER',
                'type' => 'Pokrowiec zimowy PCWBi 9,0 kW-A/12,0 kW-A',
                'sku' => '91.09.93',
                'price' => 105,
                'products' => ['91.13.06', '91.13.07'],
                'img' => ZH_URL . 'public/images/pcwb-form/clientoffer/pokrowiec-na-pompie.jpeg?v=1'
            ],
            [
                'category' => 'COVER',
                'type' => 'Pokrowiec zimowy PCWBi 19,5 KW / 19,5 KW-A / PCWB 16,0 KW-A',
                'sku' => '91.09.98',
                'price' => 105,
                'products' => ['91.13.08', '91.13.05'],
                'img' => ZH_URL . 'public/images/pcwb-form/clientoffer/pokrowiec-na-pompie.jpeg?v=1'
            ],
            [
                'category' => 'COVER',
                'type' => 'Pokrowiec zimowy PCWBi 24,2 KW / 28,3 KW / 24,2 KW-A / 28,3 KW-A',
                'sku' => '91.09.99',
                'price' => 105,
                'products' => ['91.13.09', '91.13.10'],
                'img' => ZH_URL . 'public/images/pcwb-form/clientoffer/pokrowiec-na-pompie.jpeg?v=1'
            ],
            [
                'category' => 'WIFI',
                'type' => 'Moduł internetowy PCWB mWiFi',
                'sku' => '91.10.93',
                'price' => 199,
            ],
            [
                'category' => 'BYPASS',
                'type' => 'Bypass 210-32 klejony',
                'sku' => 'HPBB21032A',
                'price' => 558,
                'products' => ['91.13.00'],
                'img' => ZH_URL . 'public/images/pcwb-form/clientoffer/bypass_pingwin.jpeg?v=1',
            ],
            [
                'category' => 'BYPASS',
                'type' => 'Bypass 270-40 klejony',
                'sku' => 'HPBB27040A',
                'price' => 558,
                'products' => ['91.13.01'],
                'img' => ZH_URL . 'public/images/pcwb-form/clientoffer/bypass.jpeg?v=1',
            ],
            [
                'category' => 'BYPASS',
                'type' => 'Bypass 350-40 klejony',
                'sku' => 'HPBB35040A',
                'price' => 558,
                'products' => ['91.13.02', '91.13.03', '91.13.04', 'HPBY071B', '91.13.06', 'HPBY095B', '91.13.07', 'HPBY130B', 'HPBY178B'],
                'img' => ZH_URL . 'public/images/pcwb-form/clientoffer/bypass.jpeg?v=1',
            ],
            [
                'category' => 'BYPASS',
                'type' => 'Bypass 465-50 klejony',
                'sku' => 'HPBB46550A',
                'price' => 558,
                'products' => ['91.13.05', '91.13.08', 'HPBY210B'],
                'img' => ZH_URL . 'public/images/pcwb-form/clientoffer/bypass.jpeg?v=1',
            ],
            [
                'category' => 'BYPASS',
                'type' => 'Bypass 550-50 klejony',
                'sku' => 'HPBB55050A',
                'price' => 558,
                'products' => ['91.13.09', '91.13.10'],
                'img' => ZH_URL . 'public/images/pcwb-form/clientoffer/bypass.jpeg?v=1',
            ],
        ];

        $this->productsParams['pumpsHeadCaption'] = $headCaption;
        $this->productsParams['products'] = array_merge($pumps, $pumpCover);
    }

    private function getProductByType($type)
    {
        $product = array_filter($this->productsParams['products'], function($item) use ($type) {
            return ($item['type'] == $type);
        });

        return array_shift($product);
    }

    private function getProductsBySku($sku)
    {
        $products = array_filter($this->productsParams['products'], function($item) use ($sku) {
            return in_array($item['sku'], $sku);
        });
        return $products;
    }

    private function getOptionSplitProduct($sku)
    {
        $options = [
            '91.09.03' => 'HPOS010Z0A HPOS010W6A',
            '91.10.19' => 'HPOS013Z0A HPOS013W6A',
            '91.09.06' => 'HPOS020Z0A HPOS020W6A',
            'HPOS010Z0A HPOS010W6A' => '91.09.03',
            'HPOS013Z0A HPOS013W6A' => '91.10.19',
            'HPOS020Z0A HPOS020W6A' => '91.09.06',
        ];

        $optionSku = $options[$sku] ?? [];
        $product = array_filter($this->productsParams['products'], function($item) use ($optionSku) {
            return ($item['sku'] == $optionSku);
        });

        return reset($product);
    }

    private function getRangePower($sku)
    {
        switch ($sku) {
            case '91.13.01':
            case '91.13.02':
            case '91.13.03':
            case '91.13.04':
            case '91.13.05':
                return ['HPBY071B', 'HPBY095B', 'HPBY130B'];

            case 'HPBY071B':
            case 'HPBY095B':
            case 'HPBY130B':
                return ['91.13.03', '91.13.04', '91.13.05'];

            default:
                return [];

        }
    }

    private function getRangeSearch($sku)
    {
        switch ($sku) {
            case '91.13.02':
                return ['91.13.02', '91.13.03', '91.13.04', '91.13.05', 'HPBY071B', 'HPBY095B', 'HPBY130B'];

            case '91.13.03':
                return ['91.13.03', '91.13.04', '91.13.05', 'HPBY071B', 'HPBY095B', 'HPBY130B'];

            case '91.13.04':
                return ['91.13.04', '91.13.05', 'HPBY071B', 'HPBY095B', 'HPBY130B', 'HPBY178B'];

            case '91.13.05':
                return ['91.13.05', 'HPBY071B', 'HPBY095B', 'HPBY130B', 'HPBY178B', 'HPBY210B'];

            case 'HPBY071B':
                return ['91.13.03', '91.13.04', '91.13.05', 'HPBY071B', 'HPBY095B', 'HPBY130B'];

            case 'HPBY095B':
                return ['91.13.03', '91.13.04', '91.13.05', 'HPBY071B', 'HPBY095B', 'HPBY130B'];

            case '91.13.01':
                return ['91.13.02', '91.13.03', '91.13.04', '91.13.05', 'HPBY071B', 'HPBY095B', 'HPBY130B'];

            default:
                return [];
        }
    }

    private function getOptionPcwbProduct($sku)
    {
        $rangePower = $this->getRangePower($sku);
        $rangeSearch = $this->getRangeSearch($sku);

        $min = 999999999999999;
        $alternativeProduct = null;
        $product = $this->sheetOptionsPowerAndTemp($sku);

        $pumps = array_filter($this->getProductsByCategory(['PCWB', 'PCWBi']), function($item) use ($rangePower) {
            return in_array($item['sku'], $rangePower);
        });

        foreach($pumps as $pump) {
            $powerOptions = $this->sheetOptionsPowerAndTemp($pump['sku']);
            $power = $powerOptions['power'];

            $searchPower = abs($power - $product['power']);
            if ( $searchPower < $min) {
                $min = $searchPower;
                $alternativeProduct = $pump;
            }
        }
        if (!$alternativeProduct) {
            return null;
        }

        $powerOptions = $this->sheetOptionsPowerAndTemp($alternativeProduct['sku']);
        $alternativeProduct['power'] = $powerOptions['power'];

        $sku = $product['sku'] ?? '';
        if ($alternativeProduct['power'] > $product['power'] || $sku == '91.13.08') {
            return $alternativeProduct;
        }

        $pumps = array_values(array_filter($this->getProductsByCategory(['PCWB', 'PCWBi']), function($item) use ($rangeSearch) {
            return in_array($item['sku'], $rangeSearch);
        }));
        $index = array_search($alternativeProduct['sku'], array_column($pumps, 'sku'));
        $alternativeProduct = $pumps[$index + 1];

        return $alternativeProduct;
    }

    private function getOptionPcwbiBProduct($sku)
    {
        $min = 999999999999999;
        $alternativeProduct = null;
        $product = $this->sheetOptionsPowerAndTemp($sku);
        $pumps = $this->getProductsByCategory(['PCWBi']);
        foreach($pumps as &$pump) {
            $powerOptions = $this->sheetOptionsPowerAndTemp($pump['sku']);
            $power = $powerOptions['power'];

            $searchPower = abs($power - $product['power']);
            if ( $searchPower < $min) {
                $min = $searchPower;
                $alternativeProduct = $pump;
            }
        }
        return $alternativeProduct;
    }

    public function showTest()
    {
        $variables = [];
        $variables = array_merge($variables, $this->prepareTest('C', [7,9,10,11,12,13,14,15,16,17,18]));
        $variables = array_merge($variables, $this->prepareTest('F', [7,8,9,10,11,12,13,14,15,16]));

        $results = [];
        $results[] = $this->prepareTest('C', [21,22,23,24,25,26,27,28,29,30,31,33,34,36,39,40,41,42,43]);
        $results[] = array_merge(
            $this->prepareTest('D', [40,41,42,43]),
            $this->prepareTest('E', [33]),
            $this->prepareTest('F', [23,24,25,40,41]));

        echo '<head>
            <link rel="stylesheet" href="'. ZH_URL . '/public/css/pdf/pdf.css?v=2">
            <link rel="stylesheet" href="' . ZH_URL . '/public/css/pdf/custom.css?v=2">
            <link rel="stylesheet" href="' . ZH_URL . '/public/css/pdf/pcwb.css?v=3">
        </head>';

        echo '<div style="float:left;">
                <h5 style="margin-left:30px;">Parametry</h5>';
        echo '<div style="float:left;"><table cellpadding="5" style="width:300px; font-size:13px;">';
        $b = '#ffffee';
        foreach($variables as $key => $value) {
            $b = ($b == '#ffffee' ? '#f0efd0' : '#ffffee');
            echo '<tr style="background:'. $b .'; border-bottom;: 1px solid #000;"><td>'. $key. '</td><td>'. $value .'</td></tr>';
        }
        echo '</table></div>';
        echo '</div>';

        echo '<div style="float:left;">
                <h5 style="margin-left:30px;">Wyniki</h5>';
        foreach($results as $rkey => $rvalue) {
            $b = '#ffffee';
            echo '<div style="float:left; margin-left:30px;"><table cellpadding="5" style="width:300px; font-size:13px;">';
            foreach ($rvalue as $key => $value) {
                $b = ($b == '#ffffee' ? '#f0efd0' : '#ffffee');
                echo '<tr style="background:' . $b . '; border-bottom;: 1px solid #000;"><td>' . $key . '</td><td>' . $value . '</td></tr>';
            }
            echo '</table></div>';
        }
        echo '</div>';

        foreach($this->productsParams['pumpsHeadCaption'] as $key => $heads) {
            echo '<div style="width:100%;height:40px;clear:both"></div><h4><strong>' . $key .' </strong></h4>';
            echo '<table width="100%" cellpadding="5" cellspacing="5" class="offer">';
            echo '<tr>';
            foreach($heads as $headKey => $headItem) {
                echo '<td align="center">' . $headItem .' </td>';
            }
            echo '</tr>';

            $products = $this->getProductsByCategory([$key]);
            foreach ($products as $product) {
                echo '<tr>';
                foreach($heads as $headKey => $headItem) {
                    echo '<td align="center">' . $product[$headKey] .' </td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        }
        die();
    }

    private function prepareTest($x, $rows)
    {
        $tabs = [];
        foreach($rows as $y) {
            $tabs[$x.$y] = $this->getCell($x, $y);
        }
        return $tabs;
    }

    public function array_columns($array, $keys)
    {
        if (!$array) {
            return [];
        }
        if (!is_array($keys)) {
            $keys = [$keys];
        }
        $filter = function($k) use ($keys){
            return in_array($k,$keys);
        };
        return array_map(function ($el) use ($filter) {
            return array_filter($el, $filter, ARRAY_FILTER_USE_KEY );
        }, $array);
    }
}