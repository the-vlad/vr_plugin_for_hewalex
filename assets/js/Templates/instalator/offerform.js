var app = angular.module('offerForm', ['ngSanitize']);

app.directive('ngDestroy', function () {
    return {
        restrict: 'A',
        require: '?ngModel',
        link: function ($scope, elem, attrs, ngModel) {
            $scope.$on('$destroy', function () {
                ngModel.$setViewValue(undefined);
            });
        }
    };
});

app.controller('formController', function ($scope, $timeout, $http, $sce) {
 
    $scope.hash = null;
    $scope.userId = null;
    $scope.products = null;

    $scope.init = function (params) {
        this.hash = params.hash;
        this.userId = params.userId;
        this.products = params.products;
        this.form.init();
        this.profitType.init();
        this.offer.loadOffer();
        $scope.summary.init();
    },

    $scope.offer = {
        products: {},
        totalPrice: 0,
        loadOffer: function () {
            $http({
                method: 'GET',
                // url: '/api/offers/userOffer?hash='+$scope.hash
                url: '/wp-json/hewalex-zones/v2/products_carts?hash='+$scope.hash,
            }).then(function (response) {
                $scope.offer.loadParams(response.data);
            }, function () {
                $scope.form.showErrorMessage = true;
            });
        },
        loadParams: function (data) {
            /* load products */
            $scope.offer.products = data.form_options.products;
            $scope.customProducts.setValues(data.form_options.customProducts);
            /* load contact data */
            $scope.name.setValue(this.getValueFromParams(data.contact, 'name'));
            $scope.city.setValue(this.getValueFromParams(data.contact, 'city'));
            $scope.zip.setValue(this.getValueFromParams(data.contact, 'zip'));
            $scope.phone.setValue(this.getValueFromParams(data.contact, 'phone'));
            $scope.address.setValue(this.getValueFromParams(data.contact, 'address'));
            /* load form options */
            $scope.taxRate.setValue(this.getValueFromParams(data.form_options.options, 'taxRate'));
            $scope.instalationCost.setValue(this.getValueFromParams(data.form_options.options, 'instalationCost'));
            $scope.deliveryCost.setValue(this.getValueFromParams(data.form_options.options, 'deliveryCost'));
            $scope.profitType.setValue(this.getValueFromParams(data.form_options.options, 'profitType'));
            $scope.profitPercent.setValue(this.getValueFromParams(data.form_options.options, 'profitPercent'));
            $scope.profitCost.setValue(this.getValueFromParams(data.form_options.options, 'profitCost'));
            /* load additional */
            $scope.offer.totalPrice = this.getValueFromParams(data.form_options.additional, 'totalPrice');
            $scope.comment.value = data.comment;
            $scope.summary.setSummary();
        },
        getValueFromParams: function (data, key) {
            var item = _.head(_.filter(data, {'id': key}));
            return _.get(item, 'value');
        }
    };

    $scope.totalPrice = function () {
        if (!$scope.offer.totalPrice) {
            return 0;
        }
        
        var price = parseFloat($scope.offer.totalPrice)
            + $scope.deliveryCost.getPrice()
            + $scope.instalationCost.getPrice();

        if ($scope.profitType.isSelectedPercent()) {
            price = price * $scope.profitPercent.getFraction();
        }

        if ($scope.profitType.isSelectedCost()) {
            price += $scope.profitCost.getPrice();
        }

        return price;
    };

    $scope.totalPriceWithTax = function () {
        var price = $scope.totalPrice();

        if ($scope.taxRate.isSelected()) {
            price = price * $scope.taxRate.getFraction();
        }

        return price;
    };

    $scope.form = {
        instance: $('#offerForm'),
        submitButton: $('#offerForm button'),
        finished: false,
        showErrorMessage: false,
        init: function () {
            this.instance.find('form').validate({
                unhighlight: function (element) {
                    $(element).closest('.input-group')
                        .removeClass('has-error');
                    $(element)
                        .removeClass('error');
                },
                errorPlacement: function (error, element) {
                    var placement = element.closest('.input-group');
                    if (!placement.get(0)) {
                        placement = element.closest('.form-control');
                    }
                    placement.after(error);
                }
            });
            $.extend($.validator.messages, {
                required: "Pole wymagane",
                email: "Podaj poprawny adres mailowy.",
                number: "Podaj poprawną liczbę.",
                digits: "Podaj tylko cyfry.",
                max: "Podaj wartość nie większą niż {0}.",
                min: "Podaj wartość nie mniejszą niż {0}."
            });
            $.validator.addMethod('precentageCheck', function (value, element, params) {
                let sum = parseInt(value);
                _.each(params, function (param) {
                    let val = $('input[name="' + param + '"]').val();
                    sum += parseInt(val);
                });
                return sum === 100;
            }, "Suma elementów musi być równa 100%");
            $.validator.addMethod('postcodeCheck', function (value) {
                var reg = /^\d{2}-\d{3}$/;
                return reg.test(value);
            }, "Niepoprawny kod pocztowy");
            $.validator.addMethod('phoneCheck', function (value) {
                var reg = /^\d{3}-\d{3}-\d{3}$/;
                return reg.test(value);
            }, "Numer telefonu powinien składać się wyłącznie z 9 cyfr");
        },
        reset: function () {
            location.reload();
        },
        send: function () {
            var validated = this.instance.find('form').valid();
            if (!validated) {
                return;
            }
            
            this.submitButton.button('loading');

            $http({
                method: 'POST',
                /**
                 * Dorobić metodę, która updatuje rekord
                 */
                // url: '/api/offers/updateoffer',
                url: '/wp-json/hewalex-zones/v2/updateCartFromShop',
                data: JSON.stringify($scope.form.getDataToSend())
            }).then(function (response) {
                $scope.form.submitButton.html('Generowanie ...').prop('disabled', true);
                $scope.form.downloadPdf(response.data);
            }, function (response) {
                switch (JSON.parse(response.status)) {
                    case 422:
                        $scope.form.handleValidationErrors(response.data.errors);
                        break;
                    case 500:
                    default:
                        $scope.form.showErrorMessage = true;
                }
            });
        },
        downloadPdf: function (data) {
            // var pdfURL = '/api/offers/download-offer?hash=' + data.hash;
            var pdfURL = '/wp-json/hewalex-zones/v2/offerFormPreview?hash=' + data.hash + '&reportHash=4dty74si';

            $http.get(pdfURL, {responseType: 'arraybuffer'}).then(function success(response) {
                var file = new Blob([response.data], {
                    type: 'application/pdf'
                }),
                url = window.URL || window.webkitURL;

                var fileName = 'Ofeta_' + data.number + '.pdf';
                var a = document.createElement("a");
                a.href = $sce.trustAsResourceUrl(url.createObjectURL(file));
                a.download = fileName;
                a.click();
                $scope.form.submitButton.button('reset');
            }, function (response) {
                $scope.form.submitButton.button('reset');
            });
        },
        getDataToSend: function () {
            let keysToExport = ['id', 'value', 'selectedId'];
            let groups = {};

            $scope.summary.setFormData();

            _.each($scope.formGroups, function (group) {
                groups[group] = _.filter($scope.formData, function (item) {
                    return _.includes(item.group, group);
                });
            });

            _.each(groups, function (items, groupName) {
                groups[groupName] = [];
                _.each(items, function (item) {
                    if (_.isArray(item.value)) {
                        _.each(item.value, function (itemvalue) {
                            groups[groupName].push(_.pick(itemvalue, keysToExport));
                        });
                    } else {
                        groups[groupName].push(_.pick(item, keysToExport));
                    }
                });
            });

            let data = {
                hash: $scope.hash,
                contact: groups.contact,
                comment: $scope.comment.value,
                form_options: {
                    options: groups.formOptions,
                    customProducts: groups.customProducts,
                    offer: groups.offer
                }
            };

            return data;
        },
        handleValidationErrors: function (errors) {
            var form = this.instance.find('form');
            form.find('.has-error')
                .removeClass('has-error')
                .find('label.error')
                .remove();
            _.each(errors, function (message, key) {
                var element = form.find('[name^=' + key + ']');
                var placement = element.closest('.input-group');
                if (!placement.get(0)) {
                    placement = element;
                }
                if (message !== '') {
                    placement.after('<label class="error">' + message + '</label>');
                }
                element.closest('.form-group').removeClass('has-success').addClass('has-error');
            });
        }
    };

    $scope.formGroups = ['contact', 'formOptions', 'customProducts', 'offer'];
    $scope.formData = [];

    $scope.name = {
        paramId: 'name',
        group: ['contact'],
        value: undefined,
        setValue: function (value) {
            if (value !== undefined) {
                this.value = value;
            }
            $scope.setFormDataValue(this, this.value);
        }
    };
    $scope.city = {
        paramId: 'city',
        group: ['contact'],
        value: undefined,
        setValue: function (value) {
            if (value !== undefined) {
                this.value = value;
            }
            $scope.setFormDataValue(this, this.value);
        }
    };
    $scope.address = {
        paramId: 'address',
        group: ['contact'],
        value: undefined,
        setValue: function (value) {
            if (value !== undefined) {
                this.value = value;
            }
            $scope.setFormDataValue(this, this.value);
        }
    };
    $scope.zip = {
        paramId: 'zip',
        group: ['contact'],
        value: undefined,
        setValue: function (value) {
            if (value !== undefined) {
                this.value = value;
            }
            $scope.setFormDataValue(this, this.value);
        }
    };
    $scope.phone = {
        paramId: 'phone',
        group: ['contact'],
        value: undefined,
        setValue: function (value) {
            if (value !== undefined) {
                this.value = value;
            }
            $scope.setFormDataValue(this, this.value);
        }
    };
    
    $scope.taxRate = {
        paramId: 'taxRate',
        group: ['formOptions'],
        options: [
            {id: "", value: undefined, displayName: "wybierz"},
            {id: "8", value: 8, displayName: "Stawka podatku VAT 8%"},
            {id: "23", value: 23, displayName: "Stawka podatku VAT 23%"}
        ],
        selected: undefined,
        init: function () {
            this.selected = this.options[0];
            $scope.setFormDataValue(this, this.selected.value);
        },
        setValue: function (value) {
            if (!value) {
                return;
            }
            this.selected = _.first(_.filter(this.options, function (item) {
                return item.id == value;
            }));
            this.onChange();
        },
        onChange: function () {
            let value = this.selected !== undefined ? this.selected.value : undefined;
            $scope.setFormDataValue(this, value);
        },
        isSelected: function () {
            return this.selected !== undefined && this.selected.id !== "";
        },
        getFraction: function () {
            return 1 + (this.selected.value / 100);
        }
    };
    $scope.instalationCost = {
        paramId: 'instalationCost',
        group: ['formOptions'],
        value: undefined,
        min: 0,
        step: 1,
        max: 99999,
        setValue: function (value) {
            this.value = value;
            $scope.setFormDataValue(this, this.value);
        },
        onChange: function () {
            $scope.setFormDataValue(this, this.value);
        },
        getPrice: function () {
            return angular.isNumber(this.value) ? parseFloat(this.value) : 0;
        }
    };
    $scope.deliveryCost = {
        paramId: 'deliveryCost',
        group: ['formOptions'],
        value: undefined,
        min: 0,
        step: 1,
        max: 99999,
        setValue: function (value) {
            this.value = value;
            $scope.setFormDataValue(this, this.value);
        },
        onChange: function () {
            $scope.setFormDataValue(this, this.value);
        },
        getPrice: function () {
            return angular.isNumber(this.value) ? parseFloat(this.value) : 0;
        }
    };
    $scope.profitType = {
        paramId: 'profitType',
        group: ['formOptions'],
        value: undefined,
        options: [
            {id: "percent", value: 1, displayName: "Procentowa"},
            {id: "cost", value: 2, displayName: "Kwota"}
        ],
        selected: undefined,
        init: function () {
            this.selected = this.options[1].id;
            $scope.setFormDataValue(this, this.selected);
        },
        setValue: function (value) {
            if (!value) {
                return;
            }
            this.selected = value;
            this.onChange();
        },
        onChange: function () {
            $scope.setFormDataValue(this, this.selected);
            $scope.profitPercent.onChange();
            $scope.profitCost.onChange();
        },
        isSelected: function () {
            return this.selected !== undefined && this.selected.id !== "";
        },
        isSelectedPercent: function () {
            return this.selected !== undefined && this.selected === 'percent';
        },
        isSelectedCost: function () {
            return this.selected !== undefined && this.selected === 'cost';
        }
    };
    $scope.profitPercent = {
        paramId: 'profitPercent',
        group: ['formOptions'],
        value: 0,
        min: 0,
        step: 1,
        max: 99999,
        setValue: function (value) {
            this.value = value;
            this.onChange();
        },
        onChange: function () {
            $scope.setFormDataValue(this, $scope.profitType.isSelectedPercent() ? this.value : null);
        },
        getFraction: function () {
            return 1 + ((angular.isNumber(this.value) ? this.value : 0) / 100);
        }
    };
    $scope.profitCost = {
        paramId: 'profitCost',
        group: ['formOptions'],
        value: 0,
        min: 0,
        step: 1,
        max: 99999,
        setValue: function (value) {
            this.value = value;
            this.onChange();
        },
        onChange: function () {
            $scope.setFormDataValue(this, $scope.profitType.isSelectedCost() ? this.value : null);
        },
        getPrice: function () {
            return angular.isNumber(this.value) ? this.value : 0;
        }
    };
    $scope.customProducts = {
        paramId: 'customProducts',
        group: ['customProducts'],
        items: [],
        setValues: function (items) {
            if (items) {
                $scope.customProducts.items = items;
                this.onChange();
            }
        },
        onChange: function () {
            $scope.setFormDataValue(this, this.items);
        }
    };

    $scope.addItem = {
        paramId: "addItem",
        value: "Dodaj",
        onChange: function () {
            let value = this.value || undefined;
            $scope.setFormDataValue(this, value);
        },
        onClick: function () {

        },
        addItem: function () {
            $scope.customProducts.items.push({value: "", name: ""});
        }
    };

    $scope.comment = {
        paramId: "comment",
        group: ['comment'],
        value: undefined,
        onChange: function () {
            let value = this.value || undefined;
            $scope.setFormDataValue(this, value);
        }
    };

    $scope.summary = {
        paramId: "summary",
        group: ['offer'],
        items: {},
        init: function () {
            this.setSummary();
        },
        setSummary: function () {
            $scope.summary.items = [
                {
                    id: "totalPrice",
                    name: "Wartość netto produktów hewalex",
                    value: $scope.formatPrice($scope.offer.totalPrice)
                },
                {
                    id: "totalPriceOffer", 
                    name: "Suma netto", 
                    value: $scope.formatPrice($scope.totalPrice())},
                {
                    id: "totalPriceOfferWithTax",
                    name: "Suma brutto",
                    value: $scope.formatPrice($scope.totalPriceWithTax())
                }
            ];
        },
        setFormData: function () {
            $scope.setFormDataValue(this, this.items);
        }
    };

    $scope.formatPrice = function (price) {
        return Math.round(price * 100) / 100;
    };

    /* common functions */
    $scope.setFormDataValue = function (model, value) {
        $scope.removeFormDataElement(model);
        $scope.summary.setSummary();

        if (value !== undefined && value !== null) {
            let paramIds = _.isArray(model.paramId) ? model.paramId : [model.paramId];
            _.each(paramIds, function () {
                let data = {
                    id: model.paramId,
                    value: value,
                    group: model.group
                };
                if (model.selected !== undefined) {
                    data.selectedId = model.selected.id;
                }
                $scope.formData.push(data);
            });
        }


    };

    $scope.removeFormDataElement = function (model) {
        _.remove($scope.formData, function (item) {
            return item.id === model.paramId;
        });
    };
});

// angular.bootstrap(document, ['offerForm']);
