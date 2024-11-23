<div class="heading heading-primary heading-border heading-bottom-border">
    <h4 class="heading-primary">Dane klienta</h4>
</div>
<div id="offerForm" ng-controller="formController" ng-init="init({hash: '<?php echo $_GET["hash"]; ?>', userId: '<?php echo wp_get_current_user()->ID; ?>'})">
    <form class="ng-valid" action="" method="POST" enctype="multipart/form-data" novalidate="novalidate">
        <section>
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="col-md-12" for="inputName">Imię i nazwisko</label>
                    <div class="col-md-12">
                        <input class="form-control"
                               type="text"
                               name="name"
                               ng-model="name.value"
                               ng-change="name.setValue()"
                               ng-value="{{name.value}}"
                               ng-destroy
                               id="inputName">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="col-md-12" for="inputPhone">Telefon</label>
                    <div class="col-md-12">
                        <input type="text"
                               name="phone"
                               ng-model="phone.value"
                               ng-change="phone.setValue()"
                               ng-value="{{phone.value}}"
                               ng-destroy
                               placeholder="___-___-___"
                               data-plugin-masked-input
                               data-input-mask="999-999-999"
                               id="inputPhone"
                               class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="col-md-12" for="inputStreet">Adres</label>
                    <div class="col-md-12">
                        <input type="text"
                               name="address"
                               ng-model="address.value"
                               ng-change="address.setValue()"
                               ng-value="{{address.value}}"
                               ng-destroy
                               id="inputStreet"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="col-md-12" for="inputZip">Kod pocztowy</label>
                    <div class="col-md-12">
                        <input type="text"
                               name="zip"
                               ng-model="zip.value"
                               ng-change="zip.setValue()"
                               ng-value="{{zip.value}}"
                               ng-destroy
                               placeholder="__-___"
                               data-plugin-masked-input
                               data-input-mask="99-999"
                               id="inputZip"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="col-md-12" for="inputCity">Miejscowość</label>
                    <div class="col-md-12">
                        <input type="text"
                               name="city"
                               ng-model="city.value"
                               ng-change="city.setValue()"
                               ng-value="{{city.value}}"
                               ng-destroy
                               id="inputCity"
                               class="form-control">
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-xlg">
            <div class="alert alert-default">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-12" for="inputTaxRate">Stawka VAT</label>
                                <div class="col-md-12 select-group">
                                    <select
                                        name="taxrate"
                                        ng-model="taxRate.selected"
                                        ng-options="i.displayName for i in taxRate.options track by i.id"
                                        ng-init="taxRate.init()"
                                        ng-change="taxRate.onChange()"
                                        ng-destroy
                                        required
                                        class="form-control"
                                        id="inputTaxRate">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12" for="inputInstalationCost">Koszt montażu</label>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               name="instalationCost"
                                               ng-model="instalationCost.value"
                                               ng-change="instalationCost.onChange()"
                                               min="{{instalationCost.min}}"
                                               max="{{instalationCost.max}}"
                                               step="{{instalationCost.step}}"
                                               ng-destroy
                                               id="inputInstalationCost"
                                               placeholder="">
                                        <span class="input-group-addon">zł</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12" for="inputDeliveryCost">Koszt dostawy</label>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               name="deliveryCost"
                                               ng-maxlength="6"
                                               ng-model="deliveryCost.value"
                                               ng-change="deliveryCost.onChange()"
                                               min="{{deliveryCost.min}}"
                                               max="{{deliveryCost.max}}"
                                               step="{{deliveryCost.step}}"
                                               ng-destroy
                                               id="inputDeliveryCost"
                                               placeholder="">
                                        <span class="input-group-addon">zł</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="form-group form-horizontal form-inline">
                                <label class="col-md-12" >Dodatkowa marża</label>
                                <div class="col-xs-12 col-md-4 mt-xs">
                                    <div class="radio-custom" style="text-align:left !important;">
                                        <input type="radio"
                                               id="inputProfitPercent"
                                               name="profitType"
                                               ng-model="profitType.selected"
                                               ng-change="profitType.onChange()"
                                               ng-value="profitType.options[0].id"
                                               ng-destroy
                                               required
                                        >
                                        <label for="inputProfitPercent" class="text-left">Procentowa</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-8">
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               name="profitPercent"
                                               placeholder=""
                                               ng-model="profitPercent.value"
                                               ng-change="profitPercent.onChange()"
                                               min="{{profitPercent.min}}"
                                               step="{{profitPercent.step}}"
                                               ng-destroy
                                        >
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-horizontal form-inline">
                                <label class="col-md-12 hidden-xs" >&nbsp;</label>
                                <div class="col-xs-12 col-md-4 mt-xs">
                                    <div class="radio-custom" style="text-align:left !important;">
                                        <input
                                            type="radio"
                                            id="inputProfitCost"
                                            name="profitType"
                                            ng-model="profitType.selected"
                                            ng-value="profitType.options[1].id"
                                            ng-change="profitType.onChange()"
                                            ng-destroy
                                            required
                                        >
                                        <label for="inputProfitCost" class="text-left">Kwota</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-8">
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               name="profitCost"
                                               placeholder=""
                                               ng-model="profitCost.value"
                                               ng-change="profitCost.onChange()"
                                               min="{{profitCost.min}}"
                                               step="{{profitCost.step}}"
                                               ng-destroy
                                        >
                                        <span class="input-group-addon">zł</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="">
                            <div>
                                <div>
                                    <span>
                                        <h2 class="pb-sm pl-xl mb-none">
                                            <small class="text-color-custom">
                                            <strong>Oferta</strong>
                                            </small>
                                        </h2>
                                    </span>
                                </div>
                                <div class="accordion-body collapse in">
                                    <div class="panel-body pt-none mb-sm" style="background-color: #efefef; border-radius: 0px">
                                        <table class="table table-condensed p-sm pb-none" style="margin-bottom: 0px;">
                                            <tbody>
                                            <tr class="ng-scope" ng-repeat="item in summary.items">
                                                <td class="pl-xl font-size-sm ng-binding ng-scope" style="width: 50%; vertical-align: middle; border-top: none; border-bottom: 1px solid #ddd">
                                                    {{item.name}}
                                                </td>
                                                <td class="pr-xl text-right" style="vertical-align: middle; border-top: none; border-bottom: 1px solid #ddd">
                                                    <h4 class="m-none">
                                                        <strong>
                                                            <span>{{item.value}}</span> zł
                                                        </strong>
                                                    </h4>
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
                <div class="row">
                    <div class="col-sm-12 mb-lg">
                        <hr class="solid tall"/>
                        <div class="header-offer-cart">
                            <h5 class="text-center">Lista produktów w koszyku:</h5>
                        </div>
                        <table class="table table-condensed p-sm pb-none" style="margin-bottom: 0px;">
                            <tr>
                                <th>Kod produktu</th>
                                <th>Nazwa</th>
                                <th>Ilość</th>
                            </tr>
                            <tbody>
                            <tr class="ng-scope" ng-repeat="item in offer.products" ng-cloak="">
                                <td>{{item.code}}</td>
                                <td>{{item.name}}</td>
                                <td>{{item.sum}} szt.</td>
                            </tr>
                            </tbody>
                        </table>
                        <hr class="solid tall"/>
                    </div>
                    <div class="header-offer-cart">
                        <h5 class="text-center">Dodaj własne materiały instalacyjne (spoza oferty Hewalex):</h5>
                    </div>
                    <div class="row simulate-table">
                        <div class="col-md-12 mb-xs">
                            <div class="form-group col-md-12">
                                <div class="col-xs-3 col-md-1 p-none">
                                    <span class="form-control text-center font-weight-bold">Lp.</span>
                                </div>
                                <div class="col-xs-6 col-md-9 p-none">
                                    <span class="form-control text-center font-weight-bold">Nazwa</span>
                                </div>
                                <div class="col-xs-3 col-md-2 p-none">
                                    <span class="form-control text-center font-weight-bold">Ilość</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-xs simulate-td" ng-repeat="(itemId, item) in customProducts.items">
                            <div class="form-group col-md-12">
                                <div class="col-xs-3 col-md-1 p-none">
                                    <span class="form-control text-center">{{itemId + 1}}.</span>
                                </div>
                                <div class="col-xs-6 col-md-9 p-none">
                                    <input type="text"
                                           name="customProducts.items[itemId].id"
                                           ng-model="customProducts.items[itemId].id"
                                           ng-change="customProducts.onChange()"
                                           ng-destroy
                                           class="form-control">
                                </div>
                                <div class="col-xs-3 col-md-2 p-none">
                                    <input type="text"
                                           name="customProducts.items[itemId].value"
                                           ng-model="customProducts.items[itemId].value"
                                           ng-change="customProducts.onChange()"
                                           ng-destroy
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 align-right mt-lg">
                        <span type="submit"
                              name="addItem"
                              ng-value="addItem.value"
                              ng-model="addItem.value"
                              ng-click="addItem.addItem()"
                              data-loading-text="Zapisywanie..."
                              ng-cloak=""
                              class="btn btn-primary mt-xs"
                        >{{addItem.value}}</span>
                    </div>
                </div>
                <div class="row mt-xs">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="textareaComment">Uwagi do zamówienia</label>
                        <div class="col-md-12">
                            <textarea class="form-control"
                                      rows="5"
                                      name="comment"
                                      ng-model="comment.value"
                                      ng-blur="comment.onChange()"
                                      ng-destroy
                                      id="textareaComment"
                                      data-plugin-textarea-autosize=""></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-xlg">
            <div class="col-xs-12 align-center mt-lg">
                <button type="button"
                        ng-click="form.send()"
                        data-loading-text="Zapisywanie..."  class="btn btn-lg btn-primary mt-xs">Zapisz i wygeneruj ofertę</button>
            </div>
        </section>
    </form>
</div>