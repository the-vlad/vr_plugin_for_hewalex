<div id="pvSlcTool" ng-controller="pvSlcToolAppMainController" ng-init="app.setConfig({
    mode: 'development'
}); app.init()">
    <div class="container">
        <!-- entrance -->
        <div class="door hidden" ng-if="false" ng-init="app.isFriend()" ng-cloak>
            <div class="door-wing-left">
                <img src="<?php echo ZH_URL?>'/public/img/pv/calc/door-wing-left.png'; ?>">
            </div>
            <div class="door-wing-right">
                <img src="<?php echo ZH_URL?>'/public/img/pv/calc/door-wing-right.png'; ?>">
            </div>
            <div class="lock">
                <h4 class="mb-xs font-weight-semibold">Powiedz <span class="italic">przyjacielu</span> i wejdź:</h4>
                <input type="text" class="form-control text-center mb-xs" id="password" name="password"
                    ng-model="app.password" ng-change="app.isFriend()">
                <span>
                    To na nic? <a href="https://www.youtube.com/watch?v=DgHCM68KkPY&feature=youtu.be&t=224"
                        target="_blank" class="text-underline">link
                    </a>
                </span>
                <div class="author hidden-xs">
                    <span>Zrobiłem te drzwi ja, Dawid<br />w czasie wolnym od pracy.</span>
                </div>
            </div>
        </div>
        <!-- tool loading overlay -->
        <div class="row mt-lg" ng-hide="app.isInitialized()">
            <div class="col-sm-12 text-center">
                <hr class="tall">
                <div class="mb-md loader-calculator"></div>
                <div class="loading-overlay-showing" data-loading-overlay=""
                    data-loading-overlay-options="{ &quot;startShowing&quot;: true, &quot;css&quot;: { &quot;backgroundColor&quot;: &quot;#ffffff&quot; } }"
                    ng-show="!form.initialization.error">
                    <span>&nbsp;</span>
                </div>
                <div class="alert alert-danger" ng-show="app.hasInitError()" ng-cloak>
                    <span>{{app.messages.initError}}</span>
                </div>
                <hr class="tall">
            </div>
        </div>
        <!-- development info -->
        <div class="alert alert-dark text-center mt-xl" ng-if="app.isInitialized() && app.isDevMode()" ng-cloak>
            <span>Autoryzacja: </span>
            <span class="radio-custom radio-primary mr-sm" ng-repeat="i in auth.user.options">
                <input type="radio" name="userType" ng-checked="auth.user.isSelected(i.id)"
                    ng-click="auth.user.setUser(i.id)">
                <label>{{i.label}}</label>
            </span>
        </div>
        <!-- initial-info -->
        <section class="initial-info" ng-show="app.isInitialized()" ng-cloak>
            <div class="banner-html pvtool-main-banner">
                <img class="banner-img" src="<?php echo ZH_URL?>'public/images/pvslctool/tool/baner-glowna.jpg'; ?>">
                <div class="banner-content row ml-none mr-none">
                    <div class="col-md-1-5 col-xs-3 info-item">
                        <img class="img-responsive"
                            src="<?php echo ZH_URL?>'public/images/pvslctool/tool/ico-2.svg'; ?>">
                        <p class="color-primary mb-none">
                            <strong>Kompleksowa <br />oferta w 3 min. bez zobowiązań</strong>
                        </p>
                    </div>
                    <div class="col-md-1-5 col-xs-3 info-item">
                        <img class="img-responsive"
                            src="<?php echo ZH_URL?>'public/images/pvslctool/tool/ico-3.svg'; ?>">
                        <p class="color-primary mb-none">
                            <strong>Profesjonalny projekt <br />i wizualizacja w ramach usługi</strong>
                        </p>
                    </div>
                    <div class="col-md-1-5 hidden-sm hidden-xs"></div>
                    <div class="col-md-1-5 col-xs-3 info-item">
                        <img class="img-responsive"
                            src="<?php echo ZH_URL?>'/public/images/pvslctool/tool/ico-4.svg';?>">
                        <p class="color-primary mb-none">
                            <strong>Wsparcie na każdym <br />kroku realizacji <br
                                    class="visible-xl" />inwestycji</strong>
                        </p>
                    </div>
                    <div class="col-md-1-5 col-xs-3 info-item">
                        <img class="img-responsive"
                            src="<?php echo ZH_URL?>'public/images/pvslctool/tool/ico-6.svg';?>">
                        <p class="color-primary mb-none">
                            <strong>Zaufaj firmie <br />z 30-letnim doświadczeniem</strong>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- selection form -->
        <div class="slc-form-container" ng-controller="pvSlcFormController">
            <form id="pvSlcForm" class="form-horizontal" ng-show="app.isInitialized() && form.inProgress()" ng-cloak>
                <section class="card form-wizard">
                    <div class="card-body card-body-nopadding">
                        <!-- form steps -->
                        <div class="wizard-tabs">
                            <ul class="nav wizard-steps">
                                <li class="nav-item {{item.active ? 'active' : ''}}"
                                    ng-repeat="(key, item) in form.steps" ng-hide="item.hidden">
                                    <a href="{{item.href}}" class="nav-link text-center"
                                        ng-click="form.onTabClick($event, item.id)">
                                        <span class="badge">{{$index + 1}}</span>
                                        <span class="hidden-xs">{{item.displayName}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <!-- user -->
                            <div id="pvForm-step-user"
                                class="tab-pane {{form.isStepActive('user') ? 'active' : ''}} {{form.isStepHidden('user') ? 'hidden' : ''}}">
                                <div class="row">
                                    <!-- form section -->
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.clientType.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.clientType.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.clientType.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.clientType.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.clientType.paramId}}"
                                                            ng-model="formModels.clientType.selected"
                                                            ng-options="i.displayName for i in formModels.clientType.options track by i.id"
                                                            ng-init="formModels.clientType.init()"
                                                            ng-change="formModels.clientType.onChange()" ng-destroy
                                                            required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.clientType.isCompany()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.companyVatDeduct.label.form}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.companyVatDeduct.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.companyVatDeduct.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.companyVatDeduct.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.companyVatDeduct.paramId}}"
                                                            ng-model="formModels.companyVatDeduct.selected"
                                                            ng-options="i.displayName for i in formModels.companyVatDeduct.options track by i.id"
                                                            ng-init="formModels.companyVatDeduct.init()"
                                                            ng-change="formModels.companyVatDeduct.onChange()"
                                                            ng-destroy required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.region.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.region.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.region.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.region.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.region.paramId}}"
                                                            ng-model="formModels.region.selected"
                                                            ng-options="i.displayName for i in formModels.region.options track by i.id"
                                                            ng-init="formModels.region.init()"
                                                            ng-change="formModels.region.onChange()" ng-destroy
                                                            required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- info section -->
                                    <div class="col-md-3 col-md-offset-1 col-sm-4">
                                        <div class="featured-box featured-box-primary featured-box-text-left appear-animation fadeIn appear-animation-visible"
                                            data-appear-animation-delay="100" data-appear-animation="fadeIn"
                                            ng-hide="slcModels.locationSunEnergyOnGround.isHidden()">
                                            <div class="box-content text-right">
                                                <div class="summary-item">
                                                    <h6 class="mb-none">
                                                        {{slcModels.locationSunEnergyOnGround.label}}:
                                                    </h6>
                                                    <h1 class="mb-none">
                                                        {{slcModels.locationSunEnergyOnGround.value | number: (slcModels.locationSunEnergyOnGround.precision || 0)}}
                                                        <small
                                                            ng-bind-html="slcModels.locationSunEnergyOnGround.unit"></small>
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 mt-lg text-center">
                                        <span style="font-size-lg"><a class="popup-youtube"
                                                href="http://www.youtube.com/watch?v=9AmE-lNnwvI"><img
                                                    src="<?php echo ZH_URL . '/public/img/pv/lightbulb-ico.png';?>"
                                                    class="mr-sm"><strong><span class="text-black">Potrzebujesz pomocy w
                                                        uzupełnieniu formularza? Skorzystaj z poradnika </span>
                                                    &gt;&gt;&gt;&gt;&gt;</strong></a></span>
                                    </div>
                                </div>
                            </div>
                            <!-- energy -->
                            <div id="pvForm-step-energy"
                                class="tab-pane {{form.isStepActive('energy') ? 'active' : ''}} {{form.isStepHidden('energy') ? 'hidden' : ''}}">
                                <div class="row">
                                    <!-- form section -->
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.countByType.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.countByType.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.countByType.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.countByType.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.countByType.paramId}}"
                                                            ng-model="formModels.countByType.selected"
                                                            ng-options="i.displayName for i in formModels.countByType.options track by i.id"
                                                            ng-init="formModels.countByType.init()"
                                                            ng-change="formModels.countByType.onChange()" ng-destroy
                                                            required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.countByType.isByBills()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.energyPeriodUnit.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.energyPeriodUnit.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.energyPeriodUnit.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.energyPeriodUnit.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.energyPeriodUnit.paramId}}"
                                                            ng-model="formModels.energyPeriodUnit.selected"
                                                            ng-options="i.displayName for i in formModels.energyPeriodUnit.options track by i.id"
                                                            ng-init="formModels.energyPeriodUnit.init()"
                                                            ng-change="formModels.energyPeriodUnit.onChange()"
                                                            ng-destroy required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.countByType.isByBills()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.energyUsageInPeriod.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.energyUsageInPeriod.modal || formModels.energyUsageInPeriod.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.energyUsageInPeriod.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.energyUsageInPeriod.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.energyUsageInPeriod.paramId}}"
                                                            ng-model="formModels.energyUsageInPeriod.value"
                                                            ng-change="formModels.energyUsageInPeriod.onChange()"
                                                            min="{{formModels.energyUsageInPeriod.min}}" ng-destroy
                                                            required>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.energyUsageInPeriod.unit">
                                                            <span
                                                                ng-bind-html="formModels.energyUsageInPeriod.unit"></span>
                                                        </span>
                                                    </div>
                                                    <div class="text-info"
                                                        ng-show="slcModels.energyUsageByYear.isOverLimit()">
                                                        <small>{{formModels.energyUsageInPeriod.modelPs}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.countByType.isByBills()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.energyCostInPeriod.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.energyCostInPeriod.modal || formModels.energyCostInPeriod.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.energyCostInPeriod.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.energyCostInPeriod.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.energyCostInPeriod.paramId}}"
                                                            ng-model="formModels.energyCostInPeriod.value"
                                                            ng-change="formModels.energyCostInPeriod.onChange()"
                                                            min="{{formModels.energyCostInPeriod.min}}" ng-destroy
                                                            required>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.energyCostInPeriod.unit">
                                                            <span
                                                                ng-bind-html="formModels.energyCostInPeriod.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.countByType.isByPeopleCount()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.flatPeopleCount.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.flatPeopleCount.modal || formModels.flatPeopleCount.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.flatPeopleCount.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.flatPeopleCount.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.flatPeopleCount.paramId}}"
                                                            ng-model="formModels.flatPeopleCount.value"
                                                            ng-change="formModels.flatPeopleCount.onChange()"
                                                            min="{{formModels.flatPeopleCount.min}}"
                                                            max="{{formModels.flatPeopleCount.max}}" ng-destroy
                                                            required>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.flatPeopleCount.unit">
                                                            <span ng-bind-html="formModels.flatPeopleCount.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.countByType.isByPeopleCount()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.energyCostDistibutor.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.energyCostDistibutor.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.energyCostDistibutor.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.energyCostDistibutor.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.energyCostDistibutor.paramId}}"
                                                            ng-model="formModels.energyCostDistibutor.selected"
                                                            ng-options="i.displayName for i in formModels.energyCostDistibutor.options track by i.id"
                                                            ng-init="formModels.energyCostDistibutor.init()"
                                                            ng-change="formModels.energyCostDistibutor.onChange()"
                                                            ng-destroy required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- info section -->
                                    <div class="col-md-3 col-md-offset-1 col-sm-4">
                                        <div class="featured-box featured-box-primary featured-box-text-left appear-animation fadeIn appear-animation-visible"
                                            data-appear-animation-delay="100" data-appear-animation="fadeIn" ng-hide="slcModels.energyUsageByYear.isHidden()
                                                && slcModels.energyCostByYear.isHidden()
                                                && slcModels.totalKwhCosts.isHidden()">
                                            <div class="box-content text-right">
                                                <div class="summary-item"
                                                    ng-hide="slcModels.energyUsageByYear.isHidden()">
                                                    <h6 class="mb-none">
                                                        {{slcModels.energyUsageByYear.label}}:
                                                    </h6>
                                                    <h1 class="mb-none">
                                                        {{slcModels.energyUsageByYear.value}}
                                                        <small ng-bind-html="slcModels.energyUsageByYear.unit"></small>
                                                    </h1>
                                                </div>
                                                <div class="summary-item"
                                                    ng-hide="slcModels.energyCostByYear.isHidden()">
                                                    <h6 class="mb-none">
                                                        {{slcModels.energyCostByYear.label}}
                                                        {{slcModels.energyCostByYear.labelTax}}:
                                                    </h6>
                                                    <h1 class="mb-none">
                                                        {{slcModels.energyCostByYear.getGrossValue() | number: (slcModels.energyCostByYear.precision || 0)}}
                                                        <small ng-bind-html="slcModels.energyCostByYear.unit"></small>
                                                    </h1>
                                                </div>
                                                <div class="summary-item" ng-hide="slcModels.totalKwhCosts.isHidden()">
                                                    <h6 class="mb-none">
                                                        {{slcModels.totalKwhCosts.label}}
                                                        {{slcModels.totalKwhCosts.labelTax}}:
                                                    </h6>
                                                    <h1 class="mb-none">
                                                        {{slcModels.totalKwhCosts.getGrossValue() | number: (slcModels.totalKwhCosts.precision || 0)}}
                                                        <small ng-bind-html="slcModels.totalKwhCosts.unit"></small>
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- building -->
                            <div id="pvForm-step-building"
                                class="tab-pane {{form.isStepActive('building') ? 'active' : ''}} {{form.isStepHidden('building') ? 'hidden' : ''}}">
                                <div class="row">
                                    <!-- form section -->
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.buildingOrientation.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.buildingOrientation.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.buildingOrientation.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.buildingOrientation.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.buildingOrientation.paramId}}"
                                                            ng-model="formModels.buildingOrientation.selected"
                                                            ng-options="i.displayName for i in formModels.buildingOrientation.options track by i.id"
                                                            ng-init="formModels.buildingOrientation.init()"
                                                            ng-change="formModels.buildingOrientation.onChange()"
                                                            ng-destroy required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="auth.user.isHewalexWorker()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.buildingSurface.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.buildingSurface.modal || formModels.buildingSurface.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.buildingSurface.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.buildingSurface.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.buildingSurface.paramId}}"
                                                            ng-model="formModels.buildingSurface.value"
                                                            ng-change="formModels.buildingSurface.onChange()"
                                                            min="{{formModels.buildingSurface.min}}" ng-destroy>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.buildingSurface.unit">
                                                            <span ng-bind-html="formModels.buildingSurface.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.montagePlace.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.montagePlace.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.montagePlace.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.montagePlace.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.montagePlace.paramId}}"
                                                            ng-model="formModels.montagePlace.selected"
                                                            ng-options="i.displayName for i in formModels.montagePlace.options track by i.id"
                                                            ng-init="formModels.montagePlace.init()"
                                                            ng-change="formModels.montagePlace.onChange()" ng-destroy
                                                            required>
                                                        </select>
                                                    </div>
                                                    <div class="text-info"
                                                        ng-show="formModels.montagePlace.isFlat() || formModels.montagePlace.isGround()">
                                                        <small>{{formModels.montagePlace.modelPs}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.montagePlace.isSlanted()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.roofAngle.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.roofAngle.modal || formModels.roofAngle.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.roofAngle.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.roofAngle.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.roofAngle.paramId}}"
                                                            ng-model="formModels.roofAngle.selected"
                                                            ng-options="i.displayName for i in formModels.roofAngle.options track by i.id"
                                                            ng-init="formModels.roofAngle.init()"
                                                            ng-change="formModels.roofAngle.onChange()" ng-destroy
                                                            required>
                                                        </select>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.roofAngle.unit">
                                                            <span ng-bind-html="formModels.roofAngle.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.montagePlace.isSlanted()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.montageSystemType.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.montageSystemType.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.montageSystemType.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.montageSystemType.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.montageSystemType.paramId}}"
                                                            ng-model="formModels.montageSystemType.selected"
                                                            ng-options="i.displayName for i in formModels.montageSystemType.filteredOptions track by i.id"
                                                            ng-init="formModels.montageSystemType.init()"
                                                            ng-change="formModels.montageSystemType.onChange()"
                                                            ng-destroy required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"
                                                ng-show="formModels.montagePlace.isSlanted() && formModels.montageSystemType.isCustom()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.customMontageSystemType.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <label class="control-label mb-xs" style="text-align: left"
                                                        ng-hide="formModels.customMontageSystemType.hasAny()">
                                                        (brak)
                                                    </label>
                                                    <div class="products-table"
                                                        ng-show="formModels.customMontageSystemType.hasAny()">
                                                        <div class="row header mt-xs">
                                                            <div class="col-xs-2 pr-none">
                                                                <span class="form-control input-sm">#</span>
                                                            </div>
                                                            <div class="col-xs-7 p-none">
                                                                <span class="form-control input-sm">System
                                                                    montażowy</span>
                                                            </div>
                                                            <div class="col-xs-3 pl-none">
                                                                <span class="form-control input-sm">Ilość</span>
                                                            </div>
                                                        </div>
                                                        <div class="items">
                                                            <div class="row item"
                                                                ng-repeat="(index, item) in formModels.customMontageSystemType.items track by $index">
                                                                <div class="col-xs-2 pr-none">
                                                                    <span
                                                                        class="form-control input-sm item-id">{{index + 1}}.</span>
                                                                    <span class="form-control input-sm item-actions">
                                                                        <i class="item-action fa fa-times"
                                                                            ng-click="formModels.customMontageSystemType.removeItem(index)"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="col-xs-7 p-none">
                                                                    <select class="form-control input-sm"
                                                                        name="cmst_{{formModels.customMontageSystemType.items[index]}}"
                                                                        ng-model="formModels.customMontageSystemType.items[index]"
                                                                        ng-options="i.name for i in formModels.customMontageSystemType.options track by i.id"
                                                                        ng-change="formModels.customMontageSystemType.onItemChange(index)"
                                                                        required>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-3 pl-none">
                                                                    <input class="form-control input-sm" type="number"
                                                                        name="cmst_{{formModels.customMontageSystemType.items[index]}}_qty"
                                                                        ng-model="formModels.customMontageSystemType.items[index].quantity"
                                                                        ng-change="formModels.customMontageSystemType.onItemChange(index)"
                                                                        min="1" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-primary btn-block"
                                                                ng-click="formModels.customMontageSystemType.addItem()">
                                                                Dodaj pozycję
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- info section -->
                                    <div class="col-md-3 col-md-offset-1 col-sm-4">
                                        <div class="featured-box featured-box-primary featured-box-text-left appear-animation fadeIn appear-animation-visible"
                                            data-appear-animation-delay="100" data-appear-animation="fadeIn"
                                            ng-show="formModels.montagePlace.isSlanted() && formModels.montageSystemType.isCustom()">
                                            <div class="box-content text-right">
                                                <div class="summary-item">
                                                    <h6 class="mb-none">
                                                        {{formModels.panelQuantity.label}}:
                                                    </h6>
                                                    <h1 class="mb-none">
                                                        {{formModels.panelQuantity.value}}
                                                        <small ng-bind-html="formModels.panelQuantity.unit"></small>
                                                    </h1>
                                                </div>
                                                <div class="summary-item">
                                                    <h6 class="mb-none">
                                                        {{slcModels.totalMontageSystemsItemsQty.label}}:
                                                    </h6>
                                                    <h1 class="mb-none">
                                                        {{formModels.totalMontageSystemsItemsQty.value}}
                                                        <small
                                                            ng-bind-html="slcModels.totalMontageSystemsItemsQty.unit"></small>
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- installation -->
                            <div id="pvForm-step-installation"
                                class="tab-pane {{form.isStepActive('installation') ? 'active' : ''}} {{form.isStepHidden('installation') ? 'hidden' : ''}}">
                                <div class="row">
                                    <!-- form section -->
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.panelType.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.panelType.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.panelType.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.panelType.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.panelType.paramId}}"
                                                            ng-model="formModels.panelType.selected"
                                                            ng-options="i.displayName for i in formModels.panelType.options
                                                                | filter: formModels.panelType.isOptionVisible track by i.id"
                                                            ng-init="formModels.panelType.init()"
                                                            ng-change="formModels.panelType.onChange()" ng-destroy
                                                            required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.adjustInstallationToUsage.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.adjustInstallationToUsage.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.adjustInstallationToUsage.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.adjustInstallationToUsage.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.adjustInstallationToUsage.paramId}}"
                                                            ng-model="formModels.adjustInstallationToUsage.selected"
                                                            ng-options="i.displayName for i in formModels.adjustInstallationToUsage.options track by i.id"
                                                            ng-init="formModels.adjustInstallationToUsage.init()"
                                                            ng-change="formModels.adjustInstallationToUsage.onChange()"
                                                            ng-destroy required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"
                                                ng-show="formModels.adjustInstallationToUsage.yes()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.panelQuantity.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.panelQuantity.modal || formModels.panelQuantity.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.panelQuantity.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.panelQuantity.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input name="{{formModels.panelQuantity.paramId}}" type="number"
                                                            class="spinner-input form-control" readonly="readonly"
                                                            step="1" ng-model="formModels.panelQuantity.value"
                                                            ng-change="formModels.panelQuantity.onChange()"
                                                            min="{{formModels.panelQuantity.min}}"
                                                            max="{{formModels.panelQuantity.max}}" ng-destroy required>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.panelQuantity.unit">
                                                            <span ng-bind-html="formModels.panelQuantity.unit"></span>
                                                        </span>
                                                        <div class="spinner-buttons input-group-btn btn-group-vertical">
                                                            <button type="button"
                                                                class="btn spinner-up btn-xs btn-default"
                                                                ng-click="formModels.panelQuantity.increment()">
                                                                <i class="fa fa-angle-up"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn spinner-down btn-xs btn-default"
                                                                ng-click="formModels.panelQuantity.decrement()">
                                                                <i class="fa fa-angle-down"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"
                                                ng-show="formModels.adjustInstallationToUsage.yes()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.inverterType.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.inverterType.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.inverterType.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.inverterType.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.inverterType.paramId}}"
                                                            ng-model="formModels.inverterType.selected"
                                                            ng-options="i.displayName disable when i.disabled for i in formModels.inverterType.options track by i.id"
                                                            ng-init="formModels.inverterType.init()"
                                                            ng-change="formModels.inverterType.onChange()" ng-destroy
                                                            required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"
                                                ng-show="formModels.adjustInstallationToUsage.yes() && auth.user.isHewalexWorker()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.wireType.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.wireType.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.wireType.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.wireType.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.wireType.paramId}}"
                                                            ng-model="formModels.wireType.selected"
                                                            ng-options="i.displayName disable when i.disabled for i in formModels.wireType.options track by i.id"
                                                            ng-init="formModels.wireType.init()"
                                                            ng-change="formModels.wireType.onChange()" ng-destroy
                                                            required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- info section -->
                                    <div class="col-sm-4">
                                        <div class="featured-box featured-box-primary featured-box-text-left appear-animation fadeIn appear-animation-visible"
                                            data-appear-animation-delay="100" data-appear-animation="fadeIn">
                                            <div class="box-content">
                                                <div class="row" ng-show="formModels.adjustInstallationToUsage.yes()">
                                                    <div class="col-xs-6 text-center">
                                                        <h5>{{formGroups.installationStepSummary.label.hewalex}}</h5>
                                                    </div>
                                                    <div
                                                        class="col-xs-{{formModels.adjustInstallationToUsage.yes() ? '6' : '12'}} text-center">
                                                        <h5>{{formGroups.installationStepSummary.label.user}}</h5>
                                                    </div>
                                                </div>
                                                <div class="summary-item"
                                                    ng-repeat="model in formGroups.installationStepSummary.models">
                                                    <div
                                                        class="text-{{formModels.adjustInstallationToUsage.yes() ? 'center' : 'right'}}">
                                                        <h6 class="mb-none">{{model.label}}:</h6>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-6 text-{{formModels.adjustInstallationToUsage.yes() ? 'center' : 'right'}}"
                                                            ng-show="formModels.adjustInstallationToUsage.yes()">
                                                            <h3 class="mb-none text-transform-none">
                                                                {{model.defaultValue | number: (model.precision || 0)}}
                                                                <small ng-bind-html="model.unit"></small>
                                                            </h3>
                                                        </div>
                                                        <div
                                                            class="col-xs-{{formModels.adjustInstallationToUsage.yes() ? '6' : '12'}} text-{{formModels.adjustInstallationToUsage.yes() ? 'center' : 'right'}}">
                                                            <h3 class="mb-none text-transform-none">
                                                                {{getParamDisplayValue(model) | number: (model.precision || 0)}}
                                                                <small ng-bind-html="model.unit"></small>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- customizations -->
                            <div id="pvForm-step-customizations"
                                class="tab-pane {{form.isStepActive('customizations') ? 'active' : ''}} {{form.isStepHidden('customizations') ? 'hidden' : ''}}">
                                <div class="row">
                                    <!-- form section -->
                                    <div class="col-md-8">
                                        <div class="row">
                                            <!-- rebate -->
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.rebateType.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.rebateType.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.rebateType.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.rebateType.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.rebateType.paramId}}"
                                                            ng-model="formModels.rebateType.selected"
                                                            ng-options="i.displayName for i in formModels.rebateType.options track by i.id"
                                                            ng-init="formModels.rebateType.init()"
                                                            ng-change="formModels.rebateType.onChange()" ng-destroy>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.rebateType.isPrecent()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.rebatePrecent.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.rebatePrecent.modal || formModels.rebatePrecent.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.rebatePrecent.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.rebatePrecent.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.rebatePrecent.paramId}}"
                                                            ng-model="formModels.rebatePrecent.value"
                                                            ng-change="formModels.rebatePrecent.onChange()"
                                                            min="{{formModels.rebatePrecent.min}}"
                                                            max="{{formModels.rebatePrecent.max}}" ng-destroy required>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.rebatePrecent.unit">
                                                            <span ng-bind-html="formModels.rebatePrecent.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.rebateType.isAmount()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.rebateAmount.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.rebateAmount.modal || formModels.rebateAmount.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.rebateAmount.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.rebateAmount.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.rebateAmount.paramId}}"
                                                            ng-model="formModels.rebateAmount.value"
                                                            ng-change="formModels.rebateAmount.onChange()"
                                                            min="{{formModels.rebateAmount.min}}"
                                                            max="{{formModels.rebateAmount.max}}" ng-destroy required>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.rebateAmount.unit">
                                                            <span ng-bind-html="formModels.rebateAmount.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- profit margin -->
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.profitMarginType.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="{{formModels.profitMarginType.modal ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.profitMarginType.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.profitMarginType.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <select class="form-control"
                                                            name="{{formModels.profitMarginType.paramId}}"
                                                            ng-model="formModels.profitMarginType.selected"
                                                            ng-options="i.displayName for i in formModels.profitMarginType.options track by i.id"
                                                            ng-init="formModels.profitMarginType.init()"
                                                            ng-change="formModels.profitMarginType.onChange()"
                                                            ng-destroy>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.profitMarginType.isPrecent()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.profitMarginPrecent.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.profitMarginPrecent.modal || formModels.profitMarginPrecent.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.profitMarginPrecent.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.profitMarginPrecent.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.profitMarginPrecent.paramId}}"
                                                            ng-model="formModels.profitMarginPrecent.value"
                                                            ng-change="formModels.profitMarginPrecent.onChange()"
                                                            min="{{formModels.profitMarginPrecent.min}}"
                                                            max="{{formModels.profitMarginPrecent.max}}" ng-destroy
                                                            required>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.profitMarginPrecent.unit">
                                                            <span
                                                                ng-bind-html="formModels.profitMarginPrecent.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="formModels.profitMarginType.isAmount()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.profitMarginAmount.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.profitMarginAmount.modal || formModels.profitMarginAmount.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.profitMarginAmount.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.profitMarginAmount.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.profitMarginAmount.paramId}}"
                                                            ng-model="formModels.profitMarginAmount.value"
                                                            ng-change="formModels.profitMarginAmount.onChange()"
                                                            min="{{formModels.profitMarginAmount.min}}" ng-destroy
                                                            required>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.profitMarginAmount.unit">
                                                            <span
                                                                ng-bind-html="formModels.profitMarginAmount.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- installer modifications -->
                                            <div class="form-group" ng-show="auth.user.isInstaller()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.montageCost.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.montageCost.modal || formModels.montageCost.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.montageCost.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.montageCost.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.montageCost.paramId}}"
                                                            ng-model="formModels.montageCost.value"
                                                            ng-change="formModels.montageCost.onChange()"
                                                            min="{{formModels.montageCost.min}}" ng-destroy>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.montageCost.unit">
                                                            <span ng-bind-html="formModels.montageCost.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="auth.user.isInstaller()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.deliveryCost.label}}:
                                                </label>
                                                <div class="col-sm-6">
                                                    <div class="{{formModels.deliveryCost.modal || formModels.deliveryCost.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.deliveryCost.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.deliveryCost.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.deliveryCost.paramId}}"
                                                            ng-model="formModels.deliveryCost.value"
                                                            ng-change="formModels.deliveryCost.onChange()"
                                                            min="{{formModels.deliveryCost.min}}" ng-destroy>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.deliveryCost.unit">
                                                            <span ng-bind-html="formModels.deliveryCost.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- custom products -->
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    Dodatkowe produkty/usługi:
                                                </label>
                                                <label class="col-sm-6 control-label" style="text-align: left"
                                                    ng-hide="basket.hasCustomProducts()">
                                                    (brak)
                                                </label>
                                                <div class="col-sm-12 products-table">
                                                    <div class="row header mt-xs" ng-show="basket.hasCustomProducts()">
                                                        <div class="col-xs-1 pr-none">
                                                            <span class="form-control input-sm">#</span>
                                                        </div>
                                                        <div class="col-xs-2 p-none" ng-hide="auth.user.isInstaller()">
                                                            <span class="form-control input-sm">Nr kat.</span>
                                                        </div>
                                                        <div
                                                            class="col-xs-{{auth.user.isInstaller() ? '9' : '5'}} p-none">
                                                            <span class="form-control input-sm">Nazwa</span>
                                                        </div>
                                                        <div class="col-xs-2 p-none" ng-hide="auth.user.isInstaller()">
                                                            <span class="form-control input-sm">Cena/j.m.</span>
                                                        </div>
                                                        <div class="col-xs-1 p-none">
                                                            <span class="form-control input-sm">Ilość</span>
                                                        </div>
                                                        <div class="col-xs-1 pl-none">
                                                            <span class="form-control input-sm">j.m.</span>
                                                        </div>
                                                    </div>
                                                    <div class="items">
                                                        <div class="row item"
                                                            ng-repeat="(index, item) in basket.customItems">
                                                            <div class="col-xs-1 pr-none">
                                                                <span
                                                                    class="form-control input-sm item-id">{{index + 1}}.</span>
                                                                <span class="form-control input-sm item-actions">
                                                                    <i class="item-action fa fa-times"
                                                                        ng-click="basket.removeCustomProduct(item.id)"></i>
                                                                </span>
                                                            </div>
                                                            <div class="col-xs-2 p-none"
                                                                ng-hide="auth.user.isInstaller()">
                                                                <input class="form-control input-sm" type="text"
                                                                    name="{{basket.customItems[index].code}}"
                                                                    ng-model="basket.customItems[index].code"
                                                                    ng-change="basket.onCustomProductChange()" required>
                                                            </div>
                                                            <div
                                                                class="col-xs-{{auth.user.isInstaller() ? '9' : '5'}} p-none">
                                                                <input class="form-control input-sm" type="text"
                                                                    name="{{basket.customItems[index].name}}"
                                                                    ng-model="basket.customItems[index].name" required>
                                                            </div>
                                                            <div class="col-xs-2 p-none"
                                                                ng-hide="auth.user.isInstaller()">
                                                                <input class="form-control input-sm" type="number"
                                                                    name="{{basket.customItems[index].price}}"
                                                                    ng-model="basket.customItems[index].price"
                                                                    ng-change="basket.onCustomProductChange()" min="0"
                                                                    required>
                                                            </div>
                                                            <div class="col-xs-1 p-none">
                                                                <input class="form-control input-sm" type="number"
                                                                    name="{{basket.customItems[index].sum}}"
                                                                    ng-model="basket.customItems[index].sum"
                                                                    ng-change="basket.onCustomProductChange()" min="1"
                                                                    required>
                                                            </div>
                                                            <div class="col-xs-1 pl-none">
                                                                <input class="form-control input-sm" type="text"
                                                                    name="{{basket.customItems[index].unit}}"
                                                                    ng-model="basket.customItems[index].unit" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-sm">
                                                        <div class="col-md-12 mb-xs">
                                                            <select class="form-control"
                                                                ng-model="products.list.selected"
                                                                ng-options="i.name for i in products.list.options track by i.id"
                                                                ng-change="products.list.onChange()"
                                                                ng-show="products.list.visible">
                                                            </select>
                                                            <button type="button" class="btn btn-primary btn-block"
                                                                ng-click="products.list.show()"
                                                                ng-show="products.list.addBtn.visible">
                                                                Dodaj pozycję z listy
                                                            </button>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-primary btn-block"
                                                                ng-click="basket.addCustomProduct()">
                                                                Dodaj pozycję ręcznie
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- offer terms -->
                                            <div class="form-group"
                                                ng-show="auth.user.isInstaller() || auth.user.isHewalexWorker()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.offerValidPeriod.label}}:
                                                </label>
                                                <div class="col-sm-3">
                                                    <div class="{{formModels.offerValidPeriod.modal || formModels.offerValidPeriod.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.offerValidPeriod.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.offerValidPeriod.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.offerValidPeriod.paramId}}"
                                                            ng-model="formModels.offerValidPeriod.value"
                                                            ng-init="formModels.offerValidPeriod.init()"
                                                            ng-change="formModels.offerValidPeriod.onChange()" required>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.offerValidPeriod.unit">
                                                            <span
                                                                ng-bind-html="formModels.offerValidPeriod.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"
                                                ng-show="auth.user.isInstaller() || auth.user.isHewalexWorker()">
                                                <label class="col-sm-6 control-label">
                                                    {{formModels.orderDeadline.label}}:
                                                </label>
                                                <div class="col-sm-3">
                                                    <div class="{{formModels.orderDeadline.modal || formModels.orderDeadline.unit
                                                        ? 'input-group' : 'input-control'}}">
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.orderDeadline.modal">
                                                            <a href="" data-toggle="modal"
                                                                data-target="#{{formModels.orderDeadline.paramId}}Modal">
                                                                <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                            </a>
                                                        </span>
                                                        <input type="number" class="form-control"
                                                            name="{{formModels.orderDeadline.paramId}}"
                                                            ng-model="formModels.orderDeadline.value"
                                                            ng-init="formModels.orderDeadline.init()"
                                                            ng-change="formModels.orderDeadline.onChange()" required>
                                                        <span class="input-group-addon"
                                                            ng-show="formModels.orderDeadline.unit">
                                                            <span ng-bind-html="formModels.orderDeadline.unit"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" ng-show="auth.user.isHewalexWorker()">
                                                <label class="col-sm-6 control-label">
                                                    Dodatkowe warunki oferty:
                                                </label>
                                                <label class="col-sm-6 control-label" style="text-align: left"
                                                    ng-hide="offerTerms.custom.hasAny()">
                                                    (brak)
                                                </label>
                                                <div class="col-sm-12 products-table">
                                                    <div class="row header mt-xs" ng-show="offerTerms.custom.hasAny()">
                                                        <div class="col-xs-1 pr-none">
                                                            <span class="form-control input-sm">#</span>
                                                        </div>
                                                        <div class="col-xs-11 pl-none">
                                                            <span class="form-control input-sm">Treść</span>
                                                        </div>
                                                    </div>
                                                    <div class="items">
                                                        <div class="row item"
                                                            ng-repeat="(index, item) in offerTerms.custom.items">
                                                            <div class="col-xs-1 pr-none">
                                                                <span
                                                                    class="form-control input-sm item-id">{{index + 1}}.</span>
                                                                <span class="form-control input-sm item-actions">
                                                                    <i class="item-action fa fa-times"
                                                                        ng-click="offerTerms.custom.remove(item.id)"></i>
                                                                </span>
                                                            </div>
                                                            <div class="col-xs-11 pl-none">
                                                                <input class="form-control input-sm" type="text"
                                                                    name="{{offerTerms.custom.items[index].value}}"
                                                                    ng-model="offerTerms.custom.items[index].value"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-sm">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-primary btn-block"
                                                                ng-click="offerTerms.custom.add()">
                                                                Dodaj pozycję
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- info section -->
                                    <div class="col-md-4">
                                        <div class="featured-box featured-box-primary featured-box-text-left">
                                            <div class="box-content text-right">
                                                <div class="summary-item">
                                                    <h6 class="mb-none">Kwota całkowita netto:</h6>
                                                    <h1 class="mb-none">
                                                        {{slcModels.totalPrice.getNetValue() | number: slcModels.totalPrice.precision || 0}}
                                                        <small ng-bind-html="slcModels.totalPrice.unit"></small>
                                                    </h1>
                                                </div>
                                                <div class="summary-item">
                                                    <h6 class="mb-none">Kwota całkowita brutto:</h6>
                                                    <h1 class="mb-none">
                                                        {{slcModels.totalPrice.getGrossValue() | number: slcModels.totalPrice.precision || 0}}
                                                        <small ng-bind-html="slcModels.totalPrice.unit"></small>
                                                    </h1>
                                                </div>
                                                <div class="summary-item">
                                                    <h6 class="mb-none">Stawka {{slcModels.tax.label}}:</h6>
                                                    <h1 class="mb-none">
                                                        {{slcModels.tax.value.price}}
                                                        <small ng-bind-html="slcModels.tax.unit"></small>
                                                    </h1>
                                                </div>
                                                <div class="summary-item" ng-show="auth.user.isHewalexWorker()">
                                                    <h6 class="mb-none">Zestawienie produktów dobranych<br />przez
                                                        Kreator:</h6>
                                                    <table class="table table-condensed-max products-table mb-none"
                                                        ng-show="basket.hasProducts()">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center pb-xs">Nazwa</th>
                                                                <th class="text-center pb-xs" style="width: 20%">Ilość
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="(index, item) in basket.items">
                                                                <td class="text-center">
                                                                    <span
                                                                        ng-bind-html="basket.items[index].name"></span>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control input-sm" type="number"
                                                                        name="{{basket.items[index].sum}}"
                                                                        ng-model="basket.items[index].sum"
                                                                        ng-change="basket.onProductChange()" min="0"
                                                                        required ng-readonly="!item.editable.sum">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- analyze -->
                            <div id="pvForm-step-analyze"
                                class="tab-pane {{form.isStepActive('analyze') ? 'active' : ''}} {{form.isStepHidden('analyze') ? 'hidden' : ''}}">
                                <div class="row">
                                    <div class="col-md-7 col-sm-12">
                                        <!-- analyze control panel -->
                                        <div class="panel panel-default financing-panel mb-none">
                                            <div class="panel-heading">
                                                <span>
                                                    <h3 class="p-md pt-sm pl-xl mb-none">
                                                        <small>
                                                            <big>
                                                                <i class="fa fa-database color-primary"></i>
                                                            </big>
                                                            {{formModels.analyzeBase.label}}:
                                                        </small>
                                                        <span class="pull-right">
                                                            <small>
                                                                <a href="" data-toggle="modal"
                                                                    data-target="#{{formModels.analyzeBase.paramId}}Modal">
                                                                    <i
                                                                        class="fa fa-info-circle ico__info text-info font-size-xl mr-xs"></i>
                                                                </a>
                                                                {{formModels.analyzeBase.selected.displayName}}
                                                            </small>
                                                        </span>
                                                    </h3>
                                                </span>
                                            </div>
                                            <div class="panel-body mb-sm">
                                                <div class="row">
                                                    <!-- main financing -->
                                                    <div class="form-group">
                                                        <label class="col-sm-6 control-label">
                                                            {{formModels.financingType.label}}:
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <div ng-repeat="option in formModels.financingType.options"
                                                                class="radio-custom">
                                                                <input class="form-control" type="radio"
                                                                    name="{{formModels.financingType.paramId}}"
                                                                    ng-model="formModels.financingType.selected"
                                                                    ng-init="formModels.financingType.init()"
                                                                    ng-change="formModels.financingType.onChange(option.id)"
                                                                    ng-checked="formModels.financingType.isChecked(option.id)">
                                                                <label>{{option.displayName}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"
                                                        ng-show="formModels.financingType.isCredit()">
                                                        <label class="col-sm-6 control-label">
                                                            {{formModels.creditType.label}}:
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <div
                                                                class="{{formModels.creditType.modal ? 'input-group' : 'input-control'}}">
                                                                <span class="input-group-addon"
                                                                    ng-show="formModels.creditType.modal">
                                                                    <a href="" data-toggle="modal"
                                                                        data-target="#{{formModels.creditType.paramId}}Modal">
                                                                        <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                                    </a>
                                                                </span>
                                                                <select class="form-control"
                                                                    name="{{formModels.creditType.paramId}}"
                                                                    ng-model="formModels.creditType.selected"
                                                                    ng-options="i.displayName for i in formModels.creditType.options track by i.id"
                                                                    ng-init="formModels.creditType.init()"
                                                                    ng-change="formModels.creditType.onChange()"
                                                                    ng-destroy required>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- santander -->
                                                    <div class="form-group"
                                                        ng-show="formModels.financingType.isCredit() && formModels.creditType.isSantander60()">
                                                        <div class="col-sm-4 pb-sm pb-sm">
                                                            <div class="align-right">
                                                                <h6 class="mb-none">
                                                                    {{slcModels.creditBasePrice.label}}:
                                                                </h6>
                                                                <h1 class="mb-none">
                                                                    {{slcModels.creditBasePrice.value | number: slcModels.creditBasePrice.precision}}
                                                                    <small
                                                                        ng-bind-html="slcModels.creditBasePrice.unit"></small>
                                                                </h1>
                                                            </div>
                                                            <div class="align-right">
                                                                <h6 class="mb-none">
                                                                    {{slcModels.creditMonthlyPrice.label}}:
                                                                </h6>
                                                                <h1 class="mb-none">
                                                                    {{slcModels.creditMonthlyPrice.value | number: slcModels.creditMonthlyPrice.precision}}
                                                                    <small
                                                                        ng-bind-html="slcModels.creditMonthlyPrice.unit"></small>
                                                                </h1>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div>
                                                                <div class="col-xs-9 pl-none text-left pr-none mb-xs">
                                                                    <span>{{formModels.creditCoverageAmount.label}}</span>
                                                                </div>
                                                                <div class="col-xs-3 text-right pr-none mb-xs">
                                                                    <strong>{{formModels.creditCoverageAmount.value}}</strong>
                                                                    <span
                                                                        ng-bind-html="formModels.creditCoverageAmount.unit"></span>
                                                                </div>
                                                                <rzslider
                                                                    name="{{formModels.creditCoverageAmount.paramId}}"
                                                                    rz-slider-model="formModels.creditCoverageAmount.value"
                                                                    rz-slider-options="formModels.creditCoverageAmount.options"
                                                                    ng-init="formModels.creditCoverageAmount.init()">
                                                                </rzslider>
                                                            </div>
                                                            <div class="divider divider-solid mt-sm mb-sm"></div>
                                                            <div class="mb-xs">
                                                                <div class="col-xs-9 text-left pr-none mb-xs pl-none">
                                                                    <span>{{staticResources.santanderCredit.years.label}}</span>
                                                                </div>
                                                                <div class="col-xs-3 text-right pr-none mb-xs">
                                                                    <span>
                                                                        <strong>{{staticResources.santanderCredit.years.value}}</strong>
                                                                        {{staticResources.santanderCredit.years.unit}}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-xs">
                                                                <div class="col-xs-9 text-left pr-none mb-xs pl-none">
                                                                    <span>{{staticResources.santanderCredit.rrso.label}}</span>
                                                                </div>
                                                                <div class="col-xs-3 text-right pr-none mb-xs">
                                                                    <span>
                                                                        <strong>{{staticResources.santanderCredit.rrso.value}}</strong>
                                                                        {{staticResources.santanderCredit.rrso.unit}}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- custom credit -->
                                                    <div class="form-group"
                                                        ng-show="formModels.financingType.isCredit() && formModels.creditType.isCustomCredit()">
                                                        <div class="col-sm-4 pb-sm pb-sm">
                                                            <div class="align-right">
                                                                <h6 class="mb-none">
                                                                    {{slcModels.creditBasePrice.label}}:
                                                                </h6>
                                                                <h1 class="mb-none">
                                                                    {{slcModels.creditBasePrice.value | number: slcModels.creditBasePrice.precision}}
                                                                    <small
                                                                        ng-bind-html="slcModels.creditBasePrice.unit"></small>
                                                                </h1>
                                                            </div>
                                                            <div class="align-right">
                                                                <h6 class="mb-none">
                                                                    {{slcModels.creditMonthlyPrice.label}}:
                                                                </h6>
                                                                <h1 class="mb-none">
                                                                    {{slcModels.creditMonthlyPrice.value | number: slcModels.creditMonthlyPrice.precision}}
                                                                    <small
                                                                        ng-bind-html="slcModels.creditMonthlyPrice.unit"></small>
                                                                </h1>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div>
                                                                <div class="col-xs-9 pl-none text-left pr-none mb-xs">
                                                                    <span>{{formModels.creditCoverageAmount.label}}</span>
                                                                </div>
                                                                <div class="col-xs-3 text-right pr-none mb-xs">
                                                                    <strong>{{formModels.creditCoverageAmount.value}}</strong>
                                                                    <span
                                                                        ng-bind-html="formModels.creditCoverageAmount.unit"></span>
                                                                </div>
                                                                <rzslider
                                                                    name="{{formModels.creditCoverageAmount.paramId}}"
                                                                    rz-slider-model="formModels.creditCoverageAmount.value"
                                                                    rz-slider-options="formModels.creditCoverageAmount.options"
                                                                    ng-init="formModels.creditCoverageAmount.init()">
                                                                </rzslider>
                                                            </div>
                                                            <div>
                                                                <div class="col-xs-9 pl-none text-left pr-none mb-xs">
                                                                    <span>{{formModels.creditYears.label}}</span>
                                                                </div>
                                                                <div class="col-xs-3 text-right pr-none mb-xs">
                                                                    <strong>{{formModels.creditYears.value}}</strong>
                                                                    <span
                                                                        ng-bind-html="formModels.creditYears.unit"></span>
                                                                </div>
                                                                <rzslider name="{{formModels.creditYears.paramId}}"
                                                                    rz-slider-model="formModels.creditYears.value"
                                                                    rz-slider-options="formModels.creditYears.options"
                                                                    ng-init="formModels.creditYears.options.onChange()">
                                                                </rzslider>
                                                            </div>
                                                            <div>
                                                                <div class="col-xs-9 pl-none text-left pr-none mb-xs">
                                                                    <span>{{formModels.creditPrecentage.label}}</span>
                                                                </div>
                                                                <div class="col-xs-3 text-right pr-none mb-xs">
                                                                    <strong>{{formModels.creditPrecentage.value}}</strong>
                                                                    <span
                                                                        ng-bind-html="formModels.creditPrecentage.unit"></span>
                                                                </div>
                                                                <rzslider name="{{formModels.creditPrecentage.paramId}}"
                                                                    rz-slider-model="formModels.creditPrecentage.value"
                                                                    rz-slider-options="formModels.creditPrecentage.options"
                                                                    ng-init="formModels.creditPrecentage.options.onChange()">
                                                                </rzslider>
                                                            </div>
                                                            <div>
                                                                <div class="col-xs-9 pl-none text-left pr-none mb-xs">
                                                                    <span>{{formModels.creditInitialPayment.label}}</span>
                                                                </div>
                                                                <div class="col-xs-3 text-right pr-none mb-xs">
                                                                    <strong>{{formModels.creditInitialPayment.value}}</strong>
                                                                    <span
                                                                        ng-bind-html="formModels.creditInitialPayment.unit"></span>
                                                                </div>
                                                                <rzslider
                                                                    name="{{formModels.creditInitialPayment.paramId}}"
                                                                    rz-slider-model="formModels.creditInitialPayment.value"
                                                                    rz-slider-options="formModels.creditInitialPayment.options"
                                                                    ng-init="formModels.creditInitialPayment.options.onChange()">
                                                                </rzslider>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- additional financing options -->
                                                    <div class="form-group"
                                                        ng-show="formModels.financingType.isSelected()">
                                                        <label class="col-sm-6 control-label">
                                                            {{formGroups.additionalFinancing.label}}:
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <div ng-show="!formModels.mojPrad.isHidden()"
                                                                class="checkbox-custom checkbox-default font-size-sm line-height-sm input-group">
                                                                <input class="form-control" type="checkbox"
                                                                    name="{{formModels.mojPrad.paramId}}"
                                                                    ng-model="formModels.mojPrad.value"
                                                                    ng-change="formModels.mojPrad.onChange()"
                                                                    ng-disabled="formModels.mojPrad.isDisabled()"
                                                                    ng-destroy>
                                                                <label>{{formModels.mojPrad.label}}</label>
                                                                <a href="" data-toggle="modal"
                                                                    data-target="#{{formModels.mojPrad.paramId}}Modal"
                                                                    ng-show="formModels.mojPrad.modal">
                                                                    <i
                                                                        class="fa fa-info-circle ico__info font-size-xl text-info"></i>
                                                                </a>
                                                            </div>
                                                            <p class="font-size-xs text-info mb-xs"
                                                                ng-show="!formModels.mojPrad.isHidden() && formModels.mojPrad.isDisabled()"
                                                                ng-bind-html="formModels.mojPrad.disabledDesc">
                                                            </p>
                                                            <div ng-show="!formModels.ulgaTermo.isHidden()"
                                                                class="checkbox-custom checkbox-default font-size-sm line-height-sm input-group">
                                                                <input class="form-control" type="checkbox"
                                                                    name="{{formModels.ulgaTermo.paramId}}"
                                                                    ng-model="formModels.ulgaTermo.value"
                                                                    ng-change="formModels.ulgaTermo.onChange()"
                                                                    ng-destroy>
                                                                <label>{{formModels.ulgaTermo.label}}</label>
                                                                <a href="" data-toggle="modal"
                                                                    data-target="#{{formModels.ulgaTermo.paramId}}Modal"
                                                                    ng-show="formModels.ulgaTermo.modal">
                                                                    <i
                                                                        class="fa fa-info-circle ico__info font-size-xl text-info"></i>
                                                                </a>
                                                            </div>
                                                            <div ng-show="!formModels.dofinansowanie.isHidden()"
                                                                class="checkbox-custom checkbox-default font-size-sm line-height-sm input-group">
                                                                <input class="form-control" type="checkbox"
                                                                    name="{{formModels.dofinansowanie.paramId}}"
                                                                    ng-model="formModels.dofinansowanie.value"
                                                                    ng-change="formModels.dofinansowanie.onChange()"
                                                                    ng-destroy>
                                                                <label>{{formModels.dofinansowanie.label}}</label>
                                                                <a href="" data-toggle="modal"
                                                                    data-target="#{{formModels.dofinansowanie.paramId}}Modal"
                                                                    ng-show="formModels.dofinansowanie.modal">
                                                                    <i
                                                                        class="fa fa-info-circle ico__info font-size-xl text-info"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"
                                                        ng-show="formModels.dofinansowanie.isSelected()">
                                                        <label class="col-sm-6 control-label">
                                                            {{formModels.dofinansowanieValue.label}}:
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <div class="{{formModels.dofinansowanieValue.modal || formModels.dofinansowanieValue.unit
                                                                ? 'input-group' : 'input-control'}}">
                                                                <span class="input-group-addon"
                                                                    ng-show="formModels.dofinansowanieValue.modal">
                                                                    <a href="" data-toggle="modal"
                                                                        data-target="#{{formModels.dofinansowanieValue.paramId}}Modal">
                                                                        <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                                    </a>
                                                                </span>
                                                                <input type="number" class="form-control"
                                                                    name="{{formModels.dofinansowanieValue.paramId}}"
                                                                    ng-model="formModels.dofinansowanieValue.value"
                                                                    ng-change="formModels.dofinansowanieValue.onChange()"
                                                                    min="{{formModels.dofinansowanieValue.min}}"
                                                                    max="{{formModels.dofinansowanieValue.max}}"
                                                                    ng-destroy required>
                                                                <span class="input-group-addon"
                                                                    ng-show="formModels.dofinansowanieValue.unit">
                                                                    <span
                                                                        ng-bind-html="formModels.dofinansowanieValue.unit"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- additional options -->
                                                    <div class="form-group mb-xs"
                                                        ng-show="formModels.financingType.isSelected()">
                                                        <div class="col-xs-12">
                                                            <div class="col-xs-10 pl-none text-left pr-none mb-xs">
                                                                <span>{{formModels.energyCostGrowthByYear.label}}
                                                                    <a href="" data-toggle="modal"
                                                                        data-target="#{{formModels.energyCostGrowthByYear.paramId}}Modal">
                                                                        <i
                                                                            class="fa fa-info-circle ico__info font-size-xl text-info"></i>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                            <div class="col-xs-2 text-right pr-none mb-xs">
                                                                <strong>{{formModels.energyCostGrowthByYear.value}}</strong>
                                                                <span
                                                                    ng-bind-html="formModels.energyCostGrowthByYear.unit"></span>
                                                            </div>
                                                            <rzslider
                                                                name="{{formModels.energyCostGrowthByYear.paramId}}"
                                                                rz-slider-model="formModels.energyCostGrowthByYear.value"
                                                                rz-slider-options="formModels.energyCostGrowthByYear.options"
                                                                ng-init="formModels.energyCostGrowthByYear.init()">
                                                            </rzslider>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"
                                                        ng-show="formModels.financingType.isSelected()">
                                                        <div class="col-xs-12">
                                                            <div class="col-xs-10 pl-none text-left pr-none mb-xs">
                                                                <span>{{formModels.ownEnergyConsumptionFactor.label}}
                                                                    <a href="" data-toggle="modal"
                                                                        data-target="#{{formModels.ownEnergyConsumptionFactor.paramId}}Modal">
                                                                        <i
                                                                            class="fa fa-info-circle ico__info font-size-xl text-info"></i>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                            <div class="col-xs-2 text-right pr-none mb-xs">
                                                                <strong>{{formModels.ownEnergyConsumptionFactor.value}}</strong>
                                                                <span
                                                                    ng-bind-html="formModels.ownEnergyConsumptionFactor.unit"></span>
                                                            </div>
                                                            <rzslider
                                                                name="{{formModels.ownEnergyConsumptionFactor.paramId}}"
                                                                rz-slider-model="formModels.ownEnergyConsumptionFactor.value"
                                                                rz-slider-options="formModels.ownEnergyConsumptionFactor.options"
                                                                ng-init="formModels.ownEnergyConsumptionFactor.init()">
                                                            </rzslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- opti-ener -->
                                        <?php /*
                                        <div class="row mb-md mt-xs optiener-box">
                                            <div class="col-md-7 col-xs-6">
                                                <p class="bold mb-xs line-height-sm">
                                                    <big>
                                                        <i class="fa fa-line-chart color-primary font-size-xl mr-xs" aria-hidden="true"></i>
                                                    </big>
                                                    Zwiększ opłacalność inwestycji i zyskaj kontrolę nad zużyciem energii w Twoim domu dzięki OPTI-ENER
                                                </p>
                                            </div>
                                            <div class="col-md-5 col-xs-6">
                                                <div class="row opti-ener-selectbox">
                                                    <div class="clearfix mb-sm mt-xs">
                                                        <img
                                                            src="/public/img/pv/calc/opti-energy-logo.png?rev=3"
                                                            width="150px"
                                                            height="auto"
                                                            class="img-responsive pull-right"
                                                            alt="">
                                                    </div>
                                                    <div class="checkbox-custom checkbox-default font-size-sm line-height-sm pull-right">
                                                        <input
                                                            type="checkbox"
                                                            class="form-control"
                                                            name="{{formModels.optiener.paramId}}"
                                                            ng-model="formModels.optiener.value"
                                                            ng-change="formModels.optiener.onChange()"
                                                            ng-destroy>
                                                        <label>
                                                            <span ng-bind-html="formModels.optiener.label.form"></span>
                                                            <a
                                                                href=""
                                                                data-toggle="modal"
                                                                data-target="#{{formModels.optiener.paramId}}Modal"
                                                                class="ml-xs">
                                                                <i class="fa fa-info-circle ico__info text-info font-size-xl"></i>
                                                            </a>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										*/
                                        ?>

                                        <div class="row mb-md mt-xs optiener-box" style="background:#0f3d82;">
                                            <div class="col-md-7 col-xs-6">
                                                <p class="bold text-white font-size-xl text-right mb-sm mt-xs">
                                                    Dodaj do oferty &gt;&gt;&gt;
                                                </p>
                                                <p class="bold text-white font-size-xl text-right mb-none">
                                                    Wykorzystaj lepiej nadwyżki energii!
                                                </p>
                                            </div>
                                            <div class="col-md-5 col-xs-6">
                                                <div class="row opti-ener-selectbox" style="padding:5px;">
                                                    <div
                                                        class="checkbox-custom checkbox-default font-size-sm line-height-sm">
                                                        <input type="checkbox" class="form-control"
                                                            name="{{formModels.optiener.paramId}}"
                                                            ng-model="formModels.optiener.value"
                                                            ng-change="formModels.optiener.onChange()" ng-destroy>
                                                        <label>
                                                            <span><strong>Zwiększ opłacalność</strong></span>
                                                        </label>
                                                    </div>
                                                    <div class="clearfix mb-sm mt-xs">
                                                        <a href="" data-toggle="modal"
                                                            data-target="#{{formModels.optiener.paramId}}Modal"
                                                            class="ml-sm pull-right">
                                                            <i class="fa fa-info-circle ico__info text-info font-size-xl"></i>
                                                        </a>
                                                        <img src="<?php echo ZH_URL . '/public/img/pv/calc/opti-energy-logo.png?rev=3';?>"
                                                            width="150px" height="auto"
                                                            class="img-responsive pull-right mt-xs" alt="">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <!-- summary -->
                                        <div class="panel panel-default analyze-summary-panel">
                                            <div class="panel-heading">
                                                <h2 class="pb-sm pl-xl mb-none">
                                                    <small class="color-primary">
                                                        <strong>{{formGroups.analyzeSummary.label}}</strong>
                                                    </small>
                                                </h2>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table table-condensed analyze-summary-table">
                                                    <tbody>
                                                        <tr ng-repeat="i in getGroupModels('analyzeSummary')">
                                                            <td
                                                                class="analyze-summary-label {{i.highlighted ? 'highlighted' : ''}}">
                                                                {{i.label}}
                                                            </td>
                                                            <td
                                                                class="analyze-summary-value {{i.highlighted ? 'highlighted' : ''}}">
                                                                <h4 class="m-none">
                                                                    <strong ng-if="i.valueType === 'text'">
                                                                        {{i.value}}
                                                                        <span ng-bind-html="i.unit"></span>
                                                                    </strong>
                                                                    <strong ng-if="i.valueType !== 'text'">
                                                                        {{getParamDisplayValue(i) | number: i.precision || 0}}
                                                                        <span ng-bind-html="i.unit"></span>
                                                                    </strong>
                                                                </h4>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center mt-xs">
                                                <small>{{formModels.guaranteePeriod.label}}</small>
                                                <a href="" data-toggle="modal"
                                                    data-target="#{{formModels.guaranteePeriod.paramId}}Modal">
                                                    <i class="fa fa-info-circle ico__info font-size-xl text-info"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- chart and additional info -->
                                <div class="row">
                                    <!-- summary chart -->
                                    <div class="col-md-7 col-sm-12">
                                        <div class="chart profit-chart">
                                            <h2 class="title pl-sm mb-sm">
                                                <small>
                                                    <big><i class="fa fa-signal color-primary pr-xs"></i></big>
                                                    Opłacalność
                                                </small>
                                            </h2>
                                            <div id="financingCanvas">
                                                <canvas class="chart chart-line pl-xs pr-xs"
                                                    chart-data="profitChart.data" chart-options="profitChart.options"
                                                    chart-labels="profitChart.labels" chart-legend="true"
                                                    chart-series="profitChart.series">
                                                </canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- offer info -->
                                    <div class="col-md-5 col-sm-12" ng-show="!auth.user.isInstaller()">
                                        <div class="pvtool-offer-banner">
                                            <img class="logo-hewalex"
                                                src="<?php echo ZH_URL . '/public/images/pvslctool/tool/logo-hewalex.svg';?>">
                                            <div class="banner-html">
                                                <img class="banner-img"
                                                    src="<?php echo ZH_URL . '/public/images/pvslctool/tool/banner-rabat.jpg';?>">
                                                <div class="banner-content">
                                                    <div class="banner-info">
                                                        <ul>
                                                            <li class="info-item info-item-1">
                                                                <span class="desc">Otrzymaj kod rabatowy</span>
                                                            </li>
                                                            <li class="info-item info-item-2">
                                                                <span class="desc">Wygeneruj ofertę bez
                                                                    zobowiązań</span>
                                                            </li>
                                                            <li class="info-item info-item-3">
                                                                <span class="desc">Wszystko w 3 minuty</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="text-center btn-with-arrow">
                                                        <a ng-click="form.next()">
                                                            <button class="btn btn-lg btn-danger">
                                                                <strong>Chcę skorzystać z rabatu</strong>
                                                            </button>
                                                            <img
                                                                src="<?php echo ZH_URL . '/public/images/pvslctool/tool/strzalka.svg';?>">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- offer -->
                            <div id="pvForm-step-offer"
                                class="tab-pane {{form.isStepActive('offer') ? 'active' : ''}} {{form.isStepHidden('offer') ? 'hidden' : ''}} offer-form">
                                <!-- promo code info -->
                                <section ng-show="auth.user.isMereMortal()">
                                    <div class="alert offer-promo-code">
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2 col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-3 pr-xs mb-xs">
                                                        <div class="offer-promo-code-icons">
                                                            <img
                                                                src="<?php echo ZH_URL . '/public/images/pvslctool/tool/ico-5.svg';?>">
                                                            <img
                                                                src="<?php echo ZH_URL . '/public/images/pvslctool/tool/ico-1.svg';?>">
                                                            <img
                                                                src="<?php echo ZH_URL . '/public/images/pvslctool/tool/ico-7.svg';?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-9 pl-xs">
                                                        <h5 class="color-primary font-weight-bold">
                                                            Wypełnij formularz, wygeneruj w 3 minuty ofertę bez żadnych
                                                            zobowiązań i uzyskaj kod rabatowy na Twoją instalację.
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 text-center">
                                                <small class="font-weight-semibold">
                                                    * Kod rabatowy ważny jest dwa tygodnie od daty wygenerowania oferty.
                                                    Skontaktuj się z nami w tym czasie!
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mt-md">
                                            <div class="col-xs-12 text-center">
                                                <button type="button" class="btn btn-primary"
                                                    ng-click="form.preview()">Podgląd oferty
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section ng-show="auth.user.isInstaller()">
                                    <div class="alert alert-info text-center">
                                        Oferty przygotowywane przez instalatora zalogowanego w strefie, nie są wysyłane
                                        do klientów automatycznie.
                                    </div>
                                </section>
                                <!-- pv department section -->
                                <section ng-show="auth.user.isHewalexWorker()">
                                    <div class="row">
                                        <div class="col-sm-4 control-label">
                                            <h5 class="text-uppercase">{{formGroups.worker.label}}:</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">
                                                <span class="required">*</span> {{formModels.offerRspUId.label}}:
                                            </label>
                                            <div class="col-sm-6">
                                                <div
                                                    class="{{formModels.offerRspUId.modal ? 'input-group' : 'input-control'}}">
                                                    <span class="input-group-addon"
                                                        ng-show="formModels.offerRspUId.modal">
                                                        <a href="" data-toggle="modal"
                                                            data-target="#{{formModels.offerRspUId.paramId}}Modal">
                                                            <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                        </a>
                                                    </span>
                                                    <select class="form-control"
                                                        name="{{formModels.offerRspUId.paramId}}"
                                                        ng-model="formModels.offerRspUId.selected"
                                                        ng-options="i.displayName for i in formModels.offerRspUId.options track by i.id"
                                                        ng-init="formModels.offerRspUId.init()"
                                                        ng-change="formModels.offerRspUId.onChange()" ng-destroy
                                                        required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- client section -->
                                <section>
                                    <div class="row">
                                        <div class="col-sm-4 control-label">
                                            <h5 class="text-uppercase">{{formGroups.client.label}}:</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">
                                                {{formModels.name.label}}:
                                            </label>
                                            <div class="col-sm-6">
                                                <div
                                                    class="{{formModels.name.modal ? 'input-group' : 'input-control'}}">
                                                    <span class="input-group-addon" ng-show="formModels.name.modal">
                                                        <a href="" data-toggle="modal"
                                                            data-target="#{{formModels.name.paramId}}Modal">
                                                            <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                        </a>
                                                    </span>
                                                    <input type="text" class="form-control"
                                                        name="{{formModels.name.paramId}}"
                                                        ng-model="formModels.name.value" ng-destroy>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">
                                                <span class="required">*</span> {{formModels.email.label}}:
                                            </label>
                                            <div class="col-sm-6">
                                                <div
                                                    class="{{formModels.email.modal ? 'input-group' : 'input-control'}}">
                                                    <span class="input-group-addon" ng-show="formModels.email.modal">
                                                        <a href="" data-toggle="modal"
                                                            data-target="#{{formModels.email.paramId}}Modal">
                                                            <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                        </a>
                                                    </span>
                                                    <input type="text" class="form-control"
                                                        name="{{formModels.email.paramId}}"
                                                        ng-model="formModels.email.value" required="true" ng-destroy>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-4 control-label">
                                                {{formModels.phone.label}}:
                                            </label>
                                            <div class="col-xs-3 col-sm-2 col-md-1 pr-none">
                                                <input type="text" class="form-control text-right"
                                                    name="{{formModels.areaCode.paramId}}"
                                                    ng-model="formModels.areaCode.value"
                                                    ng-change="formModels.areaCode.onChange()" maxlength="4" ng-destroy>
                                            </div>
                                            <div class="col-xs-9 col-sm-4 col-md-5 pl-xs">
                                                <div
                                                    class="{{formModels.phone.modal ? 'input-group' : 'input-control'}}">
                                                    <span class="input-group-addon" ng-show="formModels.phone.modal">
                                                        <a href="" data-toggle="modal"
                                                            data-target="#{{formModels.phone.paramId}}Modal">
                                                            <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                        </a>
                                                    </span>
                                                    <input type="text" class="form-control"
                                                        name="{{formModels.phone.paramId}}"
                                                        ng-model="formModels.phone.value"
                                                        ng-change="formModels.phone.onChange()"
                                                        placeholder="___-___-___" data-plugin-masked-input
                                                        data-input-mask="999-999-999" ng-destroy>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">
                                                {{formModels.address.label}}:
                                            </label>
                                            <div class="col-sm-6">
                                                <div
                                                    class="{{formModels.address.modal ? 'input-group' : 'input-control'}}">
                                                    <span class="input-group-addon" ng-show="formModels.address.modal">
                                                        <a href="" data-toggle="modal"
                                                            data-target="#{{formModels.address.paramId}}Modal">
                                                            <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                        </a>
                                                    </span>
                                                    <input type="text" class="form-control"
                                                        name="{{formModels.address.paramId}}"
                                                        ng-model="formModels.address.value" ng-destroy>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">
                                                <span class="required">*</span> {{formModels.zip.label}}:
                                            </label>
                                            <div class="col-sm-6">
                                                <div class="{{formModels.zip.modal ? 'input-group' : 'input-control'}}">
                                                    <span class="input-group-addon" ng-show="formModels.zip.modal">
                                                        <a href="" data-toggle="modal"
                                                            data-target="#{{formModels.zip.paramId}}Modal">
                                                            <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                        </a>
                                                    </span>
                                                    <input type="text" class="form-control"
                                                        name="{{formModels.zip.paramId}}"
                                                        ng-model="formModels.zip.value"
                                                        ng-change="formModels.zip.onChange()" placeholder="__-___"
                                                        data-plugin-masked-input data-input-mask="99-999" ng-destroy
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">
                                                {{formModels.city.label}}:
                                            </label>
                                            <div class="col-sm-6">
                                                <div
                                                    class="{{formModels.city.modal ? 'input-group' : 'input-control'}}">
                                                    <span class="input-group-addon" ng-show="formModels.city.modal">
                                                        <a href="" data-toggle="modal"
                                                            data-target="#{{formModels.city.paramId}}Modal">
                                                            <i class="fa fa-info-circle ico__info font-size-xl">i</i>
                                                        </a>
                                                    </span>
                                                    <input type="text" class="form-control"
                                                        name="{{formModels.city.paramId}}"
                                                        ng-model="formModels.city.value" ng-destroy>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-4">
                                                <div
                                                    class="checkbox-custom checkbox-default font-size-sm line-height-sm input-group">
                                                    <input type="checkbox" class="form-control"
                                                        name="{{formModels.accept_mailing.paramId}}"
                                                        ng-model="formModels.accept_mailing.value"
                                                        ng-change="formModels.accept_mailing.onChange()" ng-destroy
                                                        required>
                                                    <label for="accept_mailing">
                                                        <span class="required">*</span>
                                                        {{formModels.accept_mailing.label.form}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-4">
                                                <div
                                                    class="checkbox-custom checkbox-default font-size-sm line-height-sm input-group">
                                                    <input type="checkbox" class="form-control"
                                                        name="{{formModels.accept_data.paramId}}"
                                                        ng-model="formModels.accept_data.value"
                                                        ng-change="formModels.accept_data.onChange()" ng-destroy
                                                        required>
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
                                                    Informacje o warunkach przetwarzania danych osobowych:<br><br>
                                                    Administratorem danych osobowych jest HEWALEX Sp. z o.o. Sp.k. z siedzibą w Czechowicach-Dziedzicach, 43-502, ul. Słowackiego 33.<br><br>
                                                    Dane osobowe będą przetwarzane w celu przygotowania i realizacji umowy na podstawie art. 6 ust. 1 lit. b RODO.<br><br>
                                                    Informujemy o przysługującym prawie dostępu, sprostowania, usunięcia lub ograniczenia przetwarzania danych osobowych, a także o prawie wniesienia skargi.<br>
                                                    <br>Podanie danych osobowych jest dobrowolne, jednakże odmowa podania danych może skutkować odmową przygotowania i realizacji umowy.<br>
                                                    <br>Szczegółowe informacje znajdują się na stronie internetowej hewalex.pl/ochrona-danych.">informacją o administratorze i przetwarzaniu dany
                                                 </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6 col-sm-offset-4">
                                                <button type="button" class="btn btn-primary"
                                                    ng-click="form.send()">{{form.sendButtonText.value}}
                                                </button>
                                                <br />
                                                <label class="font-size-sm ml-sm">
                                                    <span class="required">*</span> - pole wymagane
                                                </label>
                                                <div class="mt-sm">
                                                    <label class="font-size-sm">
                                                        Po wysłaniu zapytania otrzymasz możliwość pobrania wypełnionej
                                                        ankiety.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" ng-show="form.showErrorMessage">
                                        <div class="col-sm-12">
                                            <div class="alert alert-danger text-center p-xlg m-xlg">
                                                <h4 class="mb-none">
                                                    Wystąpił nieoczekiwany błąd podczas wysyłania, spróbuj ponownie za
                                                    kilka minut.
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- progress bar -->
                                <section class="mt-xlg hidden-xs">
                                    <div class="alert alert-primary text-center p-sm mb-xs">
                                        <h4 class="font-weight-semibold mb-none">Tylko kilka kroków dzieli Cię od
                                            własnej instalacji PV:</h4>
                                    </div>
                                    <div class="lead-progress-bar-pv mt-sm mb-md">
                                        <?php //echo $this->renderPvLeadProgress(1, 'after'); ?>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <!-- navigation -->
                    <div class="card-footer" style="display: block;">
                        <ul class="pager">
                            <li class="previous hidden">
                                <a ng-click="form.previous()"><i class="fa fa-angle-left"></i> Poprzedni krok</a>
                            </li>
                            <li class="next">
                                <a ng-click="form.next()" class="filled-pager">Następny krok <i
                                        class="fa fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </section>
            </form>
            <!-- selection form summary -->
            <div ng-show="form.isFinished()" ng-cloak>
                <div class="alert alert-success text-center p-xlg m-xlg">
                    <div ng-show="auth.user.isMereMortal() || auth.user.isHewalexWorker()">
                        <h1>Dziękujemy za skorzystanie z narzędzia doboru.</h1>
                        <h4 class="mb-xl text-primary">
                            W ciągu 15 minut otrzymasz raport doboru na podany adres email.
                            <br />Jeśli masz pytania, skontaktuj się ze wsparciem technicznym działu fotowoltaiki.
                            <span ng-if="form.sendResult.reportHash">
                                <br /><strong>Podsumowanie wypełnionej ankiety</strong> dostępne jest do pobrania
                                <a href="{{form.getFormSummaryReportUrl()}}"><strong
                                        class="text-underline">tutaj</strong></a>
                            </span>
                        </h4>
                        <h2 class="mb-xs">Dział fotowoltaiki - <strong>(32) 214 17 10 wew. 450</strong></h2>
                        <h2 class="mb-xl">Ogólny adres kontaktowy: <strong>fotowoltaika@hewalex.pl</strong></h2>
                    </div>
                    <div ng-show="auth.user.isInstaller()">
                        <h1>Konfiguracja została pomyślnie zapisana w przechowalni</h1>
                    </div>
                    <button type="button" class="btn btn-primary btn-xlg" ng-show="form.isDefaultMode()"
                        ng-click="form.reset()">Rozpocznij od nowa
                    </button>
                    <a href="/index.php?controller=manUserInterestingOffer&action=offerformshow&id={{offer.data.offer_form_id}}"
                        class="btn btn-primary btn-xlg"
                        ng-show="auth.user.isHewalexWorker() && form.isEditMode()">Powrót do podglądu oferty
                    </a>
                    <a href="/instalator/oferty/" class="btn btn-primary btn-xlg"
                        ng-show="auth.user.isInstaller()">Przejdź do przechowalni
                    </a>
                </div>
            </div>
            <!-- selection form modals -->
            <div class="slc-form-modals-container">
                <!-- basic modals -->
                <div ng-repeat="model in formModels" ng-if="model.modal && !model.modal.customRender" class="modal fade"
                    id="{{model.paramId}}Modal" tabindex="-1" role="dialog" style="display: none;">
                    <div class="modal-dialog {{model.modal.size}}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">{{model.modal.title || model.paramId + '_title'}}</h4>
                            </div>
                            <div class="modal-body" ng-bind-html="model.modal.content || model.paramId + '_content'">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij okno</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- custom content modals -->
                <div class="modal fade" id="{{formModels.energyUsageInPeriod.paramId}}Modal" tabindex="-1" role="dialog"
                    style="display: none;">
                    <div class="modal-dialog {{formModels.energyUsageInPeriod.modal.size}}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">{{formModels.energyUsageInPeriod.modal.title}}</h4>
                            </div>
                            <div class="modal-body">
                                <p ng-bind-html="formModels.energyUsageInPeriod.modal.content.text"></p>
                                <div class="row">
                                    <div class="col-sm-1-5 col-xs-4 text-center"
                                        ng-repeat="bill in formModels.energyUsageInPeriod.modal.content.bills">
                                        <span class="thumb-info thumb-info-centered-icons mb-xs">
                                            <span class="thumb-info-wrapper">
                                                <img ng-src="{{bill.imgSrc}}" class="img-responsive" alt="">
                                                <span class="thumb-info-action">
                                                    <a ng-href="{{bill.imgSrc}}" target="_blank">
                                                        <span
                                                            class="thumb-info-action-icon thumb-info-action-icon-light">
                                                            <i class="fa fa-link"></i>
                                                        </span>
                                                    </a>
                                                </span>
                                            </span>
                                        </span>
                                        <span>{{bill.label}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij okno</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="{{formModels.energyCostInPeriod.paramId}}Modal" tabindex="-1" role="dialog"
                    style="display: none;">
                    <div class="modal-dialog {{formModels.energyCostInPeriod.modal.size}}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">{{formModels.energyCostInPeriod.modal.title}}</h4>
                            </div>
                            <div class="modal-body">
                                <p ng-bind-html="formModels.energyCostInPeriod.modal.content.text"></p>
                                <div class="row">
                                    <div class="col-sm-1-5 col-xs-4 text-center"
                                        ng-repeat="bill in formModels.energyCostInPeriod.modal.content.bills">
                                        <span class="thumb-info thumb-info-centered-icons mb-xs">
                                            <span class="thumb-info-wrapper">
                                                <img ng-src="{{bill.imgSrc}}" class="img-responsive" alt="">
                                                <span class="thumb-info-action">
                                                    <a ng-href="{{bill.imgSrc}}" target="_blank">
                                                        <span
                                                            class="thumb-info-action-icon thumb-info-action-icon-light">
                                                            <i class="fa fa-link"></i>
                                                        </span>
                                                    </a>
                                                </span>
                                            </span>
                                        </span>
                                        <span>{{bill.label}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij okno</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="{{formModels.panelType.paramId}}Modal" tabindex="-1" role="dialog"
                    style="display: none;">
                    <div class="modal-dialog {{formModels.panelType.modal.size}}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">{{formModels.panelType.modal.title}}</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div ng-repeat="panel in formModels.panelType.options"
                                        ng-if="formModels.panelType.isOptionVisible(panel)">
                                        <div class="col-sm-6 text-center pl-md pr-md">
                                            <img class="img-responsive img-thumbnail mb-xs" ng-src="{{panel.img}}">
                                            <a href="{{panel.link}}" target="blank" ng-show="panel.link">
                                                {{panel.displayName}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij okno</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- initial-info -->
        <section class="initial-info hidden-xs" ng-show="app.isInitialized()" ng-cloak>
            <div class="alert alert-primary text-center p-sm mb-xs">
                <h4 class="font-weight-semibold mb-none">Tylko kilka kroków dzieli Cię od własnej instalacji PV:</h4>
            </div>
            <div class="lead-pv-progress-bar">
                <?php //echo $this->renderPvLeadProgress(1); ?>
            </div>
        </section>
    </div>
</div>