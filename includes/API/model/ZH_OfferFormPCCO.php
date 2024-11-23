<?php

namespace Develtio\ZonesHewalex\API\model;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_OfferFormPCCO
 */
class ZH_OfferFormPCCO extends ZH_OfferFormBase
{
    private static $resources = [
        'sides' => [
            ['id' => "north", 'displayName' => "północ",   'excelId' => 'n', 'suffix' => "North", 'owners' => ['wall', 'window']],
            ['id' => "east",  'displayName' => "wschód",   'excelId' => 'e', 'suffix' => "East",  'owners' => ['wall', 'window']],
            ['id' => "south", 'displayName' => "południe", 'excelId' => 's', 'suffix' => "South", 'owners' => ['wall', 'window']],
            ['id' => "west",  'displayName' => "zachód",   'excelId' => 'w', 'suffix' => "West",  'owners' => ['wall', 'window']],
            ['id' => "roof",  'displayName' => "dach",     'excelId' => 'r', 'suffix' => "Roof",  'owners' => ['window']]
        ],
        'constuctionMaterials' => [
            ['id' => "",                'value' => null,                                'displayName' => "wybierz"],
            ['id' => "airbrick1",       'value' => "pustak z ceramiki poryzowanej",     'displayName' => "pustak z ceramiki poryzowanej"],
            ['id' => "airbrick2",       'value' => "pustak ceramiczny Max",             'displayName' => "pustak ceramiczny Max"],
            ['id' => "airbrick3",       'value' => "pustak żużlobetonowy Alfa",         'displayName' => "pustak żużlobetonowy Alfa"],
            ['id' => "airbrick4",       'value' => "pustak keramzytowy 700",            'displayName' => "pustak keramzytowy (700)"],
            ['id' => "airbrick5",       'value' => "pustak keramzytowy 900",            'displayName' => "pustak keramzytowy (900)"],
            ['id' => "brick1",          'value' => "cegła ceramiczna pełna",            'displayName' => "cegła ceramiczna pełna"],
            ['id' => "brick2",          'value' => "cegła ceramiczna dziurawka",        'displayName' => "cegła ceramiczna dziurawka"],
            ['id' => "brick3",          'value' => "cegła ceramiczna kratkówka",        'displayName' => "cegła ceramiczna kratkówka"],
            ['id' => "concrete400",     'value' => "beton komórkowy (400)",             'displayName' => "beton komórkowy (400)"],
            ['id' => "concrete500",     'value' => "beton komórkowy (500)",             'displayName' => "beton komórkowy (500)"],
            ['id' => "concrete600",     'value' => "beton komórkowy (600)",             'displayName' => "beton komórkowy (600)"],
            ['id' => "concrete700",     'value' => "beton komórkowy (700)",             'displayName' => "beton komórkowy (700)"],
            ['id' => "concrete800",     'value' => "beton komórkowy (800)",             'displayName' => "beton komórkowy (800)"],
            ['id' => "block",           'value' => "bloczek silikatowy",                'displayName' => "bloczek silikatowy"],
            ['id' => "wood",            'value' => "bal drewniany w poprzek włókien",   'displayName' => "bal drewniany w poprzek włókien"],
            ['id' => "concretereinf",   'value' => "żelbet",                            'displayName' => "żelbet"],
            ['id' => "custom",          'value' => "własny materiał",                   'displayName' => "własny materiał"]
        ],
        'isolationMaterials' => [
            ['id' => "",                'lambda' => "",    'value' => null,                         'displayName' => "wybierz"],
            ['id' => "wool43",          'lambda' => 0.043, 'value' => "wełna mineralna 0,043",      'displayName' => "wełna mineralna [0,043 W/mK]"],
            ['id' => "wool40",          'lambda' => 0.04,  'value' => "wełna mineralna 0,04",       'displayName' => "wełna mineralna [0,04 W/mK]"],
            ['id' => "wool36",          'lambda' => 0.036, 'value' => "wełna mineralna 0,036",      'displayName' => "wełna mineralna [0,036 W/mK]"],
            ['id' => "wool33",          'lambda' => 0.033, 'value' => "wełna mineralna 0,033",      'displayName' => "wełna mineralna [0,033 W/mK]"],
            ['id' => "styrowhite42",    'lambda' => 0.042, 'value' => "styropian biały 0,042",      'displayName' => "styropian biały [0,042 W/mK]"],
            ['id' => "styrowhite40",    'lambda' => 0.04,  'value' => "styropian biały 0,04",       'displayName' => "styropian biały [0,04 W/mK]"],
            ['id' => "styrowhite38",    'lambda' => 0.038, 'value' => "styropian biały 0,038",      'displayName' => "styropian biały [0,038 W/mK]"],
            ['id' => "styrographite33", 'lambda' => 0.033, 'value' => "styropian grafitowy 0,033",  'displayName' => "styropian grafitowy [0,033 W/mK]"],
            ['id' => "styrographite31", 'lambda' => 0.031, 'value' => "styropian grafitowy 0,031",  'displayName' => "styropian grafitowy [0,031 W/mK]"],
            ['id' => "pur35",           'lambda' => 0.035, 'value' => "pianka PUR 0,035",           'displayName' => "pianka PUR [0,035 W/mK]"],
            ['id' => "pir22",           'lambda' => 0.022, 'value' => "płyta PIR 0,022",            'displayName' => "płyta PIR [0,022 W/mK]"],
            ['id' => "platestraw56",    'lambda' => 0.056, 'value' => "płyta słomiana 0,056",       'displayName' => "płyta słomiana [0,056 W/mK]"],
            ['id' => "perlit7",         'lambda' => 0.07,  'value' => "perlit 0,07",                'displayName' => "perlit [0,07 W/mK]"],
            ['id' => "custom",          'lambda' => "",    'value' => "własny materiał",            'displayName' => "własny materiał"]
        ],
        'windowTypes' => [
            ['id' => "",        'value' => null,                                    'u' => null,      'displayName' => "wybierz"],
            ['id' => "dk",      'value' => "dwuszybowe kilkuletnie-1.4W/m2K",       'u' => "1.4",     'displayName' => "dwuszybowe kilkuletnie"],
            ['id' => "dkn",     'value' => "dwuszybowe kilkunastoletnie-1.9W/m2K",  'u' => "1.9",     'displayName' => "dwuszybowe kilkunastoletnie"],
            ['id' => "dn",      'value' => "dwuszybowe nowe-1.2W/m2K",              'u' => "1.2",     'displayName' => "dwuszybowe nowe"],
            ['id' => "ts",      'value' => "trójszybowe standardowe-1.1W/m2K",      'u' => "1.1",     'displayName' => "trójszybowe standardowe"],
            ['id' => "te",      'value' => "trójszybowe energooszczędne-0.9W/m2K",  'u' => "0.9",     'displayName' => "trójszybowe energooszczędne"],
            ['id' => "tee",     'value' => "trójszybowe dom pasywny-0.7W/m2K",      'u' => "0.7",     'displayName' => "trójszybowe dom pasywny"],
            ['id' => "custom",  'value' => "własny materiał",                       'u' => null,      'displayName' => "własny materiał"]
        ],
        'wallLayers' => [
            ['id' => 'cl',  'displayName' => 'warstwa konstrukcyjna',     'excelId' => '1', 'suffix' => 'ConstructionLayer',        'materials' => '[CONSTRUCTION_MATERIALS]'],
            ['id' => 'il',  'displayName' => 'warstwa izolacyjna',        'excelId' => '2', 'suffix' => 'IsolationLayer',           'materials' => '[ISOLATION_MATERIALS]'],
            ['id' => 'ol',  'displayName' => 'warstwa zewnętrzna',        'excelId' => '3', 'suffix' => 'OutsideLayer',             'materials' => '[CONSTRUCTION_MATERIALS]'],
            ['id' => 'ail', 'displayName' => 'docieplenie w konstrukcji', 'excelId' => '4', 'suffix' => 'AdditionalIsolationLayer', 'materials' => '[ISOLATION_MATERIALS]'],
        ],
        'cities' => [
            ['id' => "",    'displayName' => "wybierz",      'value' => null,           'climateZone' => null],
            ['id' => "bl",  'displayName' => "Białystok",    'value' => "Białystok",    'climateZone' => 4],
            ['id' => "el",  'displayName' => "Elbląg",       'value' => "Elbląg",       'climateZone' => 3],
            ['id' => "gd",  'displayName' => "Gdańsk",       'value' => "Gdańsk",       'climateZone' => 1],
            ['id' => "gr",  'displayName' => "Gorzów Wlk.",  'value' => "Gorzów Wlk.",  'climateZone' => 2],
            ['id' => "jl",  'displayName' => "Jelenia Góra", 'value' => "Jelenia Góra", 'climateZone' => 3],
            ['id' => "kls", 'displayName' => "Kalisz",       'value' => "Kalisz",       'climateZone' => 2],
            ['id' => "kt",  'displayName' => "Katowice",     'value' => "Katowice",     'climateZone' => 3],
            ['id' => "klc", 'displayName' => "Kielce",       'value' => "Kielce",       'climateZone' => 3],
            ['id' => "kl",  'displayName' => "Koło",         'value' => "Koło",         'climateZone' => 2],
            ['id' => "kld", 'displayName' => "Kłodzko",      'value' => "Kłodzko",      'climateZone' => 3],
            ['id' => "kr",  'displayName' => "Kraków",       'value' => "Kraków",       'climateZone' => 3],
            ['id' => "lg",  'displayName' => "Legnica",      'value' => "Legnica",      'climateZone' => 2],
            ['id' => "ls",  'displayName' => "Lesko",        'value' => "Lesko",        'climateZone' => 4],
            ['id' => "lb",  'displayName' => "Lublin",       'value' => "Lublin",       'climateZone' => 3],
            ['id' => "lba", 'displayName' => "Łeba",         'value' => "Łeba",         'climateZone' => 1],
            ['id' => "ld",  'displayName' => "Łódź",         'value' => "Łódź",         'climateZone' => 3],
            ['id' => "ml",  'displayName' => "Mława",        'value' => "Mława",        'climateZone' => 3],
            ['id' => "ol",  'displayName' => "Olsztyn",      'value' => "Olsztyn",      'climateZone' => 4],
            ['id' => "pl",  'displayName' => "Piła",         'value' => "Piła",         'climateZone' => 2],
            ['id' => "plc", 'displayName' => "Płock",        'value' => "Płock",        'climateZone' => 3],
            ['id' => "pz",  'displayName' => "Poznań",       'value' => "Poznań",       'climateZone' => 2],
            ['id' => "rc",  'displayName' => "Racibórz",     'value' => "Racibórz",     'climateZone' => 3],
            ['id' => "rz",  'displayName' => "Rzeszów",      'value' => "Rzeszów",      'climateZone' => 3],
            ['id' => "sn",  'displayName' => "Sandomierz",   'value' => "Sandomierz",   'climateZone' => 3],
            ['id' => "sd",  'displayName' => "Siedlce",      'value' => "Siedlce",      'climateZone' => 4],
            ['id' => "sl",  'displayName' => "Sulejów",      'value' => "Sulejów",      'climateZone' => 3],
            ['id' => "sw",  'displayName' => "Suwałki",      'value' => "Suwałki",      'climateZone' => 5],
            ['id' => "sz",  'displayName' => "Szczecin",     'value' => "Szczecin",     'climateZone' => 1],
            ['id' => "swn", 'displayName' => "Świnioujście", 'value' => "Świnioujście", 'climateZone' => 1],
            ['id' => "tr",  'displayName' => "Terespol",     'value' => "Terespol",     'climateZone' => 4],
            ['id' => "trn", 'displayName' => "Toruń",        'value' => "Toruń",        'climateZone' => 3],
            ['id' => "wr",  'displayName' => "Warszawa",     'value' => "Warszawa",     'climateZone' => 3],
            ['id' => "wl",  'displayName' => "Włodawa",      'value' => "Włodawa",      'climateZone' => 3],
            ['id' => "wrc", 'displayName' => "Wrocław",      'value' => "Wrocław",      'climateZone' => 2],
            ['id' => "zk",  'displayName' => "Zakopane",     'value' => "Zakopane",     'climateZone' => 5]
        ]
    ];

