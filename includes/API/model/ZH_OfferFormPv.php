<?php

namespace Develtio\ZonesHewalex\API\model;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_OfferFormPv
 */
class ZH_OfferFormPv extends ZH_OfferFormBase
{
    private $pvModel;

    protected $formGroups = [
        /* main groups */
        'form' => [
            'subgroupsIds' => ['contact', 'formOptions', 'summary']
        ],
        'contact' => [
            'label' => 'Dane kontaktowe',
            'subgroupsIds' => ['client', 'worker', 'installer'],
            'order' => 1
        ],
        'formOptions' => [
            'label' => 'Formularz doboru',
            'subgroupsIds' => ['energy', 'building', 'installation', 'financing'],
            'order' => 2
        ],
        'summary' => [
            'label' => 'Informacje dodatkowe',
            'subgroupsIds' => ['energySummary', 'installationSummary', 'analyzeSummary'],
            'order' => 3,
            'hidden' => [
                'summary' => false,
                'print' => true
            ]
        ],
        /* contact groups */
        'client' => [
            'label' => 'Dane klienta',
            'order' => 7
        ],
        'worker' => [
            'label' => 'Dane pracownika działu PV',
            'order' => 7,
            'hidden' => [
                'summary' => true,
                'print' => true
            ]
        ],
        'installer' => [
            'label' => 'Dane instalatora',
            'order' => 7,
            'hidden' => [
                'summary' => true,
                'print' => true
            ]
        ],
        /* formModels groups */
        'energy' => [
            'label' => 'Zużycie energii',
            'order' => 10
        ],
        'building' => [
            'label' => 'Zabudowa paneli',
            'order' => 20
        ],
        'installation' => [
            'label' => 'Parametry instalacji',
            'order' => 30
        ],
        'financing' => [
            'label' => 'Finansowanie',
            'order' => 40,
            'hidden' => [
                'summary' => true,
                'print' => false
            ]
        ],
        'additionalFinancing' => [
            'label' => 'Dofinansowania',
            'order' => 50
        ],
        /* summary groups */
        'energySummary' => [
            'label' => 'Energia: informacje dodatkowe',
            'order' => 60
        ],
        'installationSummary' => [
            'label' => 'Instalacja: informacje dodatkowe',
            'order' => 70
        ],
        'installationStepSummary' => [
            'label' => [
                'hewalex' => 'Dobór Hewalex',
                'user' => 'Twój dobór'
            ]
        ],
        'analyzeSummary' => [
            'label' => 'Podsumowanie',
            'hidden' => [
                'summary' => true
            ]
        ]
    ];

