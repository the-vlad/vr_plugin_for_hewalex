<div id="pumpsForm" class="container" ng-controller="formController" ng-init="init()">
    <!-- calc info top -->
    <div class="row mb-md" ng-hide="formModels.pumpUsage.isSelected()">
        <div class="col-md-12">
            <p>
                Wersja 1.4.1
                <a href="" data-toggle="modal" data-target="#versionInfoModal">
                    <i class="fa fa-info-circle ml-xs"></i>
                </a>
            </p>
        </div>
        <div class="col-md-12">
            <div class="mb-md">
                <p>
                    Formularz jest przeznaczony do doboru pomp ciepła PCCO dla typowych budynków. Dla obiektów
                    wielkokubaturowych i o nietypowym przeznaczeniu prosimy o kontakt z
                    <a href="/strony/kontakt.html"><strong>Działem Pomp Ciepła</strong></a> firmy Hewalex.
                </p>
                <p>
                    Wypełnij poniższy formularz, a wyniki obliczeń wraz z doborem urządzenia otrzymasz w ciągu dwóch dni
                    roboczych na podany adres email.
                </p>
            </div>
        </div>
        <div class="col-md-12">
            <h2 class="text-transform-none text-center mb-md">
                <strong>Przed przystąpieniem do uzupełniania zapoznaj się z naszymi uwagami:</strong>
            </h2>
            <ol>
                <li class="mb-xs">Staranne wypełnienie danych w formularzu doboru pozwoli wykorzystać jego zaawansowane
                    funkcje dla doboru rozwiązania spełniającego wymagania użytkownika.</li>
                <li class="mb-xs">Firma Hewalex nie bierze odpowiedzialności za wpisanie niepoprawnych danych. Pomimo
                    bardzo wysokiej dokładności obliczeń, wyniki kalkulatora nie zastępują szczegółowych opracowań
                    projektowych.</li>
                <li class="mb-xs">Wyniki obliczeń wraz z doborem urządzeń są przekazywane w ciągu około 2 dni roboczych
                    na adres mailowy, który jest niezbędny do podania na końcu formularza.</li>
                <li class="mb-xs">Ze względu na złożoność kalkulatora zaleca się czytanie wszystkich pól z informacją
                    dot. poszczególnych pytań (wyjaśnienia dostępne po kliknięciu ikony <span
                        class="ico__info text-primary">i</span>).</li>
                        <style>
                            .ico__info{
                                width:10px;
                                height:10px;
                                color: #e3a14e !important;
                                /* content: "i" !important; */
                                font-weight: 900;
                                font-size: 18px;
                                display:inline-block;
                                margin-left:15px;
                            }
                            </style>
                <li class="mb-xs">Aby dobierane urządzenie było jak najlepiej dostosowane do Twojego obiektu, sugerujemy
                    korzystanie z opcji wypełniania szczegółowych informacji formularza. W tym celu, zanim rozpoczniesz
                    wypełnianie formularza przygotuj następujące dane: wymiary zewnętrzne budynku, powierzchnię podłóg
                    wszystkich kondygnacji, powierzchnię okien względem stron świata oraz rodzaje i grubości
                    zastosowanych materiałów konstrukcyjnych oraz izolacyjnych.</li>
                <li class="mb-xs">Wypełnienie formularza zajmie około 10-15 min.</li>
            </ol>
        </div>
    </div>
    <!-- initial step -->
    <div ng-hide="formModels.pumpUsage.isSelected()">
        <div class="row mb-md">
            <div class="col-md-12 text-center mb-lg">
                <h2 class="text-transform-none mb-none">
                    <strong>Aby przejść do formularza wybierz przeznaczenie pompy ciepła:</strong>
                </h2>
            </div>
            <div class="col-sm-4" ng-repeat="x in formModels.pumpUsage.options">
                <section class="lp-buttons call-to-action with-borders mb-md" ng-model="formModels.pumpUsage.selected"
                    ng-click="formModels.pumpUsage.select(x.id)">
                    <div class="col-12 match-height">
                        <div class="call-to-action-content">
                            <!-- <img ng-src="/public/images/pcco-form/lp-{{x.id}}.svg?v=2"> -->
                            <h4 class="text-primary mb-none">
                                <strong ng-cloak="">{{x.displayName}}</strong>
                            </h4>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="row form-horizontal mb-md hide" ng-hide="form.config.isEditMode()">
        <div class="form-group">
            <label class="col-sm-4 control-label">
                {{formModels.pumpUsage.label}}:
            </label>
            <div class="col-sm-6">
                <select class="form-control" name="pumpUsage" ng-model="formModels.pumpUsage.selected"
                    ng-options="i.displayName for i in formModels.pumpUsage.options track by i.id"
                    ng-change="formModels.pumpUsage.onChange()" required="">
                </select>
            </div>
        </div>
    </div>
    <!-- form -->
    <div ng-show="formModels.pumpUsage.isSelected() && form.inProgress()" ng-cloak="">
        <section class="card form-wizard" id="pumpsForm">
            <div class="card-body card-body-nopadding" style="display: block;">
                <!-- form steps -->
                <div class="wizard-tabs">
                    <ul class="nav wizard-steps">
                        <li class="nav-item" ng-repeat="(key, item) in form.filteredSteps">
                            <a href="{{item.href}}" data-toggle="tab" class="nav-link text-center">
                                <span class="badge">{{key + 1}}</span>
                                <span class="hidden-xs">{{item.displayName}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- form content -->
                <form class="form-horizontal">
                    <div class="tab-content">
                        <!-- cwu -->
                        <div id="pumpsForm-step-cwu" class="tab-pane" ng-show="formModels.pumpUsage.includesCwu()">
                            <div class="row">
                                <label class="col-sm-4 control-label">
                                    <h4><span
                                            class="badge badge-primary badge-text mr-sm">{{groups.waterUsage.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row" ng-init="formModels.waterUsageSelectionMode.init()">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.buildingPeopleCount.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#buildingPeopleCountModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="buildingPeopleCount"
                                                ng-model="formModels.buildingPeopleCount.value"
                                                ng-change="formModels.buildingPeopleCount.onChange()"
                                                min="{{formModels.buildingPeopleCount.min}}"
                                                max="{{formModels.buildingPeopleCount.max}}" ng-destroy required>
                                            <span class="input-group-addon">os.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.waterUsageSelectionMode.isBasicMode()">
                                    <div class="col-sm-6 col-sm-offset-4">
                                        <small>Jeśli masz nietypowe zużycie wody (np. dużą wannę z hydromasażem) lub
                                            liczba osób korzystających z wody przekracza 6 -
                                            <a href="" ng-model="formModels.waterUsageSelectionMode.selected"
                                                ng-click="formModels.waterUsageSelectionMode.setMode(0)">
                                                <strong>przejdź do ustawień szczegółowych</strong>
                                            </a>
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.waterUsageSelectionMode.isAdvancedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.waterUsageDaily.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#waterUsageDailyModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="waterUsageDaily"
                                                ng-model="formModels.waterUsageDaily.value"
                                                ng-change="formModels.waterUsageDaily.onChange()"
                                                ng-value="{{formModels.waterUsageDaily.value}}"
                                                min="{{formModels.waterUsageDaily.min}}"
                                                max="{{formModels.waterUsageDaily.max}}" ng-destroy required>
                                            <span class="input-group-addon">{{formModels.waterUsageDaily.unit}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.waterUsageSelectionMode.isAdvancedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.maxDisposableWaterUsage.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#maxDisposableWaterUsageModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="maxDisposableWaterUsage"
                                                ng-model="formModels.maxDisposableWaterUsage.value"
                                                ng-change="formModels.maxDisposableWaterUsage.onChange()"
                                                ng-value="{{formModels.maxDisposableWaterUsage.value}}"
                                                min="{{formModels.maxDisposableWaterUsage.min}}"
                                                max="{{formModels.maxDisposableWaterUsage.max}}" ng-destroy required>
                                            <span
                                                class="input-group-addon">{{formModels.maxDisposableWaterUsage.unit}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.waterUsageSelectionMode.isAdvancedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.timeGapBetweenHighWaterUsage.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#timeGapBetweenHighWaterUsageModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control"
                                                name="timeGapBetweenHighWaterUsage"
                                                ng-model="formModels.timeGapBetweenHighWaterUsage.value"
                                                ng-change="formModels.timeGapBetweenHighWaterUsage.onChange()"
                                                ng-value="{{formModels.timeGapBetweenHighWaterUsage.value}}"
                                                min="{{formModels.timeGapBetweenHighWaterUsage.min}}"
                                                max="{{formModels.timeGapBetweenHighWaterUsage.max}}" ng-destroy
                                                required>
                                            <span
                                                class="input-group-addon">{{formModels.timeGapBetweenHighWaterUsage.unit}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.waterUsageSelectionMode.isAdvancedMode()">
                                    <div class="col-sm-6 col-sm-offset-4">
                                        <small>
                                            Jeśli masz normalne zużycie ciepłej wody użytkowej przez nie więcej niż 6
                                            osób
                                            <a href="" ng-model="formModels.waterUsageSelectionMode.selected"
                                                ng-click="formModels.waterUsageSelectionMode.setMode(1)">
                                                <strong>przejdź do ustawień standardowych</strong>
                                            </a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- co -->
                        <div id="pumpsForm-step-co" class="tab-pane" ng-show="formModels.pumpUsage.includesCo()">
                            <div class="row">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.building.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.buildingState.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#buildingStateModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="buildingState"
                                                ng-model="formModels.buildingState.selected"
                                                ng-options="i.displayName for i in formModels.buildingState.options track by i.id"
                                                ng-init="formModels.buildingState.init()"
                                                ng-change="formModels.buildingState.onChange()" required="">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.buildingType.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#buildingTypeModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="buildingType"
                                                ng-model="formModels.buildingType.selected"
                                                ng-options="i.displayName for i in formModels.buildingType.options track by i.id"
                                                ng-init="formModels.buildingType.init()"
                                                ng-change="formModels.buildingType.onChange()" ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        <span
                                            ng-bind-html="formModels.buildingHeatLoadSelectionMode.label.form"></span>:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#buildingHeatLoadSelectionModeModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="buildingHeatLoadSelectionMode"
                                                ng-model="formModels.buildingHeatLoadSelectionMode.selected"
                                                ng-options="i.displayName for i in formModels.buildingHeatLoadSelectionMode.options track by i.id"
                                                ng-init="formModels.buildingHeatLoadSelectionMode.init()"
                                                ng-change="formModels.buildingHeatLoadSelectionMode.onChange()"
                                                required="">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" name="pumpSelectionDetails"
                                        ng-model="formModels.pumpSelectionDetails.value"
                                        ng-init="formModels.pumpSelectionDetails.init()" ng-destroy>
                                </div>
                                <div class="form-group"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isBasicMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.buildingHeatLoad.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#buildingHeatLoadModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="buildingHeatLoad"
                                                ng-model="formModels.buildingHeatLoad.value"
                                                ng-change="formModels.buildingHeatLoad.onChange()"
                                                min="{{formModels.buildingHeatLoad.min}}"
                                                max="{{formModels.buildingHeatLoad.max}}"
                                                step="{{formModels.buildingHeatLoad.step}}"
                                                ng-focus="formModels.buildingHeatLoad.desc.visible = true"
                                                ng-blur="formModels.buildingHeatLoad.desc.visible = false" ng-destroy
                                                required>
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.buildingHeatLoad.unit"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 hidden-xs" ng-show="formModels.buildingHeatLoad.desc.visible">
                                        <span ng-bind-html="formModels.buildingHeatLoad.desc.content"></span>
                                    </div>
                                </div>
                                <div class="form-group"
                                    ng-hide="!formModels.buildingHeatLoadSelectionMode.isSelected()">
                                    <label class="col-sm-4 control-label">
                                        <span ng-hide="formModels.buildingHeatLoadSelectionMode.isBasicMode()"
                                            ng-bind-html="formModels.buildingHeatedSurface.label.form"></span>
                                        <span ng-show="formModels.buildingHeatLoadSelectionMode.isBasicMode()"
                                            ng-bind-html="formModels.buildingHeatedSurface.label.formBasicMode"></span>:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#buildingHeatedSurfaceModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="buildingHeatedSurface"
                                                ng-model="formModels.buildingHeatedSurface.value"
                                                ng-init="formModels.buildingHeatedSurface.init()"
                                                ng-change="formModels.buildingHeatedSurface.onChange()"
                                                min="{{formModels.buildingHeatedSurface.min}}"
                                                max="{{formModels.buildingHeatedSurface.max}}"
                                                ng-focus="formModels.buildingHeatedSurface.desc.visible = true"
                                                ng-blur="formModels.buildingHeatedSurface.desc.visible = false"
                                                required="">
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.buildingHeatedSurface.unit"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 hidden-xs"
                                        ng-show="formModels.buildingHeatedSurface.desc.visible">
                                        <span ng-bind-html="formModels.buildingHeatedSurface.desc.content"></span>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-hide="!formModels.buildingHeatLoadSelectionMode.isSelected() || formModels.buildingHeatLoadSelectionMode.isBasicMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.atticType.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#atticTypeModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="atticType"
                                                ng-model="formModels.atticType.selected"
                                                ng-options="i.displayName for i in formModels.atticType.options track by i.id"
                                                ng-init="formModels.atticType.init()"
                                                ng-change="formModels.atticType.onChange()" ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.atticType.isHeated() && formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.atticSurface.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#atticSurfaceModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="atticSurface"
                                                ng-model="formModels.atticSurface.value"
                                                ng-change="formModels.atticSurface.onChange()"
                                                min="{{formModels.atticSurface.min}}" ng-destroy required>
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.atticSurface.unit"></span>
                                        </div>
                                        <div class="text-info" ng-hide="formModels.atticSurface.isHidden()">
                                            <small>{{slcModels.buildingTotalHeatedSurace.label}}: </small>
                                            <small>
                                                <strong>{{slcModels.buildingTotalHeatedSurace.value}}
                                                    <span
                                                        ng-bind-html="slcModels.buildingTotalHeatedSurace.unit"></span>
                                                </strong>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"
                                    ng-hide="!formModels.buildingHeatLoadSelectionMode.isSelected() || formModels.buildingHeatLoadSelectionMode.isBasicMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.garageType.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#garageTypeModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="garageType"
                                                ng-model="formModels.garageType.selected"
                                                ng-options="i.displayName for i in formModels.garageType.options track by i.id"
                                                ng-init="formModels.garageType.init()"
                                                ng-change="formModels.garageType.onChange()" ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"
                                    ng-show="formModels.garageType.isGarage() && formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.garageSurface.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#garageSurfaceModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="garageSurface"
                                                ng-model="formModels.garageSurface.value"
                                                ng-change="formModels.garageSurface.onChange()"
                                                min="{{formModels.garageSurface.min}}"
                                                max="{{formModels.garageSurface.max}}" ng-destroy required>
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.garageSurface.unit"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"
                                    ng-hide="!formModels.buildingHeatLoadSelectionMode.isSelected() || formModels.buildingHeatLoadSelectionMode.isBasicMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.isBasement.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#isBasementModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="isBasement"
                                                ng-model="formModels.isBasement.selected"
                                                ng-options="i.displayName for i in formModels.isBasement.options track by i.id"
                                                ng-init="formModels.isBasement.init()"
                                                ng-change="formModels.isBasement.onChange()" ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.isBasement.yes() && formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.basementSurface.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#basementSurfaceModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="basementSurface"
                                                ng-model="formModels.basementSurface.value"
                                                ng-change="formModels.basementSurface.onChange()"
                                                min="{{formModels.basementSurface.min}}"
                                                max="{{formModels.basementSurface.max}}" ng-destroy required>
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.basementSurface.unit"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"
                                    ng-show="formModels.buildingType.isHouse() && formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        <span ng-bind-html="formModels.heatedStoreys.label.form"></span>
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#heatedStoreysModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="heatedStoreys"
                                                ng-model="formModels.heatedStoreys.value"
                                                ng-init="formModels.heatedStoreys.init()"
                                                ng-change="formModels.heatedStoreys.setValue()"
                                                min="{{formModels.heatedStoreys.min}}"
                                                max="{{formModels.heatedStoreys.max}}" ng-destroy required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"
                                    ng-show="formModels.buildingType.isFlat() && formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.flatLocation.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#flatLocationModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="flatLocation"
                                                ng-model="formModels.flatLocation.selected"
                                                ng-options="i.displayName for i in formModels.flatLocation.filteredOptions track by i.id"
                                                ng-init="formModels.flatLocation.init()"
                                                ng-change="formModels.flatLocation.onChange()" ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"
                                    ng-hide="!formModels.buildingHeatLoadSelectionMode.isSelected() || formModels.buildingHeatLoadSelectionMode.isBasicMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.buildingSurface.label}}:<br />
                                        <small>{{formModels.buildingSurface.labelPs}}</small>
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#buildingSurfaceModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="buildingSurface"
                                                ng-model="formModels.buildingSurface.value"
                                                ng-change="formModels.buildingSurface.onChange()"
                                                min="{{formModels.buildingSurface.min}}"
                                                max="{{formModels.buildingSurface.max}}"
                                                ng-focus="formModels.buildingSurface.desc.visible = true"
                                                ng-blur="formModels.buildingSurface.desc.visible = false" required="">
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.buildingSurface.unit"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 hidden-xs" ng-show="formModels.buildingSurface.desc.visible">
                                        <span ng-bind-html="formModels.buildingSurface.desc.content"></span>
                                    </div>
                                </div>
                                <div class="form-group"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.expectedRoomTemp.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#expectedRoomTempModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="expectedRoomTemp"
                                                ng-model="formModels.expectedRoomTemp.value"
                                                ng-init="formModels.expectedRoomTemp.init()"
                                                ng-change="formModels.expectedRoomTemp.onChange()"
                                                min="{{formModels.expectedRoomTemp.min}}"
                                                max="{{formModels.expectedRoomTemp.max}}" required="">
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.expectedRoomTemp.unit"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md" ng-hide="true">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.expectedHeatGains.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#expectedHeatGainsModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="expectedHeatGains"
                                                ng-model="formModels.expectedHeatGains.selected"
                                                ng-options="i.displayName for i in formModels.expectedHeatGains.options track by i.id"
                                                ng-init="formModels.expectedHeatGains.init()"
                                                ng-change="formModels.expectedHeatGains.onChange()" ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row"
                                ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.garageType.isGarage()">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.garage.label}}</span></h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.garageType.isGarage()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.garageInBuilding.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#garageInBuildingModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="garageInBuilding"
                                                ng-model="formModels.garageInBuilding.selected"
                                                ng-options="i.displayName for i in formModels.garageInBuilding.options track by i.id"
                                                ng-init="formModels.garageInBuilding.init()"
                                                ng-change="formModels.garageInBuilding.onChange()" ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.garageType.isHeated()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.expectedGarageTemp.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#expectedGarageTempModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="expectedGarageTemp"
                                                ng-model="formModels.expectedGarageTemp.value"
                                                ng-change="formModels.expectedGarageTemp.onChange()"
                                                min="{{formModels.expectedGarageTemp.min}}"
                                                max="{{formModels.expectedGarageTemp.max}}" ng-destroy required>
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.expectedGarageTemp.unit"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row"
                                ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.isBasement.yes()">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.basement.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.isBasement.yes()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.isBasementHeated.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#isBasementHeatedModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="isBasementHeated"
                                                ng-model="formModels.isBasementHeated.selected"
                                                ng-options="i.displayName for i in formModels.isBasementHeated.options track by i.id"
                                                ng-init="formModels.isBasementHeated.init()"
                                                ng-change="formModels.isBasementHeated.onChange()" ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.isBasement.yes() && formModels.isBasementHeated.yes()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.expectedBasementTemp.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#expectedBasementTempModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="expectedBasementTemp"
                                                ng-model="formModels.expectedBasementTemp.value"
                                                ng-change="formModels.expectedBasementTemp.onChange()"
                                                min="{{formModels.expectedBasementTemp.min}}"
                                                max="{{formModels.expectedBasementTemp.max}}" ng-destroy required>
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.expectedBasementTemp.unit"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                <label class="col-sm-4 control-label">
                                    <h4><span
                                            class="badge badge-primary badge-text">{{groups.bottomIsolation.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.bottomIsolationType.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#bottomIsolationTypeModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="bottomIsolationType"
                                                ng-model="formModels.bottomIsolationType.selected"
                                                ng-options="i.displayName for i in formModels.bottomIsolationType.filteredOptions track by i.id"
                                                ng-init="formModels.bottomIsolationType.init()"
                                                ng-change="formModels.bottomIsolationType.onChange()" ng-destroy
                                                required="">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.bottomIsolationType.anyIsolationSelected()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.bottomIsolationMaterial.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#bottomIsolationMaterialModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="bottomIsolationMaterial"
                                                ng-model="formModels.bottomIsolationMaterial.selected"
                                                ng-options="i.displayName for i in formModels.bottomIsolationMaterial.options track by i.id"
                                                ng-init="formModels.bottomIsolationMaterial.init()"
                                                ng-change="formModels.bottomIsolationMaterial.onChange()" ng-destroy
                                                required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md" ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()
                                        && formModels.bottomIsolationType.anyIsolationSelected()
                                        && formModels.bottomIsolationMaterial.customMaterialSelected()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.bottomIsolationMaterialLambda.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#bottomIsolationMaterialLambdaModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control"
                                                name="bottomIsolationMaterialLambda"
                                                ng-model="formModels.bottomIsolationMaterialLambda.value"
                                                ng-init="formModels.bottomIsolationMaterialLambda.init()"
                                                ng-change="formModels.bottomIsolationMaterialLambda.setValue()"
                                                min="{{formModels.bottomIsolationMaterialLambda.min}}"
                                                step="{{formModels.bottomIsolationMaterialLambda.step}}" ng-destroy
                                                required="">
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.bottomIsolationMaterialLambda.unit"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.bottomIsolationType.anyIsolationSelected()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.bottomIsolationThickness.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#bottomIsolationThicknessModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="bottomIsolationThickness"
                                                ng-model="formModels.bottomIsolationThickness.value"
                                                ng-change="formModels.bottomIsolationThickness.onChange()"
                                                min="{{formModels.bottomIsolationThickness.min}}"
                                                max="{{formModels.bottomIsolationThickness.max}}" ng-destroy required>
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.bottomIsolationThickness.unit"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.walls.label}}</span></h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.wallType.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#{{formModels.wallType.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="{{formModels.wallType.paramId}}"
                                                ng-model="formModels.wallType.selected"
                                                ng-options="i.displayName for i in formModels.wallType.options track by i.id"
                                                ng-init="formModels.wallType.init()"
                                                ng-change="formModels.wallType.onChange()" ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.wallType.isSelected()">
                                    <label class="col-sm-4 control-label">
                                        Materiał i grubość przegród:
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-4 form-group ml-none mr-none"
                                                ng-repeat="layer in formModels.wallType.layers" ng-show="formModels.wallType.showLayer(layer.id)
                                                    && formModels.buildingHeatLoadSelectionMode.isAdvandedMode()
                                                    && formModels.wallType.isSelected()">
                                                <strong class="text-center text-info text-uppercase mb-md">
                                                    {{layer.displayName}}
                                                </strong>
                                                <div class="mb-xs">
                                                    <label class="control-label">Materiał:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#wallMaterialModal">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{scope.formModels['wall'+layer.suffix+'Material'].paramId}}"
                                                            ng-model="scope.formModels['wall'+layer.suffix+'Material'].selected"
                                                            ng-options="i.displayName for i in scope.formModels['wall'+layer.suffix+'Material'].options track by i.id"
                                                            ng-init="scope.formModels['wall'+layer.suffix+'Material'].init()"
                                                            ng-change="scope.formModels['wall'+layer.suffix+'Material'].onChange()"
                                                            ng-destroy>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ml-none mr-none" ng-show="scope.formModels['wall'+layer.suffix+'Material'].isCustomMaterial()
                                                    && formModels.wallType.showLayer(layer.id)
                                                    && formModels.buildingHeatLoadSelectionMode.isAdvandedMode()
                                                    && formModels.wallType.isSelected()">
                                                    <label class="control-label">Współczynnik LAMBDA:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#wallMaterialLambdaModal">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{scope.formModels['wall'+layer.suffix+'MaterialLambda'].paramId}}"
                                                            ng-model="scope.formModels['wall'+layer.suffix+'MaterialLambda'].value"
                                                            ng-change="scope.formModels['wall'+layer.suffix+'MaterialLambda'].onChange()"
                                                            min="{{scope.formModels['wall'+layer.suffix+'MaterialLambda'].min}}"
                                                            step="{{scope.formModels['wall'+layer.suffix+'MaterialLambda'].step}}"
                                                            ng-destroy>
                                                        <span class="input-group-addon">W/mK</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="control-label">Grubość:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#wallThicknessModal">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{scope.formModels['wall'+layer.suffix+'Thickness'].paramId}}"
                                                            ng-model="scope.formModels['wall'+layer.suffix+'Thickness'].value"
                                                            ng-change="scope.formModels['wall'+layer.suffix+'Thickness'].onChange()"
                                                            min="{{scope.formModels['wall'+layer.suffix+'Thickness'].min}}"
                                                            max="{{scope.formModels['wall'+layer.suffix+'Thickness'].max}}"
                                                            ng-destroy>
                                                        <span class="input-group-addon">cm</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.wallType.isSelected()">
                                    <label class="col-sm-4 control-label pt-none mb-xs">
                                        Zestawienie ścian w zależności od nastawy:
                                    </label>
                                    <div class="col-sm-12">
                                        <table class="table table-no-more table-bordered table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-info text-uppercase">Orientacja</th>
                                                    <th class="text-info text-uppercase">
                                                        {{formModels.wallSurfaceTotal.label}}
                                                        <a href="" data-toggle="modal"
                                                            data-target="#wallSurfaceTotalModal">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                    </th>
                                                    <th class="text-info text-uppercase" style="width:20%">
                                                        {{formModels.wallSurfaceConnected.label}}
                                                        <a href="" data-toggle="modal"
                                                            data-target="#wallSurfaceConnectedModal">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                    </th>
                                                    <th class="text-info text-uppercase"
                                                        ng-repeat="layer in formModels.wallType.layers"
                                                        ng-show="formModels.wallType.showLayer(layer.id)">
                                                        {{layer.displayName}}
                                                    </th>
                                                    <tr />
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="x in formModels.wallType.sides">
                                                    <td data-title="Nastawa" class="va-middle">
                                                        <strong>{{x.displayName}}</strong>
                                                    </td>
                                                    <td data-title="{{formModels.wallSurfaceTotal.label}}">
                                                        <div class="input-group table-input-no-label">
                                                            <input type="number" class="form-control"
                                                                name="{{scope.formModels['wallSurfaceTotal'+x.suffix].paramId}}"
                                                                ng-model="scope.formModels['wallSurfaceTotal'+x.suffix].value"
                                                                ng-change="scope.formModels['wallSurfaceTotal'+x.suffix].onChange()"
                                                                min="{{scope.formModels['wallSurfaceTotal'+x.suffix].min}}"
                                                                max="{{scope.formModels['wallSurfaceTotal'+x.suffix].max}}"
                                                                ng-destroy ng-required="true">
                                                            <span class="input-group-addon"
                                                                ng-bind-html="formModels.wallSurfaceTotal.unit"></span>
                                                        </div>
                                                    </td>
                                                    <td data-title="{{formModels.wallSurfaceConnected.label}}">
                                                        <div class="input-group table-input-no-label">
                                                            <input type="number" class="form-control"
                                                                name="{{scope.formModels['wallSurfaceConnected'+x.suffix].paramId}}"
                                                                ng-model="scope.formModels['wallSurfaceConnected'+x.suffix].value"
                                                                ng-change="scope.formModels['wallSurfaceConnected'+x.suffix].onChange()"
                                                                min="{{scope.formModels['wallSurfaceConnected'+x.suffix].min}}"
                                                                max="{{scope.formModels['wallSurfaceConnected'+x.suffix].max}}"
                                                                ng-destroy ng-required="true">
                                                            <span class="input-group-addon"
                                                                ng-bind-html="formModels.wallSurfaceConnected.unit"></span>
                                                        </div>
                                                        <div class="text-info">
                                                            <small>Wpisz wartość "0" jeśli ściana nie łączy się z innym
                                                                budynkiem.</small>
                                                        </div>
                                                    </td>
                                                    <td class="form-group ml-none mr-none"
                                                        data-title="{{layer.displayName}}"
                                                        ng-repeat="layer in formModels.wallType.layers"
                                                        ng-show="formModels.wallType.showLayer(layer.id)">
                                                        <div>
                                                            <label class="control-label pt-none">Materiał:</label>
                                                            <select class="form-control"
                                                                name="wall{{layer.suffix}}Material{{x.suffix}}"
                                                                ng-model="scope.formModels['wall'+layer.suffix+'Material'+x.suffix].selected"
                                                                ng-options="i.displayName for i in scope.formModels['wall'+'{{layer.suffix}}'+'Material'+'{{x.suffix}}'].options track by i.id"
                                                                ng-init="scope.formModels['wall'+layer.suffix+'Material'+x.suffix].init()"
                                                                ng-change="scope.formModels['wall'+layer.suffix+'Material'+x.suffix].onChange()"
                                                                ng-destroy ng-required="true">
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="control-label">Grubość:</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control"
                                                                    name="wall{{layer.suffix}}Thickness{{x.suffix}}"
                                                                    ng-model="scope.formModels['wall'+layer.suffix+'Thickness'+x.suffix].value"
                                                                    ng-change="scope.formModels['wall'+layer.suffix+'Thickness'+x.suffix].onChange()"
                                                                    min="{{scope.formModels['wall'+layer.suffix+'Thickness'+x.suffix].min}}"
                                                                    max="{{scope.formModels['wall'+layer.suffix+'Thickness'+x.suffix].max}}"
                                                                    ng-destroy ng-required="true">
                                                                <span class="input-group-addon">cm</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ml-none mr-none"
                                                            ng-show="formModels.wallType.showLayer(layer.id) && scope.formModels['wall'+layer.suffix+'Material'+x.suffix].isCustomMaterial()">
                                                            <label class="control-label">Współczynnik LAMBDA:</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control"
                                                                    name="wall{{layer.suffix}}MaterialLambda{{x.suffix}}"
                                                                    ng-model="scope.formModels['wall'+layer.suffix+'MaterialLambda'+x.suffix].value"
                                                                    ng-change="scope.formModels['wall'+layer.suffix+'MaterialLambda'+x.suffix].onChange()"
                                                                    min="{{scope.formModels['wall'+layer.suffix+'MaterialLambda'+x.suffix].min}}"
                                                                    step="{{scope.formModels['wall'+layer.suffix+'MaterialLambda'+x.suffix].step}}"
                                                                    ng-destroy ng-required="true">
                                                                <span class="input-group-addon">W/mK</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row" ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.windows.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.windowType.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#windowTypeModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="windowType"
                                                ng-model="formModels.windowType.selected"
                                                ng-options="i.displayName for i in formModels.windowType.options track by i.id"
                                                ng-init="formModels.windowType.init()"
                                                ng-change="formModels.windowType.onChange()" ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.windowType.isCustomMaterial()">
                                    <label class="col-sm-4 control-label">
                                        Współczynnik U okien:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#windowMaterialFactorModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="windowMaterialFactor"
                                                ng-model="formModels.windowMaterialFactor.value"
                                                ng-change="formModels.windowMaterialFactor.setValue()"
                                                min="{{formModels.windowMaterialFactor.min}}"
                                                max="{{formModels.windowMaterialFactor.max}}"
                                                step="{{formModels.windowMaterialFactor.step}}" ng-destroy required>
                                            <span class="input-group-addon">W/m&sup2;K</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && (formModels.windowType.isSelected() || form.config.isEditMode())">
                                    <label class="col-sm-4 control-label">
                                        Zestawienie okien w zależności od nastawy:
                                    </label>
                                    <div class="col-sm-8">
                                        <table class="table table-no-more table-bordered table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-info text-uppercase">Nastawa</th>
                                                    <th class="text-info text-uppercase">{{formModels.windowType.label}}
                                                    </th>
                                                    <th class="text-info text-uppercase">
                                                        {{formModels.windowSurface.label}}
                                                        <a href="" data-toggle="modal"
                                                            data-target="#windowSurfaceModal">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                    </th>
                                                    <th class="text-info text-uppercase">
                                                        {{formModels.windowMaterialFactor.label}}</th>
                                                    <tr />
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="x in formModels.windowType.sides">
                                                    <td data-title="Nastawa" class="va-middle">
                                                        <strong>{{x.displayName}}</strong>
                                                    </td>
                                                    <td data-title="{{formModels.windowType.label}}">
                                                        <select class="form-control" name="windowType{{x.suffix}}"
                                                            ng-model="scope.formModels['windowType'+x.suffix].selected"
                                                            ng-options="i.displayName for i in scope.formModels['windowType'+'{{x.suffix}}'].options track by i.id"
                                                            ng-change="scope.formModels['windowType'+x.suffix].onChange()"
                                                            ng-destroy ng-required="true">
                                                        </select>
                                                    </td>
                                                    <td data-title="{{formModels.windowSurface.label}}">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                name="windowSurface{{x.suffix}}"
                                                                ng-model="scope.formModels['windowSurface'+x.suffix].value"
                                                                ng-change="scope.formModels['windowSurface'+x.suffix].onChange()"
                                                                min="{{scope.formModels['windowSurface'+x.suffix].min}}"
                                                                max="{{scope.formModels['windowSurface'+x.suffix].max}}"
                                                                step="{{scope.formModels['windowSurface'+x.suffix].step}}"
                                                                ng-destroy ng-required="true">
                                                            <span class="input-group-addon"
                                                                ng-bind-html="formModels.windowSurface.unit"></span>
                                                        </div>
                                                        <div class="text-info">
                                                            <small>Wpisz wartość "0" jeśli brak okien.</small>
                                                        </div>
                                                    </td>
                                                    <td data-title="{{formModels.windowMaterialFactor.label}}">
                                                        <div ng-if="!scope.formModels['windowType'+x.suffix].isCustomMaterial()"
                                                            class="text-center table-input-align">
                                                            <span>
                                                                {{scope.formModels['windowType'+x.suffix].selected.u}}
                                                                W/m&sup2;K
                                                            </span>
                                                        </div>
                                                        <div
                                                            ng-if="scope.formModels['windowType'+x.suffix].isCustomMaterial()">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control"
                                                                    name="windowMaterialFactor{{x.suffix}}"
                                                                    ng-model="scope.formModels['windowMaterialFactor'+x.suffix].value"
                                                                    ng-change="scope.formModels['windowMaterialFactor'+x.suffix].onChange()"
                                                                    min="{{scope.formModels['windowMaterialFactor'+x.suffix].min}}"
                                                                    max="{{scope.formModels['windowMaterialFactor'+x.suffix].max}}"
                                                                    step="{{scope.formModels['windowMaterialFactor'+x.suffix].step}}"
                                                                    ng-destroy ng-required="true">
                                                                <span class="input-group-addon"
                                                                    ng-bind-html="formModels.windowMaterialFactor.unit"></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row" ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.roof.label}}</span></h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.roofType.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#roofTypeModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="roofType"
                                                ng-model="formModels.roofType.selected"
                                                ng-options="i.displayName for i in formModels.roofType.options track by i.id"
                                                ng-init="formModels.roofType.init()"
                                                ng-change="formModels.roofType.onChange()" ng-destroy required="">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.roofSurface.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#roofSurfaceModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="roofSurface"
                                                ng-model="formModels.roofSurface.value"
                                                ng-change="formModels.roofSurface.onChange()"
                                                min="{{formModels.roofSurface.min}}"
                                                max="{{formModels.roofSurface.max}}" ng-destroy required>
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.roofSurface.unit"></span>
                                        </div>
                                        <div class="text-info">
                                            <small>Jeśli nie znasz powierzchni, wpisz wartość "0"</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.roofIsolationLocation.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#roofIsolationLocationModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="roofIsolationLocation"
                                                ng-model="formModels.roofIsolationLocation.selected"
                                                ng-options="i.displayName for i in formModels.roofIsolationLocation.options track by i.id"
                                                ng-init="formModels.roofIsolationLocation.init()"
                                                ng-change="formModels.roofIsolationLocation.onChange()" ng-destroy
                                                required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12"
                                        ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.roofIsolationLocation.withoutIsolation()">
                                        <div class="alert alert-danger text-center p-xlg m-xlg mb-none">
                                            <h3 class="mb-md text-transform-none">
                                                <strong>Czy na pewno nie ma żadnej izolacji na dachu?</strong>
                                            </h3>
                                            <h5 class="mb-sm text-transform-none">
                                                Brak izolacji na dachu/stopie
                                                pod nieogrzewanym poddaszem powoduje duże straty ciepła do otoczenia.
                                                Dobór pompy ciepła w takim przypadku nie jest zalecany i nie będzie
                                                kontynuowany.
                                            </h5>
                                            <h5 class="mb-none text-transform-none">
                                                W pierwszej kolejności należy docieplić budynek.
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.roofIsolationLocation.withIsolation()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.roofIsolationMaterial.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#roofIsolationMaterialModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="roofIsolationMaterial"
                                                ng-model="formModels.roofIsolationMaterial.selected"
                                                ng-options="i.displayName for i in formModels.roofIsolationMaterial.options track by i.id"
                                                ng-init="formModels.roofIsolationMaterial.init()"
                                                ng-change="formModels.roofIsolationMaterial.onChange()" ng-destroy
                                                required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md" ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode()
                                        && formModels.roofIsolationLocation.withIsolation()
                                        && formModels.roofIsolationMaterial.customMaterialSelected()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.roofIsolationMaterialLambda.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#roofIsolationMaterialLambdaModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="roofIsolationMaterialLambda"
                                                ng-model="formModels.roofIsolationMaterialLambda.value"
                                                ng-init="formModels.roofIsolationMaterialLambda.init()"
                                                ng-change="formModels.roofIsolationMaterialLambda.onChange()"
                                                min="{{formModels.roofIsolationMaterialLambda.min}}"
                                                step="{{formModels.roofIsolationMaterialLambda.step}}" ng-destroy
                                                required>
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.roofIsolationMaterialLambda.unit"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.buildingHeatLoadSelectionMode.isAdvandedMode() && formModels.roofIsolationLocation.withIsolation()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.roofIsolationThickness.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#roofIsolationThicknessModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="roofIsolationThickness"
                                                ng-model="formModels.roofIsolationThickness.value"
                                                ng-init="formModels.roofIsolationThickness.init()"
                                                ng-change="formModels.roofIsolationThickness.onChange()"
                                                min="{{formModels.roofIsolationThickness.min}}"
                                                max="{{formModels.roofIsolationThickness.max}}" ng-destroy required>
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.roofIsolationThickness.unit"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- installation -->
                        <div id="pumpsForm-step-installation" class="tab-pane">
                            <div class="row" ng-show="formModels.pumpUsage.includesCwu()">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.cwu.label}}</span></h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group" ng-show="formModels.pumpUsage.includesCwu()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.pumpWithCirculation.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#pumpWithCirculationModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="pumpWithCirculation"
                                                ng-model="formModels.pumpWithCirculation.selected"
                                                ng-options="i.displayName for i in formModels.pumpWithCirculation.options track by i.id"
                                                ng-init="formModels.pumpWithCirculation.init()"
                                                ng-change="formModels.pumpWithCirculation.onChange()" ng-destroy
                                                required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md" ng-show="formModels.pumpUsage.includesCwu()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.cwuHeatingAdditionalDevices.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#cwuHeatingAdditionalDevicesModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="cwuHeatingAdditionalDevices"
                                                ng-model="formModels.cwuHeatingAdditionalDevices.selected"
                                                ng-options="i.displayName for i in formModels.cwuHeatingAdditionalDevices.options track by i.id"
                                                ng-init="formModels.cwuHeatingAdditionalDevices.init()"
                                                ng-change="formModels.cwuHeatingAdditionalDevices.onChange()" ng-destroy
                                                required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" ng-show="formModels.pumpUsage.includesCo()">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.vent.label}}</span></h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group mb-md" ng-show="formModels.pumpUsage.includesCo()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.buildingVentType.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#buildingVentTypeModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="buildingVentType"
                                                ng-model="formModels.buildingVentType.selected"
                                                ng-options="i.displayName for i in formModels.buildingVentType.options track by i.id"
                                                ng-init="formModels.buildingVentType.init()"
                                                ng-change="formModels.buildingVentType.onChange()" ng-destroy
                                                required="">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" ng-show="formModels.pumpUsage.includesCo()">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.co.label}}</span></h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group" ng-show="formModels.pumpUsage.includesCo()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.buildingHeatingType.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#buildingHeatingTypeModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="buildingHeatingType"
                                                ng-model="formModels.buildingHeatingType.selected"
                                                ng-options="i.displayName for i in formModels.buildingHeatingType.options track by i.id"
                                                ng-init="formModels.buildingHeatingType.init()"
                                                ng-change="formModels.buildingHeatingType.onChange()" ng-destroy
                                                required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="precentage-group">
                                    <div class="form-group mb-md"
                                        ng-show="1==0 && formModels.pumpUsage.includesCo() && formModels.buildingHeatingType.isMixed()">
                                        <label class="col-sm-4 control-label">
                                            {{formModels.buildingHeatingInPrecentWall.label}}:
                                        </label>
                                        <div class="col-sm-3">
                                            <div class="input-group precentage-item">
                                                <input type="number" class="form-control"
                                                    name="buildingHeatingInPrecentWall"
                                                    ng-model="formModels.buildingHeatingInPrecentWall.value"
                                                    ng-init="formModels.buildingHeatingInPrecentWall.init()"
                                                    ng-change="formModels.buildingHeatingInPrecentWall.onChange()"
                                                    min="{{formModels.buildingHeatingInPrecentWall.min}}" ng-destroy
                                                    required>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-md"
                                        ng-show="1==0 && formModels.pumpUsage.includesCo() && formModels.buildingHeatingType.isMixed()">
                                        <label class="col-sm-4 control-label">
                                            {{formModels.buildingHeatingInPrecentHeater.label}}:
                                        </label>
                                        <div class="col-sm-3">
                                            <div class="input-group precentage-item">
                                                <input type="number" class="form-control"
                                                    name="buildingHeatingInPrecentHeater"
                                                    ng-model="formModels.buildingHeatingInPrecentHeater.value"
                                                    ng-init="formModels.buildingHeatingInPrecentHeater.init()"
                                                    ng-change="formModels.buildingHeatingInPrecentHeater.onChange()"
                                                    min="{{formModels.buildingHeatingInPrecentHeater.min}}" ng-destroy
                                                    required>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-md"
                                        ng-show="1==0 && formModels.pumpUsage.includesCo() && formModels.buildingHeatingType.isMixed()">
                                        <label class="col-sm-4 control-label">
                                            {{formModels.buildingHeatingInPrecentKlim.label}}:
                                        </label>
                                        <div class="col-sm-3">
                                            <div class="input-group precentage-item">
                                                <input type="number" class="form-control"
                                                    name="buildingHeatingInPrecentKlim"
                                                    ng-model="formModels.buildingHeatingInPrecentKlim.value"
                                                    ng-init="formModels.buildingHeatingInPrecentKlim.init()"
                                                    ng-change="formModels.buildingHeatingInPrecentKlim.onChange()"
                                                    min="{{formModels.buildingHeatingInPrecentKlim.min}}" ng-destroy
                                                    required>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.pumpUsage.includesCo()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.heatingMaxTemp.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#heatingMaxTempModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="number" class="form-control" name="heatingMaxTemp"
                                                ng-model="formModels.heatingMaxTemp.value"
                                                ng-change="formModels.heatingMaxTemp.setValue()"
                                                min="{{formModels.heatingMaxTemp.min}}"
                                                max="{{formModels.heatingMaxTemp.max}}"
                                                step="{{formModels.heatingMaxTemp.step}}" ng-destroy required>
                                            <span class="input-group-addon"
                                                ng-bind-html="formModels.heatingMaxTemp.unit"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md" ng-show="formModels.pumpUsage.includesCo()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.pumpAsOnlyHeatingDevice.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#pumpAsOnlyHeatingDeviceModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="pumpAsOnlyHeatingDevice"
                                                ng-model="formModels.pumpAsOnlyHeatingDevice.selected"
                                                ng-options="i.displayName disable when i.disabled for i in formModels.pumpAsOnlyHeatingDevice.options track by i.id"
                                                ng-init="formModels.pumpAsOnlyHeatingDevice.init()"
                                                ng-change="formModels.pumpAsOnlyHeatingDevice.onChange()" required="">
                                            </select>
                                        </div>
                                        <div class="text-info" ng-show="formModels.heatingMaxTemp.highValueExpected()">
                                            <small>Wysoka oczekiwana temperatura, pompa nie może być jedynym źródłem
                                                grzewczym.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md"
                                    ng-show="formModels.pumpUsage.includesCo() && ((formModels.buildingState.isNew() && formModels.pumpAsOnlyHeatingDevice.no()) || formModels.buildingState.isRenovated())">
                                    <label class="col-sm-4 control-label" ng-if="formModels.buildingState.isNew()">
                                        {{formModels.coHeatingAdditionalDevices.labelOptions.additional}}:
                                    </label>
                                    <label class="col-sm-4 control-label"
                                        ng-if="formModels.buildingState.isRenovated()">
                                        {{formModels.coHeatingAdditionalDevices.labelOptions.current}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#coHeatingAdditionalDevicesModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="coHeatingAdditionalDevices"
                                                ng-model="formModels.coHeatingAdditionalDevices.selected"
                                                ng-options="i.displayName disable when i.disabled for i in formModels.coHeatingAdditionalDevices.options track by i.id"
                                                ng-init="formModels.coHeatingAdditionalDevices.init()"
                                                ng-change="formModels.coHeatingAdditionalDevices.onChange()" ng-destroy
                                                required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-md" ng-show="formModels.buildingState.isRenovated()">
                                    <label class="col-sm-4 col-xs-12 control-label">
                                        {{formModels.fuelBurnedAmount.label}}:
                                    </label>
                                    <div class="col-sm-2 col-xs-5">
                                        <input type="number" class="form-control" name="fuelBurnedAmount"
                                            ng-model="formModels.fuelBurnedAmount.value"
                                            ng-change="formModels.fuelBurnedAmount.setValue()"
                                            min="{{formModels.fuelBurnedAmount.min}}"
                                            step="{{formModels.fuelBurnedAmount.step}}" ng-destroy required>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <select class="form-control" name="fuelBurnedAmountUnit"
                                            ng-model="formModels.fuelBurnedAmountUnit.selected"
                                            ng-options="i.displayName for i in formModels.fuelBurnedAmountUnit.filteredOptions track by i.id"
                                            ng-init="formModels.fuelBurnedAmountUnit.init()"
                                            ng-change="formModels.fuelBurnedAmountUnit.onChange()" ng-destroy required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- location -->
                        <div id="pumpsForm-step-location" class="tab-pane">
                            <div class="row">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.location.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.installationPostcode.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group no-arrow">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#installationPostcodeModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input type="text" id="postSeparationAdd" class="form-control" name="installationPostcode"
                                                ng-model="formModels.installationPostcode.value" 
                                                ng-change="formModels.installationPostcode.onChange()" maxlength="6"
                                                placeholder="__-___" data-plugin-masked-input data-input-mask="99-999"
                                                ng-destroy required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.installationClimateZone.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal"
                                                    data-target="#installationClimateZoneModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control"
                                                name="{{formModels.installationClimateZone.paramId}}"
                                                ng-model="formModels.installationClimateZone.selected"
                                                ng-options="i.displayName for i in formModels.installationClimateZone.options track by i.id"
                                                ng-init="formModels.installationClimateZone.init()"
                                                ng-change="formModels.installationClimateZone.onChange()"
                                                ng-focus="formModels.installationClimateZone.desc.visible = true"
                                                ng-blur="formModels.installationClimateZone.desc.visible = false"
                                                ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 hidden-xs"
                                        ng-show="formModels.installationClimateZone.desc.visible">
                                        <span ng-bind-html="formModels.installationClimateZone.desc.content"></span>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.installationClimateZone.isSelected()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.installationClosestCity.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <select class="form-control"
                                            name="{{formModels.installationClosestCity.paramId}}"
                                            ng-model="formModels.installationClosestCity.selected"
                                            ng-options="i.displayName for i in formModels.installationClosestCity.filteredOptions track by i.id"
                                            ng-init="formModels.installationClosestCity.init()"
                                            ng-change="formModels.installationClosestCity.onChange()" ng-destroy
                                            required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- summary -->
                        <div id="pumpsForm-step-summary" class="tab-pane">
                            <div class="row">
                                <div class="col-md-12 text-center mb-sm">
                                    <h2 class="heading-primary">
                                        <strong>Podsumowanie dotychczas zebranych danych:</strong>
                                    </h2>
                                </div>
                                <div class="col-md-7 col-sm-12">
                                    <!-- form summary -->
                                    <div ng-if="!isGroupHidden(groups.formOptions)">
                                        <h3 class="heading-primary text-center text-transform-none mb-xl">
                                            <strong>{{groups.formOptions.label}}:</strong>
                                        </h3>
                                        <div ng-repeat="group in groups.formOptions.groups"
                                            ng-if="!isGroupHidden(group)">
                                            <h5 class="heading-primary text-center text-transform-none mb-none"
                                                ng-show="group.label">
                                                <strong>{{group.label}}:</strong>
                                            </h5>
                                            <table class="table table-condensed-max table-no-border mb-none">
                                                <tbody>
                                                    <tr ng-repeat="param in group.models"
                                                        ng-hide="isParamHidden(param) || !paramHasValue(param)">
                                                        <td>
                                                            <small><strong>{{param.label.print || param.label || param.paramId}}:</strong></small>
                                                        </td>
                                                        <td width="45%" class="text-right"
                                                            style="vertical-align: bottom">
                                                            <small class="param-value">
                                                                <a class="param-edit-link"
                                                                    ng-click="goToParam(param.paramId)"
                                                                    ng-if="!param.summaryEditLinkHidden">
                                                                    <div class="fa fa-pencil-square-o"><img class="edit_ico" src ="<?php echo ZH_URL ?>assets/img/edit.svg"/></div>
                                                                </a>
                                                                {{getParamDisplayValue(param)}}
                                                                <span ng-bind-html="param.unit"
                                                                    ng-show="param.unit"></span>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr class="mt-sm mb-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12 additional-summary">
                                    <!-- additional summary info -->
                                    <div ng-if="!isGroupHidden(groups.summary)">
                                        <h3 class="heading-primary text-center text-transform-none mb-xl">
                                            <strong class="title1">{{groups.summary.label}}:</strong>
                                        </h3>
                                        <div ng-repeat="group in groups.summary.groups" ng-if="!isGroupHidden(group)">
                                            <h5 class="heading-primary text-center text-transform-none mb-none"
                                                ng-show="group.label">
                                                <strong class="title2">{{group.label}}:</strong>
                                            </h5>
                                            <table class="table table-condensed-max table-no-border mb-none">
                                                <tbody>
                                                    <tr ng-repeat="param in group.models"
                                                        ng-hide="isParamHidden(param) || !paramHasValue(param)">
                                                        <td>
                                                            <small><strong>{{param.label || param.paramId}}:</strong></small>
                                                        </td>
                                                        <td width="20%" class="text-right"
                                                            style="vertical-align: bottom">
                                                            <small>
                                                                {{getParamDisplayValue(param) | number: (param.resultPrecision || 0)}}
                                                                <span ng-bind-html="param.unit"
                                                                    ng-show="param.unit"></span>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr class="mt-sm mb-sm">
                                        </div>
                                    </div>
                                    <!-- info section -->
                                    <div
                                        class="summary-info call-to-action call-to-action-primary button-centered mt-xlg">
                                        <div class="call-to-action-content">
                                            <h4 class="mb-lg">
                                                W następnym kroku będziesz mógł złożyć <strong>zapytanie
                                                    ofertowe</strong>.
                                            </h4>
                                            <p class="mb-sm">
                                                Przed przejściem dalej sprawdź poprawność wprowadzonych danych i dokonaj
                                                korekty w razie pomyłki.
                                            </p>
                                            <div
                                                class="checkbox-custom checkbox-default font-size-sm line-height-sm input-group">
                                                <input type="checkbox" class="form-control"
                                                    name="formModels.confirmFormData"
                                                    ng-model="formModels.confirmFormData.value"
                                                    ng-change="formModels.confirmFormData.onChange()" ng-destroy
                                                    required>
                                                <label>
                                                    <span class="required">*</span>
                                                    {{formModels.confirmFormData.label.form}}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="call-to-action-btn mt-sm">
                                            <a ng-click="form.next()" class="btn btn-default">
                                                Dalej <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- user -->
                        <div id="pumpsForm-step-user" class="tab-pane">
                            <div class="row">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.contact.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.name.label}}
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="name"
                                            ng-model="formModels.name.value" ng-change="formModels.name.onChange()"
                                            ng-destroy>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-4 control-label">
                                        {{formModels.email.label}}
                                    </label>
                                    <div class="col-sm-3">
                                        <input id="email" type="email" class="form-control" name="email"
                                            ng-model="formModels.email.value" required="true" ng-change="formModels.email.onChange()"
                                            ng-destroy>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Telefon
                                    </label>
                                    <div class="col-sm-3">
                                        <input id="phoneSeparationAdd" type="text" class="form-control" name="phone"
                                            ng-model="formModels.phone.value" ng-change="formModels.phone.onChange()"
                                            placeholder="___-___-___" data-plugin-masked-input
                                            maxlength="11"
                                            data-input-mask="999-999-999" maxlength="9" ng-destroy>
                                    </div>
                                </div>
                                <div class="form-group mb-md">
                                    <label class="col-sm-4 control-label">
                                        Dodatkowe informacje dla działu pomp ciepła
                                    </label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="comment"
                                            ng-model="formModels.comment.value" ng-blur="formModels.comment.onChange()"
                                            ng-destroy rows="5">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">
                                    <h4><span class="badge badge-primary badge-text">{{groups.additional.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.complexApproach.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <a href="" data-toggle="modal" data-target="#complexApproachModal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select class="form-control" name="complexApproach"
                                                ng-model="formModels.complexApproach.selected"
                                                ng-options="i.displayName for i in formModels.complexApproach.options track by i.id"
                                                ng-init="formModels.complexApproach.init()"
                                                ng-change="formModels.complexApproach.onChange()" ng-destroy required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        <div
                                            class="checkbox-custom checkbox-default font-size-sm line-height-sm input-group">
                                            <input type="checkbox" class="form-control" name="accept_mailing"
                                                ng-model="formModels.accept_mailing.value"
                                                ng-change="formModels.accept_mailing.onChange()" ng-destroy required>
                                            <label for="accept_mailing">
                                                <span class="required">*</span> Wyrażam zgodę na otrzymanie oferty oraz
                                                informacji handlowych od Hewalex Sp. z o.o. Sp.k. za pośrednictwem maila
                                                oraz drogą sms-ową. Mam prawo cofnąć zgodę w każdym czasie (dane
                                                przetwarzane są do czasu cofnięcia zgody).
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        <div
                                            class="checkbox-custom checkbox-default font-size-sm line-height-sm input-group">
                                            <input type="checkbox" class="form-control" name="accept_data"
                                                ng-model="formModels.accept_data.value"
                                                ng-change="formModels.accept_data.onChange()" ng-destroy required>
                                            <label for="accept_data" class="label-tooltip-wide">
                                                <span class="required">*</span>
                                                Zapoznałem się z
                                                <span
                                                        class="tip_onhover text-decoration-underline"
                                                        data-plugin-tooltip=""
                                                        data-toggle="tooltip"
                                                        data-container="body"
                                                        data-placement="top"
                                                        data-html="true">
                                                        informacją o administratorze i przetwarzaniu danych.
                                                </span>

                                                <div class="tip_toshow">
                                                    <span class="tip_onclose">&#x2715;</span>
                                                    Administratorem danych osobowych jest HEWALEX Sp. z o.o. Sp.k. z siedzibą w Czechowicach-Dziedzicach, 43-502, ul. Słowackiego 33.<br><br>
                                                    Dane osobowe będą przetwarzane w celu przygotowania i realizacji umowy na podstawie art. 6 ust. 1 lit. b RODO.<br><br>
                                                    Informujemy o przysługującym prawie dostępu, sprostowania, usunięcia lub ograniczenia przetwarzania danych osobowych, a także o prawie wniesienia skargi.<br>
                                                    <br>Podanie danych osobowych jest dobrowolne, jednakże odmowa podania danych może skutkować odmową przygotowania i realizacji umowy.<br>
                                                    <br>Szczegółowe informacje znajdują się na stronie internetowej hewalex.pl/ochrona-danych.">informacją o administratorze i przetwarzaniu danych
                                                 </div>
                                                 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6 col-sm-offset-4">
                                        <button type="button" class="btn btn-primary" ng-click="form.send()">Wyślij
                                        </button>
                                        <label class="font-size-sm ml-sm">
                                            <span class="required">*</span> - pole wymagane
                                        </label>
                                        <div class="mt-sm">
                                            <label class="font-size-sm">
                                                Po wysłaniu zapytania otrzymasz możliwość pobrania wypełnionej ankiety.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" ng-show="form.showErrorMessage">
                                <div class="col-sm-12">
                                    <div class="alert alert-danger text-center p-xlg m-xlg">
                                        <h4 class="mb-none">
                                            Wystąpił nieoczekiwany błąd podczas wysyłania, spróbuj ponownie za kilka
                                            minut.
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- navigation -->
            <div class="card-footer" style="display: block;">
                <ul class="pager">
                    <li class="previous">
                        <a ng-click="form.previous()"><i class="fa fa-angle-left"></i> Wstecz</a>
                    </li>
                    <li class="next {{form.navigation.next.disabled ? 'disabled' : ''}}">
                        <a ng-click="form.next()">Dalej <i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
            </div>
        </section>
    </div>
    <!-- form summary -->
    <div ng-show="form.isFinished()" ng-cloak="" class="new-brand">
        <div class="alert alert-success text-center p-xlg m-xlg">
            <h1>Dziękujemy za skorzystanie z formularza.</h1>
            <h4 class="mb-xl text-primary-brand line-height-4">
                Wkrótce otrzymasz raport doboru na podany adres email.
                <br />W przypadku pytań skontaktuj się z działem technicznym pomp ciepła Hewalex*.
                <span>
                    <br /><strong>Podsumowanie wypełnionej ankiety</strong> dostępne jest do pobrania
                    <a href="{{form.getFormSummaryReportUrl()}}"><strong class="text-underline">tutaj</strong></a>
                </span>
            </h4>
            <h2 class="mb-xs mt-xlg">Dział pomp ciepła - <strong>(32) 214 17 10 wew. 180</strong></h2>
            <h2 class="mb-xl">Ogólny adres kontaktowy: <strong>pompyciepla@hewalex.pl</strong></h2>
            <button type="button" class="btn btn-primary-brand btn-xlg mb-xlg" ng-click="form.reset()">Rozpocznij od
                nowa
            </button>
            <h6 class="mt-xlg text-sm">*Standardowy czas przygotowania raportu zajmuje nie więcej niż 30 min. W
                wyjątkowych przypadkach przygotowanie raportu może potrwać do 48h.</h6>
        </div>
    </div>
    <!-- modals -->
    <div>
        <div ng-repeat="(modelId, model) in getAllModels()" ng-if="model.desc" class="modal fade"
            id="{{model.paramId || modelId}}Modal" tabindex="-1" role="dialog" style="display: none;">
            <div class="modal-dialog {{model.desc.modalSize}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">{{model.desc.title || model.paramId + '_title'}}</h4>
                    </div>
                    <div class="modal-body" ng-bind-html="model.desc.content || model.paramId + '_content'"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>