    protected $formGroups = [
        /* main groups */
        'form' => [
            'subgroupsIds' => ['contact', 'formOptions']
        ],
        'contact' => [
            'label' => 'Dane kontaktowe',
            'order' => 1
        ],
        'formOptions' => [
            'label' => 'Formularz doboru',
            'subgroupsIds' => [
                'pumpUsage', 'waterUsage', 'building', 'attic', 'garage',
                'basement', 'bottomIsolation', 'walls', 'windows', 'roof', 'cwu', 'vent', 'co',
                'location', 'additional'
            ],
            'order' => 2
        ],
        /* form models groups */
        'pumpUsage' => [
            'order' => 1
        ],
        'waterUsage' => [
            'label' => 'Zużycie wody',
            'order' => 2
        ],
        'building' => [
            'label' => 'Budynek',
            'order' => 3
        ],
        'attic' => [
            'label' => 'Poddasze',
            'order' => 4
        ],
        'garage' => [
            'label' => 'Garaż',
            'order' => 5
        ],
        'basement' => [
            'label' => 'Piwnica',
            'order' => 6
        ],
        'bottomIsolation' => [
            'label' => 'Podłoga na gruncie',
            'order' => 7
        ],
        'walls' => [
            'label' => 'Ściany',
            'order' => 8
        ],
        'windows' => [
            'label' => 'Okna',
            'order' => 9
        ],
        'roof' => [
            'label' => 'Dach',
            'order' => 10
        ],
        'cwu' => [
            'label' => 'Woda użytkowa',
            'order' => 11
        ],
        'vent' => [
            'label' => 'Wentylacja',
            'order' => 12
        ],
        'co' => [
            'label' => 'Ogrzewanie',
            'order' => 13
        ],
        'location' => [
            'label' => 'Lokalizacja inwestycji',
            'order' => 14
        ],
        'additional' => [
            'label' => 'Informacje dodatkowe',
            'order' => 15,
            'hidden' => [
                'summary' => true,
                'print' => false
            ]
        ]
    ];