    protected $formModels = [
        'clientType' => [
            'label' => 'Typ użytkownika',
            'group' => ['contact', 'client'],
            'options' => [
                ['id' => "",        'displayName' => 'wybierz'],
                ['id' => "person",  'displayName' => 'osoba fizyczna'],
                ['id' => "company", 'displayName' => 'przedsiębiorstwo']
            ],
            'order' => 10,
        ],
        'companyVatDeduct' => [
            'label' => [
                'form' => 'Odliczam VAT od ceny zakupu instalacji fotowoltaicznej oraz kosztów energii elektrycznej',
                'print' => 'Odliczam VAT'
            ],
            'group' => ['contact', 'client'],
            'options' => [
                ['id' => "",  'displayName' => 'wybierz'],
                ['id' => "n", 'displayName' => 'nie'],
                ['id' => "y", 'displayName' => 'tak']
            ],
            'order' => 15
        ],
        'name' => [
            'label' => 'Imię i nazwisko',
            'group' => ['contact', 'client'],
            'order' => 20
        ],
        'email' => [
            'label' => 'Adres email',
            'group' => ['contact', 'client'],
            'order' => 30
        ],
        'areaCode' => [
            'label' => 'Numer kierunkowy',
            'group' => ['contact', 'client'],
            'defaultValue' => '+48',
            'order' => 39
        ],
        'phone' => [
            'label' => 'Numer telefonu',
            'group' => ['contact', 'client'],
            'order' => 40
        ],
        'address' => [
            'label' => 'Ulica i numer budynku',
            'group' => ['contact', 'client'],
            'order' => 50
        ],
        'city' => [
            'label' => 'Miasto',
            'group' => ['contact', 'client'],
            'order' => 60
        ],
        'zip' => [
            'label' => 'Kod pocztowy',
            'group' => ['contact', 'client'],
            'order' => 70
        ],
        'region' => [
            'label' => 'Województwo',
            'group' => ['contact', 'client'],
            'options' => [
                ['id' => "",   'displayName' => "wybierz"],
                ['id' => "3",  'displayName' => "dolnośląskie"],
                ['id' => "4",  'displayName' => "kujawsko-pomorskie"],
                ['id' => "6",  'displayName' => "lubelskie",],
                ['id' => "7",  'displayName' => "lubuskie"],
                ['id' => "5",  'displayName' => "łódzkie"],
                ['id' => "1",  'displayName' => "małopolskie"],
                ['id' => "8",  'displayName' => "mazowieckie"],
                ['id' => "9",  'displayName' => "opolskie"],
                ['id' => "10", 'displayName' => "podkarpackie"],
                ['id' => "11", 'displayName' => "podlaskie"],
                ['id' => "12", 'displayName' => "pomorskie"],
                ['id' => "2",  'displayName' => "śląskie"],
                ['id' => "13", 'displayName' => "świętokrzyskie"],
                ['id' => "14", 'displayName' => "warmińsko-mazurskie"],
                ['id' => "15", 'displayName' => "wielkopolskie"],
                ['id' => "16", 'displayName' => "zachodniopomorskie"],
            ],
            'order' => 80,
        ],
        'accept_mailing' => [
            'paramId' => 'accept_mailing',
            'type' => 'checkbox',
            'label' => [
                'form' => 'Wyrażam zgodę na otrzymanie oferty oraz informacji handlowych od Hewalex Sp. z o.o. Sp.k. za pośrednictwem maila oraz drogą sms-ową. Mam prawo cofnąć zgodę w każdym czasie (dane przetwarzane są do czasu cofnięcia zgody).',
                'print' => 'Zgoda mailing',
            ],
            'group' => ['contact', 'client'],
            'defaultValue' => false,
            'order' => 90
        ],
        'accept_data' => [
            'paramId' => 'accept_data',
            'type' => 'checkbox',
            'label' => [
                'form' => 'Zapoznałem się z informacją o administratorze i przetwarzaniu danych.',
                'print' => 'Zgoda dane',
            ],
            'group' => ['contact', 'client'],
            'defaultValue' => false,
            'order' => 100
        ],
        'offerRspUId' => [
            'label' => 'Pracownik odpowiedzialny za ofertę',
            'group' => ['contact', 'worker'],
            'options' => [ //@todo fetch from edokumenty
                ['id' => '',   'displayName' => 'wybierz',            'edokUId' => null],
                ['id' => 'ic', 'displayName' => 'Izabela Ciupek',     'edokUId' => 109],
                ['id' => 'sk', 'displayName' => 'Sonia Kopoczek',     'edokUId' => 167],
                ['id' => 'mk', 'displayName' => 'Monika Kozak',       'edokUId' => 135],
                ['id' => 'km', 'displayName' => 'Karol Majewski',     'edokUId' => 136],
                ['id' => 'az', 'displayName' => 'Arkadiusz Zarębski', 'edokUId' => 10],
                ['id' => 'bs', 'displayName' => 'Bogna Ścigajło',     'edokUId' => 73],
                ['id' => 'mp', 'displayName' => 'Magdalena Pietrzyk', 'edokUId' => 153],
                ['id' => 'wo', 'displayName' => 'Wanda Olender',      'edokUId' => 154],
            ],
            'order' => 101
        ],
        'countByType' => [
            'label' => 'Sposób podania zużycia energii',
            'group' => ['formOptions', 'energy'],
            'options' => [
                ['id' => "",                   'displayName' => 'wybierz'],
                ['id' => "byEnergyUsage&Bill", 'displayName' => "Rachunek za energię elektryczną"],
                ['id' => "byPeopleCount",      'displayName' => "Liczba mieszkańców budynku"]
            ],
            'modal' => [
                'title' => 'Kalkulacja zużycia energii',
                'content' => '
                    <p>
                        W celu uzyskania najbardziej dokładnego doboru instalacji fotowoltaicznej oraz obliczeń, należy 
                        wprowadzić zużycie energii w kWh oraz kwotę brutto z rachunków obejmujących cały rok. Tak 
                        wprowadzone dane pozwolą na dokonanie analizy opłacalności instalacji bez względu na rodzaj 
                        taryfy. Można również podać zużycie energii i opłaty za energię elektryczną w ujęciu miesięcznym 
                        lub dwumiesięcznym, należy jednak pamiętać że w zależności od miesiąca zużycie energii może być 
                        różne, co może wpłynąć na dobór mocy instalacji oraz analizę ekonomiczną.
                    </p>
                    <p class="mb-none">
                        W przypadku braku powyższych danych, można skorzystać z możliwości dokonania obliczeń przybliżonych 
                        w oparciu o ilość mieszkańców.
                    </p>'
            ],
            'order' => 110,
        ],
        'energyPeriodUnit' => [
            'label' => 'Okres jaki pokrywa rachunek za energię',
            'group' => ['formOptions', 'energy'],
            'options' => [
                ['id' => "",        'displayName' => 'wybierz'],
                ['id' => "month01", 'displayName' => "miesiąc",      'monthsNum' => 1],
                ['id' => "month02", 'displayName' => "dwa miesiące", 'monthsNum' => 2],
                ['id' => "year",    'displayName' => "rok"]
            ],
            'order' => 120,
        ],
        'energyUsageInPeriod' => [
            'label' => 'Zużycie energii elektrycznej w wybranym okresie',
            'group' => ['formOptions', 'energy'],
            'unit' => 'kWh',
            'modelPs' => 'Kreator został przygotowany dla instalacji do 10 kW. W celu uzyskania oferty na większe zapotrzebowanie skontaktuj się z działem fotowoltaiki.',
            'modal' => [
                'size' => 'modal-lg',
                'title' => 'Zużycie energii',
                'customRender' => true,
                'content' => [
                    'text' => 'Wartość zużycia energii wyrażona w kWh.<br/>Wybierz swojego dostawcę energii aby sprawdzić, które pola składają się na zużycie energii:',
                    'bills' => [
                        'enea' => [
                            'label' => 'Enea',
                            'imgSrc' =>  ZH_URL . '/public/img/pv/rachunki-pogladowe/enea-zuzycie-opis.png'
                        ],
                        'energa' => [
                            'label' => 'Energa',
                            'imgSrc' =>  ZH_URL . '/public/img/pv/rachunki-pogladowe/energa-zuzycie-opis.png'
                        ],
                        'pge' => [
                            'label' => 'PGE',
                            'imgSrc' =>  ZH_URL . '/public/img/pv/rachunki-pogladowe/pge-zuzycie-opis.png'
                        ],
                        'rwe' => [
                            'label' => 'RWE',
                            'imgSrc' =>  ZH_URL . '/public/img/pv/rachunki-pogladowe/rwe-zuzycie-opis.png'
                        ],
                        'tauron' => [
                            'label' => 'Tauron',
                            'imgSrc' =>  ZH_URL . '/public/img/pv/rachunki-pogladowe/tauron-zuzycie-opis.png'
                        ],
                    ]
                ],
            ],
            'order' => 130,
        ],
        'energyCostInPeriod' => [
            'label' => 'Kwota brutto z rachunku w wybranym okresie',
            'group' => ['formOptions', 'energy'],
            'unit' => 'zł',
            'modal' => [
                'size' => 'modal-lg',
                'title' => 'Zużycie energii',
                'customRender' => true,
                'content' => [
                    'text' => 'Kwota brutto rachunku za energię wyrażona w zł.<br/>Wybierz swojego dostawcę energii aby sprawdzić, które pola składają się na koszty energii:',
                    'bills' => [
                        'enea' => [
                            'label' => 'Enea',
                            'imgSrc' =>  ZH_URL . '/public/img/pv/rachunki-pogladowe/enea-koszty-opis.png'
                        ],
                        'energa' => [
                            'label' => 'Energa',
                            'imgSrc' =>  ZH_URL . '/public/img/pv/rachunki-pogladowe/energa-koszty-opis.png'
                        ],
                        'pge' => [
                            'label' => 'PGE',
                            'imgSrc' =>  ZH_URL . '/public/img/pv/rachunki-pogladowe/pge-koszty-opis.png'
                        ],
                        'rwe' => [
                            'label' => 'RWE',
                            'imgSrc' =>  ZH_URL . '/public/img/pv/rachunki-pogladowe/rwe-koszty-opis.png'
                        ],
                        'tauron' => [
                            'label' => 'Tauron',
                            'imgSrc' => ZH_URL . '/public/img/pv/rachunki-pogladowe/tauron-koszty-opis.png'
                        ],
                    ]
                ],
            ],
            'order' => 140,
        ],
        'flatPeopleCount' => [
            'label' => 'Liczba mieszkańców budynku',
            'group' => ['formOptions', 'energy'],
            'unit' => 'os.',
            'order' => 150,
        ],
        'energyCostDistibutor' => [
            'label' => 'Dostawca energii',
            'group' => ['formOptions', 'energy'],
            'options' => [
                ['id' => "",       'displayName' => 'wybierz'],
                ['id' => "enea",   'displayName' => "Enea SA",      'kWhCost' => 0.63],
                ['id' => "energa", 'displayName' => "Energa Obrót", 'kWhCost' => 0.70],
                ['id' => "pge",    'displayName' => "PGE Obrót",    'kWhCost' => 0.68],
                ['id' => "e.on",   'displayName' => "E.ON",         'kWhCost' => 0.63],
                ['id' => "tauron", 'displayName' => "Tauron PE",    'kWhCost' => 0.66]
            ],
            'order' => 160,
        ],
        'buildingOrientation' => [
            'label' => 'Orientacja paneli względem stron świata',
            'group' => ['formOptions', 'building'],
            'options' => [
                ['id' => "",   'displayName' => 'wybierz'],
                ['id' => "e",  'displayName' => "wschód"],
                ['id' => "w",  'displayName' => "zachód"],
                ['id' => "s",  'displayName' => "południe"],
                ['id' => "se", 'displayName' => "południowy wschód"],
                ['id' => "sw", 'displayName' => "południowy zachód"]
            ],
            'order' => 170,
        ],
        'buildingSurface' => [
            'label' => 'Powierzchnia użytkowa budynku mieszkalnego',
            'group' => ['formOptions', 'building'],
            'unit' => 'm<sup>2</sup>',
            'taxThreshold' => 300,
            'order' => 175
        ],
        'montagePlace' => [
            'label' => 'Miejsce zabudowy paneli',
            'group' => ['formOptions', 'building'],
            'options' => [
                ['id' => "",        'displayName' => 'wybierz'],
                ['id' => "flat",    'displayName' => "dach płaski"],
                ['id' => "slanted", 'displayName' => "dach pochyły"],
                ['id' => "ground",  'displayName' => "grunt"]
            ],
            'modelPs' => 'Panele PV zostaną ustawione na konstrukcji wsporczej pod kątem 30 stopni',
            'order' => 180,
        ],
        'roofAngle' => [
            'label' => 'Kąt nachylenia dachu',
            'group' => ['formOptions', 'building'],
            'options' => [
                ['id' => "",     'displayName' => 'wybierz'],
                ['id' => "st30", 'displayName' => "30", 'value' => 30],
                ['id' => "st45", 'displayName' => "45", 'value' => 45],
                ['id' => "st60", 'displayName' => "60", 'value' => 60]
            ],
            'unit' => '&deg;',
            'order' => 190,
        ],
        'montageSystemType' => [
            'label' => 'Rodzaj pokrycia dachu',
            'group' => ['formOptions', 'building'],
            'options' => [
                ['id' => "",       'displayName' => 'wybierz'],
                ['id' => "custom", 'displayName' => 'pokrycie niestandardowe']
            ],
            'order' => 200,
        ],
        'customMontageSystemType' => [
            'label' => 'Niestandardowy system montażowy',
            'group' => ['formOptions', 'building'],
            'options' => [
                ['id' => "", 'name' => 'wybierz']
            ],
            'hidden' => true,
            'order' => 201,
        ],
        'panelType' => [
            'label' => 'Panel fotowoltaiczny',
            'group' => ['formOptions', 'installation'],
            'options' => [],
            'modal' => [
                'title' => 'Wybierz panel aby przejść na kartę produktu',
                'customRender' => true
            ],
            'order' => 210,
        ],
        'adjustInstallationToUsage' => [
            'label' => 'Czy chcesz zmodyfikować dobraną instalację?',
            'group' => ['formOptions', 'installation'],
            'options' => [
                ['id' => "n", 'displayName' => 'nie'],
                ['id' => "y", 'displayName' => 'tak']
            ],
            'modal' => [
                'title' => 'Dobór liczby paneli',
                'content' => '
                    <p>
                        Zmiana wielkości instalacji pozwala na dopasowanie jej do naszych wymagań zarówno pod względem 
                        wymaganego pokrycia zapotrzebowania jak również pod względem nakładów inwestycyjnych.
                    </p>
                    <p class="mb-none">
                        Zmiana ta wiąże się nie tylko ze zmianą ilości paneli ale także z dobraniem odpowiedniego 
                        inwertera oraz liczby elementów montażowych zgodnie z wybranym miejscem montażu instalacji.
                    </p>'
            ],
            'order' => 220,
        ],
        'panelQuantity' => [
            'label' => 'Ilość paneli',
            'group' => ['formOptions', 'installation', 'installationStepSummary'],
            'unit' => 'szt.',
            'order' => 230,
        ],
        'inverterType' => [
            'label' => 'Typ inwertera',
            'group' => ['formOptions', 'installation'],
            'options' => [],
            'order' => 240,
        ],
        'wireType' => [
            'label' => 'Rodzaj przewodu',
            'group' => ['formOptions', 'installation'],
            'options' => [
                ['id' => "", 'displayName' => 'wybierz']
            ],
            'hidden' => true,
            'order' => 241,
        ],
        'analyzeBase' => [//@todo separate as static resource
            'hidden' => true,
            'label' => 'Podstawa analizy',
            'group' => ['formOptions', 'financing'],
            'options' => [
                ['id' => "oze2016", 'displayName' => ""],
            ],
            'modal' => [
                'title' => 'Podstawa analizy',
                'content' => ''
            ],
            'order' => 245,
        ],
        'financingType' => [
            'label' => 'Sposób finansowania',
            'group' => ['formOptions', 'financing'],
            'options' => [
                ['id' => "wlasne",        'displayName' => "środki własne"],
                ['id' => "wlasne&Kredyt", 'displayName' => "środki własne + kredyt"]
            ],
            'order' => 250,
        ],
        'creditType' => [
            'label' => 'Rodzaj kredytu',
            'group' => ['formOptions', 'financing'],
            'options' => [
//                ['id' => "santander60", 'displayName' => "kredyt Santander",            'parentID' => ["osobaFizyczna"]],
                ['id' => "innyKredyt",  'displayName' => "indywidualny kredyt bankowy", 'parentID' => ["osobaFizyczna", "przedsiebiorstwo"]]
            ],
            'order' => 260,
        ],
        'creditCoverageAmount' => [
            'label' => 'Pokrycie ze środków własnych',
            'group' => ['formOptions', 'financing'],
            'unit' => 'zł',
            'order' => 262,
        ],
        'creditYears' => [
            'label' => 'Okres kredytowania',
            'group' => ['formOptions', 'financing'],
            'unit' => 'lat',
            'order' => 264,
        ],
        'creditPrecentage' => [
            'label' => 'Roczne oprocentowanie kredytu',
            'group' => ['formOptions', 'financing'],
            'unit' => '%',
            'order' => 266,
        ],
        'creditInitialPayment' => [
            'label' => 'Prowizja za udzielenie kredytu',
            'group' => ['formOptions', 'financing'],
            'unit' => 'zł',
            'order' => 268,
        ],
        'mojPrad' => [
            'label' => 'Mój Prąd',
            'type' => 'checkbox',
            'group' => ['formOptions', 'financing', 'additionalFinancing'],
            'defaultValue' => false,
            'modal' => [
                'title' => 'Mój Prąd',
                'content' => '
                    <p class="mb-none">
                        Nabór wniosków do programu Mój Prąd trwa od 15.04.2022r. do 22.12.2022r. Wysokość dofinansowania dla instalacji fotowoltaicznej w systemie net-billing bez dodatkowych urządzeń w zakresie magazynowania ciepła i energii elektrycznej wynosi 4 000 zł.
                    </p>'
            ],
            'discountValue' => 4000,
            'discountValueUnit' => 'zł',
            'disabled' => false,
            //'disabledDesc' => 'Budżet programu Mój Prąd na rok 2020 został wyczerpany. Termin oraz zasady kolejnego naboru nie zostały jeszcze podane.',
            'order' => 270
        ],
        'ulgaTermo' => [
            'label' => 'Ulga termomodernizacyjna',
            'type' => 'checkbox',
            'group' => ['formOptions', 'financing', 'additionalFinancing'],
            'defaultValue' => false,
            'modal' => [
                'title' => 'Ulga termomodernizacyjna',
                'content' => '
                    <p class="mb-none">
                        Ulga pozwala uzyskać zwrot podatku od kwoty inwestycji na zakup instalacji PV. 
                        W kalkulacji efektu ekonomicznego uwzględniono stawkę 17% (dla stawki 32% opłacalność inwestycji 
                        wzrośnie jeszcze dodatkowo).
                    </p>'
            ],
            'discountValue' => 0.83,
            'discountValueUnit' => '%',
            'order' => 280
        ],
        'dofinansowanie' => [
            'label' => 'Inne dofinansowanie',
            'type' => 'checkbox',
            'group' => ['formOptions', 'financing', 'additionalFinancing'],
            'defaultValue' => false,
            'order' => 290
        ],
        'dofinansowanieValue' => [
            'label' => 'Kwota dofinansowania',
            'group' => ['formOptions', 'financing', 'additionalFinancing'],
            'unit' => 'zł',
            'order' => 291
        ],
        'ownEnergyConsumptionFactor' => [
            'label' => 'Bezpośrednia konsumpcja energii z PV',
            'group' => ['formOptions', 'additional'],
            'unit' => '%',
            'defaultValue' => 20,
            'modal' => [
                'title' => 'Wykorzystanie energii z instalacji PV',
                'content' => '
                    <p>
                        Najkorzystniejszą sytuacją dla posiadacza instalacji fotowoltaicznej jest konsumpcja wyprodukowanej 
                        energii na bieżąco. Rozumie się przez to wykorzystanie wyprodukowanej energii przez urządzenia w 
                        domu podłączone do tej samej fazy do której podłączony jest inwerter.
                    </p>
                    <p class="mb-none">
                        Prąd z sieci nie jest wtedy pobierany, więc oszczędzamy nie tylko na opłacie za energię ale 
                        także na opłatach dystrybucyjnych.
                    </p>'
            ],
            'order' => 300,
        ],
        'energyCostGrowthByYear' => [
            'label' => 'Roczny wzrost ceny energii',
            'group' => ['formOptions', 'additional'],
            'unit' => '%',
            'defaultValue' => 8,
            'modal' => [
                'title' => 'Ulga termomodernizacyjna',
                'content' => '
                    <p>
                        Obliczenie czasu zwrotu nakładów inwestycyjnych wymaga uwzględnienia cen energii elektrycznej. 
                        Na podstawie wieloletnich statystyk można przewidzieć, że cena 1 kWh będzie regularnie rosła. 
                        W wyniku tego, z każdym rokiem będzie rosła również ilość oszczędzanych przez nas pieniędzy, 
                        dzięki darmowej energii elektrycznej z naszej instalacji.
                    </p>
                    <p class="mb-none">
                        Według różnych źródeł szacuje się, że wzrost cen będzie wynosił od 1 do 5 % rocznie.
                    </p>'
            ],
            'order' => 310,
        ],
        'optiener' => [
            'label' => [
                'form' => '<strong>Uwzględnij zastosowanie</strong>',
                'print' => 'Wybieram OPTI-ENER'
            ],
            'type' => 'checkbox',
            'group' => ['formOptions', 'additional'],
            'defaultValue' => false,
            'modal' => [
                'title' => 'OPTI-ENER',
                'content' => '
                    <p class="mb-none">
                        Dla kalkulacji efektu przyjęto wzrost rocznej bezpośredniej konsumpcji energii z instalacji PV 
                        do 45%. Rzeczywisty poziom będzie zależny od sposobu użytkowania urządzeń elektrycznych w budynku. 
                        Przyjęto podstawowy wariant systemu OPTI-ENER dla zarządzania bilansem energii.
                    </p>'
            ],
            'order' => 320
        ],
        'guaranteePeriod' => [//@todo separate as static resource
            'hidden' => true,
            'static' => true,
            'label' => '* dla 25 letniego objętego gwarancją okresu eksploatacji',
            'value' => 25,
            'modal' => [
                'title' => 'Gwarancja',
                'content' => '
                    <p>
                        Długoletnią żywotność paneli potwierdza aż dziesięcioletnia gwarancja na produkt. Dodatkowo oferujemy 
                        <strong>25 lat gwarancji</strong> na liniową utratę mocy. Oznacza to, że po pierwszym roku eksploatacji 
                        spadek mocy nie przekroczy 3%, a od drugiego do dwudziestego piątego roku użytkowania moc będzie 
                        spadać maksymalnie o 0,708% rocznie.
                    </p>
                    <p class="mb-none">
                        W rezultacie po dwudziestu pięciu latach moc paneli nie będzie niższa niż 80%
                    </p>'
            ]
        ],
        'rebateType' => [
            'label' => 'Typ rabatu',
            'group' => ['formOptions', 'customizations'],
            'options' => [
                ['id' => "",       'displayName' => 'wybierz'],
                ['id' => '%',      'displayName' => 'procentowy'],
                ['id' => 'amount', 'displayName' => 'kwota']
            ],
            'order' => 1000
        ],
        'rebatePrecent' => [
            'label' => 'Wartość % rabatu',
            'group' => ['formOptions', 'customizations'],
            'unit' => '%',
            'order' => 1010
        ],
        'rebateAmount' => [
            'label' => 'Kwota rabatu',
            'group' => ['formOptions', 'customizations'],
            'unit' => 'zł',
            'order' => 1020
        ],
        'profitMarginType' => [
            'label' => 'Typ marży',
            'group' => ['formOptions', 'customizations'],
            'options' => [
                ['id' => "",       'displayName' => 'wybierz'],
                ['id' => '%',      'displayName' => 'procentowa'],
                ['id' => 'amount', 'displayName' => 'kwota']
            ],
            'order' => 1030
        ],
        'profitMarginPrecent' => [
            'label' => 'Wartość % marży',
            'group' => ['formOptions', 'customizations'],
            'unit' => '%',
            'order' => 1040
        ],
        'profitMarginAmount' => [
            'label' => 'Kwota marży',
            'group' => ['formOptions', 'customizations'],
            'unit' => 'zł',
            'order' => 1050
        ],
        'montageCost' => [
            'label' => 'Koszt montażu',
            'group' => ['formOptions', 'customizations'],
            'unit' => 'zł',
            'order' => 1060
        ],
        'deliveryCost' => [
            'label' => 'Koszt dostawy',
            'group' => ['formOptions', 'customizations'],
            'unit' => 'zł',
            'order' => 1070
        ],
        'offerValidPeriod' => [
            'label' => 'Okres ważności oferty',
            'group' => ['formOptions', 'customizations'],
            'defaultValue' => 30,
            'unit' => 'dni',
            'order' => 1080
        ],
        'orderDeadline' => [
            'label' => 'Termin realizacji zamówienia',
            'group' => ['formOptions', 'customizations'],
            'defaultValue' => 30,
            'unit' => 'dni',
            'order' => 1090
        ]
    ];

