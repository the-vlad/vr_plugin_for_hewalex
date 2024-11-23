// import AWN from "awesome-notifications";



let options = {
    position: "bottom-right",
    icons: {
        enabled: false
    },
};
options.labels = {
    success: "SUKCES",
    warning: "UWAGA",
    alert: "BŁĄD",
};

var prepaidCard = function()
{
    // jQuery(document).ready(function ($) {
    return {
        initialize: function() 
        {
     
       
            this.main = $('#prepaidCardContainer');
            this.mainContainer = $('#prepaidCardContainer .content');
            this.modal = $('#prepaidCardModal');
            this.modalContainer = $('#prepaidCardModal .modal-dialog .modal-content');
            this.data = {};
            this.installerData = null;
            this.installerInstallationsData = null;
            this.sectionState = null;
            this.orderCategory = 'ppCardApplication';
            this.installerOrders = null;
            this.wp_nonce = prepaid.nonce;
            
            $.when(
                prepaidCard.getData(), 
                prepaidCard.getInstallerInstallationsData(),
                prepaidCard.getInstallerOrders()
            ).then(function(response1, response2, response3) {
                prepaidCard.data = response1[0];
                prepaidCard.installerInstallationsData = response2[0];
                prepaidCard.installerOrders = response3[0];
                prepaidCard.createMainContainerContent();
               
                $('.eq-height').matchHeight();
             
            }, function() {
                prepaidCard.createErrorContent();
                $('.eq-height').matchHeight();
            });
      
            
        },
        
        getData: function()
        {
            return $.ajax({
                type: 'GET',
                url: '/wp-json/hewalex-zones/v2/installerprepaidcard',
                headers: {
                    'X-WP-Nonce': this.wp_nonce,
                },
                dataType: 'json',
                timeout: 10000
            });
        },
        
        getInstallerInstallationsData: function()
        {
            return $.ajax({
                type: 'GET',
                url: '/wp-json/hewalex-zones/v2/installerinstallations',
                // url: 'https://stage.hewalex.pl/json/installerinstallations/',
                headers: {
                    'X-WP-Nonce': this.wp_nonce,
                },
                dataType: 'json',
                timeout: 10000
            });
        },
        
        getInstallerOrders: function()
        {
             return $.ajax({
                type: 'GET',
                // url: 'https://stage.hewalex.pl/instalator/zamowienie?category='+ prepaidCard.orderCategory,
                url: '/wp-json/hewalex-zones/v2/getOrderCard',
                headers: {
                    'X-WP-Nonce': this.wp_nonce,
                },
                dataType: 'json',
                timeout: 10000
            });
        },
        
        createErrorContent: function()
        {
            var htmlContent = '\n\
                <div class="text-center pt-xl">\n\
                    <h4 class="text-muted mb-none"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></h4>\n\
                    <h6 class="text-muted">Błąd pobierania danych</h6>\n\
                </div>';
            this.main.trigger('loading-overlay:hide');
            this.mainContainer.html(htmlContent);
        },
        
        createMainContainerContent: function()
        {
            this.sectionState = this.getMainContainerState();
            var body;
            
            switch (this.sectionState) {
                case 'activated':
                    body = '\n\
                        <h4 class="mb-sm font-weight-bold">'+ this.data.number +'</h4>\n\
                        <h6 class="mb-none">Data ważności: '+ moment(this.data.validDate).format('MM/Y') +'</h6>';
                    break;
                case 'sent':
                    body = '\n\
                        <div class="form-group form-group-register">\n\
                            <button \n\
                                class="btn btn-success btn-block btn-truncate" \n\
                                data-toggle="modal" \n\
                                data-target="#prepaidCardModal" \n\
                                onclick="prepaidCard.createActivationForm()">Zarejestruj\n\
                            </buttton>\n\
                        </div>';
                    break;
                case 'ordered':
                    body = '\n\
                        <div>\n\
                            <h4 class="card-order-complete-title mb-xs font-weight-bold" style="display: inline">Złożono zamówienie</h4>\n\
                            <a href="#" onclick="prepaidCard.downloadOrder(); return false">\n\
                                <h6 class="btn-completed-order text-muted mb-none">Zobacz wniosek</h6>\n\
                            </a>\n\
                        </div>';
                    break;
                case 'enabled':
                    body = '\n\
                        <div class="form-group">\n\
                            <button \n\
                                class="btn btn-primary btn-block btn-truncate" \n\
                                data-toggle="modal" \n\
                                data-target="#prepaidCardModal" \n\
                                onclick="prepaidCard.createOrderForm()">Zamów kartę\n\
                            </buttton>\n\
                        </div>';
                    break;
                case 'disabled':
                default:
                    body = '\n\
                        <div class="form-group">\n\
                            <button \n\
                                class="btn btn-disabled btn-block btn-truncate" \n\
                                title="Aby otrzymać kartę należy zarejestrować min. 2 instalacje w ciągu 12 miesięcy."\n\
                                disabled>Zamów kartę</buttton>\n\
                        </div>';
                    break;
            }
            
            var header = (this.sectionState === 'activated')
                ? '\n\<h4 class="pt-sm mb-xs">Numer karty</h4>'
                : '\n\<h4 class="pt-sm">Karta prepaid</h4>';
            var img = (this.sectionState === 'sent')
                ? 'prepaid-card-back.png'
                : 'prepaid-card.png';
            
            var htmlContent = '\n\
                <div class="row">\n\
                    <div class="col-sm-6">'
                        + header + body +
                    '</div>\n\
                    <div class="col-sm-6 hidden-xs">\n\
                        <img \n\
                            src="' + window.zh_url + '/public/images/strefa-instalatora/'+ img +'" \n\
                            class="img-responsive pull-right" \n\
                            alt="">\n\
                    </div>\n\
                </div>';
            this.main.trigger('loading-overlay:hide');
            this.mainContainer.html(htmlContent);
        },
        
        getMainContainerState: function()
        {
            // if (this.data.isActive) {
            //     return 'activated';
            // }
            // if (this.data.isSent) {
            //     return 'sent';
            // }
            // if (!_.isEmpty(this.installerOrders)) {
            //     return 'ordered';
            // }
            // return 'enabled';
            if (this.data.isActive) {
                return 'activated';
            }
            if (this.data.isSent) {
                return 'sent';
            }
            if (!_.isEmpty(this.installerOrders)) {
                return 'ordered';
            }

            var issetInstallations = this.issetInstallations(this.installerInstallationsData);
            if (issetInstallations === true) {
                return 'enabled';
            }
            return 'disabled';

            // var collection1 = _.filter(this.installerInstallationsData, function(item) {
            //     var installationDate = new Date(item.instalation_date_ins).getTime(),
            //         startDate = new Date('2018-01-10 00:00:00'),
            //         endDate = moment(startDate).add(12, 'months');
            //     return installationDate >= startDate.getTime() && installationDate < endDate.valueOf();
            // });
            // var collection2 = _.filter(this.installerInstallationsData, function(item) {
            //     var installationDate = new Date(item.instalation_date_ins).getTime(),
            //         startDate = new Date('2019-01-10 00:00:00');
            //     return installationDate >= startDate.getTime();
            // });
            // var collection3 = _.filter(this.installerInstallationsData, function(item) {
            //     var installationDate = new Date(item.instalation_date_ins).getTime(),
            //         startDate = new Date('2018-04-10 00:00:00'),
            //         endDate = moment(startDate).add(12, 'months');
            //     return installationDate >= startDate.getTime() && installationDate < endDate.valueOf();
            // });
            // var pair = this.getTwoElementsSeparatedByLessThanYear(collection2);
            // if (collection1.length >= 2 || collection3.length >= 2 || pair) {
            //     return 'enabled';
            // }
            // return 'disabled';
        },

        issetInstallations: function (collections)
        {
            if (_.size(collections) > 0) {
                return true;
            }
        },

        getTwoElementsSeparatedByLessThanYear: function(collection)
        {
            if (_.size(collection) < 2) {
                return null;
            }

            var dateKey = 'instalation_date_ins';
            collection = _.sortBy(collection, dateKey);
            var result = [];
            _.each(collection, function(item) {
                if (_.size(result) === 2) {
                    return false;
                }
                if (_.isEmpty(result)) {
                    result.push(item);
                    return true;
                }
                var dateFrom = moment(_.head(result)[dateKey]);
                var dateTo = moment(item[dateKey]);
                if (dateTo.diff(dateFrom, 'years') === 0) {
                    result.push(item);
                } else {
                    result = [];
                    result.push(item);
                }
            });

            return _.size(result) === 2 ? result : null;
        },

        downloadOrder: function()
        {
            var id = (this.installerOrders)['order_id'];
            var permalink = (this.installerOrders)['permalink'];
            window.open(
                permalink + '?format=pdf&id=' + id,
                'Karta prepaid - pobierz wniosek',
                'width=600,height=600,scrollbars,status'
            );
        },
        
        createOrderForm: function()
        {
            var formContent = '',
                expectedOrderFormFields = this.getExpectedOrderFormFields(),
                prefix = 'shipping_';
            
            _.each(expectedOrderFormFields, function(field) {
                var type = field.type || null;
                if (type === 'static') {
                    var input = '<div id="'+ field.id +'" class="pt-xs"></div>';
                } else {
                    var input = '<input type="text" value="" name="'+ prefix + field.id +'" id="'+ field.id +'" class="form-control" required>';
                }
                formContent += '\
                    <div class="form-group">\n\
                        <label class="col-md-4 control-label" for="'+ field.id +'">'+ field.label +'</label>\n\
                        <div class="col-md-6">\n\
                            '+ input +'\n\
                        </div>\n\
                    </div>';
            });
            
            var htmlContent = '\n\
                <div class="modal-header">\n\
                    <button type="button" class="close" data-dismiss="modal">\n\
                        <span aria-hidden="true">×</span><span class="sr-only">Close</span>\n\
                    </button>\n\
                    <h4 class="modal-title">Formularz zamówienia karty prepaid</h4>\n\
                </div>\n\
                <div class="modal-body">\n\
                    <div class="panel-body">\n\
                        <p>Aby otrzymać kartę prepaid należy wypełnić poniższy formularz.</p>\n\
                        <p class="mb-xlg">Karta prepaid zostanie wysłana na adres podany we wniosku.</p>\n\
                        <form class="form-horizontal form-bordered">\n\
                        '+ formContent +'\n\
                        </form>\n\
                    </div>\n\
                </div>\n\
                <div class="modal-footer">\n\
                    <button class="btn btn-primary" name="submitBtn" onclick="prepaidCard.submitOrder()">Złóż wniosek</button>\n\
                    <button class="btn btn-default" data-dismiss="modal">Anuluj</button>\n\
                </div>';
            this.modalContainer.html(htmlContent);
            
            if (!_.isEmpty(this.installerData)) {
                this.fillOrderFormWithInstallerData();
            } else {
                $.when(prepaidCard.getInstallerData()).then(function(response) {
                    prepaidCard.installerData = response;
                    prepaidCard.fillOrderFormWithInstallerData();
                }, function () {
                    new AWN().alert('Nie można pobrać danych instalatora.', options);
                    // new PNotify({
                    //     title: 'Błąd',
                    //     text: 'Nie można pobrać danych instalatora.',
                    //     hide: true,
                    //     buttons: {
                    //         sticker: false
                    //     }
                    // });
                });
            }
        },
        
        getExpectedOrderFormFields: function()
        {
            return [
                {id: 'name',            label: 'Nazwa', type: 'static'}, 
                {id: 'nip',             label: 'Nip',   type: 'static'}, 
                {id: 'address',         label: 'Adres'}, 
                {id: 'zip',             label: 'Kod pocztowy'}, 
                {id: 'city',            label: 'Miasto'}, 
                {id: 'phone',           label: 'Numer telefonu'},
                {id: 'contact_person',  label: 'Osoba kontaktowa do zamówienia'}
            ];
        },
        
        getInstallerData: function()
        {
            return $.ajax({
                type: 'GET',
                url: '/wp-json/hewalex-zones/v2/installer',
                headers: {
                    'X-WP-Nonce': this.wp_nonce,
                },
                dataType: 'json',
                timeout: 10000
            });
        },
        
        fillOrderFormWithInstallerData: function()
        {
            var expectedOrderFormFields = this.getExpectedOrderFormFields(),
                prefix = 'installers_';
        
            _.each(expectedOrderFormFields, function(field) {
                var object = $('#'+ field.id),
                    value = prepaidCard.installerData[prefix + field.id] || null;
                if (field.type === 'static') {
                    object.html(value);
                } else {
                    object.attr('value', value);
                }
            });
        },
        
        submitOrder: function()
        {
            var validated = this.validateForm();
            if (!validated) {
                return;
            }

            $.ajax({
                type: 'POST',
                // url: 'https://stage.hewalex.pl/instalator/zamowienie/',
                url: '/wp-json/hewalex-zones/v2/addOrderCard',
                headers: {
                    'X-WP-Nonce': this.wp_nonce,
                },
                dataType: 'json',
                timeout: 10000,
                data: {
                    category: prepaidCard.orderCategory,
                    basket: JSON.parse(JSON.stringify(prepaidCard.getBasket())),
                    billing: JSON.parse(JSON.stringify(prepaidCard.getBillingData())),
                    shipping: JSON.parse(JSON.stringify($('#prepaidCardModal form').serializeArray()))
                },
                success: function() {
                    prepaidCard.hideModal();
                    prepaidCard.main.trigger('loading-overlay:show');
                    $.when(prepaidCard.getInstallerOrders()).then(function(response) {
                        prepaidCard.installerOrders = response;
                        prepaidCard.createMainContainerContent();
                    });
                    new AWN().success('Zamówienie zostało złożone.', options);
                    // new PNotify({
                    //     title: 'Powodzenie',
                    //     text: 'Zamówienie zostało złożone.',
                    //     hide: true,
                    //     buttons: {
                    //         sticker: false
                    //     }
                    // });
                },
                error: function(xhr) {
                    var response = JSON.parse(xhr.responseText);
                    switch (JSON.parse(xhr.status)) {
                        case 422:
                            prepaidCard.handleValidationErrors(response.errors);
                            break;
                        case 500:
                        default:
                            new AWN().alert('Nie udało się złożyć zamówienia.', options);
                            // new PNotify({
                            //     title: 'Błąd',
                            //     text: 'Nie udało się złożyć zamówienia.',
                            //     hide: true,
                            //     buttons: {
                            //         sticker: false
                            //     }
                            // });
                    }
                }
            });
        },
        
        validateForm: function()
        {
            var error = false;
            this.modalContainer.find('label.error').remove();
            this.modalContainer.find('form input[required]:visible').each(function() {
                if (!$(this).val()) {
                    $(this).closest('.form-control')
                        .after('<label class="error error-notify notification-alert">Pole wymagane</label>')
                        .closest('.form-group')
                        .addClass('has-error');
                    error = true;
                }
            });
            if (!error) {
                this.modalContainer.find('.has-error')
                    .removeClass('has-error')
                    .find('label.error')
                    .remove();
            }
            return !error;
        },
        
        getBasket: function()
        {
            return [{ref: 'ppcard', name: 'Karta prepaid', count: 1, price: 0}];
        },
        
        getBillingData: function()
        {
            var expectedFields = ['name', 'nip', 'address', 'city', 'zip', 'phone', 'email'],
                prefix = 'installers_',
                data = [];
        
            _.each(expectedFields, function (field) {
                data.push({name: field, value: prepaidCard.installerData[prefix + field]}); 
            });
            data.push({name: 'company', value: 1});
            
            return data;
        },
        
        hideModal: function()
        {
            this.modal.modal('toggle');
        },
        
        handleValidationErrors: function(errors)
        {
            this.modalContainer.find('.has-error')
                .removeClass('has-error')
                .find('label.error')
                .remove();
            
            _.each(errors, function(message, key) {
                var element = prepaidCard.modalContainer.find('[name^='+ key +']');
                var placement = element.closest('.input-group');
                if (!placement.get(0)) {
                    placement = element;
                }
                if (message !== '') {
                    placement.after('<label class="error">'+ message +'</label>');
                }
                element.closest('.form-group').removeClass('has-success').addClass('has-error');
            });
        },
        
        createActivationForm: function()
        {
            var months = _.map(
                Array.apply(0, Array(12)).map(function(v,i){return (i + 1 + '').padStart(2, '0')}),
                function(value) {
                    return '<option value="' + value + '">' + value + '</option>';
                }
            );
            var years = _.map(
                Array.apply(0, Array(6)).map(function(v,i){return moment().add('years', i).format('Y')}),
                function(value) {
                    return '<option value="' + value + '">' + value + '</option>';
                }
            );
            var htmlContent = '\n\
                <div class="modal-header">\n\
                    <button type="button" class="close" data-dismiss="modal">\n\
                        <span aria-hidden="true">×</span><span class="sr-only">Close</span>\n\
                    </button>\n\
                    <h4 class="modal-title">Formularz aktywacji karty prepaid</h4>\n\
                </div>\n\
                <div class="modal-body">\n\
                    <div class="panel-body">\n\
                        <p class="mb-xlg">Aby dokonać aktywacji wpisz poniżej dane z karty.</p>\n\
                        <form class="form-horizontal form-bordered">\n\
                            <div class="form-group">\n\
                                <label class="col-md-4 control-label" for="number">Numer karty</label>\n\
                                <div class="col-md-6">\n\
                                    <input type="text" value="" name="number" class="form-control" data-plugin-masked-input required>\n\
                                    <span class="font-size-xs">(10-cyfrowy kod na rewersie)</span>\n\
                                </div>\n\
                            </div>\n\
                            <div class="form-group">\n\
                                <label class="col-md-4 control-label" for="validDate">Data ważności</label>\n\
                                <div class="col-md-6 select-row">\n\
                                    <div class="select-group"><select type="text" name="validMonth" class="form-control" style="width: 65px; display: inline-block" required>\\' +
                                    months.join('\n') +
                                    '</select></div>\
                                    <span style="font-size: 20px">/</span>\
                                    <div class="select-group"><select type="text" name="validYear" class="form-control" style="width: 80px; display: inline-block" required>\\' +
                                    years.join('\n') +
                                    '</select></div>\
                                </div>\n\
                            </div>\n\
                            <input type="hidden" value="795" name="status">\n\
                        </form>\n\
                    </div>\n\
                </div>\n\
                <div class="modal-footer">\n\
                    <button class="btn btn-primary" name="submitBtn" onclick="prepaidCard.activate()">Aktywuj</button>\n\
                    <button class="btn btn-default" data-dismiss="modal">Anuluj</button>\n\
                </div>';
            this.modalContainer.html(htmlContent);
            this.modalContainer.find(".datepicker").datepicker({
                format: "yyyy-mm-dd",
                language: "pl",
                autoclose: true
            });
            this.modalContainer.find('input[name="number"]').mask('9999999999');
        },
        
        activate: function()
        {
            var validated = this.validateForm();
            if (!validated) {
                return;
            }

            var params = $('#prepaidCardModal form').serializeArray();
            params.push({
                name: 'validDate',
                value: moment([
                    (_.find(params, { name: 'validYear' })).value,
                    (_.find(params, { name: 'validMonth' })).value,
                    '01'
                ].join('-')).endOf('month').format('Y-MM-DD')
            })

            /**
             * @TODO
             * 1. przygotować metodę, która zmieni status jeśli karta będzie zamówiona? sprawdzić co kryje się w data
             */
            $.ajax({
                type: 'POST',
                // url: 'https://stage.hewalex.pl/json/installerprepaidcard/',
                // url: 'https://stage.hewalex.pl/json/installerprepaidcard/',
                url: '/wp-json/hewalex-zones/v2/installerprepaidcardpatch',
                headers: {
                    'X-WP-Nonce': this.wp_nonce,
                },
                dataType: 'json',
                timeout: 10000,
                data: {
                    // params: JSON.stringify(params)
                    params: JSON.parse(JSON.stringify(params))
                },
                success: function() {
                    prepaidCard.hideModal();
                    prepaidCard.main.trigger('loading-overlay:show');
                    $.when(prepaidCard.getData()).then(function(cardData) {
                        prepaidCard.data = cardData;
                        prepaidCard.createMainContainerContent();
                    });
                    new AWN().success('Karta została aktywowana.', options);
                    // new PNotify({
                    //     title: 'Powodzenie',
                    //     text: 'Karta została aktywowana.',
                    //     hide: true,
                    //     buttons: {
                    //         sticker: false
                    //     }
                    // });
                },
                error: function(xhr) {
                    var response = JSON.parse(xhr.responseText);
                    switch (JSON.parse(xhr.status)) {
                        case 422:
                            prepaidCard.handleValidationErrors(response.errors);
                            break;
                        case 500:
                        default:
                            new AWN().alert('Nie udało się aktywować karty.', options);
                            // new PNotify({
                            //     title: 'Błąd',
                            //     text: 'Nie udało się aktywować karty.',
                            //     hide: true,
                            //     buttons: {
                            //         sticker: false
                            //     }
                            // });
                    }
                }
            });
        }
    };
}();