    protected $formModels = [
        /* initial step */
        'pumpUsage' => [
            'label' => 'Przeznaczenie pompy ciepła',
            'group' => ['formOptions', 'pumpUsage'],
            'excelId' => '1',
            'options' => [
                ['id' => "co+cwu",  'value' => 2, 'displayName' => "Ciepła woda użytkowa/ ogrzewanie budynku"],
                ['id' => "cwu",     'value' => 3, 'displayName' => "Zwiększone potrzeby ciepłej wody użytkowej"],
                ['id' => "co",      'value' => 1, 'displayName' => "Ogrzewanie budynku"]
            ],
            'order' => 5,
        ],
        /* step 1 */
        'waterUsageSelectionMode' => [
            'group' => ['formOptions', 'waterUsage'],
            'excelId' => '4.1',
            'hidden' => true
        ],
        'buildingPeopleCount' => [
            'label' => 'Ilość osób korzystających z ciepłej wody użytkowej',
            'group' => ['formOptions', 'waterUsage'],
            'excelId' => '4',
            'order' => 10,
            'unit' => 'os.'
        ],
        'waterUsageDaily' => [
            'label' => 'Dzienne zużycie ciepłej wody użytkowej',
            'group' => ['formOptions', 'waterUsage'],
            'excelId' => '4.1.0.1',
            'order' => 20,
            'unit' => 'l'
        ],
        'maxDisposableWaterUsage' => [
            'label' => 'Maksymalny jednorazowy rozbiór ciepłej wody użytkowej',
            'group' => ['formOptions', 'waterUsage'],
            'excelId' => '4.1.0.2',
            'order' => 30,
            'unit' => 'l'
        ],
        'timeGapBetweenHighWaterUsage' => [
            'label' => 'Czas pomiędzy dużymi rozbiorami ciepłej wody użytkowej',
            'group' => ['formOptions', 'waterUsage'],
            'excelId' => '4.1.0.3',
            'order' => 40,
            'unit' => 'h'
        ],
        /* step 2 */
        'buildingState' => [
            'label' => 'Rodzaj budynku dla zastosowania pompy ciepła',
            'group' => ['formOptions', 'building'],
            'excelId' => '3.1',
            'options' => [
                ['id' => "",     'value' => null, 'displayName' => "wybierz"],
                ['id' => "new",  'value' => 0,    'displayName' => "nowy"],
                ['id' => "used", 'value' => 1,    'displayName' => "modernizowany"]
            ],
            'order' => 50
        ],
        'buildingHeatedSurface' => [
            'label' => [
                'form' => 'Ogrzewana powierzchnia <strong>bez poddasza, garażu oraz piwnicy</strong>',
                'print' => 'Ogrzewana powierzchnia'
            ],
            'group' => ['formOptions', 'building'],
            'excelId' => '3.9',
            'order' => 60,
            'unit' => 'm<sup>2</sup>'
        ],
        'buildingSurface' => [
            'label' => 'Powierzchnia zabudowy na gruncie',
            'labelPs' => '(bez garażu oraz tarasu)',
            'group' => ['formOptions', 'building'],
            'excelId' => '3.9.1',
            'order' => 70,
            'unit' => 'm<sup>2</sup>'
        ],
        'expectedRoomTemp' => [
            'label' => 'Oczekiwana temperatura wewnętrzna',
            'group' => ['formOptions', 'building'],
            'excelId' => '3.10',
            'order' => 80,
            'unit' => '<sup>o</sup>C'
        ],
        'buildingHeatLoadSelectionMode' => [
            'label' => [
                'form' => 'Czy znasz obciążenie cieplne budynku w <strong>KW</strong> (nie w kWh)',
                'print' => 'Czy znasz obciążenie cieplne budynku'
            ],
            'group' => ['formOptions', 'building'],
            'excelId' => '2',
            'options' => [
                ['id' => "",  'value' => null, 'displayName' => "wybierz"],
                ['id' => "y", 'value' => 1,    'displayName' => "tak"],
                ['id' => "n", 'value' => 0,    'displayName' => "nie"],
            ],
            'order' => 85,
        ],
        'pumpSelectionDetails' => [
            'group' => ['formOptions', 'building'],
            'excelId' => '3',
            'hidden' => true
        ],
        'buildingHeatLoad' => [
            'label' => 'Moc obciążenia cieplnego budynku',
            'group' => ['formOptions', 'building'],
            'excelId' => '2.1.2',
            'order' => 90,
            'unit' => 'kW'
        ],
        'buildingType' => [
            'label' => 'Typ budynku',
            'group' => ['formOptions', 'building'],
            'excelId' => '3.2',
            'options' => [
                ['id' => "",          'value' => null,      'displayName' => "wybierz"],
                ['id' => "detached",  'value' => 2,         'displayName' => "wolnostojący"],
                ['id' => "twin",      'value' => 3,         'displayName' => "bliźniak - sąsiad z jednej strony"],
                ['id' => "inline",    'value' => 0,         'displayName' => "szeregowy - sąsiad z dwóch strony"],
                ['id' => "flat",      'value' => 1,         'displayName' => "mieszkanie"]
            ],
            'order' => 100
        ],
        'expectedHeatGains' => [
            'label' => 'Spodziewane wewnętrzne zyski ciepła',
            'group' => ['formOptions', 'building'],
            'excelId' => '3.3',
            'options' => [
                ['id' => "small", 'value' => 3,  'displayName' => "małe"],
                ['id' => "mid",   'value' => 1,  'displayName' => "średnie"],
                ['id' => "big",   'value' => 2,  'displayName' => "duże"]
            ],
            'order' => 110
        ],
        'heatedStoreys' => [
            'label' => [
                'form' => 'Ilość ogrzewanych kondygnacji <strong>o stałej wysokości</strong>, bez poddasza oraz piwnicy',
                'print' => 'Ilość ogrzewanych kondygnacji'
            ],
            'group' => ['formOptions', 'building'],
            'excelId' => '3.4',
            'order' => 120
        ],
        'flatLocation' => [
            'label' => 'Usytuowanie mieszkania w budynku',
            'group' => ['formOptions', 'building'],
            'excelId' => '3.2.1',
            'options' => [
                ['id' => "",        'value' => null,      'displayName' => "wybierz"],
                ['id' => "ground",  'value' => 1,         'displayName' => "parter"],
                ['id' => "stroey",  'value' => 2,         'displayName' => "sąsiad z góry i z dołu"],
                ['id' => "attic",   'value' => 3,         'displayName' => "poddasze"],
                ['id' => "other",   'value' => 0,         'displayName' => "inny"]
            ],
            'order' => 130
        ],
        'atticType' => [
            'label' => 'Typ poddasza',
            'group' => ['formOptions', 'attic'],
            'excelId' => '3.4.1',
            'options' => [
                ['id' => '',          'value' => null,      'displayName' => 'wybierz'],
                ['id' => 'without',   'value' => 0,         'displayName' => 'brak lub poddasze nieogrzewane'],
                ['id' => 'partial',   'value' => 1,         'displayName' => 'poddasze ogrzewane']
            ],
            'order' => 140
        ],
        'atticSurface' => [
            'label' => 'Powierzchnia poddasza',
            'group' => ['formOptions', 'attic'],
            'excelId' => '3.4.1.1',
            'order' => 150,
            'unit' => 'm<sup>2</sup>'
        ],
        'garageType' => [
            'label' => 'Czy budynek posiada garaż',
            'group' => ['formOptions', 'garage'],
            'excelId' => '3.11',
            'options' => [
                ['id' => "",          'value' => null,      'displayName' => "wybierz"],
                ['id' => "heated",    'value' => 1,         'displayName' => "tak i będzie ogrzewany"],
                ['id' => "nonheated", 'value' => 0,         'displayName' => "tak, ale nie będzie ogrzewany"],
                ['id' => "nogarage",  'value' => 2,         'displayName' => "nie posiada"]
            ],
            'order' => 160
        ],
        'garageSurface' => [
            'label' => 'Powierzchnia garażu',
            'group' => ['formOptions', 'garage'],
            'excelId' => '3.11.1',
            'order' => 170,
            'unit' => 'm<sup>2</sup>'
        ],
        'garageInBuilding' => [
            'label' => 'Czy garaż znajduje się w bryle budynku',
            'group' => ['formOptions', 'garage'],
            'excelId' => '3.11.2',
            'options' => [
                ['id' => "",  'value' => null,  'displayName' => "wybierz"],
                ['id' => "y", 'value' => 1,     'displayName' => "tak"],
                ['id' => "n", 'value' => 0,     'displayName' => "nie"]
            ],
            'order' => 180
        ],
        'expectedGarageTemp' => [
            'label' => 'Oczekiwana temperatura w garażu',
            'group' => ['formOptions', 'garage'],
            'excelId' => '3.11.3',
            'order' => 190,
            'unit' => '<sup>o</sup>C'
        ],
        'isBasement' => [
            'label' => 'Czy w budynku jest piwnica',
            'group' => ['formOptions', 'basement'],
            'excelId' => '3.12',
            'options' => [
                ['id' => "",                'value' => null, 'displayName' => "wybierz"],
                ['id' => "withBasement",    'value' => 1,    'displayName' => "tak"],
                ['id' => "withoutBasement", 'value' => 0,    'displayName' => "nie"]
            ],
            'order' => 200
        ],
        'basementSurface' => [
            'label' => 'Powierzchnia piwnicy',
            'group' => ['formOptions', 'basement'],
            'excelId' => '3.12.1.1',
            'order' => 210,
            'unit' => 'm<sup>2</sup>'
        ],
        'isBasementHeated' => [
            'label' => 'Czy piwnica jest ogrzewana',
            'group' => ['formOptions', 'basement'],
            'excelId' => '3.12.1.2',
            'options' => [
                ['id' => "",  'value' => null, 'displayName' => "wybierz"],
                ['id' => "y", 'value' => 1,    'displayName' => "tak"],
                ['id' => "n", 'value' => 0,    'displayName' => "nie"]
            ],
            'order' => 220
        ],
        'expectedBasementTemp' => [
            'label' => 'Oczekiwana temperatura w piwnicy',
            'group' => ['formOptions', 'basement'],
            'excelId' => '3.12.1.2.1',
            'order' => 230,
            'unit' => '<sup>o</sup>C'
        ],
        'bottomIsolationType' => [
            'label' => 'Izolacja od gruntu',
            'group' => ['formOptions', 'bottomIsolation'],
            'excelId' => '3.14',
            'options' => [
                ['id' => "",                         'value' => null, 'displayName' => "wybierz",                                             'parentId' => []],
                ['id' => "basementwithoutisolation", 'value' => 0,    'displayName' => "brak",                                                'parentId' => ["withBasement"]],
                ['id' => "basementroofonly",         'value' => 2,    'displayName' => "izolowany cieplnie wyłącznie strop",                  'parentId' => ["withBasement"]],
                ['id' => "basementfull",             'value' => 1,    'displayName' => "izolowana cieplnie bryła piwnicy (ściany i podłoga)", 'parentId' => ["withBasement"]],
                ['id' => "groundwithoutisolation",   'value' => 3,    'displayName' => "brak",                                                'parentId' => ["withoutBasement"]],
                ['id' => "groundwithisolation",      'value' => 4,    'displayName' => "izolacja na gruncie",                                 'parentId' => ["withoutBasement"]]
            ],
            'order' => 240
        ],
        'bottomIsolationMaterial' => [
            'label' => 'Rodzaj izolacji',
            'group' => ['formOptions', 'bottomIsolation'],
            'excelId' => '3.14.1',
            'options' => '[ISOLATION_MATERIALS]',
            'order' => 250
        ],
        'bottomIsolationMaterialLambda' => [
            'label' => 'Współczynnik LAMBDA izolacji',
            'group' => ['formOptions', 'bottomIsolation'],
            'excelId' => '3.14.1.1',
            'order' => 258,
            'unit' => 'W/mK'
        ],
        'bottomIsolationThickness' => [
            'label' => 'Grubość izolacji',
            'group' => ['formOptions', 'bottomIsolation'],
            'excelId' => '3.14.2',
            'order' => 260,
            'unit' => 'cm'
        ],
        'wallType' => [
            'label' => 'Budowa ściany',
            'group' => ['formOptions', 'walls'],
            'excelId' => ['3.7.n.z', '3.7.n.w', '3.7.e.z', '3.7.e.w', '3.7.s.z', '3.7.s.w', '3.7.w.z', '3.7.w.w'],
            'options' => [
                ['id' => "",         'value' => null, 'displayName' => "wybierz"],
                ['id' => "layer1",   'value' => 1,    'displayName' => "mur bez izolacji cieplnej"],
                ['id' => "layer2",   'value' => 2,    'displayName' => "mur z izolacją cieplną"],
                ['id' => "layer3",   'value' => 3,    'displayName' => "trójwarstwowa"],
                ['id' => "skeleton", 'value' => 4,    'displayName' => "szkieletowa"]
            ],
            'order' => 271
        ],
        'wallSurfaceTotal[DIRECTION_SUFFIX]' => [
            'generic' => true,
            'baseModel' => 'wallSurfaceTotal',
            'label' => 'Całkowita powierzchnia ścian zewnętrznych, [DIRECTION_LABEL]',
            'group' => ['formOptions', 'walls'],
            'excelId' => '3.6.[DIRECTION_ID].z',
            'order' => 273,
            'unit' => 'm<sup>2</sup>'
        ],
        'wallSurfaceConnected[DIRECTION_SUFFIX]' => [
            'generic' => true,
            'baseModel' => 'wallSurfaceConnected',
            'label' => 'Powierzchnia ścian łączących budynek z innym budynkiem lub garażem, [DIRECTION_LABEL]',
            'group' => ['formOptions', 'walls'],
            'excelId' => '3.6.[DIRECTION_ID].w',
            'order' => 275,
            'unit' => 'm<sup>2</sup>'
        ],
        'wall[LAYER_SUFFIX]Thickness[DIRECTION_SUFFIX]' => [
            'generic' => true,
            'baseModel' => 'wallThickness',
            'label' => 'Grubość ściany: [LAYER_LABEL], [DIRECTION_LABEL]',
            'group' => ['formOptions', 'walls'],
            'excelId' => ["3.7.[LAYER_ID].2.[DIRECTION_ID].z", "3.7.[LAYER_ID].2.[DIRECTION_ID].w"],
            'order' => 277,
            'unit' => 'cm'
        ],
        'wall[LAYER_SUFFIX]Material[DIRECTION_SUFFIX]' => [
            'generic' => true,
            'baseModel' => 'wallMaterial',
            'label' => 'Materiał: [LAYER_LABEL], [DIRECTION_LABEL]',
            'group' => ['formOptions', 'walls'],
            'excelId' => ["3.7.[LAYER_ID].1.[DIRECTION_ID].z", "3.7.[LAYER_ID].1.[DIRECTION_ID].w"],
            'options' => '[LAYER_MATERIALS]',
            'order' => 279,
        ],
        'wall[LAYER_SUFFIX]MaterialLambda[DIRECTION_SUFFIX]' => [
            'generic' => true,
            'baseModel' => 'wallMaterialLambda',
            'label' => 'Współczynnik LAMBDA: [LAYER_LABEL], [DIRECTION_LABEL]',
            'group' => ['formOptions', 'walls'],
            'excelId' => ["3.7.[LAYER_ID].1.1.[DIRECTION_ID].z", "3.7.[LAYER_ID].1.1.[DIRECTION_ID].w"],
            'order' => 281,
            'unit' => 'W/mK'
        ],
        'windowType[DIRECTION_SUFFIX]' => [
            'generic' => true,
            'baseModel' => 'windowType',
            'label' => 'Typ okien, [DIRECTION_LABEL]',
            'group' => ['formOptions', 'windows'],
            'excelId' => '3.8.[DIRECTION_ID].1',
            'options' => '[WINDOW_TYPES]',
            'order' => 287
        ],
        'windowSurface[DIRECTION_SUFFIX]' => [
            'generic' => true,
            'baseModel' => 'windowSurface',
            'label' => 'Powierzchnia okien, [DIRECTION_LABEL]',
            'group' => ['formOptions', 'windows'],
            'excelId' => '3.8.[DIRECTION_ID]',
            'order' => 288,
            'unit' => 'm<sup>2</sup>'
        ],
        'windowMaterialFactor[DIRECTION_SUFFIX]' => [
            'generic' => true,
            'baseModel' => 'windowMaterialFactor',
            'label' => 'Współczynnik U okien, [DIRECTION_LABEL]',
            'group' => ['formOptions', 'windows'],
            'excelId' => '3.8.[DIRECTION_ID].1.1',
            'order' => 289,
            'unit' => 'W/m<sup>2</sup>K'
        ],
        'roofType' => [
            'label' => 'Rodzaj dachu',
            'group' => ['formOptions', 'roof'],
            'excelId' => '3.5',
            'options' => [
                ['id' => "",         'value' => null, 'displayName' => "wybierz"],
                ['id' => "flat",     'value' => 1,    'displayName' => "płaski"],
                ['id' => "envelope", 'value' => 2,    'displayName' => "kopertowy"],
                ['id' => "gable",    'value' => 3,    'displayName' => "dwuspadowy"]
            ],
            'order' => 290
        ],
        'roofSurface' => [
            'label' => 'Powierzchnia dachu',
            'group' => ['formOptions', 'roof'],
            'excelId' => '3.13.1',
            'order' => 295,
            'unit' => 'm<sup>2</sup>'
        ],
        'roofIsolationLocation' => [
            'label' => 'Lokalizacja izolacji dachu/ stropu',
            'group' => ['formOptions', 'roof'],
            'excelId' => '3.13',
            'options' => [
                ['id' => "",        'value' => null, 'displayName' => "wybierz"],
                ['id' => "roof",    'value' => 2,    'displayName' => "na stropie"],
                ['id' => "surface", 'value' => 1,    'displayName' => "wzdłuż powierzchni dachu"],
                ['id' => "without", 'value' => 0,    'displayName' => "brak ocieplenia"]
            ],
            'order' => 300
        ],
        'roofIsolationMaterial' => [
            'label' => 'Rodzaj izolacji dachu',
            'group' => ['formOptions', 'roof'],
            'excelId' => '3.13.2.1',
            'options' => '[ISOLATION_MATERIALS]',
            'order' => 310
        ],
        'roofIsolationMaterialLambda' => [
            'label' => 'Współczynnik LAMBDA izolacji',
            'group' => ['formOptions', 'roof'],
            'excelId' => '3.13.2.1.1',
            'order' => 320,
            'unit' => 'W/mK'
        ],
        'roofIsolationThickness' => [
            'label' => 'Grubość izolacji',
            'group' => ['formOptions', 'roof'],
            'excelId' => '3.13.2.2',
            'order' => 330,
            'unit' => 'cm'
        ],
        /* step 3 */
        'cwuTankState' => [
            'label' => 'Istniejący zbiornik wody użytkowej',
            'group' => ['formOptions', 'cwu'],
            'excelId' => '4.2',
            'options' => [
                ['id' => "",     'value' => null, 'displayName' => "wybierz"],
                ['id' => "new",  'value' => 0,    'displayName' => "brak lub chcę nowy"],
                ['id' => "used", 'value' => 1,    'displayName' => "mam zbiornik"]
            ],
            'order' => 340
        ],
        'cwuTankSize' => [
            'label' => 'Pojemność aktualnego zbiornika wody',
            'group' => ['formOptions', 'cwu'],
            'excelId' => '4.2.1.1',
            'order' => 350,
            'unit' => 'l'
        ],
        'cwuTankCoilSize' => [
            'label' => 'Powierzchnia wolnej wężownicy',
            'group' => ['formOptions', 'cwu'],
            'excelId' => '4.2.1.2',
            'order' => 360,
            'unit' => 'm<sup>2</sup>'
        ],
        'pumpWithCirculation' => [
            'label' => 'Czy instalacja ma być wyposażona w cyrkulację',
            'group' => ['formOptions', 'cwu'],
            'excelId' => '4.4',
            'options' => [
                ['id' => "",  'value' => null, 'displayName' => "wybierz"],
                ['id' => "y", 'value' => 1,    'displayName' => "tak"],
                ['id' => "n", 'value' => 0,    'displayName' => "nie"]
            ],
            'order' => 370
        ],
        'cwuHeatingAdditionalDevices' => [
            'label' => 'Inne urządzenie do podgrzewania wody użytkowej, które posiadam',
            'group' => ['formOptions', 'cwu'],
            'excelId' => '4.3',
            'options' => [
                ['id' => "",    'value' => null,                          'displayName' => "wybierz"],
                ['id' => "kg",  'value' => "Kocioł gazowy",               'displayName' => "kocioł gazowy"],
                ['id' => "ko",  'value' => "Kocioł olejowy",              'displayName' => "kocioł olejowy"],
                ['id' => "ks",  'value' => "Kocioł stałopalny",           'displayName' => "kocioł stałopalny"],
                ['id' => "ke",  'value' => "Kocioł elektryczny",          'displayName' => "kocioł elektryczny"],
                ['id' => "kpw", 'value' => "Kominek z płaszczem wodnym",  'displayName' => "kominek z płaszczem wodnym"],
                ['id' => "ge",  'value' => "Grzałka elektryczna",         'displayName' => "grzałka elektryczna"],
                ['id' => "sol", 'value' => "Kolektory słoneczne",         'displayName' => "kolektory słoneczne"],
                ['id' => "cwu", 'value' => "Pompa ciepła wody użytkowej", 'displayName' => "pompa ciepła wody użytkowej"],
                ['id' => "b",   'value' => "Brak",                        'displayName' => "brak"]
            ],
            'order' => 380
        ],
        'buildingVentType' => [
            'label' => 'Rodzaj wentylacji w budynku',
            'group' => ['formOptions', 'vent'],
            'excelId' => '3.15',
            'options' => [
                ['id' => "",     'value' => null, 'displayName' => "wybierz"],
                ['id' => "grav", 'value' => 1,    'displayName' => "grawitacyjna"],
                ['id' => "mech", 'value' => 2,    'displayName' => "Mechaniczna nawiewno-wywiewna"],
                ['id' => "reku", 'value' => 3,    'displayName' => "Mechaniczna z odzyskiem ciepła (rekuperacja)"]
            ],
            'order' => 390
        ],
        'buildingHeatingType' => [
            'label' => 'Rodzaj ogrzewania',
            'group' => ['formOptions', 'co'],
            'excelId' => '3.16',
            'options' => [
                ['id' => "",       'value' => null, 'displayName' => "wybierz"],
                ['id' => "wall",   'value' => 1,    'displayName' => "podłogowe lub ścienne"],
                ['id' => "heater", 'value' => 2,    'displayName' => "grzejnikowe"],
                ['id' => "klim",   'value' => 3,    'displayName' => "klimakonwektorowe"],
                ['id' => "mixed",  'value' => 4,    'displayName' => "mieszane"]
            ],
            'order' => 400
        ],
        'buildingHeatingInPrecentWall' => [
            'label' => 'Procentowy udział ogrzewania: podłogowe lub ścienne',
            'group' => ['formOptions', 'co'],
            'excelId' => '3.16.4.1',
            'order' => 410,
            'unit' => '%'
        ],
        'buildingHeatingInPrecentHeater' => [
            'label' => 'Procentowy udział ogrzewania: grzejnikowe',
            'group' => ['formOptions', 'co'],
            'excelId' => '3.16.4.2',
            'order' => 420,
            'unit' => '%'
        ],
        'buildingHeatingInPrecentKlim' => [
            'label' => 'Procentowy udział ogrzewania: klimakonwektorowe',
            'group' => ['formOptions', 'co'],
            'excelId' => '3.16.4.3',
            'order' => 430,
            'unit' => '%'
        ],
        'heatingMaxTemp' => [
            'label' => 'Maksymalna temperatura zasilania instalacji grzewczej',
            'group' => ['formOptions', 'co'],
            'excelId' => '3.17',
            'order' => 440,
            'unit' => '<sup>o</sup>C'
        ],
        'pumpAsOnlyHeatingDevice' => [
            'label' => 'Czy pompa ciepła będzie jedynym źródłem grzewczym?',
            'group' => ['formOptions', 'co'],
            'options' => [
                ['id' => "",  'value' => null, 'displayName' => "wybierz"],
                ['id' => "y", 'value' => 1,    'displayName' => "tak"],
                ['id' => "n", 'value' => 0,    'displayName' => "nie"]
            ],
            'excelId' => '3.17.1',
            'order' => 450
        ],
        'coHeatingAdditionalDevices' => [
            'label' => 'Dodatkowe źródło grzewcze',
            'labelOptions' => [
                'additional' => 'Dodatkowe źródło grzewcze',
                'current' => 'Obecnie stosowane źródło grzewcze'
            ],
            'group' => ['formOptions', 'co'],
            'excelId' => '3.17.1.0',
            'options' => [
                ['id' => "",    'value' => null,                          'displayName' => "wybierz"],
                ['id' => "kg",  'value' => "Kocioł gazowy",               'displayName' => "kocioł gazowy"],
                ['id' => "ko",  'value' => "Kocioł olejowy",              'displayName' => 'kocioł olejowy'],
                ['id' => "kw",  'value' => "Kocioł węglowy",              'displayName' => "kocioł węglowy"],
                ['id' => "ks",  'value' => "Kocioł stałopalny",           'displayName' => "kocioł stałopalny"],
                ['id' => "ke",  'value' => "Kocioł elektryczny",          'displayName' => "kocioł elektryczny"],
                ['id' => "kpw", 'value' => "Kominek z płaszczem wodnym",  'displayName' => "kominek z płaszczem wodnym"],
                ['id' => "kp",  'value' => "Kominek powietrzny",          'displayName' => "kominek powietrzny"],
                ['id' => "gco", 'value' => "Grzałka w buforze CO",        'displayName' => "grzałka w buforze CO"]
            ],
            'order' => 460
        ],
        'fuelBurnedAmount' => [
            'label' => 'Ilość dotychczas spalanego opału',
            'group' => ['formOptions', 'co'],
            'excelId' => '3.17.1.1',
            'order' => 470
        ],
        'fuelBurnedAmountUnit' => [
            'label' => 'Jednostka ilości spalanego opału',
            'group' => ['formOptions', 'co'],
            'excelId' => '3.17.1.1.u',
            'options' => [
                ['id' => "",    'value' => null,      'displayName' => "wybierz jednostkę"],
                ['id' => "t",   'value' => "Tony",    'displayName' => "tony"],
                ['id' => "kWh", 'value' => "kWh",     'displayName' => "kWh"],
                ['id' => "m3",  'value' => "m3",      'displayName' => "m3"],
                ['id' => "mp",  'value' => "mp",      'displayName' => "mp"],
                ['id' => "zł",  'value' => "zł",      'displayName' => "zł"],
                ['id' => "l",   'value' => "l",       'displayName' => "l"],
                ['id' => "kg",  'value' => "kg",      'displayName' => "kg"]
            ],
            'order' => 480
        ],
        'installationPostcode' => [
            'label' => 'Kod pocztowy lokalizacji inwestycji',
            'group' => ['formOptions', 'location'],
            'excelId' => '5',
            'order' => 490
        ],
        'installationClimateZone' => [
            'label' => 'Strefa klimatyczna',
            'group' => ['formOptions', 'location'],
            'excelId' => '11',
            'options' => [
                ['id' => "",  'value' => null, 'displayName' => "wybierz"],
                ['id' => "1", 'value' => 1,    'displayName' => "Strefa 1"],
                ['id' => "2", 'value' => 2,    'displayName' => "Strefa 2"],
                ['id' => "3", 'value' => 3,    'displayName' => "Strefa 3"],
                ['id' => "4", 'value' => 4,    'displayName' => "Strefa 4"],
                ['id' => "5", 'value' => 5,    'displayName' => "Strefa 5"]
            ],
            'order' => 500
        ],
        'installationClosestCity' => [
            'label' => 'Miasto zlokalizowane najbliżej instalacji',
            'group' => ['formOptions', 'location'],
            'excelId' => '13',
            'options' => '[CITIES]',
            'order' => 510
        ],
        'name' => [
            'label' => "Imię i nazwisko",
            'group' => ['contact'],
            'order' => 520
        ],
        'email' => [
            'label' => "Email",
            'group' => ['contact'],
            'type' => 'email',
            'required' => true,
            'order' => 530
        ],
        'phone' => [
            'label' => "Telefon",
            'group' => ['contact'],
            'order' => 540
        ],
        'comment' => [
            'label' => 'Dodatkowe informacje dla działu pomp ciepła',
            'group' => ['contact'],
            'order' => 550
        ],
        'complexApproach' => [
            'label' => 'Czy jesteś zainteresowany kompleksową wyceną instalacji?',
            'group' => ['formOptions', 'additional'],
            'options' => [
                ['id' => "",  'value' => null, 'displayName' => "wybierz"],
                ['id' => "y", 'value' => 1,    'displayName' => "tak"],
                ['id' => "n", 'value' => 0,    'displayName' => "nie, posiadam instalatora, który dokona wyceny"]
            ],
            'order' => 560,
            'modal' => [
                'title' => 'Czy jesteś zainteresowany kompleksową wyceną instalacji?',
                'content' => '
                    <p class="mb-none">
                        Jesteś zainteresowany czymś więcej, niż otrzymanie raportu, który przedstawia szacunkowe roczne koszty eksploatacyjne oraz proponowane urządzenie? Jeśli nie jesteś w kontakcie z odpowiednią firmą, możemy przygotować dla Ciebie również wycenę instalacji razem z montażem.
                    </p>'
            ]
        ],
        'confirmFormData' => [
            'label' => [
                'form' => 'Potwierdzam poprawność wprowadzonych danych i biorę odpowiedzialność za popełnione na ich podstawie obliczenia.',
                'print' => 'Potwierdzenie poprawności wprowadzynych danych',
            ],
            'type' => 'checkbox',
            'group' => ['formOptions', 'additional'],
            'defaultValue' => false,
            'order' => 565
        ],
        'accept_mailing' => [
            'paramId' => 'accept_mailing',
            'label' => [
                'form' => 'Wyrażam zgodę na otrzymanie oferty oraz informacji handlowych od Hewalex Sp. z o.o. Sp.k. za pośrednictwem maila oraz drogą sms-ową. Mam prawo cofnąć zgodę w każdym czasie (dane przetwarzane są do czasu cofnięcia zgody).',
                'print' => 'Zgoda mailing',
            ],
            'type' => 'checkbox',
            'group' => ['contact'],
            'defaultValue' => false,
            'order' => 570
        ],
        'accept_data' => [
            'paramId' => 'accept_data',
            'label' => [
                'form' => 'Zapoznałem się z informacją o administratorze i przetwarzaniu danych.',
                'print' => 'Zgoda dane',
            ],
            'type' => 'checkbox',
            'group' => ['contact'],
            'defaultValue' => false,
            'order' => 580
        ]
    ];