    protected $slcModels = [
        'locationSunEnergyOnGround' => [
            'label' => 'Roczna suma energii promieniowania słonecznego',
            'group' => ['summary', 'energySummary'],
            'unit' => 'kWh/m&sup2;'
        ],
        'totalEnergyFromSunPerYear' => [
            'label' => 'Roczna suma energii promieniowania słonecznego dla orientacji i nachylenia dachu',
            'group' => ['summary', 'energySummary'],
            'unit' => 'W/m&sup2;'
        ],
        'energyUsageByYear' => [
            'label' => 'Roczne zużycie energii',
            'group' => ['summary', 'energySummary'],
            'unit' => 'kWh'
        ],
        'energyCostByYear' => [
            'label' => 'Roczny koszt energii',
            'labelTaxOptions' => [
                'gross' => 'brutto',
                'net' => 'netto'
            ],
            'group' => ['summary', 'energySummary'],
            'unit' => 'zł'
        ],
        'totalKwhCosts' => [
            'label' => 'Średni roczny koszt kWh',
            'labelTaxOptions' => [
                'gross' => 'brutto',
                'net' => 'netto'
            ],
            'group' => ['summary', 'energySummary'],
            'unit' => 'zł'
        ],
        'avgYearlyTGEKwhCosts' => [
            'label' => 'Średnia roczna cena sprzedaży energii elektrycznej z Towarowej Giełdy Energii',
            'labelTaxOptions' => [
                'gross' => 'brutto',
                'net' => 'netto'
            ],
            'group' => ['summary', 'energySummary'],
            'unit' => 'zł'
        ],
        'totalMontageSystemsItemsQty' => [
            'label' => 'Całkowita liczba sztuk wszystkich systemów montażowych',
            'group' => ['summary'],
            'unit' => 'szt.'
        ],
        'installationMaxPower' => [
            'label' => 'Moc szczytowa instalacji',
            'group' => ['summary', 'installationSummary', 'installationStepSummary'],
            'unit' => 'kWp'
        ],
        'installationEnergyUsageCoverage' => [
            'label' => 'Pokrycie zapotrzebowania na energię',
            'group' => ['summary', 'installationSummary'],
            'unit' => '%'
        ],
        'energyUsageCoverageProsumer' => [
            'label' => 'Pokrycie zapotrzebowania na energię wg ustawy o OZE',
            'group' => ['summary', 'installationSummary'],
            'unit' => '%'
        ],
        'directEnergyUsageCoverage' => [
            'defaultValue' => 20,
            'label' => 'Bezpośrednia konsumpcja energii z PV',
            'group' => ['installationStepSummary'],
            'unit' => '%'
        ],
        'totalPrice' => [
            'label' => 'Cena instalacji fotowoltaicznej wraz z montażem',
            'labelTaxOptions' => [
                'gross' => 'brutto',
                'net' => 'netto'
            ],
            'group' => ['summary', 'analyzeSummary'],
            'unit' => 'zł'
        ],
        'tax' => [
            'label' => 'VAT',
            'group' => ['summary'],
            'unit' => '%'
        ],
        'installationCost' => [
            'label' => 'Wartość inwestycji w instalację PV',
            'group' => ['summary', 'analyzeSummary'],
            'unit' => 'zł'
        ],
        'energyProducedByPV' => [
            'label' => 'Energia wytworzona przez instalację PV *',
            'group' => ['summary', 'analyzeSummary'],
            'unit' => 'MWh',
            'order' => 1200
        ],
        'directConsumptionEnergyAmount' => [
            'label' => 'Wartość energii zużytej w bezpośredniej konsumpcji *',
            'group' => ['summary'],
            'unit' => 'zł',
            'order' => 1210
        ],
        'netMeteringEnergyAmount' => [
            'label' => 'Wartość energii rozliczanej w net meteringu *',
            'group' => ['summary'],
            'unit' => 'zł',
            'order' => 1220
        ],
        'paybackTime' => [
            'label' => 'Okres zwrotu inwestycji w instalację PV',
            'group' => ['summary', 'analyzeSummary'],
            'valueType' => 'text',
            'order' => 1230
        ],
        'incomeAmount' => [
            'label' => 'Zysk po odliczeniu kosztów inwestycji *',
            'group' => ['summary'],
            'unit' => 'zł',
            'highlighted' => true,
            'order' => 1240
        ],
        'creditBasePrice' => [
            'label' => 'Bazowa kwota kredytu',
            'group' => ['summary'],
            'unit' => 'zł',
        ],
        'creditMonthlyPrice' => [
            'label' => 'Wysokość raty',
            'group' => ['summary'],
            'unit' => 'zł',
        ],
        'creditTotalCost' => [
            'label' => 'Całkowity koszt kredytu',
            'group' => ['summary'],
            'unit' => 'zł',
        ]
    ];

