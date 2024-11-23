<div id="pcwbTool" class="calcpv" ng-controller="pcwbtoolController" ng-init="app.init()">
    <div class="container">
        <!-- form loading overlay -->
        <div class="row" ng-show="!app.isInitialized()">
            <div class="col-sm-12 text-center">
                <hr class="tall">
                <h1 class="mb-md">Trwa ładowanie danych...</h1>
                <div class="loading-overlay-showing"
                     data-loading-overlay=""
                     data-loading-overlay-options="{ &quot;startShowing&quot;: true, &quot;css&quot;: { &quot;backgroundColor&quot;: &quot;#ffffff&quot; } }"
                     ng-show="!form.initialization.error">
                    <span>&nbsp;</span>
                </div>
                <div class="alert alert-danger" ng-show="app.hasError()" ng-cloak="">
                    <span>Wystąpił nieoczekiwany błąd. Załaduj stronę ponownie.</span>
                </div>
                <hr class="tall">
            </div>
        </div>
        <!-- form -->
        <section class="card form-wizard" id="pcwbForm" ng-show="app.isInitialized() && form.inProgress()" ng-cloak>
            <div class="card-body card-body-nopadding" style="display: block;">
                <!-- form steps -->
                <div class="wizard-tabs">
                    <ul class="nav wizard-steps">
                        <li class="nav-item {{item.active ? 'active' : ''}}" ng-repeat="(key, item) in form.steps">
                            <a href="{{item.href}}" data-toggle="tab" class="nav-link text-center">
                                <span class="badge">{{key + 1}}</span>
                                <span class="hidden-xs">{{item.displayName}}</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <form class="form-horizontal">
                    <div class="tab-content">
                        <!-- instalation -->
                        <div id="pcwbForm-step-instalation" class="tab-pane active">
                            <div class="row mb-md">
                                <label class="col-sm-4 control-label">
                                    <h4 class="mb-none">
                                        <span class="badge badge-primary badge-text">{{groups.pool.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.poolUsage.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="{{formModels.poolUsage.modal ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.poolUsage.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.poolUsage.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select
                                                    class="form-control"
                                                    name="{{formModels.poolUsage.paramId}}"
                                                    ng-model="formModels.poolUsage.selected"
                                                    ng-options="i.displayName.form for i in formModels.poolUsage.options track by i.id"
                                                    ng-init="formModels.poolUsage.init()"
                                                    ng-change="formModels.poolUsage.onChange()"
                                                    ng-destroy
                                                    required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.poolSurface.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="{{formModels.poolSurface.modal || formModels.poolSurface.unit
                                            ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.poolSurface.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.poolSurface.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input
                                                    type="number"
                                                    class="form-control"
                                                    name="{{formModels.poolSurface.paramId}}"
                                                    ng-model="formModels.poolSurface.value"
                                                    ng-change="formModels.poolSurface.onChange()"
                                                    min="{{formModels.poolSurface.min}}"
                                                    max="{{formModels.poolSurface.max}}"
                                                    ng-destroy
                                                    required>
                                            <span class="input-group-addon" ng-show="formModels.poolSurface.unit">
                                                <span ng-bind-html="formModels.poolSurface.unit"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.poolDepth.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="{{formModels.poolDepth.modal || formModels.poolDepth.unit
                                            ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.poolDepth.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.poolDepth.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input
                                                    type="number"
                                                    class="form-control"
                                                    name="{{formModels.poolDepth.paramId}}"
                                                    ng-model="formModels.poolDepth.value"
                                                    ng-change="formModels.poolDepth.onChange()"
                                                    min="{{formModels.poolDepth.min}}"
                                                    max="{{formModels.poolDepth.max}}"
                                                    step="{{formModels.poolDepth.step}}"
                                                    ng-destroy
                                                    required>
                                            <span class="input-group-addon" ng-show="formModels.poolDepth.unit">
                                                <span ng-bind-html="formModels.poolDepth.unit"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.poolExpectedWaterTemp.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="{{formModels.poolExpectedWaterTemp.modal || formModels.poolExpectedWaterTemp.unit
                                            ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.poolExpectedWaterTemp.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.poolExpectedWaterTemp.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input
                                                    type="number"
                                                    class="form-control"
                                                    name="{{formModels.poolExpectedWaterTemp.paramId}}"
                                                    ng-model="formModels.poolExpectedWaterTemp.value"
                                                    ng-change="formModels.poolExpectedWaterTemp.onChange()"
                                                    min="{{formModels.poolExpectedWaterTemp.min}}"
                                                    max="{{formModels.poolExpectedWaterTemp.max}}"
                                                    ng-destroy
                                                    required>
                                            <span class="input-group-addon" ng-show="formModels.poolExpectedWaterTemp.unit">
                                                <span ng-bind-html="formModels.poolExpectedWaterTemp.unit"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.poolUsagePeriod.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="{{formModels.poolUsagePeriod.modal ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.poolUsagePeriod.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.poolUsagePeriod.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select
                                                    class="form-control"
                                                    name="{{formModels.poolUsagePeriod.paramId}}"
                                                    ng-model="formModels.poolUsagePeriod.selected"
                                                    ng-options="i.displayName.form for i in formModels.poolUsagePeriod.options track by i.id"
                                                    ng-init="formModels.poolUsagePeriod.init()"
                                                    ng-change="formModels.poolUsagePeriod.onChange()"
                                                    ng-destroy
                                                    required>
                                            </select>
                                        </div>
                                        <div class="text-info" ng-show="formModels.poolUsagePeriod.modelPs">
                                            <small>{{formModels.poolUsagePeriod.modelPs}}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="poolLocationDiv" ng-show="formModels.poolUsagePeriod.isSelected()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.poolLocation.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="{{formModels.poolLocation.modal ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.poolLocation.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.poolLocation.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select
                                                    id="poolLocationSelect"
                                                    class="form-control"
                                                    name="{{formModels.poolLocation.paramId}}"
                                                    ng-model="formModels.poolLocation.selected"
                                                    ng-options="i.displayName.form for i in formModels.poolLocation.filteredOptions track by i.id"
                                                    ng-init="formModels.poolLocation.init()"
                                                    ng-change="formModels.poolLocation.onChange()"
                                                    ng-destroy
                                                    required>
                                            </select>
                                        </div>
                                        <div class="text-info" ng-show="formModels.poolLocation.modelPs">
                                            <small>{{formModels.poolLocation.modelPs}}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.poolLocation.isExternal()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.poolInGround.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="{{formModels.poolInGround.modal ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.poolInGround.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.poolInGround.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select
                                                    class="form-control"
                                                    name="{{formModels.poolInGround.paramId}}"
                                                    ng-model="formModels.poolInGround.selected"
                                                    ng-options="i.displayName for i in formModels.poolInGround.options track by i.id"
                                                    ng-init="formModels.poolInGround.init()"
                                                    ng-change="formModels.poolInGround.onChange()"
                                                    ng-destroy
                                                    required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.poolLocation.isInternal()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.poolRoomExpectedTemp.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="{{formModels.poolRoomExpectedTemp.modal || formModels.poolRoomExpectedTemp.unit
                                            ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.poolRoomExpectedTemp.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.poolRoomExpectedTemp.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input
                                                    type="number"
                                                    class="form-control"
                                                    name="{{formModels.poolRoomExpectedTemp.paramId}}"
                                                    ng-model="formModels.poolRoomExpectedTemp.value"
                                                    ng-change="formModels.poolRoomExpectedTemp.onChange()"
                                                    ng-init="formModels.poolRoomExpectedTemp.setDefaultValue()"
                                                    min="{{formModels.poolRoomExpectedTemp.min}}"
                                                    max="{{formModels.poolRoomExpectedTemp.max}}"
                                                    ng-destroy
                                                    required>
                                            <span class="input-group-addon" ng-show="formModels.poolRoomExpectedTemp.unit">
                                                <span ng-bind-html="formModels.poolRoomExpectedTemp.unit"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.poolLocation.isWithCover()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.hoursWithoutPoolCover.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="{{formModels.hoursWithoutPoolCover.modal || formModels.hoursWithoutPoolCover.unit
                                            ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.hoursWithoutPoolCover.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.hoursWithoutPoolCover.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input
                                                    type="number"
                                                    class="form-control"
                                                    name="{{formModels.hoursWithoutPoolCover.paramId}}"
                                                    ng-model="formModels.hoursWithoutPoolCover.value"
                                                    ng-change="formModels.hoursWithoutPoolCover.onChange()"
                                                    min="{{formModels.hoursWithoutPoolCover.min}}"
                                                    max="{{formModels.hoursWithoutPoolCover.max}}"
                                                    ng-destroy
                                                    required>
                                            <span class="input-group-addon" ng-show="formModels.hoursWithoutPoolCover.unit">
                                                <span ng-bind-html="formModels.hoursWithoutPoolCover.unit"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.poolLocation.isExternalWithoutCover()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.poolInHardConditions.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="{{formModels.poolInHardConditions.modal ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.poolInHardConditions.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.poolInHardConditions.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select
                                                    class="form-control"
                                                    name="{{formModels.poolInHardConditions.paramId}}"
                                                    ng-model="formModels.poolInHardConditions.selected"
                                                    ng-options="i.displayName for i in formModels.poolInHardConditions.options track by i.id"
                                                    ng-init="formModels.poolInHardConditions.init()"
                                                    ng-change="formModels.poolInHardConditions.onChange()"
                                                    ng-destroy
                                                    required>
                                            </select>
                                        </div>
                                        <div class="text-info" ng-show="formModels.poolInHardConditions.modelPs">
                                            <small>{{formModels.poolInHardConditions.modelPs}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-md mb-md">
                                <label class="col-sm-4 control-label">
                                    <h4 class="mb-none">
                                        <span class="badge badge-primary badge-text">{{groups.pump.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group" ng-show="formModels.poolUsagePeriod.isYearPeriod()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.outsideTempHeaterRun.label.default}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="{{formModels.outsideTempHeaterRun.modals.default ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.outsideTempHeaterRun.modals.default">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.outsideTempHeaterRun.paramIds.default}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select
                                                    class="form-control"
                                                    name="{{formModels.outsideTempHeaterRun.paramIds.default}}"
                                                    ng-model="formModels.outsideTempHeaterRun.selected"
                                                    ng-options="i.displayName for i in formModels.outsideTempHeaterRun.options track by i.id"
                                                    ng-init="formModels.outsideTempHeaterRun.init()"
                                                    ng-change="formModels.outsideTempHeaterRun.onChange()"
                                                    ng-destroy
                                                    required>
                                            </select>
                                            <div class="text-info" ng-show="formModels.outsideTempHeaterRun.modelPs">
                                                <small>{{formModels.outsideTempHeaterRun.modelPs}}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="formModels.outsideTempHeaterRun.isCustom()">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.outsideTempHeaterRun.label.custom}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="{{formModels.outsideTempHeaterRun.modals.custom || formModels.outsideTempHeaterRun.unit
                                            ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.outsideTempHeaterRun.modals.custom">
                                                <a
                                                        href=""
                                                        
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.outsideTempHeaterRun.paramIds.custom}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input
                                                    min="-25"
                                                    max="15"
                                                    type="number"
                                                    class="form-control"
                                                    name="{{formModels.outsideTempHeaterRun.paramIds.custom}}"
                                                    ng-model="formModels.outsideTempHeaterRun.value"
                                                    ng-change="formModels.outsideTempHeaterRun.onChange()"
                                                    ng-destroy
                                                    required>
                                            <span class="input-group-addon" ng-show="formModels.outsideTempHeaterRun.unit">
                                                <span ng-bind-html="formModels.outsideTempHeaterRun.unit"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.poolToPumpDistance.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="{{formModels.poolToPumpDistance.modal ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.poolToPumpDistance.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.poolToPumpDistance.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select
                                                    class="form-control"
                                                    name="{{formModels.poolToPumpDistance.paramId}}"
                                                    ng-model="formModels.poolToPumpDistance.selected"
                                                    ng-options="i.displayName.form for i in formModels.poolToPumpDistance.options track by i.id"
                                                    ng-init="formModels.poolToPumpDistance.init()"
                                                    ng-change="formModels.poolToPumpDistance.onChange()"
                                                    ng-destroy
                                                    required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.pumpAsOnlyHeatingDevice.label}}:
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="{{formModels.pumpAsOnlyHeatingDevice.modal ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.pumpAsOnlyHeatingDevice.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.pumpAsOnlyHeatingDevice.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <select
                                                    class="form-control"
                                                    name="{{formModels.pumpAsOnlyHeatingDevice.paramId}}"
                                                    ng-model="formModels.pumpAsOnlyHeatingDevice.selected"
                                                    ng-options="i.displayName for i in formModels.pumpAsOnlyHeatingDevice.options track by i.id"
                                                    ng-init="formModels.pumpAsOnlyHeatingDevice.init()"
                                                    ng-change="formModels.pumpAsOnlyHeatingDevice.onChange()"
                                                    ng-destroy
                                                    required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- offer -->
                        <div id="pcwbForm-step-offer" class="tab-pane newPCWBstep">
                            <div ng-show="form.sendInProgress === false">
                                <div class="row mt-md">
                                    <div class="col-md-6 col-sm-12 text-center">
                                        <img src="{{ form.offerSelection.pump.img }}" width="100%">
                                    </div>
                                    <div class="col-md-offset-1 col-md-5 col-sm-12">
                                        <div class="panel panel-default analyze-summary-panel mt-xlg">
                                            <div class="panel-heading">
                                                <h2 class="pb-sm pl-xl mb-none">
                                                    <small class="color-primary">
                                                        <strong class="ng-binding">Podsumowanie</strong>
                                                    </small>
                                                </h2>
                                            </div>
                                            <div class="panel-body">
                                                <div>
                                                    <table class="table table-condensed analyze-summary-table">
                                                        <tbody>
                                                        <tr ng-repeat="item in form.offerSelection.offer" >
                                                            <td class="analyze-summary-label ">
                                                                {{ item.label }}
                                                            </td>
                                                            <td class="analyze-summary-value">
                                                                <h4 class="m-none text-weight-bold">{{ item.value }} <span ng-show="item.unit">{{ item.unit }}</span></h4>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-md">
                                    <div class="mt-md">
                                        <!-- summary -->
                                        <div class="panel panel-default offer-panel">
                                            <div class="panel-body">
                                                <div class="hidden-xs  hidden-sm">
                                                    <table class="table table-offer">
                                                        <tbody>
                                                        <tr>
                                                            <th>Parametr</th>
                                                            <th>Wartość</th>
                                                            <th>Parametr</th>
                                                            <th>Wartość</th>
                                                        </tr>
                                                        <tr ng-repeat="item in form.pumpParams2Column" >
                                                            <td>{{ item[0].label }}</td>
                                                            <td>{{ item[0].value }}</td>
                                                            <td>{{ item[1].label }}</td>
                                                            <td>{{ item[1].value }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="hidden-md hidden-lg">
                                                    <table class="table table-offer">
                                                        <tbody>
                                                        <tr>
                                                            <th>Parametr</th>
                                                            <th>Wartość</th>
                                                        </tr>
                                                        <tr ng-repeat="param in form.offerSelection.pumpParams">
                                                            <td>{{ param.label }}</td>
                                                            <td>{{ param.value }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-md mt-md">
                                    <div class="col-md-12 col-xs-12 mb-md">
                                        <h4>
                                            W celu dokonania zakupu zachęcamy do bezpośredniego kontaktu z dystrybutorem lub instalatorem basenowych pomp ciepła Hewalex:
                                        </h4>
                                        <div class="text-center mb-md mt-xlg">
                                            <a href="/kontakt/znajdz-instalatora/" class="btn btn-md btn-primary" target="_blank">
                                                Wyszukaj lokalnego dostawce
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-md mt-md">
                                    <div class="col-md-12 col-xs-12">
                                        <h4>Chcesz otrzymać więcej szczegółów? Przejdź do Kroku 3, dzięki czemu:</h4>
                                        <ul class="mt-lg list list-icons list-icons-style-3 list-icons-sm">
                                            <li><i class="fa fa-check"></i> wygenerujesz rozszerzony dobór i ofertę, które otrzymasz na podany adres mailowy</li>
                                            <li><i class="fa fa-check"></i> zyskasz możliwość zapisania szczegółowych założeń do obliczeń oraz wyników doboru</li>
                                            <li><i class="fa fa-check"></i> otrzymasz propozycję dodatkowego wyposażenia dla dobranego modelu pompy ciepła</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row mt-md">
                                    <div class="text-justify mt-xs">
                                        <small class="ng-binding">Uwaga: dobór pompy ciepła jest oparty o podstawowe założenia oraz metodę typowych wskaźników obliczeniowe.
                                            Pomimo dołożenia wszelkich starań dla rzetelności i poprawności obliczeń metoda ta nie zastępuje szczegółowych opracowań projektowych.
                                            Firma Hewalex nie ponosi odpowiedzialności za poprawność doboru przeprowadzonego w ramach usługi formularza doboru basenowej pompy ciepła.</small>
                                    </div>
                                </div>
                            </div>
                            <div ng-show="form.sendInProgress === true">
                                <div class="col-sm-12 text-center">
                                    <hr class="tall">
                                    <h1 class="mb-md">Trwa generowanie ofery...</h1>
                                    <div class="loading-overlay-showing"
                                         data-loading-overlay=""
                                         data-loading-overlay-options="{ &quot;startShowing&quot;: true, &quot;css&quot;: { &quot;backgroundColor&quot;: &quot;#ffffff&quot; } }"
                                    >
                                        <span>&nbsp;</span>
                                    </div>
                                    <div class="alert alert-danger" ng-show="app.hasError()" ng-cloak="">
                                        <span>Wystąpił nieoczekiwany błąd. Załaduj stronę ponownie.</span>
                                    </div>
                                    <hr class="tall">
                                </div>
                            </div>

                        </div>
                        <!-- user -->
                        <div id="pcwbForm-step-user" class="tab-pane">
                            <div class="row mb-md">
                                <div class="col-sm-4">
                                </div>
                                <div class="col-sm-6">
                                    <div class="mt-xlg newPCWBtop">
                                        <h4 class="heading-primary text-weight-bold">Proszę wypełnić dane, dzięki czemu:</h4>
                                        <ul class="mt-lg list list-icons list-icons-style-3 list-icons-sm">
                                            <li><i class="fa fa-check"></i> wygenerujesz rozszerzony dobór i ofertę, które otrzymasz na adres mailowy</li>
                                            <li><i class="fa fa-check"></i> zapiszesz szczegółowe założenia do obliczeń oraz wyniki doboru</li>
                                            <li><i class="fa fa-check"></i> otrzymasz propozycję dodatkowego wyposażenia pompy ciepła</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-md">
                                <label class="col-sm-4 control-label">
                                    <h4 class="mb-none">
                                        <span class="badge badge-primary badge-text">{{groups.location.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        *{{formModels.installationPostcode.label}}:
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="{{formModels.installationPostcode.modal ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.installationPostcode.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.installationPostcode.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input
                                                    id="postSeparationAdd"
                                                    type="text"
                                                    class="form-control"
                                                    name="{{formModels.installationPostcode.paramId}}"
                                                    ng-model="formModels.installationPostcode.value"
                                                    ng-change="formModels.installationPostcode.onChange()"
                                                    placeholder="__-___"
                                                    data-plugin-masked-input
                                                    data-input-mask="99-999"
                                                    maxlength="6"
                                                    ng-destroy
                                                    required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-md mb-md">
                                <label class="col-sm-4 control-label">
                                    <h4 class="mb-none">
                                        <span class="badge badge-primary badge-text">{{groups.contact.label}}</span>
                                    </h4>
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        *{{formModels.email.label}}
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="{{formModels.email.modal ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.email.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.email.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input
                                                    type="email"
                                                    class="form-control"
                                                    name="{{formModels.email.paramId}}"
                                                    ng-model="formModels.email.value"
                                                    required
                                                    ng-destroy>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.phone.label}} (nie wymagany)
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="{{formModels.phone.modal ? 'input-group' : 'input-control'}}">
                                            <span class="input-group-addon" ng-show="formModels.phone.modal">
                                                <a
                                                        href=""
                                                        data-toggle="modal"
                                                        data-target="#{{formModels.phone.paramId}}Modal">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                            <input
                                                    id="phoneSeparationAdd"
                                                    type="text"
                                                    class="form-control"
                                                    name="{{formModels.phone.paramId}}"
                                                    ng-model="formModels.phone.value"
                                                    ng-change="formModels.phone.onChange()"
                                                    placeholder="___-___-___"
                                                    data-plugin-masked-input
                                                    data-input-mask="999-999-999"
                                                    maxlength="11"
                                                    ng-destroy>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        {{formModels.comment.label}}
                                    </label>
                                    <div class="col-sm-6">
                                        <textarea
                                                class="form-control"
                                                name="{{formModels.comment.paramId}}"
                                                ng-model="formModels.comment.value"
                                                ng-destroy
                                                rows="5">
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group mt-lg">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        <div class="checkbox-custom checkbox-default font-size-sm line-height-sm input-group">
                                            <input
                                                    type="checkbox"
                                                    class="form-control"
                                                    name="{{formModels.accept_mailing.paramId}}"
                                                    ng-model="formModels.accept_mailing.value"
                                                    ng-change="formModels.accept_mailing.onChange()"
                                                    ng-destroy
                                                    required>
                                            <label for="accept_mailing">
                                                <span class="required">*</span> {{formModels.accept_mailing.label.form}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        <div class="checkbox-custom checkbox-default font-size-sm line-height-sm input-group">
                                            <input
                                                    type="checkbox"
                                                    class="form-control"
                                                    name="{{formModels.accept_data.paramId}}"
                                                    ng-model="formModels.accept_data.value"
                                                    ng-change="formModels.accept_data.onChange()"
                                                    ng-destroy
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
                                                <span class="tip_onclose">&#x2715;</span>
                                                Informacje o warunkach przetwarzania danych osobowych:<br><br>
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
                                        <button
                                                type="button"
                                                class="btn btn-primary"
                                                ng-click="form.send()">Wyślij
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
                            <div class="row" ng-show="form.showSendErrorMessage">
                                <div class="col-sm-12">
                                    <div class="alert alert-danger text-center p-xlg m-xlg">
                                        <h4 class="mb-none">
                                            Wystąpił nieoczekiwany błąd podczas wysyłania, spróbuj ponownie za kilka minut.
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
                    <li class="previous hidden">
                        <a ng-click="form.previous()"><i class="fa fa-angle-left"></i> Wstecz</a>
                    </li>
                    <li class="next">
                        <a ng-click="form.next()">Dalej <i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
            </div>
        </section>
        <!-- form summary -->
        <div ng-show="form.isFinished()" ng-cloak="" class="new-brand">
            <div class="alert alert-success text-center p-xlg m-xlg">
                <h1>Dziękujemy za skorzystanie z formularza.</h1>
                <h4 class="mb-xlg text-primary-brand line-height-4">
                    Wkrótce otrzymasz raport doboru na podany adres email.
                    <br/>W przypadku pytań skontaktuj się z działem technicznym pomp ciepła Hewalex*.
                    <span ng-if="form.sendResult.reportHash">
                        <br/><strong>Podsumowanie wypełnionej ankiety</strong> dostępne jest do pobrania
                        <a href="{{form.getFormSummaryReportUrl()}}"><strong class="text-underline">tutaj</strong></a>
                    </span>
                </h4>
                <h2 class="mb-xs mt-xlg">Dział pomp ciepła - <strong>(32) 214 17 10 wew. 180</strong></h2>
                <h2 class="mb-xl">Ogólny adres kontaktowy: <strong>pompyciepla@hewalex.pl</strong></h2>
                <button
                        type="button"
                        class="btn btn-primary-brand btn-xlg mb-xlg"
                        ng-click="form.reset()">Rozpocznij od nowa
                </button>
                <h6 class="mt-xlg text-sm">*Standardowy czas przygotowania raportu zajmuje nie więcej niż 30 min. W wyjątkowych przypadkach przygotowanie raportu może potrwać do 48h.</h6>
            </div>
        </div>
    </div>
    <!-- modals -->
    <div class="modals-container">
        <div
                ng-repeat="model in formModels" ng-if="model.modal"
                class="modal fade"
                id="{{model.paramId}}Modal" tabindex="-1" role="dialog" style="display: none;">
            <div class="modal-dialog {{model.modal.size}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">{{model.modal.title || model.paramId + '_title'}}</h4>
                    </div>
                    <div class="modal-body" ng-bind-html="model.modal.content || model.paramId + '_content'"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>

        <div ng-repeat="model in formModels" ng-if="model.modals">
            <div
                    ng-repeat="(key, item) in model.modals"
                    class="modal fade"
                    id="{{model.paramIds[key]}}Modal" tabindex="-1" role="dialog" style="display: none;">
                <div class="modal-dialog {{item.size}}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">{{item.title}}</h4>
                        </div>
                        <div class="modal-body" ng-bind-html="item.content"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>