    private $replacements = [];

    public $PCCO_DESTINATION = 'pcco';

    public function __construct()
    {
        $this->initResources();
        $this->initGenericModels();
    }

    public function getCategoryModel()
    {
        return $this->PCCO_DESTINATION;
    }

    public static function insert($data, $hash)
    {
        $searcher = new ZH_OfferForm();
        $installer = new ZH_Installers();

        $args = array(
            'post_title'    => (new ZH_OfferForm)->searchArray('name', 'id', 'value', $data['contact']),
            'post_type'     => 'users_pcco',
            'post_status'   => 'publish',
            'post_author'   => (new ZH_Installers())->getIdInstallator() ?? '',
            'meta_input'    => array(
                'hash'           => $hash,
                'parent_hash'    => $data['form_options']['parent_hash'],
                'category_calc'  => $data['offer_form_category'],
                'pcco_name'           => $searcher->searchArray('name', 'id', 'value', $data['contact']),
                'pcco_phone'          => $searcher->searchArray('phone', 'id', 'value', $data['contact']),
                'pcco_mail'           => $searcher->searchArray('email', 'id', 'value', $data['contact']),
                'pcco_agree_1'        => $searcher->searchArray('accept_mailing', 'id', 'value', $data['contact']) ? 'Tak' : 'Nie',
                'pcco_agree_2'        => $searcher->searchArray('accept_data', 'id', 'value', $data['contact']) ? 'Tak' : 'Nie',
                'pcco_options'        => json_encode($data['form_options']['options'], JSON_UNESCAPED_UNICODE),
                'pcco_contact'        => json_encode($data['contact'], JSON_UNESCAPED_UNICODE),
                'pcco_comment'        => $searcher->searchArray('comment', 'id', 'value', $data['contact']),
            )
        );
        $insert = wp_insert_post($args);

        return $insert;
    }