    public function __construct()
    {
        $this->pvModel = new ZH_PV();
        $this->pvModel->setDestination(ZH_PV::$CALCPV_DESTINATION);

        $this->initResources();
        $this->initExactFormModels();
    }

    public function getCategoryModel()
    {
        return ZH_PV::$CALCPV_DESTINATION;
    }

    public static function insert($data, $hash)
    {
        $searcher = new ZH_OfferForm();
        $installer = new ZH_Installers();

        $regionId = $searcher->searchArray('region', 'id', 'selectedId', $data['contact']);
        $region = $searcher->selectRegion($regionId);

        $args = array(
            'post_title'    => $searcher->searchArray('name', 'id', 'value', $data['contact']),
            'post_type'     => 'users_pv',
            'post_status'   => 'publish',
            'post_author'   => $installer->getIdInstallator() ?? '',
            'meta_input'    => array(
                'hash'           => $hash,
                'parent_hash'    => $data['form_options']['parent_hash'],
                'category_calc'  => $data['offer_form_category'],
                'pv_name'           => $searcher->searchArray('name', 'id', 'value', $data['contact']),
                'pv_phone'          => $searcher->searchArray('phone', 'id', 'value', $data['contact']),
                'pv_phone_area'     => $searcher->searchArray('areaCode', 'id', 'value', $data['contact']),
                'pv_mail'           => $searcher->searchArray('email', 'id', 'value', $data['contact']),
                'pv_city'           => $searcher->searchArray('city', 'id', 'value', $data['contact']),
                'pv_postcode'       => $searcher->searchArray('zip', 'id', 'value', $data['contact']),
                'pv_street'         => $searcher->searchArray('address', 'id', 'value', $data['contact']),
                'pv_province'       => $region,
                'pv_agree_1'        => $searcher->searchArray('accept_mailing', 'id', 'value', $data['contact']) ? 'Tak' : 'Nie',
                'pv_agree_2'        => $searcher->searchArray('accept_data', 'id', 'value', $data['contact']) ?  'Tak' : 'Nie',
                'pv_attachment'     => $searcher->searchArray('summaryChart', 'id', 'content', $data['form_options']['attachments']),
                'pv_results'        => json_encode($data['form_options']['results'], JSON_UNESCAPED_UNICODE),
                'pv_options'        => json_encode($data['form_options']['options'], JSON_UNESCAPED_UNICODE),
                'pv_products'       => json_encode($data['form_options']['products'], JSON_UNESCAPED_UNICODE),
                'pv_cproducts'      => json_encode($data['form_options']['customProducts'], JSON_UNESCAPED_UNICODE),
                'pv_cterms'         => json_encode($data['form_options']['customTerms'], JSON_UNESCAPED_UNICODE),
                'pv_contact'        => json_encode($data['contact'], JSON_UNESCAPED_UNICODE),
            )
        );
        $insert = wp_insert_post($args);

        return $insert;
    }

