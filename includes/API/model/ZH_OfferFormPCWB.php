<?php

namespace Develtio\ZonesHewalex\API\model;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_OfferFormPCWB
 */
class ZH_OfferFormPCWB extends ZH_OfferFormBase
{
    protected $formGroups = [
        /* main groups */
        'form' => [
            'id' => 'form',
            'subgroupsIds' => ['contact', 'formOptions']
        ],
        'contact' => [
            'id' => 'contact',
            'label' => 'Dane kontaktowe'
        ],
        'formOptions' => [
            'id' => 'formOptions',
            'label' => 'Formularz doboru',
            'subgroupsIds' => ['pool', 'pump', 'location', 'additional']
        ],
        /* form models groups */
        'pool' => [
            'id' => 'pool',
            'label' => 'Basen',
            'order' => 1
        ],
        'pump' => [
            'id' => 'pump',
            'label' => 'Pompa ciepła',
            'order' => 2
        ],
        'location' => [
            'id' => 'location',
            'label' => 'Lokalizacja inwestycji',
            'order' => 3
        ],
        'additional' => [
            'id' => 'additional',
            'label' => 'Informacje dodatkowe',
            'order' => 4
        ]
    ];

    protected $formModels = [
        'poolUsage' => [
            'label' => 'Przeznaczenie basenu',
            'group' => ['formOptions', 'pool'],
            'options' => [
                [
                    'id' => "",
                    'value' => 5,
                    'displayName' => [
                        'form' => "wybierz"
                    ]
                ],
                ['id' => "hs",
                    'value' => 0,
                    'displayName' => [
                        'form' => "domowy",
                        'print' => "domowy"
                    ]],
                ['id' => "pb",
                    'value' => 10,
                    'displayName' => [
                        'form' => "publiczny",
                        'print' => "publiczny"
                    ]],
                ['id' => "jc",
                    'value' => 0,
                    'displayName' => [
                        'form' => "jacuzzi",
                        'print' => "jacuzzi"
                    ]]
            ],
            'order' => 10,
            'modal' => [
                'title' => 'Przeznaczenie basenu',
                'content' => '
                    <ul>
                        <li><strong>Basen domowy:</strong> prywatny basen bez wzmożonej wymiany świeżej wody.</li>
                        <li><strong>Jacuzzi:</strong> wymagający podwyższonej temperatury wody, z intensywnym ruchem wody.</li>
                        <li><strong>Basen publiczny:</strong> ogólnodostępny intensywnie użytkowany, z dużą ilością wymiany świeżej wody. Zalecamy bezpośredni kontakt z Działem Technicznym.</li>
                    </ul>'
            ],
            'axisXls' => 'C.12'
        ],
        'poolSurface' => [
            'label' => 'Powierzchnia lustra wody',
            'group' => ['formOptions', 'pool'],
            'unit' => 'm<sup>2</sup>',
            'order' => 20,
            'modal' => [
                'title' => 'Powierzchnia lustra wody',
                'content' => '
                    <ul>
                        <li>Obliczenie dla basenu <strong>prostokątnego:</strong><br/> = a x b,  gdzie (a- krótszy bok, b- dłuższy bok [metr].</li>
                        <li>Obliczenie dla basenu <strong>okrągłego: </strong><br/> = 3,14 x r<sup>2</sup> ,  gdzie r– promień (czyli 0,5 średnicy) [metr]</li>
                    </ul>
                    <p class="mb-none">
                       Szybkie obliczenie powierzchni lustra wody dla standardowo oferowanych basenów :
                    </p>
                    <table width="100%" class="mt-xlg table table-bordered table-condensed align-center">
                        <tr><th class="align-center">Średnica (cm)</th><th class="align-center">Powierzchnia (m<sup>2</sup>)</th></tr>
                        <tr><td>183</td><td class="text-weight-bold">2,6</td></tr>
                        <tr><td>244</td><td class="text-weight-bold">4,7</td></tr>
                        <tr><td>305</td><td class="text-weight-bold">7,3</td></tr>
                        <tr><td>366</td><td class="text-weight-bold">10,5</td></tr>
                        <tr><td>396</td><td class="text-weight-bold">12,3</td></tr>
                        <tr><td>427</td><td class="text-weight-bold">14,3</td></tr>
                        <tr><td>457</td><td class="text-weight-bold">16,4</td></tr>
                        <tr><td>478</td><td class="text-weight-bold">18,0</td></tr>
                        <tr><td>488</td><td class="text-weight-bold">18,7</td></tr>
                        <tr><td>549</td><td class="text-weight-bold">23,7</td></tr>
                        <tr><td>610</td><td class="text-weight-bold">29,2</td></tr>
                        <tr><td>732</td><td class="text-weight-bold">42,1</td></tr>
                    </table>'
            ],
            'axisXls' => 'C.9'
        ],
        'poolDepth' => [
            'label' => 'Głębokość basenu',
            'group' => ['formOptions', 'pool'],
            'unit' => 'm',
            'order' => 30,
            'modal' => [
                'title' => 'Głębokość basenu',
                'content' => '
                    <p class="mb-none">
                       Głębokość wody w basenie. Jeśli dno jest  nieregularne to należy podać średnią głębokość wody [metr].
                    </p>'
            ],
            'axisXls' => 'C.11'
        ],
        'poolExpectedWaterTemp' => [
            'label' => 'Oczekiwana temperatura wody',
            'group' => ['formOptions', 'pool'],
            'unit' => "&deg;C",
            'valueOptions' => [7, 18, 24, 25, 26, 27, 28, 30, 32, 34, 36, 37, 38, 39, 40, 41],
            'order' => 40,
            'modal' => [
                'title' => 'Oczekiwana temperatura wody',
                'content' => '
                    <p class="mb-none">
                       <strong>24-26&deg;C</strong> – optymalna w basenie pływackim<br/>
<strong>28-32&deg;C</strong> – podwyższony komfort w basenie rekreacyjnym<br/>
<strong>35-38&deg;C</strong> – podwyższone wymagania dla jacuzzi<br/>
                    </p>'
            ],
            'axisXls' => 'C.14'
        ],
        'poolUsagePeriod' => [
            'label' => 'Okres użytkowania basenu',
            'group' => ['formOptions', 'pool'],
            'options' => [
                [
                    'id' => '',
                    'value' => 2,
                    'displayName' => [
                        'form' => "wybierz"
                    ]
                ],
                [
                    'id' => "summer",
                    'value' => 20,
                    'displayName' => [
                        'form' => "tylko latem (około 3-4 miesiące)",
                        'print' => 'Tylko lato'
                    ]
                ],
                [
                    'id' => "5-10",
                    'value' => 15,
                    'displayName' => [
                        'form' => "maj-październik (około 6 miesięcy)",
                        'print' => 'od Maja do Października'
                    ]
                ],
                [
                    'id' => "3-11",
                    'value' => 5,
                    'displayName' => [
                        'form' => "marzec-listopad (około 9 miesięcy)",
                        'print' => 'od Marca do Listopada'
                    ]
                ],
                [
                    'id' => "year",
                    'value' => -5,
                    'displayName' => [
                        'form' => "przez cały rok",
                        'print' => 'Całoroczny'
                    ]
                ],
            ],
            'modelPsOptions' => [
                "year" => 'Celem ogrzewania basenu całorocznego program dobierze pompę ciepła serii PCCO.',
                "3-11" => 'Wydłużenie okresu użytkowania basenu o podane miesiące spowoduje dobranie droższego modelu pompy ciepła. Upewnij się, że chcesz używać basenu poza okresem letnim.',
            ],
            'order' => 50,
            'modal' => [
                'title' => 'Okres użytkowania',
                'content' => '
                    <p class="mb-none">
                       Podaj w jakim okresie w ciągu roku planujesz użytkować basen i ogrzewać go pompą ciepła.
                    </p>'
            ],
            'axisXls' => 'F.9'
        ],
        'poolLocation' => [
            'label' => 'Lokalizacja basenu',
            'group' => ['formOptions', 'pool'],
            'options' => [
                ['id' => '', 'displayName' => [
                    'form' => "wybierz",
                ]],
                ['id' => "oc",
                    'value' => 20,
                    'air_humidity' => 90,
                    'parentId' => ["summer", "5-10"], 'displayName' => [
                    'form' => "basen zewnętrzny + przykrywanie lustra wody",
                    'print' => 'Zewnątrz z przykryciem'
                ]],
                ['id' => "onc",
                    'value' => 15,
                    'air_humidity' => 70,
                    'parentId' => ["summer", "5-10", "3-11"], 'displayName' => [
                    'form' => "basen zewnętrzny – bez przykrywania lustra wody",
                    'print' => 'Zewnątrz bez przykrycia'
                ]],
                ['id' => "oct",
                    'value' => 7,
                    'air_humidity' => 50,
                    'parentId' => ["3-11"], 'displayName' => [
                    'form' => "basen zewnętrzny + przykrywanie lustra wody",
                    'print' => 'Zewnątrz z przykryciem (min. temp.)'
                ]],
                ['id' => "inc",
                    'value' => 26,
                    'air_humidity' => 70,
                    'parentId' => ["summer", "5-10", "3-11", "year"], 'displayName' => [
                    'form' => "basen w budynku – bez przykrywania lustra wody",
                    'print' => 'Wewnątrz bez przykrycia'
                ]],
                ['id' => "ic",
                    'value' => 26,
                    'air_humidity' => 95,
                    'parentId' => ["summer", "5-10", "3-11", "year"], 'displayName' => [
                    'form' => "basen w budynku + przykrywanie lustra wody",
                    'print' => 'Wewnątrz z przykryciem'
                ]],
            ],
            'order' => 60,
            'modelPsOptions' => [
                "onc" => 'Zalecamy stosowanie przykrywania basenu, plandeką, folią solarną lub innym przykryciem, celem minimalizacji strat ciepła (umożliwi to dobór tańszej pompy ciepła).',
                "inc" => 'Zalecamy stosowanie przykrywania basenu, plandeką, folią solarną lub innym przykryciem, celem minimalizacji strat ciepła (umożliwi to dobór tańszej pompy ciepła).',
            ],
            'modal' => [
                'title' => 'Lokalizacja',
                'content' => '
                    <p class="mb-none">
                        Lokalizacja basenu (w budynku lub na zewnątrz) oraz okresowe przykrywanie lustra wody (roleta, folia itp.) odgrywa znaczny wpływ na straty cieplne i dobór pompy ciepła.
                    </p>'
            ],
            'axisXls' => 'C.7'
        ],
        'poolInGround' => [
            'label' => 'Czy basen jest wkopany w ziemię?',
            'group' => ['formOptions', 'pool'],
            'options' => [
                ['id' => "",  'displayName' => "wybierz"],
                ['id' => "y", 'value' => 3, 'displayName' => "tak"],
                ['id' => "n", 'value' => 7, 'displayName' => "nie"]
            ],
            'order' => 70,
            'modal' => [
                'title' => 'Czy basen jest wkopany w ziemię?',
                'content' => '
                    <p class="mb-none">
                       Basen wkopany w ziemię (np. niecka murowana) cechuje się niższymi stratami ciepła. Basen na gruncie to np. popularny basen stelażowy lub rozporowy.
                    </p>'
            ],
            'axisXls' => 'F.7'
        ],
        'poolRoomExpectedTemp' => [
            'label' => 'Temperatura powietrza w pomieszczeniu basenowym',
            'group' => ['formOptions', 'pool'],
            'unit' => "&deg;C",
            'order' => 80,
            'modal' => [
                'title' => 'Temperatura powietrza w pomieszczeniu basenowym',
                'content' => '
                    <p class="mb-none">
                       Dla ograniczenia strat ciepła z basenu zaleca się aby temperatura powietrza była zbliżona do temperatury wody basenowej.
                    </p>'
            ],
            'axisXls' => 'F.14'
        ],
        'hoursWithoutPoolCover' => [
            'label' => 'Dzienna liczba godzin z odkrytym lustrem wody (bez rolety, folii itp.)',
            'group' => ['formOptions', 'pool'],
            'unit' => "h",
            'order' => 85,
            'modal' => [
                'title' => 'Dzienna liczba godzin z odkrytym lustrem wody (bez rolety, folii itp.)',
                'content' => '
                    <p class="mb-none">
                       Przeciętna dzienna liczba godzin użytkowania basenu, podczas której lustro wody jest odsłonięte. Dłuższy czas oznacza wyższe straty ciepła z wody basenowej i może wpływać na dobór pompy ciepła o większej mocy.
                    </p>'
            ],
            'axisXls' => 'F.11'
        ],
        'poolInHardConditions' => [
            'label' => 'Czy basen jest zlokalizowany w otwartej przestrzeni i narażony na silne podmuchy wiatru?',
            'group' => ['formOptions', 'pool'],
            'options' => [
                ['id' => "",  'displayName' => "wybierz"],
                ['id' => "y", 'displayName' => "tak"],
                ['id' => "n", 'displayName' => "nie"]
            ],
            'order' => 90,
            'modelPsOptions' => [
                "y" => 'Ochrona basenu przed silnymi podmuchami wiatru, umożliwi dobór tańszej pompy ciepła.',
            ],
            'modal' => [
                'title' => 'Czy basen jest zlokalizowany w otwartej przestrzeni i narażony na silne podmuchy wiatru?',
                'content' => '
                    <p class="mb-none">
                       Wzmożony ruch powietrza powoduje zwiększenie strat ciepła z powierzchni lustra basenu przez co może wpłynąć na konieczność doboru mocniejszego urządzenia.
                    </p>'
            ],
            'axisXls' => 'F.10'
        ],
        'outsideTempHeaterRun' => [
            'paramIds' => [
                'default' => 'outsideTempHeaterRun',
                'custom' => 'outsideTempHeaterRunCustom'
            ],
            'label' => [
                'default' => 'Temperatura powietrza zewnętrznego, poniżej której uruchomi się wbudowana grzałka elektryczna',
                'custom' => 'Podaj temperaturę powietrza zewnętrznego, poniżej której uruchomi się wbudowana grzałka elektryczna'
            ],
            'group' => ['formOptions', 'pump'],
            'unit' => "&deg;C",
            'options' => [
                ['id' => "",       'value' => null, 'displayName' => "wybierz"],
                ['id' => "-5",     'value' => -5,        'displayName' => "-5 st. C"],
                ['id' => "-10",    'value' => -10,       'displayName' => "-10 st. C"],
                ['id' => "-15",    'value' => -15,       'displayName' => "-15 st. C"],
                ['id' => "custom", 'value' => null, 'displayName' => "inna"],
            ],
            'modelPsOptions' => [
                "-5" => 'Pompa ciepła dobrana na samodzielną pracę przez około 70-80% godzin w ciągu roku. Prawdopodobieństwo częstego uruchamiania dodatkowego źródła grzewczego.',
                "-10" => 'Pompa ciepła dobrana na samodzielną pracę przez około 80-90% godzin w ciągu roku. Optymalna wartość dla ogrzewania całorocznego.',
                "-15" => 'Pompa ciepła dobrana na samodzielną pracę przez około 95% godzin w ciągu roku. Pompa ciepła może zostać przewymiarowana. Spowoduje to dobór droższego urządzenia.'
            ],
            'order' => 100,
            'modals' => [
                'default' => [
                    'title' => 'Temperatura powietrza zewnętrznego, poniżej której uruchomi się wbudowana grzałka elektryczna',
                    'content' => '
                        <p class="mb-none">
                               Wybierz temperaturę poniżej której dopuszczalna będzie współpraca z wbudowaną grzałką elektryczną lub innym źródłem grzewczym.
                        </p>'
                ],
                'custom' => [
                    'title' => 'Podaj temperaturę powietrza zewnętrznego, poniżej której uruchomi się wbudowana grzałka elektryczna',
                    'content' => '
                        <p class="mb-none">
                               Wybierz temperaturę poniżej której dopuszczalna będzie współpraca z wbudowaną grzałką elektryczną lub innym źródłem grzewczym.
                        </p>'
                ],
            ],
            'axisXls' => 'F.15'
        ],
        'poolToPumpDistance' => [
            'label' => 'Odległość pomiędzy basenem, a pompą ciepła',
            'group' => ['formOptions', 'pump'],
            'options' => [
                ['id' => '', 'displayName' => [
                    'form' => "wybierz"
                ]],
                ['id' => "<5",
                    'value' => 2,
                    'displayName' => [
                        'form' => "pompa ciepła przy basenie (do 5 m)",
                        'print' => '<5m'
                    ]],
                ['id' => "5-10",
                    'value' => 3,
                    'displayName' => [
                        'form' => "od 5 do 10m",
                        'print' => '5-10m'
                    ]],
                ['id' => "10-20",
                    'value' => 5,
                    'displayName' => [
                        'form' => "od 10 do 20m",
                        'print' => '10-20m'
                    ]],
                ['id' => ">20",
                    'value' => 7,
                    'displayName' => [
                        'form' => "ponad 20 m",
                        'print' => '>20m'
                    ]],
            ],
            'order' => 110,
            'modal' => [
                'title' => 'Odległość pomiędzy basenem, a pompą ciepła',
                'content' => '
                    <p class="mb-none">
                       Podaj planowaną odległość pomiędzy basenem a docelową lokalizacją pompy ciepła. Im większa odległość tym potencjalnie większe straty ciepła na rurociągu wodnym.
                    </p>'
            ],
            'axisXls' => 'F.8'
        ],
        'pumpAsOnlyHeatingDevice' => [
            'label' => 'Czy pompa ciepła będzie jedynym źródłem grzewczym dla basenu?',
            'group' => ['formOptions', 'pump'],
            'options' => [
                ['id' => "",  'displayName' => "wybierz"],
                ['id' => "y", 'displayName' => "tak"],
                ['id' => "n", 'displayName' => "nie"]
            ],
            'order' => 120,
            'modal' => [
                'title' => 'Czy pompa ciepła będzie jedynym źródłem grzewczym dla basenu?',
                'content' => '
                    <p class="mb-none">
                       Należy wybrać <strong>„tak”</strong> jeżeli woda w basenie będzie podgrzewana tylko przez pompę ciepła.
                    </p>'
            ],
            'axisXls' => 'F.12'
        ],
        'installationPostcode' => [
            'label' => 'Kod pocztowy',
            'group' => ['formOptions', 'location'],
            'order' => 130,
            'axisXls' => 'C.5'

        ],
        'name' => [
            'label' => "Imię i nazwisko",
            'group' => ['contact'],
            'order' => 140,
            'xlsCol' => 'C',
            'xlsRow' => 2
        ],
        'email' => [
            'label' => "Email",
            'group' => ['contact'],
            'type' => 'email',
            'required' => true,
            'order' => 150,
            'xlsCol' => 'C',
            'xlsRow' => 3
        ],
        'phone' => [
            'label' => "Telefon",
            'group' => ['contact'],
            'order' => 160,
            'axisXls' => 'C.4'
        ],
        'comment' => [
            'label' => 'Dodatkowe informacje dla działu pomp ciepła',
            'group' => ['contact'],
            'order' => 170
        ],
        'complexApproach' => [
            'label' => 'Czy jesteś zainteresowany kompleksową wyceną instalacji?',
            'group' => ['formOptions', 'additional'],
            'options' => [
                ['id' => "",  'displayName' => "wybierz"],
                ['id' => "y", 'displayName' => "tak"],
                ['id' => "n", 'displayName' => "nie, posiadam instalatora, który dokona wyceny"]
            ],
            'order' => 180,
            'modal' => [
                'title' => 'Czy jesteś zainteresowany kompleksową wyceną instalacji?',
                'content' => '
                    <p class="mb-none">
                        Jesteś zainteresowany czymś więcej, niż otrzymanie raportu, który przedstawia szacunkowe roczne koszty eksploatacyjne oraz proponowane urządzenie? Jeśli nie jesteś w kontakcie z odpowiednią firmą, możemy przygotować dla Ciebie również wycenę instalacji razem z montażem.
                    </p>'
            ]
        ],
        'acceptMailing' => [
            'paramId' => 'accept_mailing',
            'label' => [
                'form' => 'Wyrażam zgodę na otrzymanie oferty oraz informacji handlowych od Hewalex Sp. z o.o. Sp.k. za pośrednictwem maila oraz drogą sms-ową. Mam prawo cofnąć zgodę w każdym czasie (dane przetwarzane są do czasu cofnięcia zgody).',
                'print' => 'Zgoda mailing',
            ],
            'group' => ['contact'],
            'defaultValue' => false,
            'order' => 190
        ],
        'acceptData' => [
            'paramId' => 'accept_data',
            'label' => [
                'form' => 'Zapoznałem się z informacją o administratorze i przetwarzaniu danych.',
                'print' => 'Zgoda dane',
            ],
            'group' => ['contact'],
            'defaultValue' => false,
            'order' => 200
        ]
    ];

    public function __construct()
    {
        foreach ($this->formModels as $modelId => $model) {
            if (isset($model['paramId'])) {
                continue;
            }
            $this->formModels[$modelId]['paramId'] = $modelId;
        }
    }

    public function getCategoryModel()
    {
        return ZH_PCWB::$PCWB_DESTINATION;
    }

    public static function insert($data, $hash)
    {
        $searcher = new ZH_OfferForm();
        $installer = new ZH_Installers();

        $args = array(
            'post_title'    => (new ZH_OfferForm)->searchArray('name', 'id', 'value', $data['contact']),
            'post_type'     => 'users_pcwb',
            'post_status'   => 'publish',
            'post_author'   => (new ZH_Installers())->getIdInstallator() ?? '',
            'meta_input'    => array(
                'hash'           => $hash,
                'parent_hash'    => $data['parent_hash'],
                'category_calc'  => $data['offer_form_category'],
                'pcwb_name'           => $searcher->searchArray('name', 'id', 'value', $data['contact']),
                'pcwb_postcode'       => $searcher->searchArray('installationPostcode', 'id', 'value', $data['form_options']['options']),
                'pcwb_phone'          => $searcher->searchArray('phone', 'id', 'value', $data['contact']),
                'pcwb_mail'           => $searcher->searchArray('email', 'id', 'value', $data['contact']),
                'pcwb_agree_1'        => $searcher->searchArray('accept_mailing', 'id', 'value', $data['contact']) ? 'Tak' : 'Nie',
                'pcwb_agree_2'        => $searcher->searchArray('accept_data', 'id', 'value', $data['contact']) ?  'Tak' : 'Nie',
                'pcwb_options'        => json_encode($data['form_options']['options'], JSON_UNESCAPED_UNICODE),
                'pcwb_contact'        => json_encode($data['contact'], JSON_UNESCAPED_UNICODE),
            )
        );
        $insert = wp_insert_post($args);

        return $insert;
    }

    public static function getDataset($hash)
    {
        $args = array(
            'post_type' => 'users_pcwb',
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

    public function setExactOffer($offerForm)
    {
        $this->offerForm = $offerForm;
        return $this;
    }

    public function getResources()
    {
        return [
            'formGroups' => $this->formGroups,
            'formModels' => $this->formModels
        ];
    }

    public function getOfferForm()
    {
        return $this->offerForm;
    }

    public function getPreparedClientOfferForPrint()
    {
        $mpdf = new \Mpdf\Mpdf();

        $url_styl_pdf = ZH_DIR . 'public/css/pdf/pdf.css';
        $url_style = ZH_DIR . 'public/css/pdf/custom.css';
        $url_styl_pcwb = ZH_DIR . 'public/css/pdf/pcwb.css';

        $options = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $stylesheet1 = file_get_contents($url_style, false, stream_context_create($options));
        $stylesheet2 = file_get_contents($url_styl_pdf, false, stream_context_create($options));
        $stylesheet3 = file_get_contents($url_styl_pcwb, false, stream_context_create($options));

        $mpdf->WriteHTML($stylesheet1,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($stylesheet2,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($stylesheet3,\Mpdf\HTMLParserMode::HEADER_CSS);

        $optionsArr = (new ZH_OfferForm())->getContactValue('pcwb_options');
        $arrOptions = json_decode($optionsArr, true);
        $contactArr = (new ZH_OfferForm())->getContactValue('pcwb_contact');
        $arrContacts = json_decode($contactArr, true);

        $completedArr = array_merge($arrOptions, $arrContacts);

        $cells = $this->prepareXlsCellsFromFormData($completedArr);

        $calculatorPcwb = new ZH_PCWB($cells);
        $calculatorPcwb->setFormModels($this->getExactFormWithModels($arrOptions, $arrContacts, ''));

        $pagesReport = $calculatorPcwb->preparePagesReport();

        foreach ($pagesReport as $page) {
            $pdfPage = $this->renderPCWB($page['template'], $page['params']);
            $mpdf->AddPage();
            $mpdf->WriteHTML($pdfPage);
        }

        return base64_encode($mpdf->Output());
    }

    public function getPreparedClientOfferHistoryForPrint()
    {
        global $wpdb;

        $offer_form_id = isset($_GET['offer_forms']) ? intval($_GET['offer_forms']) : '';
        $mpdf = new \Mpdf\Mpdf();

        $url_styl_pdf = ZH_DIR . 'public/css/pdf/pdf.css';
        $url_style = ZH_DIR . 'public/css/pdf/custom.css';
        $url_styl_pcwb = ZH_DIR . 'public/css/pdf/pcwb.css';

        $options = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $stylesheet1 = file_get_contents($url_style, false, stream_context_create($options));
        $stylesheet2 = file_get_contents($url_styl_pdf, false, stream_context_create($options));
        $stylesheet3 = file_get_contents($url_styl_pcwb, false, stream_context_create($options));

        $mpdf->WriteHTML($stylesheet1,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($stylesheet2,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($stylesheet3,\Mpdf\HTMLParserMode::HEADER_CSS);

        $options = "select form_options from offer_forms where offer_form_id LIKE {$offer_form_id}";
        $contact = "select contact from offer_forms where offer_form_id LIKE {$offer_form_id}";
        $category = "select offer_form_category from offer_forms where offer_form_id LIKE {$offer_form_id}";

        $options_arr = $wpdb->get_results($options, 'ARRAY_A');
        $contact_arr = $wpdb->get_results($contact, 'ARRAY_A');
        $category_arr = $wpdb->get_results($category, 'ARRAY_A');

        $optionsArrNew = json_decode($options_arr[0]['form_options'], true);

        $arrOptions = $optionsArrNew['options'];
        $arrContacts = json_decode($contact_arr[0]['contact'], true);

        $completedArr = array_merge($arrOptions, $arrContacts);

        $cells = $this->prepareXlsCellsFromFormData($completedArr);

        $calculatorPcwb = new ZH_PCWB($cells);
        $calculatorPcwb->setFormModels($this->getExactFormWithModels($arrOptions, $arrContacts, ''));

        $pagesReport = $calculatorPcwb->preparePagesReportHistory();

        foreach ($pagesReport as $page) {
            $pdfPage = $this->renderPCWB($page['template'], $page['params']);
            $mpdf->AddPage();
            $mpdf->WriteHTML($pdfPage);
        }

        return base64_encode($mpdf->Output());
    }

    public function prepareXlsCellsFromFormData($completedArr)
    {
        $cells = [];
        $formParams = $this->getExactFormWithModelsPcwb($completedArr);

        foreach ($formParams as $key => $item) {
            if ($item['axisXls'] ?? false) {
                $axis = explode('.', $item['axisXls']);
                if(isset($item['value'])){
                    $cells[$axis[0]][$axis[1]] = $item['value'];
                }
            }
        }

        return $cells;
    }

    public function getPreparedClientAnkietForPrint()
    {
        $mpdf = new \Mpdf\Mpdf();

        $url4 = ZH_DIR . 'public/views/_pdf/offerform/pcwb/clientankiet/page1.phtml';
        $url_style = ZH_DIR . 'public/css/pdf/custom.css';
        $url_styl_pdf = ZH_DIR . 'public/css/pdf/pdf.css';
        $url_styl_pcwb = ZH_DIR . 'public/css/pdf/pcwb.css';

        $options = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $stylesheet1 = file_get_contents($url_style, false, stream_context_create($options));
        $stylesheet2 = file_get_contents($url_styl_pdf, false, stream_context_create($options));
        $stylesheet3 = file_get_contents($url_styl_pcwb, false, stream_context_create($options));

        $mpdf->WriteHTML($stylesheet1,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($stylesheet2,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($stylesheet3,\Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->AddPage();
        $mpdf->WriteHTML($this->render($url4));

        return base64_encode($mpdf->Output());
    }

    public function getPreparedClientAnkietHistoryForPrint()
    {
        $mpdf = new \Mpdf\Mpdf();

        $url4 = ZH_DIR . 'public/views/_pdf/offerform/pcwb/history/clientankiet/page1.phtml';
        $url_style = ZH_DIR . 'public/css/pdf/custom.css';
        $url_styl_pdf = ZH_DIR . 'public/css/pdf/pdf.css';
        $url_styl_pcwb = ZH_DIR . 'public/css/pdf/pcwb.css';

        $options = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $stylesheet1 = file_get_contents($url_style, false, stream_context_create($options));
        $stylesheet2 = file_get_contents($url_styl_pdf, false, stream_context_create($options));
        $stylesheet3 = file_get_contents($url_styl_pcwb, false, stream_context_create($options));

        $mpdf->WriteHTML($stylesheet1,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($stylesheet2,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($stylesheet3,\Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->AddPage();
        $mpdf->WriteHTML($this->render($url4));

        return base64_encode($mpdf->Output());
    }

    public function getExactFormWithModelsPcwb($completedArr, $params = [])
    {
        $models = $this->formModels;

        /* sort models */
        uasort($models, function ($x, $y) {
            return ($x['order'] ?? 1) < ($y['order'] ?? 1) ? -1 : 1;
        });

        /* assign form values to models */
        $formData = $completedArr;

        foreach ($formData as $formOption) {
            if (!($models[$formOption['id']] ?? null)) {
                continue;
            }

            $models[$formOption['id']]['value'] = $formOption['value'] ?? null;
            if ($formOption['selectedId'] ?? null) {
                $models[$formOption['id']]['selectedId'] = $formOption['selectedId'];
                $option = $this->getDatasetItemPcwb($models, $formOption['id'] . '.options', $formOption['selectedId']);

                if (($models[$formOption['id']]['paramIds'] ?? false) && is_array($models[$formOption['id']]['paramIds'])) {
                    $models[$formOption['id']]['label'] = $models[$formOption['id']]['label']['default'];
                }
                if (($models[$formOption['id']]['paramIds'] ?? false)
                    && is_array($models[$formOption['id']]['paramIds'])
                    && array_key_exists($formOption['selectedId'], $models[$formOption['id']]['paramIds'])
                    && ($formOption['value'] ?? null)
                ) {
                    $models[$formOption['id']]['label'] = $models[$formOption['id']]['label']['default'];
                    $models[$formOption['id']]['selectedId'] = null;

                } else {
                    $models[$formOption['id']]['value'] = data_get($option, 'displayName.print', $option['displayName']);
                }
            }
        }

        /* unset models without value */
        $exactModels = array_filter($models, function ($model) {
            return isset($model['value']) || isset($model['selectedId']);
        });

        /* group models by defined groups */
        if ($params['grouped'] ?? false) {
            $groups = $this->formGroups;
            /* sort groups */
            uasort($groups, function ($x, $y) {
                if(isset($x['order']) && isset($y['order'])) {
                    return $x['order'] < $y['order'] ? -1 : 1;
                }
            });

            /* assign models to groups */
            $group = $groups['form'];
            $this->initGroup($group, $exactModels, $groups);

            return $group;
        }
        return $exactModels;
    }

    public static function getDatasetItemPcwb(array $offer, string $path, string $id)
    {
        $dataset = data_get($offer, $path, []);
        $item = array_first($dataset, function ($item) use ($id) {
            return $item['id'] == $id;
        });
        return $item;
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

    public function getTest()
    {
        $optionsArr = (new ZH_OfferForm())->getContactValue('pcwb_options');
        $arrOptions = json_decode($optionsArr, true);
        $contactArr = (new ZH_OfferForm())->getContactValue('pcwb_contact');
        $arrContacts = json_decode($contactArr, true);

        $completedArr = array_merge($arrOptions, $arrContacts);

        $calculatorPcwb = new ZH_PCWB($this->prepareXlsCellsFromFormData($completedArr));
        $calculatorPcwb->setFormModels($this->getExactFormWithModels($arrOptions, $arrContacts, ''));
        $calculatorPcwb->showTest();
    }

    public function prepareToStatistic()
    {
        $calculatorPcwb = new ZH_PCWB($this->prepareXlsCellsFromFormData());
        $calculatorPcwb->setFormModels($this->getExactFormWithModels());
        $toStat = [
            ['C', 7],
            ['C', 9],
            ['C', 14],
            ['C', 39],
            ['C', 40],
            ['D', 40],
            ['C', 41],
            ['D', 41],
            ['C', 42],
            ['D', 42],
            ['F',9]
        ];

        $result = [];
        foreach($toStat as $key => $xy) {
            $result[$xy[0].$xy[1]] = $calculatorPcwb->getCell($xy[0], $xy[1]);
        }
        return $result;
    }

    public function getPreparedClientOfferForJson()
    {
        $data = json_decode(file_get_contents('php://input', true), true);

        $optionsArr = $data['form_options']['options'];
        $contactArr = $data['contact'];

        $completedArr = array_merge($optionsArr, $contactArr);

        $cells = $this->prepareXlsCellsFromFormData($completedArr);
        $calculatorPcwb = new ZH_PCWB($cells);
        $calculatorPcwb->setFormModels($this->getExactFormWithModels($optionsArr, $contactArr, ''));

        return [
            'report' => $calculatorPcwb->prepareOneOfferParams()
        ];
    }
}