    public static function getDataset($hash)
    {
        $args = array(
            'post_type' => 'users_pcco',
            'post_status'   => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'hash',
                    'value' => $hash,
                    'compare' => '=='
                )
            )
        );

        $offers = get_posts($args);

        return $offers;
    }

    private function initResources()
    {
        $this->replacements = [
            '[CONSTRUCTION_MATERIALS]' => self::$resources['constuctionMaterials'],
            '[ISOLATION_MATERIALS]' => self::$resources['isolationMaterials'],
            '[WINDOW_TYPES]' => self::$resources['windowTypes'],
            '[CITIES]' => self::$resources['cities']
        ];
        $search = array_keys($this->replacements);

        foreach ($this->formGroups as $key => $group) {
            /* set group key as property */
            $this->formGroups[$key]['id'] = $key;
        }

        foreach ($this->formModels as $key => $model) {
            /* set model key as property */
            $this->formModels[$key]['paramId'] = $key;

            /* initialize common variables */
            if (in_array($model['options'] ?? null, $search)) {
                $this->formModels[$key]['options'] = $this->replacements[$model['options']];
            }
        }
    }

    private function initGenericModels()
    {
        $directionsByElement = [
            'walls' => array_filter(self::$resources['sides'], function ($side) {
                return in_array('wall', $side['owners']);
            }),
            'windows' => array_filter(self::$resources['sides'], function ($side) {
                return in_array('window', $side['owners']);
            })
        ];

        foreach ($this->formModels as $key => $model) {
            if (!($model['generic'] ?? false)) {
                continue;
            }

            switch ($model['baseModel']) {
                case 'windowType':
                case 'windowSurface':
                case 'windowMaterialFactor':
                    $directions = $directionsByElement['windows'];

                    foreach ($directions as $dk => $direction) {
                        $newModel = $model;
                        $newKey = str_replace('[DIRECTION_SUFFIX]', $direction['suffix'], $key);
                        $newModel['paramId'] = str_replace('[DIRECTION_SUFFIX]', $direction['suffix'], $model['paramId']);
                        $newModel['label'] = str_replace('[DIRECTION_LABEL]', $direction['displayName'], $model['label']);
                        $newModel['excelId'] = str_replace('[DIRECTION_ID]', $direction['excelId'], $model['excelId']);
                        $newModel['order'] = $model['order'] + 0.1 * ($dk+1);
                        $this->formModels[$newKey] = $newModel;
                    }
                    break;
                case 'wallSurfaceTotal':
                case 'wallSurfaceConnected':
                    $directions = $directionsByElement['walls'];

                    foreach ($directions as $dk => $direction) {
                        $newModel = $model;
                        $newKey = str_replace('[DIRECTION_SUFFIX]', $direction['suffix'], $key);
                        $newModel['paramId'] = str_replace('[DIRECTION_SUFFIX]', $direction['suffix'], $model['paramId']);
                        $newModel['label'] = str_replace('[DIRECTION_LABEL]', $direction['displayName'], $model['label']);
                        $newModel['excelId'] = str_replace('[DIRECTION_ID]', $direction['excelId'], $model['excelId']);
                        $newModel['order'] = $model['order'] + 0.1 * ($dk+1);
                        $this->formModels[$newKey] = $newModel;
                    }
                    break;
                case 'wallThickness':
                case 'wallMaterialLambda':
                case 'wallMaterial':
                    $directions = $directionsByElement['walls'];
                    $layers = self::$resources['wallLayers'];
                    $data = [];

                    foreach ($layers as $lk => $layer) {
                        $newModel2 = $model;
                        $newKey2 = str_replace('[LAYER_SUFFIX]', $layer['suffix'], $key);
                        $newModel2['paramId'] = str_replace('[LAYER_SUFFIX]', $layer['suffix'], $model['paramId']);
                        $newModel2['label'] = str_replace('[LAYER_LABEL]', $layer['displayName'], $model['label']);
                        $newModel2['excelId'] = str_replace('[LAYER_ID]', $layer['excelId'], $model['excelId']);
                        $newModel2['order'] = $model['order'] + 0.1 * ($lk+1);
                        if (($newModel2['options'] ?? null) === '[LAYER_MATERIALS]') {
                            $newModel2['options'] = $this->replacements[$layer['materials']];
                        }

                        foreach ($directions as $dk => $direction) {
                            $newModel = $newModel2;
                            $newKey = str_replace('[DIRECTION_SUFFIX]', $direction['suffix'], $newKey2);
                            $newModel['paramId'] = str_replace('[DIRECTION_SUFFIX]', $direction['suffix'], $newModel2['paramId']);
                            $newModel['label'] = str_replace('[DIRECTION_LABEL]', $direction['displayName'], $newModel2['label']);
                            $newModel['excelId'] = str_replace('[DIRECTION_ID]', $direction['excelId'], $newModel2['excelId']);
                            $newModel['order'] = $newModel2['order'] + 0.01 * ($dk+1);

                            $data[$newKey] = $newModel;
                        }
                    }
                    $this->formModels = array_merge($this->formModels, $data);
                    break;
            }
            /* unset basic generic model */
            unset($this->formModels[$key]);
        }
    }

    public function getFormOptionsValue($offerForm, $id)
    {
        $model = $this->formModels[$id] ?? null;
        if (!$model) {
            return null;
        }

        $option = OfferForm::getDatasetItem($offerForm, 'form_options.options', $id);
        if (!$option) {
            return null;
        }

        $value = $option['value'];
        $selectedId = $option['selectedId'] ?? null;
        if ($selectedId) {
            $valueModel = array_first($model['options'], function ($option) use ($selectedId) {
                return $option['id'] === $selectedId;
            });
            $value = $valueModel['displayName'] ?? "<span class=\"error\">{$model['value']}</span>";
        }

        return $value;
    }

    public function getPreparedClientAnkietForPrint()
    {
        $mpdf = new \Mpdf\Mpdf();

        $url4 = ZH_DIR . 'public/views/_pdf/offerform/pcco/clientankiet/page1.phtml';
        $url_style = ZH_DIR . 'public/css/pdf/custom.css';
        $url_styl_pdf = ZH_DIR . 'public/css/pdf/pdf.css';

        $options = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $stylesheet1 = file_get_contents($url_style, false, stream_context_create($options));
        $stylesheet2 = file_get_contents($url_styl_pdf, false, stream_context_create($options));

        $mpdf->WriteHTML($stylesheet1,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($stylesheet2,\Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML($this->render($url4));

        return base64_encode($mpdf->Output());
    }

    public function getPreparedClientAnkietHistoryForPrint()
    {
        $mpdf = new \Mpdf\Mpdf();

        $url4 = ZH_DIR . 'public/views/_pdf/offerform/pcco/history/clientankiet/page1.phtml';
        $url_style = ZH_DIR . 'public/css/pdf/custom.css';
        $url_styl_pdf = ZH_DIR . 'public/css/pdf/pdf.css';

        $options = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $stylesheet1 = file_get_contents($url_style, false, stream_context_create($options));
        $stylesheet2 = file_get_contents($url_styl_pdf, false, stream_context_create($options));

        $mpdf->WriteHTML($stylesheet1,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($stylesheet2,\Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML($this->render($url4));

        return base64_encode($mpdf->Output());
    }
}