    public static function getDataset($hash)
    {
        $args = array(
            'post_type' => 'users_pv',
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
        foreach ($this->formGroups as $key => $group) {
            /* set group key as property */
            $this->formGroups[$key]['id'] = $key;
        }

        foreach ($this->formModels as $modelId => $model) {
            if ($model['paramId'] ?? null) {
                continue;
            }
            $this->formModels[$modelId]['paramId'] = $modelId;
        }

        foreach ($this->slcModels as $key => $model) {
            if ($model['paramId'] ?? null) {
                continue;
            }
            /* set group key as property */
            $this->slcModels[$key]['paramId'] = $key;
        }
    }

    private function initExactFormModels()
    {
        $data = $this->pvModel->getKitsInfoForCalcPv();

        /* prepare options names */
        $namesMap = [
            'montageData' => 'roofCoverageName',
            'panelsData' => 'name',
            'kitsData' => 'inverterInfo',
            'wires' => 'name'
        ];
        foreach ($namesMap as $groupName => $itemName) {
            $data[$groupName] = array_map(function ($item) use ($itemName) {
                $item['displayName'] = $item[$itemName];
                return $item;
            }, $data[$groupName]);
        }

        /* set models options */
        $modelsOptionsMap = [
            'montageSystemType' => 'montageData',
            'customMontageSystemType' => 'montageData',
            'panelType' => 'panelsData',
            'inverterType' => 'kitsData',
            'wireType' => 'wires'
        ];
        foreach ($modelsOptionsMap as $model => $dataKey) {
            $this->formModels[$model]['options'] = array_merge($this->formModels[$model]['options'], $data[$dataKey]);
        }
    }

    public function getResources()
    {
        return [
            'formGroups' => $this->formGroups,
            'formModels' => $this->formModels,
            'slcModels' => $this->slcModels,
            'products'=> $this->pvModel->getProducts()
        ];
    }

    public function getFormModels()
    {
        return $this->formModels;
    }

    public static function getProductsByProperty($products, $key, $val)
    {
        return array_filter($products, function ($item) use ($key, $val) {
            $propValue = $item[$key] ?? null;
            if (!$propValue) {
                return false;
            }

            if (is_array($propValue)) {
                return in_array($val, $propValue);
            }

            return $propValue === $val;
        });
    }

    public static function getProductByProperty($products, $key, $val)
    {
        $array = self::getProductsByProperty($products, $key, $val);
        return reset($array);
    }

    public function getClientOfferProducts($basketProducts)
    {
        $allProducts = (new ZH_PV)->getProducts();

        foreach ($basketProducts as $orderedProduct) {
            if ($allProducts[$orderedProduct['id']] ?? null) {
                $allProducts[$orderedProduct['id']]['sum'] = $orderedProduct['sum'];
            }
        }

        $clientProducts = array_filter($allProducts, function ($product)  {
            if(isset($product['sum'])) {
                return $product['sum'] > 0;
            }
        });

        uasort($clientProducts, function ($x, $y) {
            return ($x['order'] ?? 1) < ($y['order'] ?? 1) ? -1 : 1;
        });

        return $clientProducts;
    }

    public function getPreparedClientAnkietForPrint()
    {
        $mpdf = new \Mpdf\Mpdf();

        $url4 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/clientankiet/page1.phtml';
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

        $url4 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/history/clientankiet/page1.phtml';
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

    public function getPreparedClientOfferForPrint()
    {
        $mpdf = new \Mpdf\Mpdf();

        $url = ZH_DIR . 'public/views/_pdf/offerform/calcpv/clientoffer/page1.phtml';
        $url2 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/clientoffer/page2.phtml';
        $url3 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/clientoffer/page3.phtml';
        $url4 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/clientankiet/page1.phtml';
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

        $mpdf->WriteHTML($this->render($url));
//        $mpdf->AddPage();
//        $mpdf->WriteHTML($this->render($url2));
        $mpdf->AddPage();
        $mpdf->WriteHTML($this->render($url3));

        $optionsArray = (new ZH_OfferForm())->getContactValue('pv_options');
        $arrOptions = json_decode($optionsArray, true);

        $optiEnerSelected = (new ZH_OfferForm())->searchArray('optiener', 'id', 'value', $arrOptions);

        $url_optiener = ZH_DIR . 'public/docs/opti-ener/OptiEnerInfoPage.pdf';

        if ($optiEnerSelected) {
            $mpdf->AddPage();
            $pagecount = $mpdf->SetSourceFile($url_optiener);
            $tplId = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($tplId);
        }

        $mpdf->AddPage();
        $mpdf->WriteHTML($this->render($url4));

        return base64_encode($mpdf->Output());
    }

    public function getPreparedClientOfferHistoryForPrint()
    {
        global $wpdb;
        $offer_form_id = isset($_GET['offer_forms']) ? intval($_GET['offer_forms']) : '';

        $mpdf = new \Mpdf\Mpdf();

        $url = ZH_DIR . 'public/views/_pdf/offerform/calcpv/history/clientoffer/page1.phtml';
        $url2 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/history/clientoffer/page2.phtml';
        $url3 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/history/clientoffer/page3.phtml';
        $url4 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/history/clientankiet/page1.phtml';
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

        $mpdf->WriteHTML($this->render($url));
//        $mpdf->AddPage();
//        $mpdf->WriteHTML($this->render($url2));
        $mpdf->AddPage();
        $mpdf->WriteHTML($this->render($url3));

        $optionsArray = (new ZH_OfferForm)->getArrayFromFormOptionsHistoryOffer($offer_form_id, 'form_options', 'products');
        $arrOptions = $optionsArray;

        $optiEnerSelected = (new ZH_OfferForm())->searchArray('optiener', 'id', 'value', $arrOptions);

        $url_optiener = ZH_DIR . 'public/docs/opti-ener/OptiEnerInfoPage.pdf';

        if ($optiEnerSelected) {
            $mpdf->AddPage();
            $pagecount = $mpdf->SetSourceFile($url_optiener);
            $tplId = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($tplId);
        }

        $mpdf->AddPage();
        $mpdf->WriteHTML($this->render($url4));

        return base64_encode($mpdf->Output());
    }

    public function getPreparedInstallerOfferForPrint()
    {
        $mpdf = new \Mpdf\Mpdf();

        $url = ZH_DIR . 'public/views/_pdf/offerform/calcpv/clientoffer/page1.phtml';
        $url2 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/clientoffer/page2.phtml';
        $url3 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/installeroffer/productsPage.phtml';
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

        $mpdf->WriteHTML($this->render($url));
//        $mpdf->AddPage();
//        $mpdf->WriteHTML($this->render($url2));
        $mpdf->AddPage();
        $mpdf->WriteHTML($this->render($url3));

        $optionsArray = (new ZH_OfferForm())->getContactValue('pv_options');
        $arrOptions = json_decode($optionsArray, true);

        $optiEnerSelected = (new ZH_OfferForm())->searchArray('optiener', 'id', 'value', $arrOptions);

        $url_optiener = ZH_DIR . 'public/docs/opti-ener/OptiEnerInfoPage.pdf';

        if ($optiEnerSelected) {
            $mpdf->AddPage();
            $pagecount = $mpdf->SetSourceFile($url_optiener);
            $tplId = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($tplId);
        }

        return base64_encode($mpdf->Output());
    }

    public function getPreparedInstallerOfferHistoryForPrint()
    {
        global $wpdb;
        $offer_form_id = isset($_GET['offer_forms']) ? intval($_GET['offer_forms']) : '';

        $mpdf = new \Mpdf\Mpdf();

        $url = ZH_DIR . 'public/views/_pdf/offerform/calcpv/history/clientoffer/page1.phtml';
        $url2 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/history/clientoffer/page2.phtml';
        $url3 = ZH_DIR . 'public/views/_pdf/offerform/calcpv/history/installeroffer/productsPage.phtml';
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

        $mpdf->WriteHTML($this->render($url));
//        $mpdf->AddPage();
//        $mpdf->WriteHTML($this->render($url2));
        $mpdf->AddPage();
        $mpdf->WriteHTML($this->render($url3));

        $optionsArray = (new ZH_OfferForm)->getArrayFromFormOptionsHistoryOffer($offer_form_id, 'form_options', 'products');
        $arrOptions = $optionsArray;

        $optiEnerSelected = (new ZH_OfferForm())->searchArray('optiener', 'id', 'value', $arrOptions);

        $url_optiener = ZH_DIR . 'public/docs/opti-ener/OptiEnerInfoPage.pdf';

        if ($optiEnerSelected) {
            $mpdf->AddPage();
            $pagecount = $mpdf->SetSourceFile($url_optiener);
            $tplId = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($tplId);
        }

        return base64_encode($mpdf->Output());
    }
}