<?php

namespace Develtio\ZonesHewalex;

use Develtio\ZonesHewalex\Admin\ZH_Installations_History;
use Develtio\ZonesHewalex\Admin\ZH_Offers;
use Develtio\ZonesHewalex\Ajax\ZH_RegisterAjax;
use Develtio\ZonesHewalex\API\ZH_Mounting;
use Develtio\ZonesHewalex\CPT\ZH_Awards;
use Develtio\ZonesHewalex\CPT\ZH_AwardsProducts;
use Develtio\ZonesHewalex\CPT\ZH_Calculators;
use Develtio\ZonesHewalex\CPT\ZH_InterestedListUsersPCCO;
use Develtio\ZonesHewalex\CPT\ZH_InterestedListUsersPCWB;
use Develtio\ZonesHewalex\CPT\ZH_InterestedListUsersPv;
use Develtio\ZonesHewalex\CPT\ZH_InterestedListUsersShop;
use Develtio\ZonesHewalex\CPT\ZH_OrderedAwards;
use Develtio\ZonesHewalex\CPT\ZH_OrderedCredits;
use Develtio\ZonesHewalex\CPT\ZH_OrderedEdenredCards;
use Develtio\ZonesHewalex\CPT\ZH_PumpNumbersSet;
use Develtio\ZonesHewalex\CPT\ZH_PumpSet;
use Develtio\ZonesHewalex\CPT\ZH_PumpTypesSet;
use Develtio\ZonesHewalex\CPT\ZH_SolarNumbersSet;
use Develtio\ZonesHewalex\CPT\ZH_SolarSet;
use Develtio\ZonesHewalex\CPT\ZH_SolarTypesSet;
use Develtio\ZonesHewalex\CPT\ZH_SolarTypesSetConfiguration;
use Develtio\ZonesHewalex\Cron\ZH_Cron;
use Develtio\ZonesHewalex\Installations\ZH_RegisterInstallationFormInstallator;
use Develtio\ZonesHewalex\Installations\ZH_SupervisedInstallations;
use Develtio\ZonesHewalex\Shop\ZH_Shop;
use Develtio\ZonesHewalex\SSO\ZH_Installators;
use Develtio\ZonesHewalex\Synology\ZH_Synology;
use Develtio\ZonesHewalex\Utils\ZH_Enqueue;
use Develtio\ZonesHewalex\Utils\ZH_Metabox;
use Develtio\ZonesHewalex\Utils\ZH_RedirectLoggedUser;
use Develtio\ZonesHewalex\Utils\ZH_Rest;
use Develtio\ZonesHewalex\Utils\ZH_UserRole;
use Develtio\ZonesHewalex\Utils\ZH_Utils;
use Develtio\ZonesHewalex\CPT\ZH_RegisterInstallationCPT;
use Develtio\ZonesHewalex\CPT\ZH_RegisterInformationCPT;
use Develtio\ZonesHewalex\CPT\ZH_RegisterInformationPCCO;
use Develtio\ZonesHewalex\CPT\ZH_RegisterInformationPCWB;
use Develtio\ZonesHewalex\CPT\ZH_RegisterInformationEkontrol;
use Develtio\ZonesHewalex\CPT\ZH_RegisterInformationPV;
use Develtio\ZonesHewalex\CPT\ZH_RegisterKonfeoCPT;
use Develtio\ZonesHewalex\CPT\ZH_RegisterTrainerCPT;
use Develtio\ZonesHewalex\CPT\ZH_RegisterTrainerTypeCPT;
use Develtio\ZonesHewalex\CPT\ZH_InterestedListUsers;
use Develtio\ZonesHewalex\eDokumenty\ZH_eDokumentyMethods;
use Develtio\ZonesHewalex\eDokumenty\ZH_ExportKonfeoToeDokumenty;
use Develtio\ZonesHewalex\Options\ZH_Exports;
use Develtio\ZonesHewalex\Options\ZH_Options;
use Develtio\ZonesHewalex\SalesManago\ZH_Salesmanago;
use Develtio\ZonesHewalex\SalesManago\ZH_SalesmanagoNewsletter;
use Develtio\ZonesHewalex\SSO\ZH_SSO;
use Develtio\ZonesHewalex\Templates\ZH_Templates;
use Develtio\ZonesHewalex\EdenredPrepaid\ZH_Prepaid;


if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Init
 */
final class ZH_Init
{
    private static function init(): array
    {
       return [
           //Utils
           ZH_Enqueue::class,
           ZH_Metabox::class,
           ZH_RedirectLoggedUser::class,
           ZH_Rest::class,
           ZH_UserRole::class,
           ZH_Utils::class,

           //CPT
           ZH_RegisterInstallationCPT::class,
           ZH_RegisterKonfeoCPT::class,
           ZH_RegisterTrainerCPT::class,
           ZH_RegisterTrainerTypeCPT::class,
           ZH_Calculators::class,

           ZH_InterestedListUsers::class,
           ZH_InterestedListUsersPv::class,
           ZH_InterestedListUsersPCCO::class,
           ZH_InterestedListUsersPCWB::class,
           ZH_InterestedListUsersShop::class,

           ZH_RegisterInformationCPT::class,
           ZH_RegisterInformationPCCO::class,
           ZH_RegisterInformationPCWB::class,
           ZH_RegisterInformationPV::class,
           ZH_RegisterInformationEkontrol::class,

           ZH_SolarSet::class,
           ZH_SolarTypesSet::class,
           ZH_SolarNumbersSet::class,
           ZH_SolarTypesSetConfiguration::class,

           ZH_PumpSet::class,
           ZH_PumpTypesSet::class,
           ZH_PumpNumbersSet::class,

           ZH_Awards::class,
           ZH_AwardsProducts::class,
           ZH_OrderedAwards::class,
           ZH_OrderedCredits::class,
           ZH_OrderedEdenredCards::class,

           //Shop
           ZH_Shop::class,

           //Edenred Status
           ZH_Prepaid::class,

           //eDokumenty
           ZH_eDokumentyMethods::class,
           ZH_ExportKonfeoToeDokumenty::class,

           //Installations
           ZH_RegisterAjax::class,
           ZH_RegisterInstallationFormInstallator::class,
           ZH_SupervisedInstallations::class,

           //Options
           ZH_Options::class,
           ZH_Exports::class,

           //SalesManago
           ZH_Salesmanago::class,
           ZH_SalesmanagoNewsletter::class,

           //SSO
           ZH_SSO::class,
           ZH_Installators::class,

           //Templates
           ZH_Templates::class,

           //API
           ZH_Mounting::class,

           //Cron
           ZH_Cron::class,

           //Synology
           ZH_Synology::class,

           //Admin
           ZH_Installations_History::class,
           ZH_Offers::class,
       ];
    }

    public static function register() : void
    {
        foreach (self::init() as $class)
        {
            new $class();
        }
    }
}