// import 'angular';
// import 'angular-sanitize';
import rzSlider from 'angularjs-slider';
// import 'angular-chart.js';
// import 'jquery';
// import 'jquery-ui';
import html2canvas from "html2canvas";
// import 'lodash';

var app = angular.module('pvSlcTool', ['ngSanitize', 'rzSlider', 'chart.js']);

app.directive('ngDestroy', function () {
    return {
        restrict: 'A',
        require: '?ngModel',
        link: function($scope, elem, attrs, ngModel) {
            $scope.$on('$destroy', function() {
                ngModel.$setViewValue(undefined);
            });
        }
    };
});

app.controller('pvSlcToolAppMainController', function ($scope, $http, $q) {

    $scope.app = {
        instance: $('#pvSlcTool2'),
        modeOptions: { //@todo update modeOptions inside app
            production: 'production',
            dev: 'development'
        },
        config: {
            mode: 'production',
            slcForm: {
                unlockedSteps: false,
                disabledValidation: false
            }
        },
        status: {
            initialized: false,
            error: false
        },
        messages: {
            initError: 'Wystąpił nieoczekiwany błąd. Załaduj stronę ponownie.'
        },
        setConfig: function (config) {
            if (!config) {
                return;
            }
            this.config = _.merge(this.config, config);
            this.configure();
        },
        configure: function () {
            if (this.config.mode === 'development') {
                this.config.slcForm.unlockedSteps = this.config.slcForm.disabledValidation = true;
            }
            if ($scope.auth.user.isHewalexWorker()) {
                this.config.slcForm.unlockedSteps = true;
            }
        },
        isInitialized: function () {
            return this.status.initialized && !this.status.error;
        },
        hasInitError: function () {
            return this.status.error;
        },
        isDevMode: function () {
            return this.config.mode !== 'production';
        },
        isFriend: function () {
            if (localStorage.getItem('friend')) {
                this.instance.find('.door').hide();
            }
            if (_.toLower(this.password) === 'mellon') {
                this.instance.find('.door .lock').hide();
                this.instance.find('.door-wing-left').hide('slide', {direction: 'left'}, 1000);
                this.instance.find('.door-wing-right').hide('slide', {direction: 'right'}, 1000);
                localStorage.setItem("friend", true);
            }
        },
        init: function () {
            $scope.resources.load();
            $scope.auth.init();
        }
    };

    $scope.auth = {
        user: {
            options: [
                {id: 'mereMortal',    label: 'Zwykły Śmiertelnik'},
                {id: 'installer',     label: 'Instalator'},
                {id: 'hewalexWorker', label: 'Pracownik Hewalex'}
            ],
            selected: undefined,
            installer: undefined,
            hewalexWorker: undefined,
            isMereMortal: function () {
                if ($scope.app.isDevMode()) {
                    return this.selected && this.selected.id === 'mereMortal';
                }
                return !this.isInstaller() && !this.isHewalexWorker();
            },
            isInstaller: function () {
                if ($scope.app.isDevMode()) {
                    return this.selected && this.selected.id === 'installer';
                }
                return this.installer && this.installer.installers_id;
            },
            isHewalexWorker: function () {
                if ($scope.app.isDevMode()) {
                    return this.selected && this.selected.id === 'hewalexWorker';
                }
                return this.hewalexWorker && this.hewalexWorker.isAuthorizedWorker;
            },
            setUser: function (userId) {
                var index = _.findIndex(this.options, {id: userId});
                var selected = this.options[index];
                _.each(this.options, function (item) {
                    item.checked = item.id === selected.id ? true : false;
                });
                this.selected = selected;

                $scope.$broadcast('authChanged', {
                    userId: userId
                });
            },
            isSelected: function (userId) {
                return _.find(this.options, {id: userId}).checked ? true : false;
            }
        },
        init: function () {
            var installerAuth = $http({
                method: 'get',
                //url: 'https://stage.hewalex.pl/api/front/installer'
                url: '/wp-json/hewalex-zones/v2/installer',
                headers: {
                    'X-WP-Nonce': instalator_template_rest.nonce,
                },
            }).catch(function (e) {
                if (e.status >= 500) {
                    $scope.app.status.error = true;
                }
                return e;
            });
            var hewalexWorkerAuth = $http({
                method: 'get',
                //url: 'https://stage.hewalex.pl/api/front/installer'
                // url: 'https://hewalex.develtio.test/wp-json/hewalex-zones/v2/installer'
                url: '/wp-json/hewalex-zones/v2/hewalexPVWorker',
                headers: {
                    'X-WP-Nonce': instalator_template_rest.nonce
                },
            }).catch(function (e) {
                if (e.status >= 500) {
                    $scope.app.status.error = true;
                }
                return e;
            });
            var $this = this;

            console.log(installerAuth);

            $q.all([installerAuth, hewalexWorkerAuth]).then(function (responses) {
                var installerResponse = responses[0];
                var hewalexWorkerResponse = responses[1];
                var userId = undefined;

                if (hewalexWorkerResponse && hewalexWorkerResponse.status === 200) {
                    userId = 'hewalexWorker';
                    $this.user.hewalexWorker = hewalexWorkerResponse.data;
                    $this.user.installer = undefined;
                } else if (installerResponse && installerResponse.status === 200) {
                    userId = 'installer';
                    $this.user.installer = installerResponse.data;
                    $this.user.hewalexWorker = undefined;
                } else {
                    userId = 'mereMortal';
                    $this.user.installer = undefined;
                    $this.user.hewalexWorker = undefined;
                }

                $this.user.setUser(userId);
            });
        }
    };

    $scope.resources = {
        initialized: false,
        data: undefined,
        load: function() {
            var $this = this;
            $http({
                method: 'GET',
                //url: 'https://stage.hewalex.pl/api/offers/resources?category=calcpv'
                url: '/wp-json/hewalex-zones/v2/resources?category=calcpv'
            }).then(function (response) {
                $this.data = response.data;
                $scope.app.status.initialized = true;
            }, function () {
                $scope.app.status.error = true;
            }).then(function () {
                $scope.$broadcast('resourcesLoaded');
            });
        }
    };

    $scope.offer = {
        data: undefined,
        load: function () {
            var offerHash = this.getUrlParameter('offerHash');
            var offerId = this.getUrlParameter('offer_forms');
            var offerHistory = this.getUrlParameter('history');
            if (!offerHash) {
                return;
            }

            var $this = this;
            $http({
                method: 'GET',
                url: '/wp-json/hewalex-zones/v2/offerForm?hash=' + offerHash + '&offer_forms=' + offerId + '&history=' + offerHistory
            }).then(function (response) {
                $this.data = response.data;
            }, function () {
                $scope.app.status.error = true;
            }).then(function () {
                $scope.$broadcast('offerFormLoaded');
            });
        },
        getUrlParameter: function (sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        }
    };

    /* events */
    $scope.$on('authChanged', function () {
        $scope.app.configure();
    });

    $scope.$on('resourcesLoaded', function () {
        $scope.offer.load();
    });

    $scope.$on('slcFormTabChanged', function ($event, args) {
        var vars = {
            currentStepIndex: args.currentStepIndex,
            currentStepId: args.currentStepId
        };

        /* toggle first step progress bar */
        vars.currentStepIndex === 0
            ? $scope.app.instance.find('.initial-info').slideDown()
            : $scope.app.instance.find('.initial-info').slideUp();

        /* switch analyze step next button text */
        vars.currentStepId === 'analyze'
            ? $scope.app.instance.find('.pager li.next a').text('Wygeneruj ofertę')
            : $scope.app.instance.find('.pager li.next a').html('Następny krok <i class="fa fa-angle-right"></i>');

        /* highlight last step previous button */
        vars.currentStepId === 'offer'
            ? $scope.app.instance.find('.pager li.previous a').addClass('filled-pager')
            : $scope.app.instance.find('.pager li.previous a').removeClass('filled-pager');
    });
});

app.controller('pvSlcFormController', function ($scope, $rootScope, $http, $timeout) {

    $scope.form = {
        instance: $('#pvSlcForm'),
        config: {
            mode: 'default',
            userId: undefined
        },
        stepsOptions: [
            {id: "user",           href: "#pvForm-step-user",           displayName: "Dane użytkownika"},
            {id: "energy",         href: "#pvForm-step-energy",         displayName: "Zużycie energii"},
            {id: "building",       href: "#pvForm-step-building",       displayName: "Zabudowa paneli"},
            {id: "installation",   href: "#pvForm-step-installation",   displayName: "Parametry instalacji"},
            {id: "customizations", href: "#pvForm-step-customizations", displayName: "Modyfikacje"},
            {id: "analyze",        href: "#pvForm-step-analyze",        displayName: "Analiza opłacalności"},
            {id: "offer",          href: '#pvForm-step-offer',          displayName: "Generowanie oferty"}
        ],
        steps: [],
        totalSteps: undefined,
        currentStepIndex: undefined,
        data: {
            attachments: []
        },
        finished: false,
        showSendErrorMessage: false,
        sendButtonText: {
            options: {
                'default': 'Wyślij zapytanie o ofertę',
                'edit': 'Zapisz ofertę jako nową wersję'
            },
            value: undefined
        },
        sendInProgress: false,
        sendResult: {},
        setMode: function (mode) {
            this.config.mode = mode;

            /* set form send button text */
            this.sendButtonText.value = this.sendButtonText.options[mode] || '[unknown mode]';
        },
        isDefaultMode: function () {
            return this.config.mode === 'default';
        },
        isEditMode: function () {
            return this.config.mode === 'edit';
        },
        preInit: function () {
            this.setMode('default');

            /* init resources */
            this.initResources();

            /* init form jquery validation */
            this.initValidation();
        },
        initResources: function () {
            var resources = $scope.resources.data;
            $scope.formGroups = resources.formGroups;

            _.each(resources.formModels, function (model, modelId) {
                let control = $scope.formModels[modelId];
                if (control) {
                    _.merge(control, model);
                    if (_.has($scope.formModels[modelId], 'init')) {
                        $scope.formModels[modelId].init();
                    }
                }
            });

            _.each(resources.slcModels, function (model, modelId) {
                let control = $scope.slcModels[modelId];
                if (control) {
                    _.merge(control, model);
                    if (_.has($scope.slcModels[modelId], 'init')) {
                        $scope.slcModels[modelId].init();
                    }
                }
            });
        },
        init: function () {
            /* init form steps */
            this.initSteps();

            if ($scope.app.config.mode !== $scope.app.modeOptions.production) {
                /* init form models */
                _.each($scope.formModels, function (model, modelId) {
                    if (_.has(model, 'init')) {
                        $scope.formModels[modelId].init();
                    } else if (_.has(model, 'value') && !model.static) {//@todo separate static models from form models
                        $scope.formModels[modelId].value = undefined;
                    }
                });

                _.each($scope.slcModels, function (model, modelId) {
                    if (_.has(model, 'reset')) {
                        $scope.slcModels[modelId].reset();
                    } else if (_.has(model, 'value')) {
                        $scope.slcModels[modelId].value = undefined;
                    }
                });
            }
        },
        initSteps: function () {
            var $this = this;
            this.steps = _.filter(this.stepsOptions, function (step) {
                switch (step.id) {
                    case 'customizations':
                        return $this.config.userId !== 'mereMortal';
                    default:
                        return !step.hidden;
                }
            });

            this.steps[0].active = true;
            this.totalSteps = _.size(this.steps) - 1;
            this.currentStepIndex = 0;
            this.selectFirstStep();
        },
        initValidation: function () {
            if ($scope.app.config.slcForm.disabledValidation) {
                return;
            }
            $.extend($.validator.messages, {
                required: "Pole wymagane",
                email: "Podaj poprawny adres mailowy.",
                number: "Podaj poprawną liczbę.",
                digits: "Podaj tylko cyfry.",
                max: "Podaj wartość nie większą niż {0}.",
                min: "Podaj wartość nie mniejszą niż {0}."
            });
            this.instance.validate({
                unhighlight: function (element) {
                    $(element).closest('.input-group')
                        .removeClass('has-error')
                        .addClass('has-success');
                        // $('.error').addClass('notification-alert');
                        // $('.error').css('padding','10px 25px 10px 50px')
                },
                // highlight: function(element){
                //     $('.error').addClass('notification-alert');
                //     $('.error').css('padding','10px 25px 10px 50px')
                // },
                errorPlacement: function(error, element) {
                    var placement = element.closest('.input-group');
                    if (!placement.get(0)) {
                        placement = element.closest('.form-control');
                    }
                    placement.after(error);
                    $('label.error').addClass('notification-alert');
                    $('label.error').css('padding','10px 25px 10px 50px')
                }
            });
        },
        loadOffer: function () {
            var offerForm = $scope.offer.data;
            if (!offerForm) {
                return;
            }

            this.setMode('edit');

            var dataToLoad = _.concat(offerForm.contact || {}, offerForm.form_options.options || {});
            _.each(dataToLoad, function (item) {
                let control = $scope.formModels[item.id];
                if (!control) {
                    return;
                }
                if (_.isFunction(control.loadSaved)) {
                    control.loadSaved(item);
                    return;
                }
                if (control && item.value) {
                    control.value = item.value;
                }
                if (control && item.selectedId) {
                    control.selected = _.find(control.options, {id: item.selectedId});
                }
                if (control && (item.value || item.selectedId) && _.isFunction(control.onChange)
                    && (!_.isFunction(control.isUpdatable)
                        || (_.isFunction(control.isUpdatable) && control.isUpdatable()))) {
                    control.onChange(item.selectedId);
                }
            });

            /* custom products */
            $scope.basket.loadCustomProducts();

            /* custom terms */
            $scope.offerTerms.custom.load();
        },
        selectFirstStep: function () {
            this.onTabChange(this.currentStepIndex, 0);
            this.instance.find('.wizard-steps .nav-item:first').find('a').tab('show');
        },
        next: function () {
            var validated = $scope.app.config.slcForm.disabledValidation ? true : this.instance.valid();
            if (!validated) {
                this.focusInvalid();
                return false;
            }
            var newIndex = this.currentStepIndex + 1;
            this.onTabChange(this.currentStepIndex, newIndex);
            this.instance.find('.wizard-steps .nav-item.active').next().find('a').tab('show');
        },
        previous: function () {
            let previousStep = this.instance.find('.wizard-steps .nav-item.active').prev();
            if (previousStep.get(0)) {
                var newIndex = this.currentStepIndex - 1;
                this.onTabChange(this.currentStepIndex, newIndex);
                this.instance.find('.wizard-steps .nav-item.active').prev().find('a').tab('show');
            }
        },
        onTabClick: function ($event, stepId) {
            $event.preventDefault();
            var index = this.currentStepIndex;
            var newIndex = _.findIndex(this.steps, function (step) {
                return step.id === stepId;
            });
            if (newIndex === index + 1) {
                return this.next();
            } else if (newIndex > index + 1) {
                if ($scope.app.config.slcForm.unlockedSteps) {
                    var validated = $scope.app.config.slcForm.disabledValidation ? true : this.instance.valid();
                    if (!validated) {
                        this.focusInvalid();
                        return false;
                    }
                    this.onTabChange(index, newIndex);
                    this.instance.find('.wizard-steps .nav-item').eq(newIndex).find('a').tab('show');
                    return true;
                }
                return false;
            } else if (newIndex < index) {
                this.onTabChange(index, newIndex);
                this.instance.find('.wizard-steps .nav-item').eq(newIndex).find('a').tab('show');
            } else {
                return false;
            }
        },
        onTabChange: function (index, newIndex) {
            this.currentStepIndex = newIndex;
            var step = this.steps[newIndex];
            switch (step.id) {
                case 'analyze':
                    $scope.calcFunctions.updateAnalyze();
                    break;
            }

            this.focus();
            this.instance.find('ul.pager li.previous')[newIndex === 0 ? 'addClass' : 'removeClass']('hidden');
            this.instance.find('ul.pager li.next')[newIndex === this.totalSteps ? 'addClass' : 'removeClass']('hidden');

            $scope.refreshSliders();

            $rootScope.$broadcast('slcFormTabChanged', {
                currentStepIndex: newIndex,
                pastStepId: this.steps[index].id,
                currentStepId: this.steps[newIndex].id
            });
        },
        showStep: function (stepId) {
            var step = _.find(this.steps, {id: stepId});
            $scope.form.instance.find('.wizard-steps').find("a[href='"+step.href+"']").tab('show');
        },
        isStepActive: function (stepId) {
            if (this.currentStepIndex === undefined) {
                return false;
            }
            var currentStep = this.steps[this.currentStepIndex];
            return currentStep && currentStep.id === stepId;
        },
        isStepHidden: function (stepId) {
            var step = _.find(this.steps, {id: stepId});
            return step && step.hidden || false;
        },
        isFinished: function () {
            return this.finished === true;
        },
        inProgress: function () {
            return !this.isFinished();
        },
        reset: function () {
            location.reload();
        },
        focusInvalid: function () {
            $('html, body').animate({
                scrollTop: this.instance.find('.has-error').first().offset().top - 90
            }, 500);
        },
        focus: function () {
            var threshold = 700;
            if (this.instance.outerHeight() < threshold) {
                return;
            }

            $('html, body').animate({
                scrollTop: this.instance.offset().top - 90
            }, 500);
        },
        send: function () {
            var validated = $scope.app.config.slcForm.disabledValidation ? true : this.instance.valid();
            if (!validated) {
                this.focusInvalid();
                return;
            }

            if (this.sendInProgress) {
                return;
            }
            this.sendInProgress = true;
            this.showSendErrorMessage = false;
            var $this = this;

            //@temp solution due to html2canvas issue https://github.com/niklasvh/html2canvas/issues/117
            $this.showStep('analyze');
            window.scrollTo(0,0);
            //

            var financingCanvas = document.querySelector("#financingCanvas")
            financingCanvas.style.minWidth = '1000px';
            window.dispatchEvent(new Event('resize'));
            setTimeout(function() {
                html2canvas(document.querySelector("#financingCanvas canvas"), {
                    removeContainer: true
                }).then(function (canvas) {
                    $this.data.attachments.push({
                        id: 'summaryChart',
                        content: canvas.toDataURL('image/png'),
                        contentType: 'image/png',
                        ext: 'png'
                    });
                    financingCanvas.style.minWidth = 'initial';
                    window.dispatchEvent(new Event('resize'));
                }).then(function () {
                    //@temp solution due to html2canvas issue https://github.com/niklasvh/html2canvas/issues/117
                    $this.showStep('offer');
                    //
                    $http({
                        method: 'POST',
                        headers: {
                            'X-WP-Nonce': instalator_template_rest.nonce,
                            'Authorization': 'hewalex ' + 'VkGWr8NSxd38OaXEex',
                        },
                        url: '/wp-json/hewalex-zones/v2/offerForm',
                        //url: 'https://stage.hewalex.pl/api/offers/offerForm',
                        data: JSON.stringify($scope.form.getDataToSend())
                    }).then(function (response) {
                        $scope.form.handleSuccessResponse(response);
                    }, function (response) {
                        switch (JSON.parse(response.status)) {
                            case 422:
                                $scope.form.handleValidationErrors(response.data.errors);
                                break;
                            case 500:
                            default:
                                $scope.form.showSendErrorMessage = true;
                        }
                        $scope.form.sendInProgress = false;
                    });
                });

            }, 150)
        },
        getDataToSend: function () {
            /* keysToExport: paramId, modelValue, value, selected.id */
            let groups = {};
            _.each($scope.formGroups.form.subgroupsIds, function (groupId) {
                var groupModels = _.filter(_.merge($scope.formModels, $scope.slcModels), function (model) {
                    return _.includes(model.group, groupId);
                });
                groups[groupId] = [];
                _.each(groupModels, function (model) {
                    var modelIsHidden = $("[name='"+ model.paramId +"']").closest('.form-group').hasClass('ng-hide');
                    var modelHasValue = _.isFunction(model.hasValue)
                        ? model.hasValue()
                        : (model.value !== undefined || (model.selected !== undefined && model.selected.id !== ""));
                    if (modelIsHidden || !modelHasValue) {
                        return;
                    }

                    var modelDataToExport = {
                        id: model.paramId,
                        selectedId: model.selected && model.selected.id ? model.selected.id : undefined,
                        value: _.isFunction(model.getValueToSave) ? model.getValueToSave() : model.value,
                        modelValue: model.modelValue
                    };
                    modelDataToExport = _.pickBy(modelDataToExport, function (item) {
                        return item !== undefined;
                    });

                    groups[groupId].push(modelDataToExport);
                });
            });

            let data = {
                offer_form_category: 'calcpv',
                contact: groups.contact,
                form_options: {
                    options: groups.formOptions,
                    results: groups.summary,
                    products: $scope.basket.getProductsToSave(),
                    customProducts: $scope.basket.getCustomProductsToSave(),
                    customTerms: $scope.offerTerms.custom.getToSave(),
                    attachments: this.data.attachments,
                    parent_hash: $scope.offer.data ? $scope.offer.data : '',
                },
                offer_generated: 1,
                offer_verified: this.isEditMode() ? 0 : 1,
            };


            if (this.isEditMode()) {
                let offerForm = $scope.offer.data;
                data.parent_hash = offerForm.hash;
                data.root_hash = offerForm.root_hash || offerForm.hash;
            }

            if ($scope.auth.user.installer && $scope.auth.user.installer.installers_id) {
                data.user_id = $scope.auth.user.installer.installers_user_id;
            }

            return data;
        },
        handleSuccessResponse: function (response) {
            this.finished = true;
            this.sendResult = response.data;
        },
        handleValidationErrors: function (errors) {
            var $this = this;
            $this.instance.find('.has-error')
                .removeClass('has-error')
                .find('label.error')
                .remove();
            _.each(errors, function (message, key) {
                var element = $this.instance.find('[name^='+ key +']');
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
        getFormSummaryReportUrl: function () {
            if (!this.sendResult) {
                return '';
            }
            return '/wp-json/hewalex-zones/v2/offerForm?hash='+this.sendResult.offerHash
                +'&reportHash='+this.sendResult.reportHash
                +'&generated=1&download=1';
        }
    };

    $scope.formGroups = {};

    $scope.formModels = {
        /* step 1 */
        clientType: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            onChange: function () {
                $scope.slcModels.tax.calculate();
            },
            isCompany: function () {
                return this.selected && this.selected.id === 'company';
            }
        },
        companyVatDeduct: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            onChange: function () {
                $scope.slcModels.tax.calculate();
            },
            yes: function () {
                return this.selected && this.selected.id === 'y';
            }
        },
        region: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            onChange: function () {
                $scope.slcModels.locationSunEnergyOnGround.calculate();
                $scope.slcModels.totalEnergyFromSunPerYear.calculate();
            }
        },
        /* step 2 */
        countByType: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            onChange: function () {
                $scope.formModels.energyCostInPeriod.updateMinValue();
                $scope.slcModels.energyConstCost.calculate();
            },
            isSelected: function () {
                return this.selected && this.selected.id;
            },
            isByBills: function () {
                return this.selected && this.selected.id === 'byEnergyUsage&Bill';
            },
            isByPeopleCount: function () {
                return this.selected && this.selected.id === 'byPeopleCount';
            }
        },
        energyPeriodUnit: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            onChange: function () {
                $scope.formModels.energyCostInPeriod.updateMinValue();
                $scope.slcModels.energyUsageByYear.calculate();
                $scope.slcModels.energyCostByYear.calculate();
                $scope.slcModels.totalKwhCosts.calculate();
            },
            getPeriodFactor: function () {
                switch (true) {
                    case this.selected && this.selected.id === 'year':
                        return 1;
                    case this.selected && this.selected.id.includes('month'):
                        return 12 / this.selected.monthsNum;
                    default:
                        return 0;
                }
            }
        },
        energyUsageInPeriod: {
            value: undefined,
            min: 1,
            onChange: function () {
                $scope.slcModels.energyUsageByYear.calculate();
                $scope.slcModels.totalKwhCosts.calculate();
            }
        },
        energyCostInPeriod: {
            value: undefined,
            min: 0,
            onChange: function () {
                $scope.slcModels.energyCostByYear.calculate();
                $scope.slcModels.totalKwhCosts.calculate();
            },
            updateMinValue: function () {
                let value = 150 / $scope.formModels.energyPeriodUnit.getPeriodFactor();
                if (_.isNumber(value)) {
                    this.min = value;
                }
            }
        },
        flatPeopleCount: {
            value: undefined,
            min: 1,
            max: 15,
            onChange: function () {
                $scope.slcModels.totalKwhCosts.calculate();
                $scope.slcModels.energyUsageByYear.calculate();
                $scope.slcModels.energyCostByYear.calculate();
            }
        },
        energyCostDistibutor: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[2] : undefined;
            },
            onChange: function () {
                $scope.slcModels.totalKwhCosts.calculate();
                $scope.slcModels.energyCostByYear.calculate();
            }
        },
        /* step 3 */
        buildingOrientation: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            onChange: function () {
                $scope.slcModels.totalEnergyFromSunPerYear.calculate();
            }
        },
        buildingSurface: {
            value: undefined,
            min: 0,
            onChange: function () {
                $scope.slcModels.tax.calculate();
            }
        },
        montagePlace: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            onChange: function () {
                $scope.formModels.montageSystemType.filterOptions();
                $scope.slcModels.totalEnergyFromSunPerYear.calculate();
                $scope.formModels.montageSystemType.onChange();
            },
            isSelected: function () {
                return this.selected && this.selected.id;
            },
            isFlat: function () {
                return this.isSelected() && this.selected.id === 'flat';
            },
            isGround: function () {
                return this.isSelected() && this.selected.id === 'ground';
            },
            isSlanted: function () {
                return this.isSelected() && this.selected.id === 'slanted';
            }
        },
        roofAngle: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            onChange: function () {
                $scope.slcModels.totalEnergyFromSunPerYear.calculate();
            }
        },
        montageSystemType: {
            selected: undefined,
            filteredOptions: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            filterOptions: function () {
                this.filteredOptions = _.filter(this.options, function (item) {
                    if (item.id === 'custom') {
                        return $scope.auth.user.hewalexWorker && $scope.auth.user.hewalexWorker.isAuthorizedWorker;
                    }
                    return $scope.formModels.montagePlace.isSelected() && item.usage
                        ? item.usage === 'roof' + _.upperFirst($scope.formModels.montagePlace.selected.id)
                        : true;
                });
            },
            isSelected: function () {
                return this.selected && this.selected.id;
            },
            isCustom: function () {
                return this.isSelected() && this.selected.id === 'custom';
            },
            onChange: function () {
                $scope.slcModels.totalPrice.calculate();
                if (this.isCustom()) {
                    $scope.basket.removeProductByGroup('montageSystems');
                    $scope.formModels.customMontageSystemType.init();
                } else {
                    $scope.basket.addProduct(this.getBasketProduct(), this.getBasketProductQuanity());
                }
            },
            updateBasketProduct: function () {
                if (!this.isCustom()) {
                    $scope.basket.addProduct(this.getBasketProduct(), this.getBasketProductQuanity());
                }
            },
            getBasketProduct: function () {
                if ($scope.formModels.montagePlace.isFlat()) {
                    return _.find(this.options, {id: "poziomo1"});
                }
                if ($scope.formModels.montagePlace.isGround()) {
                    return _.find(this.options, {id: "grunt"});
                }
                if (!this.isSelected()) {
                    return null;
                }
                return this.selected;
            },
            getBasketProductQuanity: function () {
                if (this.isSelected() && this.selected.id === "poziomo2") {
                    return Math.ceil($scope.formModels.panelQuantity.value / 2);
                }
                return $scope.formModels.panelQuantity.value;
            },
            getPrice: function () {
                if ($scope.formModels.montagePlace.isFlat()) {
                    var system = _.find(this.options, {id: "poziomo1"});
                    return system.price[$scope.formModels.panelType.selected.id];
                }
                if ($scope.formModels.montagePlace.isGround()) {
                    var system = _.find(this.options, {id: "grunt"});
                    return system.price[$scope.formModels.panelType.selected.id];
                }
                if (!this.isSelected()) {
                    return null;
                }
                return this.selected.price[$scope.formModels.panelType.selected.id];
            },
            getMontagePrice: function () {
                if (this.isCustom()) {
                    return $scope.formModels.customMontageSystemType.getMontagePrice();
                }
                return (this.getPrice() + $scope.staticResources.constant.montageConstCost) * $scope.formModels.panelQuantity.value;
            }
        },
        customMontageSystemType: {
            items: [],
            init: function () {
                this.items = [];
            },
            hasAny: function () {
                return this.items.length !== 0;
            },
            addItem: function () {
                var montageSystem = this.options[0];
                this.items.push(montageSystem);
            },
            removeItem: function (key) {
                var item = this.items[key];
                $scope.basket.removeProduct(item.id);
                _.remove(this.items, {id: item.id});
                this.onChange();
            },
            onItemChange: function (key) {
                var item = this.items[key];
                $scope.basket.addProduct(item, item.quantity);
                this.onChange();
            },
            onChange: function () {
                $scope.slcModels.totalMontageSystemsItemsQty.calculate();
                $scope.slcModels.totalPrice.calculate();
            },
            getMontagePrice: function () {
                var price = 0;
                var montageConstCost = $scope.staticResources.constant.montageConstCost;
                var $this = this;
                _.each(this.items, function (item) {
                    if (!item.id) {
                        return;
                    }
                    var montageSystem = _.find($this.options, {id: item.id});
                    var selectedPanel = $scope.formModels.panelType.selected;
                    price += (montageConstCost + montageSystem.price[selectedPanel.id]) * item.quantity || 0;
                });
                return price;
            },
            hasValue: function () {
                return this.hasAny();
            },
            loadSaved: function (data) {
                var $this = this;
                _.each(data.value || [], function (val) {
                    var item = _.find($this.options, {id: val.id});
                    if (item) {
                        $this.items.push(_.merge(_.clone(item), val));
                        $scope.basket.addProduct(item, val.quantity);
                    }
                });
                $this.onChange();
            },
            getValueToSave: function () {
                var data = [];
                _.each(this.items, function (item) {
                    data.push(_.pick(item, ['id', 'quantity']));
                });
                return data;
            }
        },
        /* step 4 */
        panelType: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            onChange: function () {
                $scope.formModels.panelQuantity.calculate();
                $scope.basket.addProduct(this.selected, $scope.formModels.panelQuantity.value);
            },
            isOptionVisible: function (panel) {
                var key = 'hidden.calcpv.' + $scope.form.config.mode + 'Mode';
                if (_.has(panel, key)) {
                    return !_.get(panel, key);
                }
                return !panel.hidden.calcpv || false;
            }
        },
        adjustInstallationToUsage: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            yes: function () {
                return this.selected !== undefined && this.selected.id === 'y';
            },
            onChange: function () {
                if (this.yes()) {
                    $scope.formModels.panelQuantity.setValueAsDefault();
                    $scope.slcModels.installationMaxPower.setValueAsDefault();
                    $scope.slcModels.installationEnergyUsageCoverage.setValueAsDefault();
                    $scope.slcModels.energyUsageCoverageProsumer.setValueAsDefault();
                }

                $scope.formModels.panelQuantity.calculate();
            }
        },
        panelQuantity: {
            value: undefined,
            defaultValue: undefined,
            min: undefined,
            max: undefined,
            requires: ['panelType', 'energyUsageByYear', 'totalEnergyFromSunPerYear'],
            panelQuantityButtonAction: undefined,
            onChange: function () {
                $scope.slcModels.installationMaxPower.calculate();
                $scope.slcModels.installationEnergyUsageCoverage.calculate();
                $scope.slcModels.energyUsageCoverageProsumer.calculate();
                $scope.slcModels.totalPrice.calculate();

                $scope.initGroup($scope.formGroups.installationStepSummary, _.merge($scope.formModels, $scope.slcModels));

                $scope.basket.addProduct($scope.formModels.panelType.selected, this.value);
                $scope.formModels.montageSystemType.updateBasketProduct();
            },
            onCalculated: function () {
                $scope.formModels.inverterType.setCalculated();
                $scope.formModels.inverterType.updateAvailableInverters();
            },
            increment: function () {
                this.panelQuantityButtonAction = 'increment';
                this.calculate();
            },
            decrement: function () {
                this.panelQuantityButtonAction = 'decrement';
                this.calculate();
            },
            setValueAsDefault: function () {
                this.defaultValue = this.value;
            },
            calculate: function () {
                if (!$scope.hasRequiredData(this)) {
                    this.value = undefined;
                    return;
                }

                var panel = $scope.formModels.panelType.selected,
                    biggestInverter = _.last($scope.formModels.inverterType.options),
                    smallestInverter = _.first($scope.formModels.inverterType.options);

                this.max = Math.floor(biggestInverter.nominalPower * biggestInverter.powerLimits[panel.id].max / panel.maxPower);
                this.min = Math.ceil(smallestInverter.nominalPower * smallestInverter.powerLimits[panel.id].min / panel.maxPower);
                var requiredPanelQuantity = Math.ceil(
                    $scope.slcModels.energyUsageByYear.value /
                    $scope.slcModels.totalEnergyFromSunPerYear.value /
                    panel.efficiency /
                    panel.surface * 1000 /
                    $scope.staticResources.constant.inverterEfficiency /
                    $scope.staticResources.constant.otherComponentsEfficiency
                );

                var tempPanelQuantity = undefined;
                if ($scope.formModels.adjustInstallationToUsage.yes()) {
                    tempPanelQuantity = Math.max(Number(this.value || 0 ), this.min);
                    if (this.panelQuantityButtonAction === 'increment') {
                        tempPanelQuantity++;
                    }
                    if (this.panelQuantityButtonAction === 'decrement') {
                        tempPanelQuantity--;
                    }
                } else {
                    tempPanelQuantity = requiredPanelQuantity;
                }

                var index = undefined;
                do {
                    for (var i = 0; i < $scope.formModels.inverterType.options.length; i++) {
                        if (tempPanelQuantity > this.max) {
                            index = $scope.formModels.inverterType.options.length - 1;
                            break;
                        }
                        if ($scope.formModels.inverterType.options[i].isVariant) {
                            continue;
                        }

                        $scope.slcModels.installationMaxPower.calculate(tempPanelQuantity);
                        var installationMaxPower = $scope.slcModels.installationMaxPower.value;
                        var inverter = $scope.formModels.inverterType.options[i];
                        var inverterMinPower = _.round(inverter.nominalPower * inverter.powerLimits[panel.id].min, 2);
                        var inverterMaxPower = _.round(inverter.nominalPower * inverter.powerLimits[panel.id].max, 2);

                        if (installationMaxPower >= inverterMinPower && installationMaxPower <= inverterMaxPower) {
                            index = i;
                            break;
                        }
                    }
                    if (index === undefined) {
                        if ($scope.formModels.adjustInstallationToUsage.yes()) {
                            ((tempPanelQuantity > this.min) && this.panelQuantityButtonAction === 'decrement')
                                ? tempPanelQuantity-- : tempPanelQuantity++;
                        } else {
                            tempPanelQuantity++;
                        }
                    }
                } while (index === undefined);

                this.panelQuantityButtonAction = undefined;

                if (tempPanelQuantity > this.max) {
                    $scope.formModels.inverterType.setMaxIndex();
                    this.value = this.max;
                }
                else if (this.value < this.min) {
                    $scope.formModels.inverterType.setMinIndex();
                    this.value = this.min;
                } else {
                    $scope.formModels.inverterType.setIndex(index);
                    this.value = tempPanelQuantity;
                }

                this.onCalculated();
                this.onChange();
            }
        },
        inverterType: {
            selected: undefined,
            selectedIndex: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
                this.selectedIndex = 0;
            },
            onChange: function () {
                if (!this.selected) {
                    return;
                }

                $scope.basket.addProduct(this.selected, 1);
                $scope.basket.addProduct($scope.products.getSwitchgear(this.selected), 1);
                $scope.basket.addProduct($scope.products.getConnector(), 4);

                $scope.formModels.wireType.selectByInverterType(this.selected);
                $scope.slcModels.totalPrice.calculate();
            },
            setCalculated: function () {
                this.selected = this.options[this.selectedIndex];
                this.onChange();
            },
            setMaxIndex: function () {
                this.selectedIndex = this.options.length - 1;
            },
            setMinIndex: function () {
                this.selectedIndex = 0;
            },
            setIndex: function (index) {
                this.selectedIndex = index;
            },
            updateAvailableInverters: function () {
                if ($scope.form.isEditMode()) {
                    return;
                }

                var $this = this;
                this.options.forEach(function (option) {
                    option.disabled = option.nominalPower < $this.selected.nominalPower ? true : false;
                });
            }
        },
        wireType: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            selectByInverterType: function (inverter) {
                this.selected = _.find(this.options, function (option) {
                    return _.includes(option.inverters, inverter.id) && !option.isVariant;
                });
                this.onChange();
            },
            onChange: function () {
                if (!this.isSelected()) {
                    return;
                }

                $scope.basket.addProduct(this.selected, 1);
                $scope.slcModels.totalPrice.calculate();
            },
            isSelected: function () {
                return this.selected && this.selected.id;
            }
        },
        /* customizations step */
        rebateType: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            onChange: function () {
                $scope.slcModels.totalPrice.calculate();

                if (this.isAmount()) {
                    $scope.formModels.rebateAmount.updateMaxValue();
                }
            },
            isSelected: function () {
                return this.selected && this.selected.id;
            },
            isPrecent: function () {
                return this.selected && this.selected.id === '%';
            },
            isAmount: function () {
                return this.selected && this.selected.id === 'amount';
            }
        },
        rebatePrecent: {
            value: undefined,
            min: 0,
            max: 100,
            onChange: function () {
                $scope.slcModels.totalPrice.calculate();
            }
        },
        rebateAmount: {
            value: undefined,
            min: 0,
            max: undefined,
            onChange: function () {
                $scope.slcModels.totalPrice.calculate();
            },
            updateMaxValue: function () {
                this.max = $scope.slcModels.totalPrice.getNetValue();
            }
        },
        profitMarginType: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            onChange: function () {
                $scope.slcModels.totalPrice.calculate();
            },
            isPrecent: function () {
                return this.selected && this.selected.id === '%';
            },
            isAmount: function () {
                return this.selected && this.selected.id === 'amount';
            }
        },
        profitMarginPrecent: {
            value: undefined,
            min: 0,
            max: 100,
            onChange: function () {
                $scope.slcModels.totalPrice.calculate();
            }
        },
        profitMarginAmount: {
            value: undefined,
            min: 0,
            onChange: function () {
                $scope.slcModels.totalPrice.calculate();
            }
        },
        montageCost: {
            value: undefined,
            min: 0,
            onChange: function () {
                $scope.slcModels.totalPrice.calculate();
            }
        },
        deliveryCost: {
            value: undefined,
            min: 0,
            onChange: function () {
                $scope.slcModels.totalPrice.calculate();
            }
        },
        offerValidPeriod: {
            value: undefined,
            init: function () {
                this.value = this.defaultValue;
            },
            onChange: function () {
                if (!this.value) {
                    this.value = this.defaultValue;
                }
            }
        },
        orderDeadline: {
            value: undefined,
            init: function () {
                this.value = this.defaultValue;
            },
            onChange: function () {
                if (!this.value) {
                    this.value = this.defaultValue;
                }
            }
        },
        /* step 6 */
        analyzeBase: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            }
        },
        financingType: {
            selected: undefined,
            init: function () {
                _.each(this.options, function (item) {
                    switch (item.id) {
                        case 'wlasne&Kredyt':
                            item.disabled = $scope.form.config.userId === 'installer' ? true : false;
                            break;
                    }
                });
                this.selected = this.options ? this.options[0] : undefined;
            },
            isSelected: function () {
                return this.selected && this.selected.id !== '';
            },
            isCredit: function () {
                return this.isSelected() && this.selected.id === 'wlasne&Kredyt';
            },
            isOwnFinancing: function () {
                return this.isSelected() && this.selected.id === 'wlasne';
            },
            onChange: function (selectedId) {
                this.selected = _.find(this.options, {id: selectedId});
                $scope.slcModels.installationCost.calculate();
            },
            isChecked: function (id) {
                return this.selected.id === id;
            }
        },
        creditType: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            },
            isSantander60: function () {
                return this.selected && this.selected.id === 'santander60';
            },
            isCustomCredit : function () {
                return this.selected && this.selected.id === 'innyKredyt';
            },
            onChange: function () {
                $scope.slcModels.installationCost.calculate();
            }
        },
        creditCoverageAmount: {
            value: undefined,
            defaultValue: 0,
            options: {
                floor: 0,
                ceil: 10000,
                step: 100,
                precision: 1,
                draggableRange: false,
                showSelectionBar: false,
                hideLimitLabels: true,
                readOnly: false,
                disabled: false,
                showTicks: false,
                showTicksValues: false,
                onChange: function() {
                    $scope.slcModels.installationCost.calculate();
                }
            },
            init: function () {
                this.value = this.defaultValue;
                this.options.onChange();
            },
            setMax: function (value) {
                this.options.ceil = value;
            }
        },
        creditYears: {
            value: undefined,
            defaultValue: 1,
            options: {
                floor: 1,
                ceil: 10,
                step: 1,
                precision: 1,
                draggableRange: false,
                showSelectionBar: false,
                hideLimitLabels: true,
                readOnly: false,
                disabled: false,
                showTicks: false,
                showTicksValues: false,
                onChange: function () {
                    $scope.slcModels.installationCost.calculate();
                }
            },
            init: function () {
                this.value = this.defaultValue;
                this.options.onChange();
            }
        },
        creditPrecentage: {
            value: undefined,
            defaultValue: 0.1,
            options: {
                floor: 0.1,
                ceil: 15,
                step: 0.1,
                precision: 2,
                draggableRange: false,
                showSelectionBar: false,
                hideLimitLabels: true,
                readOnly: false,
                disabled: false,
                showTicks: false,
                showTicksValues: false,
                onChange: function () {
                    $scope.slcModels.installationCost.calculate();
                }
            },
            init: function () {
                this.value = this.defaultValue;
                this.options.onChange();
            }
        },
        creditInitialPayment: {
            value: undefined,
            defaultValue: 0,
            options: {
                floor: 0,
                ceil: 2000,
                step: 10,
                precision: 1,
                draggableRange: false,
                showSelectionBar: false,
                hideLimitLabels: true,
                readOnly: false,
                disabled: false,
                showTicks: false,
                showTicksValues: false,
                onChange: function () {
                    $scope.slcModels.installationCost.calculate();
                }
            },
            init: function () {
                this.value = this.defaultValue;
                this.options.onChange();
            }
        },
        mojPrad: {
            value: undefined,
            isHidden: function () {
                var instMaxPower = $scope.slcModels.installationMaxPower.value;
                return $scope.formModels.clientType.isCompany() || instMaxPower < 2 || instMaxPower > 10;
            },
            isDisabled: function () {
                return $scope.form.isEditMode() ? false : (this.disabled || false);
            },
            onChange: function () {
                if (!this.value) {
                    this.value = this.defaultValue;
                }
                $scope.slcModels.installationCost.calculate();
            },
            isSelected: function () {
                return this.value === true;
            }
        },
        ulgaTermo: {
            value: undefined,
            isHidden: function () {
                return $scope.formModels.clientType.isCompany();
            },
            onChange: function () {
                if (!this.value) {
                    this.value = this.defaultValue;
                }
                $scope.slcModels.installationCost.calculate();
            },
            isSelected: function () {
                return this.value === true;
            }
        },
        dofinansowanie: {
            value: undefined,
            isHidden: function () {
                return false;
            },
            onChange: function () {
                if (!this.value) {
                    this.value = this.defaultValue;
                }
                $scope.slcModels.installationCost.calculate();
            },
            isSelected: function () {
                return this.value === true;
            }
        },
        dofinansowanieValue: {
            value: undefined,
            min: 0,
            max: undefined,
            onChange: function () {
                $scope.slcModels.installationCost.calculate();
            },
            updateMax: function () {
                if ($scope.slcModels.installationCost.value !== undefined && this.value !== undefined) {
                    this.max = $scope.slcModels.installationCost.value + this.value;
                }
            }
        },
        ownEnergyConsumptionFactor: {
            value: undefined,
            defaultValue: 20,
            options: {
                floor: 5,
                ceil: 100,
                step: 1,
                precision: 0,
                draggableRange: false,
                showSelectionBar: false,
                hideLimitLabels: true,
                readOnly: false,
                disabled: false,
                showTicks: false,
                showTicksValues: false,
                translate: function (value) {
                    return value + $scope.formModels.ownEnergyConsumptionFactor.unit;
                },
                onChange: function () {
                    $scope.slcModels.installationEnergyUsageCoverage.calculate();
                    $scope.slcModels.energyUsageCoverageProsumer.calculate();
                    $scope.calcFunctions.updateAnalyze();
                }
            },
            calculate: function () {
                this.value = this.value + ($scope.formModels.optiener.isSelected() ? 15 : 0);
            },
            init: function () {
                this.value = this.defaultValue;
                this.options.onChange();
            },
            getFactor: function () {
                return this.value / 100;
            },
            setDefaultValue: function () {
                this.value = this.defaultValue;
                this.options.onChange();
            }
        },
        energyCostGrowthByYear: {
            value: undefined,
            defaultValue: 2,
            options: {
                floor: 0,
                ceil: 15,
                step: 1,
                precision: 0,
                draggableRange: false,
                showSelectionBar: false,
                hideLimitLabels: true,
                readOnly: false,
                disabled: false,
                showTicks: false,
                showTicksValues: false,
                translate: function (value) {
                    return value + $scope.formModels.energyCostGrowthByYear.unit;
                },
                onChange: function () {
                    $scope.calcFunctions.updateAnalyze();
                }
            },
            init: function () {
                this.value = this.defaultValue;
                this.options.onChange();
            },
            getFactor: function () {
                return this.value / 100;
            }
        },
        optiener: {
            value: undefined,
            onChange: function () {
                if (this.isSelected()) {
                    var optiEnerSet = $scope.products.get('optiEnerSet');
                    $scope.formModels.ownEnergyConsumptionFactor.value = Math.min(100, $scope.formModels.ownEnergyConsumptionFactor.value + 15);
                    $scope.basket.addProduct(optiEnerSet, 1);
                    $scope.basket.addProduct($scope.products.get('modem'), 1);
                } else {
                    $scope.formModels.ownEnergyConsumptionFactor.value = Math.max(0, $scope.formModels.ownEnergyConsumptionFactor.value - 15);
                    $scope.basket.removeProduct('optiEnerSet');
                    $scope.basket.removeProduct('modem');
                }

                $scope.slcModels.installationEnergyUsageCoverage.calculate();
                $scope.slcModels.energyUsageCoverageProsumer.calculate();
                $scope.slcModels.totalPrice.calculate();
            },
            isSelected: function () {
                return this.value === true;
            }
        },
        guaranteePeriod: {},
        /* offer form */
        name: {
            value: undefined
        },
        email: {
            value: undefined
        },
        areaCode: {
            value: undefined,
            init: function () {
                this.value = this.defaultValue;
            }
        },
        phone: {
            value: undefined,
            onChange: function () {
                if (this.value) {
                    this.value = this.value.split('-').join('');
                }
            }
        },
        address: {
            value: undefined
        },
        city: {
            value: undefined
        },
        zip: {
            value: undefined
        },
        accept_mailing: {
            value: undefined,
            onChange: function () {
                if (!this.value) {
                    this.value = this.defaultValue;
                }
            }
        },
        accept_data: {
            value: undefined,
            onChange: function () {
                if (!this.value) {
                    this.value = this.defaultValue;
                }
            }
        },
        offerRspUId: {
            selected: undefined,
            init: function () {
                this.selected = this.options ? this.options[0] : undefined;
            }
        }
    };

    $scope.slcModels = {
        locationSunEnergyOnGround: {
            value: undefined,
            requires: ['region'],
            precision: 0,
            isHidden: function () {
                return !this.value;
            },
            calculate: function () {
                if (!$scope.hasRequiredData(this)) {
                    this.value = undefined;
                    return;
                }

                var regionId = $scope.formModels.region.selected.id;
                var regionEnergy = _.find($scope.staticResources.sunEnergyByVoivodeship, {id: regionId});
                var groundEnergy = _.find(regionEnergy.energy, {direction: 'grunt'}).totalEnergyPerM2;

                this.value = groundEnergy / 1000;
            }
        },
        totalEnergyFromSunPerYear: {
            value: undefined,
            requires: [],
            calculate: function () {
                if ($scope.formModels.montagePlace.isSlanted()) {
                    this.requires = ['region', 'buildingOrientation', 'montagePlace', 'roofAngle'];
                } else {
                    this.requires = ['region', 'buildingOrientation', 'montagePlace'];
                }
                if (!$scope.hasRequiredData(this)) {
                    this.value = undefined;
                    return;
                }

                var regionId = $scope.formModels.region.selected.id;
                var direction = $scope.formModels.montagePlace.isFlat() || $scope.formModels.montagePlace.isGround()
                    ? 's30'
                    : ($scope.formModels.buildingOrientation.selected.id + $scope.formModels.roofAngle.selected.value);

                var regionEnergy = _.find($scope.staticResources.sunEnergyByVoivodeship, {id: regionId});
                this.value = _.find(regionEnergy.energy, {direction: direction}).totalEnergyPerM2;

                this.onChange();
            },
            onChange: function () {
                $scope.formModels.panelQuantity.calculate();
            }
        },
        energyUsageByYear: {
            value: undefined,
            requires: [],
            isHidden: function () {
                return !this.value;
            },
            calculate: function () {
                if (!$scope.formModels.countByType.isSelected()) {
                    this.value = undefined;
                    return;
                }
                if ($scope.formModels.countByType.isByBills()) {
                    this.requires = ['energyUsageInPeriod', 'energyPeriodUnit'];
                    this.value = $scope.hasRequiredData(this)
                        ? $scope.formModels.energyUsageInPeriod.value * $scope.formModels.energyPeriodUnit.getPeriodFactor()
                        : undefined;
                }
                if ($scope.formModels.countByType.isByPeopleCount()) {
                    this.requires = ['flatPeopleCount'];
                    this.value = $scope.hasRequiredData(this)
                        ? 750 * $scope.formModels.flatPeopleCount.value + 300
                        : undefined;
                }

                this.onChange();
            },
            onChange: function () {
                $scope.formModels.panelQuantity.calculate();
            },
            isOverLimit: function () {
                return this.value > 12000;
            }
        },
        energyCostByYear: {
            value: undefined,
            requires: [],
            precision: 0,
            isHidden: function () {
                return !this.value;
            },
            calculate: function () {
                if (!$scope.formModels.countByType.isSelected()) {
                    this.value = undefined;
                    return;
                }
                if ($scope.formModels.countByType.isByBills()) {
                    this.requires = ['energyCostInPeriod', 'energyPeriodUnit'];
                    this.value = $scope.hasRequiredData(this)
                        ? $scope.formModels.energyCostInPeriod.value / $scope.slcModels.tax.getEnergyFactor() * $scope.formModels.energyPeriodUnit.getPeriodFactor()
                        : undefined;
                }
                if ($scope.formModels.countByType.isByPeopleCount()) {
                    this.requires = ['totalKwhCosts', 'energyUsageByYear'];
                    if (!$scope.hasRequiredData(this)) {
                        this.value = undefined;
                        return;
                    }

                    var a = ($scope.slcModels.totalKwhCosts.getNetValue() * $scope.slcModels.energyUsageByYear.value);
                    var b = 1;
                    var power = 0;
                    this.value = (( (a) * (Math.pow(b, power)) ) + (a) * (Math.pow(b, power + 1)) ) / 2;
                }
            },
            getGrossValue: function () {
                this.labelTax = this.labelTaxOptions ? this.labelTaxOptions.gross : '';
                if (!this.value) {
                    return undefined;
                }
                return this.value * $scope.slcModels.tax.getEnergyFactor();
            },
            getNetValue: function () {
                this.labelTax = this.labelTaxOptions ? this.labelTaxOptions.net : '';
                return this.value;
            }
        },
        energyConstCost: {
            value: undefined,
            precision: 2,
            calculate: function () {
                this.value = $scope.formModels.countByType.isByBills()
                    ? 7.32
                    : 0;
            },
            getNetValue: function () {
                return this.value;
            },
            getGrossValue: function () {
                if (!this.value) {
                    return undefined;
                }
                return this.value * $scope.slcModels.tax.getEnergyFactor();
            }
        },
        totalKwhCosts: {
            value: undefined,
            requires: [],
            precision: 2,
            isHidden: function () {
                return !this.value;
            },
            calculate: function () {
                if (!$scope.formModels.countByType.isSelected()) {
                    this.value = undefined;
                    return;
                }
                if ($scope.formModels.countByType.isByBills()) {
                    this.requires = ['energyUsageByYear', 'energyCostByYear'];
                    if (!$scope.hasRequiredData(this)) {
                        this.value = undefined;
                        return;
                    }

                    var energyConstCost = $scope.slcModels.energyConstCost.value;
                    var value = ($scope.slcModels.energyCostByYear.getNetValue() - 12 * energyConstCost) / $scope.slcModels.energyUsageByYear.value;
                    this.value = value >= 0 ? value : 0;
                }
                if ($scope.formModels.countByType.isByPeopleCount()) {
                    this.requires = ['energyCostDistibutor'];
                    this.value = $scope.hasRequiredData(this)
                        ? $scope.formModels.energyCostDistibutor.selected.kWhCost
                        : undefined;
                }
            },
            getGrossValue: function () {
                this.labelTax = this.labelTaxOptions ? this.labelTaxOptions.gross : '';
                if (!this.value) {
                    return undefined;
                }
                return this.value * $scope.slcModels.tax.getEnergyFactor();
            },
            getNetValue: function () {
                this.labelTax = this.labelTaxOptions ? this.labelTaxOptions.net : '';
                return this.value;
            }
        },
        avgYearlyTGEKwhCosts: {
            requires: [],
            precision: 2,
            getGrossValue: function () {
                this.setDefaults()
                return this.value * $scope.slcModels.tax.getEnergyFactor();
            },
            getNetValue: function () {
                this.setDefaults()
                return this.value;
            },
            setDefaults: function () {
                console.log($scope.$parent.app.config);
                this.value = $scope.$parent.app.config.rceAvgPrice;
                this.labelTax = this.labelTaxOptions ? this.labelTaxOptions.net : '';
            },
        },
        totalMontageSystemsItemsQty: {
            value : 0,
            reset: function () {
                this.value = 0;
            },
            isHidden: function () {
                return !$scope.formModels.montageSystemType.isCustom();
            },
            calculate: function () {
                var items = $scope.formModels.customMontageSystemType.items || [];
                var qty = 0;
                _.each(items, function (item) {
                    qty += item.quantity || 0;
                });
                this.value = qty;
            }
        },
        installationMaxPower: {
            value: undefined,
            defaultValue: undefined,
            isHidden: function () {
                return !this.value;
            },
            requires: ['panelType'],
            precision: 2,
            setValueAsDefault: function () {
                this.defaultValue = this.value;
            },
            calculate: function (panelQuantity) {
                if (panelQuantity === undefined) {
                    panelQuantity = $scope.formModels.panelQuantity.value;
                }

                this.value = ($scope.hasRequiredData(this) && panelQuantity)
                    ? $scope.formModels.panelType.selected.maxPower * panelQuantity
                    : undefined;
            }
        },
        installationEnergyUsageCoverage: {
            value: undefined,
            defaultValue: undefined,
            requires: ['energyUsageByYear', 'panelType', 'totalEnergyFromSunPerYear', 'panelQuantity'],
            precision: 2,
            isHidden: function () {
                return !this.value;
            },
            setValueAsDefault: function () {
                this.defaultValue = this.value;
            },
            calculate: function () {
                this.value = $scope.hasRequiredData(this)
                    ? $scope.calcFunctions.calcEnergyProductionIn1YearByPV() / $scope.slcModels.energyUsageByYear.value * 100
                    : undefined;
            }
        },
        energyUsageCoverageProsumer: {
            value: undefined,
            defaultValue: undefined,
            requires: ['energyUsageByYear', 'panelType', 'totalEnergyFromSunPerYear', 'panelQuantity'],
            precision: 2,
            isHidden: function () {
                return !this.value;
            },
            setValueAsDefault: function () {
                this.defaultValue = this.value;
            },
            calculate: function () {
                if (!$scope.hasRequiredData(this)) {
                    this.value = undefined;
                    return;
                }

                let energyProductionIn1YearByPV = $scope.calcFunctions.calcEnergyProductionIn1YearByPV();
                let fundPercentageFactor = $scope.slcModels.installationMaxPower.value <= 10 ? 0.47 : 0.45;
                let ownEnergyConsumptionFactor = $scope.formModels.ownEnergyConsumptionFactor.getFactor();

                this.value = (
                    energyProductionIn1YearByPV * ownEnergyConsumptionFactor
                    + ((1 - ownEnergyConsumptionFactor) * energyProductionIn1YearByPV * fundPercentageFactor)
                ) / $scope.slcModels.energyUsageByYear.value * 100;
            }
        },
        directEnergyUsageCoverage: {
            value: 20,
            defaultValue: 20,
            requires: [],
            precision: 0,
            isHidden: function () {
                return !this.value;
            },
            setValueAsDefault: function () {
                this.defaultValue = this.value;
            },
            init: function () {
                this.value = 20
            }
        },
        totalPrice: {
            value: undefined,
            requires: ['inverterType', 'panelType', 'panelQuantity', 'montageSystemType'],
            precision: 0,
            calculate: function () {
                //$scope.patchProductPricesWithPromoData(); @todo

                var basePrice = $scope.formModels.inverterType.selected.price[$scope.formModels.panelType.selected.id];
                var panelQuantity = $scope.formModels.panelQuantity.value;
                var panelPrice = $scope.formModels.panelType.selected.price;
                var montagePrice = $scope.formModels.montageSystemType.getMontagePrice();
                var totalPriceFactor = 1.1 * 0.93; //@todo
                var inverterPriceFactor = $scope.formModels.inverterType.selected.priceFactor;
                var wirePrice = $scope.formModels.wireType.selected.price;

                /* base set price */
                var price = (basePrice + wirePrice
                    + (panelQuantity * panelPrice)
                    + montagePrice
                ) * totalPriceFactor / inverterPriceFactor;

                /* additional items */
                if ($scope.formModels.optiener.isSelected()) {
                    price += $scope.products.get('optiEnerSet').price;
                }

                /* custom products */
                _.each($scope.basket.customItems, function (item) {
                    if (item.price && item.sum) {
                        price += item.price * item.sum;
                    }
                });

                /* rebate */
                if ($scope.formModels.rebateType.isAmount()) {
                    price -= $scope.formModels.rebateAmount.value || 0;
                }
                if ($scope.formModels.rebateType.isPrecent()) {
                    price *= 1 - (($scope.formModels.rebatePrecent.value || 0) / 100);
                }

                /* profit margin */
                if ($scope.formModels.profitMarginType.isAmount()) {
                    price += $scope.formModels.profitMarginAmount.value || 0;
                }
                if ($scope.formModels.profitMarginType.isPrecent()) {
                    price *= 1 + (($scope.formModels.profitMarginPrecent.value || 0) / 100);
                }

                /* installer modifications */
                if ($scope.formModels.montageCost.value) {
                    price += $scope.formModels.montageCost.value;
                }
                if ($scope.formModels.deliveryCost.value) {
                    price += $scope.formModels.deliveryCost.value;
                }

                this.value = price;
                this.onChange();
            },
            onChange: function () {
                $scope.slcModels.installationCost.calculate();
            },
            getGrossValue: function () {
                this.labelTax = this.labelTaxOptions ? this.labelTaxOptions.gross : '';
                if (!this.value) {
                    return undefined;
                }
                return this.value * $scope.slcModels.tax.getPriceFactor();
            },
            getNetValue: function () {
                this.labelTax = this.labelTaxOptions ? this.labelTaxOptions.net : '';
                return this.value;
            },
            getSummaryValue: function () {
                return this.getGrossValue();
            }
        },
        tax: {
            value: {
                price: undefined,
                energy: undefined
            },
            requires: ['clientType'],
            calculate: function () {
                if (!$scope.hasRequiredData(this)) {
                    this.value.price = this.value.energy = undefined;
                    return;
                }

                switch ($scope.formModels.clientType.selected.id) {
                    case 'person':
                        this.value.energy = 23;

                        var buildingSurface = $scope.formModels.buildingSurface.value || 0;
                        var taxThreshold = $scope.formModels.buildingSurface.taxThreshold;
                        if (buildingSurface > taxThreshold) {
                            var factor = taxThreshold / buildingSurface;
                            this.value.price = _.round(factor * 8 + (1 - factor) * 23, 2);
                        } else {
                            this.value.price = 8;
                        }
                        break;
                    case 'company':
                        if ($scope.formModels.companyVatDeduct.yes()) {
                            this.value.price = this.value.energy = 0;
                        } else {
                            this.value.price = this.value.energy = 23;
                        }
                        break;
                }

                this.onChange();
            },
            hasValue: function () {
                return this.value.price !== undefined || this.value.energy !== undefined;
            },
            reset: function () {
                this.value.price = this.value.energy = undefined;
            },
            onChange: function () {
                $scope.slcModels.energyCostByYear.calculate();
                $scope.slcModels.totalKwhCosts.calculate();
                $scope.slcModels.installationCost.calculate();
            },
            getPriceFactor: function () {
                if (!this.value.price === undefined) {
                    return this.value.price;
                }
                return this.value.price / 100 + 1;
            },
            getEnergyFactor: function () {
                if (this.value.energy === undefined) {
                    return this.value.energy;
                }
                return this.value.energy / 100 + 1;
            },
            getPriceTaxValue: function () {
                return this.value.price;
            },
            getEnergyTaxValue: function () {
                return this.value.energy;
            }
        },
        installationCost: {
            value: undefined,
            precision: 0,
            calculate: function () {
                this.value = $scope.slcModels.totalPrice.getGrossValue();
                this.value = this.getUpdatedWithDiscounts(this.value);

                this.onChange();
            },
            getUpdatedWithDiscounts: function (value) {
                if ($scope.formModels.mojPrad.isSelected()) {
                    value -= $scope.formModels.mojPrad.discountValue;
                }
                if ($scope.formModels.ulgaTermo.isSelected()) {
                    value *= $scope.formModels.ulgaTermo.discountValue;
                }
                if ($scope.formModels.dofinansowanie.isSelected()) {
                    value -= $scope.formModels.dofinansowanieValue.value || 0;
                }
                return value;
            },
            onChange: function () {
                $scope.calcFunctions.updateAnalyze();
                $scope.formModels.dofinansowanieValue.updateMax();
            },
            getCreditBaseValue: function () {
                var value = $scope.slcModels.totalPrice.getGrossValue();
                value = this.getUpdatedWithDiscounts(value);

                return value;
            },
            updateWithCreditTotalCost: function (value) {
                this.value = this.getCreditBaseValue() + value;
            }
        },
        energyProducedByPV: {
            value: undefined,
            precision: 2
        },
        directConsumptionEnergyAmount: {
            value: undefined,
            precision: 2
        },
        netMeteringEnergyAmount: {
            value: undefined,
            precision: 2
        },
        paybackTime: {
            value: undefined
        },
        incomeAmount: {
            value: undefined,
            precision: 2
        },
        creditBasePrice: {
            value: undefined,
            precision: 0
        },
        creditMonthlyPrice: {
            value: undefined,
            precision: 0
        },
        creditTotalCost: {
            value: undefined,
            precision: 0
        }
    };

    $scope.products = {
        list: {
            selected: "",
            options: [
                {id: '', name: 'wybierz produkt'}
            ],
            visible: false,
            addBtn: {
                visible: true
            },
            init: function () {
                this.options = _.concat(
                    this.options,
                    _.filter($scope.resources.data.products, {visibleOnSlcList: true})
                );
                this.reset();
            },
            reset: function () {
                this.selected = this.options[0];
            },
            onChange: function () {
                $scope.basket.addCustomProduct(this.selected);
                this.hide();
                this.reset();
            },
            show: function () {
                this.addBtn.visible = false;
                this.visible = true;
            },
            hide: function () {
                this.addBtn.visible = true;
                this.visible = false;
            }
        },
        init: function () {
            this.list.init();
        },
        get: function (productId) {
            return $scope.resources.data.products[productId];
        },
        getSwitchgear: function (inverterType) {
            var switchgears = _.filter($scope.resources.data.products, function (product) {
                return product.group.containsAll(['pv', 'switchgears']);
            });

            return _.find(switchgears, function (switchgear) {
                return _.includes(switchgear.inverters, inverterType.id);
            });
        },
        getConnector: function () {
            var connectors = _.filter($scope.resources.data.products, function (product) {
                return product.group.containsAll(['pv', 'connectors']);
            });

            return _.find(connectors, {id: 'mc4'});
        },
        getWire: function (inverterType) {
            var wires = _.filter($scope.resources.data.products, function (product) {
                return product.group.containsAll(['pv', 'wires']);
            });

            return _.find(wires, function (wire) {
                return _.includes(wire.inverters, inverterType.id);
            });
        }
    };

    $scope.basket = {
        items: [],
        customItems: [],
        config: {
            editableProduct: {
                allow: {
                    sum: ['inverters', 'switchgears', 'connectors', 'wires']
                }
            }
        },
        isAllowedMultipleProductsFromSameGroup: function (product) {
            switch (true) {
                case _.includes(product.group, 'montageSystems'):
                    return $scope.formModels.montageSystemType.isCustom();
                default:
                    return false;
            }
        },
        hasProducts: function () {
            return this.items.length !== 0;
        },
        addProduct: function (product, quantity) {
            if (!product || !quantity) {
                return;
            }

            if (!this.isAllowedMultipleProductsFromSameGroup(product)) {
                this.removeProductFromSameGroup(product);
            }
            this.removeProduct(product.id);

            var item = {
                id: product.id,
                code: product.code || '',
                name: product.name,
                group: product.group,
                sum: quantity,
                unit: product.unit,
                order: product.order,
                editable: {
                    sum: _.isEmpty(_.intersection(product.group, this.config.editableProduct.allow.sum)) ? false : true
                }
            };
            this.items.push(item);
            this.items = _.sortBy(this.items, 'order');
        },
        removeProduct: function (productId) {
            _.remove(this.items, {id: productId});
        },
        removeProductByGroup: function (group) {
            this.items = _.filter(this.items, function (item) {
                return !_.includes(item.group, group);
            });
        },
        removeProductFromSameGroup: function (product) {
            this.items = _.filter(this.items, function (item) {
                return !item.group.isEqual(product.group);
            });
        },
        getProductsToSave: function () {
            let products = [];
            let keysToExport = ['id', 'code', 'sum'];

            _.each(this.items, function (item) {
                products.push(_.pick(item, keysToExport));
            });

            return products;
        },
        onProductChange: function () {},
        hasCustomProducts: function () {
            return this.customItems.length !== 0;
        },
        addCustomProduct: function (product) {
            var itemId = 'cp' + this.customItems.length + 1;
            if (!product) {
                var item = {id: itemId, code: '', name: '', price: undefined, sum: undefined, unit: ''};
            } else {
                var item = {id: itemId, code: product.code || '-', name: product.name, price: product.price, sum: undefined, unit: product.unit};
            }
            this.customItems.push(item);
        },
        removeCustomProduct: function (productId) {
            _.remove(this.customItems, {id: productId});
            this.onCustomProductChange();
        },
        onCustomProductChange: function () {
            $scope.slcModels.totalPrice.calculate();
        },
        loadCustomProducts: function () {
            var products = $scope.offer.data.form_options.customProducts || [];
            if (!products) {
                return;
            }

            this.customItems = products;
            this.onCustomProductChange();
        },
        getCustomProductsToSave: function () {
            let products = [];

            _.each(this.customItems, function (item) {
                products.push(_.pickBy(item, _.identity));
            });

            return products;
        }
    };

    $scope.offerTerms = {
        custom: {
            items: [],
            hasAny: function () {
                return this.items.length !== 0;
            },
            add: function () {
                var itemId = 'ctrm' + this.items.length + 1;
                var term = {id: itemId, value: ''};
                this.items.push(term);
            },
            remove: function (id) {
                _.remove(this.items, {id: id});
            },
            load: function () {
                var items = $scope.offer.data.form_options.customTerms || [];
                if (!items) {
                    return;
                }
                this.items = items;
            },
            getToSave: function () {
                return this.items;
            }
        }
    };

    /* events */
    $scope.$on('authChanged', function ($event, args) {
        $scope.form.config.userId = args.userId;
        $scope.form.init();
    });

    $scope.$on('resourcesLoaded', function () {
        $scope.products.init();
        $scope.form.preInit();
    });

    $scope.$on('offerFormLoaded', function () {
        $scope.form.loadOffer();
    });

    /* common functions */
    $scope.initGroup = function (group, modelsSet) {
        if (_.has(group, 'subgroupsIds')) {
            group.groups = [];
            _.each(group.subgroupsIds, function (subgroupId) {
                $scope.initGroup($scope.formGroups[subgroupId], modelsSet);
                group.groups.push($scope.formGroups[subgroupId]);
            });
            return;
        }

        group.models = $scope.getGroupModels(group, modelsSet);
    };

    $scope.getGroupModels = function (group, modelsSet) {
        if (_.isString(group)) {
            group = $scope.formGroups[group];
        }
        if (!group) {
            return [];
        }
        if (modelsSet === undefined) {
            modelsSet = _.merge($scope.formModels, $scope.slcModels);
        }
        return _.filter(modelsSet, function (model) {
            return _.includes(model.group, group.id);
        });
    };

    $scope.paramHasValue = function (model) {
        if (_.has(model, 'selected')) {
            return model.selected !== undefined && model.selected.id !== "";
        }
        return model.value !== undefined;
    };

    $scope.getParamDisplayValue = function (model) {
        if (model.selected !== undefined && model.selected.id !== "") {
            return model.selected.displayName;
        }
        if (model.type === 'checkbox') {
            return model.value === true ? 'Tak' : 'Nie';
        }
        if (model.value !== undefined) {
            if (_.isFunction(model.getGrossValue)) {
                return model.getGrossValue();
            }
            return model.value;
        }
        return undefined;
    };

    $scope.isGroupHidden = function (group, stepId) {
        if (group && _.isPlainObject(group.hidden)) {
            return group.hidden[stepId] || false;
        }
        if (!group || group.hidden) {
            return true;
        }

        var hidden = true;
        if (group.groups) {
            _.each(group.groups, function (group) {
                hidden = hidden && $scope.isGroupHidden(group, stepId);
            });
            return hidden;
        };

        _.each(group.models || [], function (model) {
            if ($scope.paramHasValue(model) && !$scope.isParamHidden(model)) {
                hidden = false;
            }
        });
        return hidden;
    };

    $scope.isParamHidden = function (model) {
        if (_.isFunction(model.hidden)) {
            return model.hidden();
        }
        if (_.isPlainObject(model.hidden)) {
            return false;
        }
        return model.hidden || false;
    };

    $scope.refreshSliders = function () {
        $timeout(function () {
            $scope.$broadcast('rzSliderForceRender');
        });
    };

    $scope.hasRequiredData = function (param) {
        var result = true;
        _.each(param.requires, function (modelId) {
            var model = _.merge($scope.formModels, $scope.slcModels)[modelId];
            if (!_.has(model, 'selected') && !_.has(model, 'value')) {
                result = false;
            } else if (_.has(model, 'selected') && (!_.has(model, 'selected.id') || model.selected.id === "")) {
                result = false;
            } else if (_.has(model, 'value') && model.value === undefined) {
                result = false;
            }
        });
        return result;
    };

    /* calculation functions */
    $scope.calcFunctions = {
        calcEnergyProductionIn1YearByPV: function () {
            var panel = $scope.formModels.panelType.selected;
            var a = $scope.slcModels.totalEnergyFromSunPerYear.value;
            var b = $scope.formModels.panelQuantity.value;
            var c = panel.surface;
            var d = panel.efficiency;
            var e = panel.effLossInYear *
                $scope.staticResources.constant.inverterEfficiency *
                $scope.staticResources.constant.otherComponentsEfficiency / 1000;

            return a * b * c * d * e;
        },
        updateAnalyze: function () {
            if (!$scope.slcModels.totalPrice.value) {
                return;
            }

            /* calc pv profits and financing  */
            var results = {
                pvProfitData: this.calculatePvProfits(),
                financingData: this.calculateFinancing()
            };

            /* generate chart */
            var chartData = this.getPreparedChartData(results);
            this.generateCharts(chartData.labels, chartData.series, chartData.values);

            /* calc summary data */
            var summaryData = this.getSummaryDataFromFinancingCalculationsData(results.pvProfitData);
            $scope.slcModels.energyProducedByPV.value = summaryData[0] / 1000;
            $scope.slcModels.directConsumptionEnergyAmount.value = summaryData[1];
            $scope.slcModels.netMeteringEnergyAmount.value = summaryData[2];
            $scope.slcModels.paybackTime.value = this.calcPaybackTime(results.pvProfitData, results.financingData);
            $scope.slcModels.incomeAmount.value = this.calcIncomeAmount(results.pvProfitData, results.financingData);
        },
        calculatePvProfits: function () {
            /*1*/
            let calcEnergyCostIn1YearNonPV = function(power) {
                var a = (
                    12 * $scope.slcModels.energyConstCost.getNetValue()
                    + $scope.slcModels.totalKwhCosts.getNetValue() * $scope.slcModels.energyUsageByYear.value
                ) * $scope.slcModels.tax.getEnergyFactor();
                var b = 1 + $scope.formModels.energyCostGrowthByYear.getFactor();
                return (( (a) * (Math.pow(b, power)) ) + (a) * (Math.pow(b, power + 1)) ) / 2;
            };

            /*2*/
            let calcEnergyProductionIn1YearByPV = function(power) {
                var panel = $scope.formModels.panelType.selected;
                var a = $scope.slcModels.totalEnergyFromSunPerYear.value;
                var b = $scope.formModels.panelQuantity.value;
                var c = panel.surface;
                var d = panel.efficiency;
                var e = (panel.effLossInYear - ($scope.staticResources.constant.efficiencyLoss * power)) * $scope.staticResources.constant.inverterEfficiency * $scope.staticResources.constant.otherComponentsEfficiency / 1000;

                return a * b * c * d * e;
            };

            /*3*/
            let calcEnergyConsumptionFromPVIn1Year = function(energyProductionIn1YearByPV) {
                if (energyProductionIn1YearByPV > $scope.slcModels.energyUsageByYear.value) {
                    energyProductionIn1YearByPV = $scope.slcModels.energyUsageByYear.value;
                }
                return $scope.formModels.ownEnergyConsumptionFactor.getFactor() * energyProductionIn1YearByPV;
            };

            /*4*/
            let calcEnergyConsumptionFromGridIn1Year = function(energyProductionIn1YearByPV) {
                if (energyProductionIn1YearByPV > $scope.slcModels.energyUsageByYear.value)
                    energyProductionIn1YearByPV = $scope.slcModels.energyUsageByYear.value;
                return (1 - $scope.formModels.ownEnergyConsumptionFactor.getFactor()) * energyProductionIn1YearByPV;
            };

            /*5*/
            let calcNewEnergyCostAndEnergyDistribCost = function(power, energyConsumptionFromPVIn1Year, energyConsumptionFromGridIn1Year) {
                var a = 1 + $scope.formModels.energyCostGrowthByYear.getFactor();
                var object = {};
                var fundPercentage = $scope.slcModels.installationMaxPower.value <= 10 ? 0.47 : 0.45;
                var unitEnergyCost = ($scope.slcModels.totalKwhCosts.getNetValue() * $scope.slcModels.tax.getEnergyFactor()) * (( Math.pow(a, power) ) + ( Math.pow(a, power + 1) )) / 2;
                var directConsumptionEnergy = energyConsumptionFromPVIn1Year * unitEnergyCost;
                var netMeteringEnergy = fundPercentage * energyConsumptionFromGridIn1Year * unitEnergyCost;

                object.directConsumptionEnergy = directConsumptionEnergy;
                object.netMeteringEnergy = netMeteringEnergy;

                return object;
            };

            /*9*/
            let calcNewZEPaymentsIn1Year = function() {
                /* produkcja energii z PV jest ogranczona do własnego zużycia, nie odsprzedajemy więc nadwyżek które ulegają opodatkowaniu */
                return 0;
            };

            var profitsData = [];

            for (var i = 0; i < $scope.formModels.guaranteePeriod.value; i++) {
                profitsData[i] = {};
                profitsData[i].id = i + 1;

                profitsData[i]._C1_energyCostIn1YearNonPV             =  calcEnergyCostIn1YearNonPV(i);
                profitsData[i]._C2_energyProductionIn1YearByPV        =  calcEnergyProductionIn1YearByPV(i);
                profitsData[i]._C3_energyConsumptionFromPVIn1Year     =  calcEnergyConsumptionFromPVIn1Year(profitsData[i]._C2_energyProductionIn1YearByPV);
                profitsData[i]._C4_energyConsumptionFromGridIn1Year   =  calcEnergyConsumptionFromGridIn1Year(profitsData[i]._C2_energyProductionIn1YearByPV);

                var C5_TMPnewEnergyCost = calcNewEnergyCostAndEnergyDistribCost(i, profitsData[i]._C3_energyConsumptionFromPVIn1Year, profitsData[i]._C4_energyConsumptionFromGridIn1Year);
                profitsData[i].directConsumptionEnergyInYear = C5_TMPnewEnergyCost.directConsumptionEnergy;
                profitsData[i].netMeteringEnergyInYear = C5_TMPnewEnergyCost.netMeteringEnergy;

                profitsData[i]._C5_newEnergyCostIn1Year               =  C5_TMPnewEnergyCost.directConsumptionEnergy + C5_TMPnewEnergyCost.netMeteringEnergy;
                profitsData[i]._C9_newZEPaymentsIn1Year               =  calcNewZEPaymentsIn1Year();
                profitsData[i]._C10_incomeCostFromPV                  =  0;
                profitsData[i]._C11_energyCostFromPV                  =  profitsData[i]._C5_newEnergyCostIn1Year - profitsData[i]._C9_newZEPaymentsIn1Year;

                (i === 0)
                    ? profitsData[i]._C12_sumEnergyCostFromPV         =  profitsData[i]._C11_energyCostFromPV
                    : profitsData[i]._C12_sumEnergyCostFromPV         =  profitsData[i - 1]._C12_sumEnergyCostFromPV + profitsData[i]._C11_energyCostFromPV;

                profitsData[i].energyCostWorthFromPvInYear = profitsData[i]._C12_sumEnergyCostFromPV;
            }
            return profitsData;
        },
        calculateFinancing: function () {
            let wlasne = function() {
                var financingData = [];
                var startAmount = $scope.slcModels.installationCost.value;

                for (var i = 0; i < $scope.formModels.guaranteePeriod.value; i++) {
                    financingData[i] = {};
                    financingData[i].financingAmountInYear = startAmount;
                }

                return financingData;
            };

            let kredytSantander = function () {
                var financingData = [];
                var startAmount = $scope.slcModels.installationCost.getCreditBaseValue();

                $scope.formModels.creditCoverageAmount.setMax(startAmount);

                var startCreditAmount = startAmount - $scope.formModels.creditCoverageAmount.value;
                var loanNumber = 12 * $scope.staticResources.santanderCredit.years.value;
                var loanAmount = startCreditAmount * (1 + $scope.staticResources.santanderCredit.precentageFactor) / loanNumber;

                for (var i = 0; i < $scope.formModels.guaranteePeriod.value; i++) {
                    financingData[i] = {};

                    switch (i < $scope.staticResources.santanderCredit.years.value) {
                        case false:
                            financingData[i]._RS1_creditPaymentPerYear = 0;
                            break;
                        case true:
                            (i === 0)
                                ? financingData[i]._RS1_creditPaymentPerYear = 12 * loanAmount + $scope.formModels.creditCoverageAmount.value
                                : financingData[i]._RS1_creditPaymentPerYear = 12 * loanAmount;
                            break;
                    }

                    (i === 0)
                        ? financingData[i]._RS2_paymentsAmount = financingData[i]._RS1_creditPaymentPerYear
                        : financingData[i]._RS2_paymentsAmount = financingData[i - 1]._RS2_paymentsAmount + financingData[i]._RS1_creditPaymentPerYear;

                    financingData[i].financingAmountInYear = financingData[i]._RS2_paymentsAmount;
                }

                var totalAmount = _.round(financingData[financingData.length - 1]._RS2_paymentsAmount);

                $scope.slcModels.creditBasePrice.value = startCreditAmount;
                $scope.slcModels.creditMonthlyPrice.value = loanAmount;
                $scope.slcModels.creditTotalCost.value = totalAmount - startAmount;
                $scope.slcModels.installationCost.updateWithCreditTotalCost(totalAmount - startAmount);

                return financingData;
            };

            let innyKredyt = function () {
                var financingData = [];
                var startAmount = $scope.slcModels.installationCost.getCreditBaseValue();

                $scope.formModels.creditCoverageAmount.setMax(startAmount);

                var startCreditAmount = startAmount - $scope.formModels.creditCoverageAmount.value;
                var loanNumber = 12 * $scope.formModels.creditYears.value;
                var precentageFactor = 1 + $scope.formModels.creditPrecentage.value / 100 / 12;
                var loanAmount = startCreditAmount * Math.pow(precentageFactor, loanNumber) * (precentageFactor - 1) / (Math.pow(precentageFactor, loanNumber) - 1);
                var creditMonthConstPayment = 0;

                for (var i = 0; i < $scope.formModels.guaranteePeriod.value; i++) {
                    financingData[i] = {};

                    switch (i < $scope.formModels.creditYears.value) {
                        case false:
                            financingData[i]._RS1_creditPaymentPerYear = 0;
                            break;
                        case true:
                            (i === 0)
                                ? financingData[i]._RS1_creditPaymentPerYear =
                                    startAmount * ($scope.formModels.creditCoverageAmount.value / startAmount)
                                    + $scope.formModels.creditInitialPayment.value
                                    + 12 * creditMonthConstPayment + 12 * loanAmount
                                : financingData[i]._RS1_creditPaymentPerYear = 12 * creditMonthConstPayment + 12 * loanAmount;
                            break;
                    }

                    (i === 0)
                        ? financingData[i]._RS2_paymentsAmount = financingData[i]._RS1_creditPaymentPerYear
                        : financingData[i]._RS2_paymentsAmount = financingData[i - 1]._RS2_paymentsAmount + financingData[i]._RS1_creditPaymentPerYear;

                    financingData[i].financingAmountInYear = financingData[i]._RS2_paymentsAmount;
                }

                var totalAmount = _.round(financingData[financingData.length - 1]._RS2_paymentsAmount);

                $scope.slcModels.creditBasePrice.value = startCreditAmount;
                $scope.slcModels.creditMonthlyPrice.value = loanAmount;
                $scope.slcModels.creditTotalCost.value = totalAmount - startAmount;
                $scope.slcModels.installationCost.updateWithCreditTotalCost(totalAmount - startAmount);

                return financingData;
            };

            switch ($scope.formModels.financingType.selected.id) {
                case 'wlasne':
                    return wlasne();
                case 'wlasne&Kredyt':
                    switch ($scope.formModels.creditType.selected.id) {
                        case 'santander60':
                            return kredytSantander();
                        case 'innyKredyt':
                            return innyKredyt();
                    }
            }
            return [];
        },
        getPreparedChartData: function (analyzeData) {
            var chartLabels = [];
            for (var i = 0; i < $scope.formModels.guaranteePeriod.value; i++) {
                chartLabels[i] = (i + 1) + " " + this.getDayMonthYearPostscript('rok', i + 1);
            }
            var chartSeries = [
                "wartość energii wytworzonej<br/>przez instalację PV <strong>Hewalex</strong>",
                "wartość inwestycji w<br/>instalację PV <strong>Hewalex</strong>",
                "wartość inwestycji<br/>w instalację PV"
            ];
            var chartData = [];

            chartData.push(
                this.getChartDataFromFinancingCalculationsData(analyzeData.pvProfitData, 'energyCostWorthFromPvInYear')
            );
            chartData.push(
                this.getChartDataFromFinancingCalculationsData(analyzeData.financingData, 'financingAmountInYear')
            );

            return {
                series: chartSeries,
                labels: chartLabels,
                values: chartData
            };
        },
        generateCharts: function (chartLabels, chartSeries, chartData) {
            var tooltipTittleTextBefore = '';
            var tooltipTittleTextAfter = '';

            var tooltipValueTextBefore = '';
            var tooltipValueTextAfter = ' zł';

            var verticalLabelTextBefore = '';
            var verticalLabelTextAfter = ' zł';

            /* zaokrąglenie danych do całości */
            for (var i = 0; i < chartData.length; i++) {
                for (var j = 0; j < chartData[i].length; j++) {
                    chartData[i][j] = Math.ceil(chartData[i][j]);
                }
            }

            $scope.profitChart = {
                options: {
                    scaleShowGridLines : true,
                    scaleGridLineColor : "rgba(0,0,0,.05)",
                    scaleGridLineWidth : 1,
                    scaleShowHorizontalLines: true,
                    scaleShowVerticalLines: true,
                    bezierCurve : false,
                    bezierCurveTension : 0.4,
                    pointDot : false,
                    pointDotRadius : 3,
                    pointDotStrokeWidth : 1,
                    pointHitDetectionRadius : 20,
                    datasetStroke : true,
                    datasetStrokeWidth : 2,
                    datasetFill : true,
                    showTooltips: false,
                    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                    multiTooltipTemplate: "<%if (datasetLabel){%><%=datasetLabel%>: <%}%>" + tooltipValueTextBefore + "<%= value %>" + tooltipValueTextAfter,
                    tooltipTitleTemplate: tooltipTittleTextBefore + "<%= label%>" + tooltipTittleTextAfter,
                    scaleLabel: verticalLabelTextBefore + "<%=value%>" + verticalLabelTextAfter,
                    tooltipCaretSize : 0,
                    tooltipFontSize: 10
                },
                labels: chartLabels,
                series: chartSeries,
                data: chartData
            };
        },
        getDayMonthYearPostscript: function(type, number) {
            switch (type) {
                case 'rok':
                    if (number === 1)
                        return 'rok';
                    else if ( (number < 10 || number > 20) && ((number % 10 > 1) && (number % 10 < 5)) )
                        return 'lata';
                    else
                        return 'lat';
                    break;
                case 'miesiac':
                    if (number === 1)
                        return 'miesiąc';
                    else if (number > 1 && number < 5)
                        return 'miesiące';
                    else
                        return 'miesięcy';
                    break;
                case 'dzien':
                    if (number === 1)
                        return 'dzień';
                    else
                        return 'dni';
                    break;
                default:
                    console.log('getDayMonthYearPostscript() - No match for type');
                    return '';
            }
        },
        getChartDataFromFinancingCalculationsData: function (dataObject, aKey) {
            var seriesObject = [];

            for (var i = 0; i < dataObject.length; i++) {

                if (aKey in dataObject[i]) {
                    seriesObject.push(dataObject[i][aKey]);
                }
            }
            return seriesObject;
        },
        getSummaryDataFromFinancingCalculationsData: function (dataObject) {
            var result = [0, 0, 0];

            for (var i = 0; i < dataObject.length; i++) {
                result[0] += dataObject[i]._C2_energyProductionIn1YearByPV;
                result[1] += dataObject[i].directConsumptionEnergyInYear;
                result[2] += dataObject[i].netMeteringEnergyInYear;
            }
            return result;
        },
        calcIncomeAmount: function (profits, financing) {
            return profits[profits.length - 1]._C12_sumEnergyCostFromPV
                - financing[financing.length - 1].financingAmountInYear;
        },
        calcPaybackTime: function (profitsData, financingData) {
            let getFunctionFormulaFromPoints = function (pointsArray) {
                var degree = pointsArray.length - 1;

                var formulaFactors = {};
                var a, b, c;
                var x1, x2, x3, y1, y2, y3;

                switch (degree) {
                    case 1:
                        x1 = pointsArray[pointsArray.length - 2].x;
                        y1 = pointsArray[pointsArray.length - 2].y;
                        x2 = pointsArray[pointsArray.length - 1].x;
                        y2 = pointsArray[pointsArray.length - 1].y;

                        b = (y2 - y1) / (x2 - x1);
                        c = y1 - b * x1;

                        formulaFactors.a = 0;
                        formulaFactors.b = b;
                        formulaFactors.c = c;

                        break;
                    case 2:
                        x1 = pointsArray[pointsArray.length - 3].x;
                        y1 = pointsArray[pointsArray.length - 3].y;
                        x2 = pointsArray[pointsArray.length - 2].x;
                        y2 = pointsArray[pointsArray.length - 2].y;
                        x3 = pointsArray[pointsArray.length - 1].x;
                        y3 = pointsArray[pointsArray.length - 1].y;

                        a = ( (y3 - y1) * (x2 - x1) - y2 * (x3 - x1) + y1 * (x3 - x1) ) / ( Math.pow(x3, 2) * (x2 - x1) - Math.pow(x2, 2) * (x3 - x1) + Math.pow(x1, 2) * (x3 - x2) );
                        b = ( y2 - y1 - a * (Math.pow(x2, 2) - Math.pow(x1, 2)) ) / ( x2 - x1 );
                        c = y1 - a * Math.pow(x1, 2) - b * x1;

                        formulaFactors.a = a;
                        formulaFactors.b = b;
                        formulaFactors.c = c;

                        break;
                    default:
                        console.log('getFunctionFormulaFromPoints - Unsupported function degree');
                }
                return formulaFactors;
            };

            let getFunctionsIntersectionPoint = function (function1Points, function2Points) {
                var function1Degree = function1Points.length - 1;
                var function2Degree = function2Points.length - 1;

                var xCoords = [];
                var formula1 = getFunctionFormulaFromPoints(function1Points);
                var formula2 = getFunctionFormulaFromPoints(function2Points);

                if (function1Degree === 1 && function2Degree === 1) {
                    xCoords[0] = (formula2.c - formula1.c) / (formula1.b - formula2.b);
                }
                else {
                    var delta = Math.pow((formula1.b - formula2.b), 2) - 4 * (formula1.a - formula2.a) * (formula1.c - formula2.c);

                    if (delta > 0) {
                        xCoords[0] = ( -1 * (formula1.b - formula2.b) - Math.sqrt(delta) ) / ( 2 * (formula1.a - formula2.a) );
                        xCoords[1] = ( -1 * (formula1.b - formula2.b) + Math.sqrt(delta) ) / ( 2 * (formula1.a - formula2.a) );
                    }
                    else if (delta === 0) {
                        xCoords[0] = ( -1 * (formula1.b - formula2.b) ) / ( 2 * (formula1.a - formula2.a) );
                    }
                    else {
                        console.log('getFunctionsIntersectionPoint() - Delta < 0, no intersection points');
                    }
                }

                return xCoords;
            };

            let getDayMonthYearFromNumber = function (periodAsNumber) {
                var period = {};

                period.years = Math.floor(periodAsNumber);
                period.months = 0;
                period.days = Math.ceil((periodAsNumber - period.years) * 365);

                return period;
            };

            var paybackTimeAsNumber = undefined;
            var xPoints = undefined;
            var creditYears = $scope.formModels.creditType.isSantander60()
                ? $scope.staticResources.santanderCredit.years.value
                : $scope.formModels.creditYears.value || 0;
            var function1Points = [
                {x : 1, y : financingData[0].financingAmountInYear},
                {x : 2, y : financingData[1].financingAmountInYear}
            ];
            var function2Points = [
                {x : 1, y : financingData[creditYears + 1].financingAmountInYear},
                {x : 2, y : financingData[creditYears + 2].financingAmountInYear}
            ];
            var function3Points = [
                {x : 1, y : profitsData[0]._C12_sumEnergyCostFromPV},
                {x : 2, y : profitsData[1]._C12_sumEnergyCostFromPV}
            ];
            if ($scope.formModels.energyCostGrowthByYear.value > 0) {
                function3Points.push({x : 3, y : profitsData[2]._C12_sumEnergyCostFromPV});
            }

            switch ($scope.formModels.financingType.selected.id) {
                case 'wlasne':
                    xPoints = getFunctionsIntersectionPoint(function1Points, function3Points);

                    for (var j = xPoints.length; j--;) {
                        if (xPoints[j] >= 0) {
                            paybackTimeAsNumber = xPoints[j];
                        }
                    }
                    break;
                case 'wlasne&Kredyt':
                    let rangeFrom = creditYears;
                    xPoints = getFunctionsIntersectionPoint(function2Points, function3Points);

                    for (var j = xPoints.length; j--;) {
                        if (xPoints[j] >= rangeFrom) {
                            paybackTimeAsNumber = xPoints[j];
                        }
                    }

                    if (paybackTimeAsNumber === undefined) {
                        let rangeFrom = 0;
                        let rangeTo = creditYears;

                        xPoints = getFunctionsIntersectionPoint(function1Points, function3Points);
                        for (var j = xPoints.length; j--;) {
                            if (xPoints[j] >= rangeFrom && xPoints[j] <= rangeTo) {
                                paybackTimeAsNumber = xPoints[j];
                            }
                        }
                    }
                    break;
            }

            var infinity = 1.7976931348623157E+10308;
            if (paybackTimeAsNumber === infinity) {
                return 'nigdy';
            }
            if (paybackTimeAsNumber === undefined) {
                if ($scope.calcFunctions.calcIncomeAmount(profitsData, financingData) > 0) {
                    return 'w dniu zakupu';
                } else {
                    return false;
                }
            }

            var period = getDayMonthYearFromNumber(paybackTimeAsNumber);
            var periodString = '';

            if (period.years > 0) {
                periodString = period.years + ' ' + this.getDayMonthYearPostscript('rok', period.years);
            }
            if (period.months > 0) {
                if (period.years > 0 && period.days === 0)
                    periodString += ' i ';
                else if (period.years > 0)
                    periodString += ' ';
                periodString += period.months + ' ' + this.getDayMonthYearPostscript('miesiac', period.months);
            }
            if (period.days > 0) {
                if (period.months > 0 || period.years > 0)
                    periodString += ' i ';
                periodString += period.days + ' ' + this.getDayMonthYearPostscript('dzien', period.days);
            }

            return periodString;
        }
    };

    //@todo should be moved to server side
    $scope.staticResources = {
        constant: {
            inverterEfficiency: 0.97,
            otherComponentsEfficiency: 0.97,
            efficiencyLoss: 0.0065,
            montageConstCost: 141
        },
        santanderCredit: {
            precentageFactor: 0.14,
            years: {
                label: 'Okres kredytowania',
                value: 5,
                unit: 'lat'
            },
            rrso: {
                label: 'RRSO',
                value: 5.51,
                unit: '%'
            }
        },
        sunEnergyByVoivodeship: [
            {id : "11", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 897135},
                    {direction : "e30",    totalEnergyPerM2 : 884637},
                    {direction : "se30",   totalEnergyPerM2 : 954583},
                    {direction : "s30",    totalEnergyPerM2 : 972055},
                    {direction : "sw30",   totalEnergyPerM2 : 927020},
                    {direction : "w30",    totalEnergyPerM2 : 846906},
                    {direction : "e45",    totalEnergyPerM2 : 863811},
                    {direction : "se45",   totalEnergyPerM2 : 953936},
                    {direction : "s45",    totalEnergyPerM2 : 974784},
                    {direction : "sw45",   totalEnergyPerM2 : 917004},
                    {direction : "w45",    totalEnergyPerM2 : 816550},
                    {direction : "e60",    totalEnergyPerM2 : 835625},
                    {direction : "se60",   totalEnergyPerM2 : 933409},
                    {direction : "s60",    totalEnergyPerM2 : 953734},
                    {direction : "sw60",   totalEnergyPerM2 : 891918},
                    {direction : "w60",    totalEnergyPerM2 : 785402}
                ]},
            {id : "4", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 857156},
                    {direction : "e30",    totalEnergyPerM2 : 849164},
                    {direction : "se30",   totalEnergyPerM2 : 911049},
                    {direction : "s30",    totalEnergyPerM2 : 925866},
                    {direction : "sw30",   totalEnergyPerM2 : 884914},
                    {direction : "w30",    totalEnergyPerM2 : 813332},
                    {direction : "e45",    totalEnergyPerM2 : 832895},
                    {direction : "se45",   totalEnergyPerM2 : 912413},
                    {direction : "s45",    totalEnergyPerM2 : 930325},
                    {direction : "sw45",   totalEnergyPerM2 : 878074},
                    {direction : "w45",    totalEnergyPerM2 : 788071},
                    {direction : "e60",    totalEnergyPerM2 : 810452},
                    {direction : "se60",   totalEnergyPerM2 : 897155},
                    {direction : "s60",    totalEnergyPerM2 : 914247},
                    {direction : "sw60",   totalEnergyPerM2 : 858310},
                    {direction : "w60",    totalEnergyPerM2 : 762705}
                ]},
            {id : "13", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 981588},
                    {direction : "e30",    totalEnergyPerM2 : 963415},
                    {direction : "se30",   totalEnergyPerM2 : 1036540},
                    {direction : "s30",    totalEnergyPerM2 : 1056504},
                    {direction : "sw30",   totalEnergyPerM2 : 1013011},
                    {direction : "w30",    totalEnergyPerM2 : 931604},
                    {direction : "e45",    totalEnergyPerM2 : 941200},
                    {direction : "se45",   totalEnergyPerM2 : 1033282},
                    {direction : "s45",    totalEnergyPerM2 : 1054821},
                    {direction : "sw45",   totalEnergyPerM2 : 1002067},
                    {direction : "w45",    totalEnergyPerM2 : 901819},
                    {direction : "e60",    totalEnergyPerM2 : 911302},
                    {direction : "se60",   totalEnergyPerM2 : 1009448},
                    {direction : "s60",    totalEnergyPerM2 : 1026693},
                    {direction : "sw60",   totalEnergyPerM2 : 973739},
                    {direction : "w60",    totalEnergyPerM2 : 868945}
                ]},
            {id : "5", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 978494},
                    {direction : "e30",    totalEnergyPerM2 : 964049},
                    {direction : "se30",   totalEnergyPerM2 : 1048677},
                    {direction : "s30",    totalEnergyPerM2 : 1070059},
                    {direction : "sw30",   totalEnergyPerM2 : 1016953},
                    {direction : "w30",    totalEnergyPerM2 : 920880},
                    {direction : "e45",    totalEnergyPerM2 : 940264},
                    {direction : "se45",   totalEnergyPerM2 : 1049459},
                    {direction : "s45",    totalEnergyPerM2 : 1074230},
                    {direction : "sw45",   totalEnergyPerM2 : 1007455},
                    {direction : "w45",    totalEnergyPerM2 : 887023},
                    {direction : "e60",    totalEnergyPerM2 : 908039},
                    {direction : "se60",   totalEnergyPerM2 : 1026962},
                    {direction : "s60",    totalEnergyPerM2 : 1050006},
                    {direction : "sw60",   totalEnergyPerM2 : 979406},
                    {direction : "w60",    totalEnergyPerM2 : 851691}
                ]},
            {id : "12", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 886350},
                    {direction : "e30",    totalEnergyPerM2 : 861319},
                    {direction : "se30",   totalEnergyPerM2 : 931905},
                    {direction : "s30",    totalEnergyPerM2 : 958573},
                    {direction : "sw30",   totalEnergyPerM2 : 925179},
                    {direction : "w30",    totalEnergyPerM2 : 851896},
                    {direction : "e45",    totalEnergyPerM2 : 836174},
                    {direction : "se45",   totalEnergyPerM2 : 927962},
                    {direction : "s45",    totalEnergyPerM2 : 962844},
                    {direction : "sw45",   totalEnergyPerM2 : 919345},
                    {direction : "w45",    totalEnergyPerM2 : 824656},
                    {direction : "e60",    totalEnergyPerM2 : 807192},
                    {direction : "se60",   totalEnergyPerM2 : 907461},
                    {direction : "s60",    totalEnergyPerM2 : 945262},
                    {direction : "sw60",   totalEnergyPerM2 : 897618},
                    {direction : "w60",    totalEnergyPerM2 : 794791}
                ]},
            {id : "14", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 883372},
                    {direction : "e30",    totalEnergyPerM2 : 864120},
                    {direction : "se30",   totalEnergyPerM2 : 942995},
                    {direction : "s30",    totalEnergyPerM2 : 967628},
                    {direction : "sw30",   totalEnergyPerM2 : 923519},
                    {direction : "w30",    totalEnergyPerM2 : 837814},
                    {direction : "e45",    totalEnergyPerM2 : 840824},
                    {direction : "se45",   totalEnergyPerM2 : 942605},
                    {direction : "s45",    totalEnergyPerM2 : 973612},
                    {direction : "sw45",   totalEnergyPerM2 : 916397},
                    {direction : "w45",    totalEnergyPerM2 : 807725},
                    {direction : "e60",    totalEnergyPerM2 : 811325},
                    {direction : "se60",   totalEnergyPerM2 : 922382},
                    {direction : "s60",    totalEnergyPerM2 : 954524},
                    {direction : "sw60",   totalEnergyPerM2 : 891977},
                    {direction : "w60",    totalEnergyPerM2 : 775953}
                ]},
            {id : "1", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 1045532},
                    {direction : "e30",    totalEnergyPerM2 : 1010488},
                    {direction : "se30",   totalEnergyPerM2 : 1098261},
                    {direction : "s30",    totalEnergyPerM2 : 1131924},
                    {direction : "sw30",   totalEnergyPerM2 : 1092979},
                    {direction : "w30",    totalEnergyPerM2 : 1003017},
                    {direction : "e45",    totalEnergyPerM2 : 981305},
                    {direction : "se45",   totalEnergyPerM2 : 1091426},
                    {direction : "s45",    totalEnergyPerM2 : 1130532},
                    {direction : "sw45",   totalEnergyPerM2 : 1084260},
                    {direction : "w45",    totalEnergyPerM2 : 971677},
                    {direction : "e60",    totalEnergyPerM2 : 945799},
                    {direction : "se60",   totalEnergyPerM2 : 1062590},
                    {direction : "s60",    totalEnergyPerM2 : 1099061},
                    {direction : "sw60",   totalEnergyPerM2 : 1053861},
                    {direction : "w60",    totalEnergyPerM2 : 934807}
                ]},
            {id : "6", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 974767},
                    {direction : "e30",    totalEnergyPerM2 : 962258},
                    {direction : "se30",   totalEnergyPerM2 : 1035220},
                    {direction : "s30",    totalEnergyPerM2 : 1051432},
                    {direction : "sw30",   totalEnergyPerM2 : 1001454},
                    {direction : "w30",    totalEnergyPerM2 : 916273},
                    {direction : "e45",    totalEnergyPerM2 : 940419},
                    {direction : "se45",   totalEnergyPerM2 : 1032977},
                    {direction : "s45",    totalEnergyPerM2 : 1049824},
                    {direction : "sw45",   totalEnergyPerM2 : 988187},
                    {direction : "w45",    totalEnergyPerM2 : 882950},
                    {direction : "e60",    totalEnergyPerM2 : 909418},
                    {direction : "se60",   totalEnergyPerM2 : 1008584},
                    {direction : "s60",    totalEnergyPerM2 : 1021121},
                    {direction : "sw60",   totalEnergyPerM2 : 958150},
                    {direction : "w60",    totalEnergyPerM2 : 848368}
                ]},
            {id : "16", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 862989},
                    {direction : "e30",    totalEnergyPerM2 : 843765},
                    {direction : "se30",   totalEnergyPerM2 : 911491},
                    {direction : "s30",    totalEnergyPerM2 : 935995},
                    {direction : "sw30",   totalEnergyPerM2 : 902279},
                    {direction : "w30",    totalEnergyPerM2 : 830699},
                    {direction : "e45",    totalEnergyPerM2 : 824031},
                    {direction : "se45",   totalEnergyPerM2 : 911647},
                    {direction : "s45",    totalEnergyPerM2 : 942751},
                    {direction : "sw45",   totalEnergyPerM2 : 899107},
                    {direction : "w45",    totalEnergyPerM2 : 807154},
                    {direction : "e60",    totalEnergyPerM2 : 799593},
                    {direction : "se60",   totalEnergyPerM2 : 896192},
                    {direction : "s60",    totalEnergyPerM2 : 929134},
                    {direction : "sw60",   totalEnergyPerM2 : 881347},
                    {direction : "w60",    totalEnergyPerM2 : 781750}
                ]},
            {id : "9", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 1014354},
                    {direction : "e30",    totalEnergyPerM2 : 994450},
                    {direction : "se30",   totalEnergyPerM2 : 1076574},
                    {direction : "s30",    totalEnergyPerM2 : 1100436},
                    {direction : "sw30",   totalEnergyPerM2 : 1053867},
                    {direction : "w30",    totalEnergyPerM2 : 963786},
                    {direction : "e45",    totalEnergyPerM2 : 970337},
                    {direction : "se45",   totalEnergyPerM2 : 1074374},
                    {direction : "s45",    totalEnergyPerM2 : 1101408},
                    {direction : "sw45",   totalEnergyPerM2 : 1045478},
                    {direction : "w45",    totalEnergyPerM2 : 933149},
                    {direction : "e60",    totalEnergyPerM2 : 938880},
                    {direction : "se60",   totalEnergyPerM2 : 1050328},
                    {direction : "s60",    totalEnergyPerM2 : 1074590},
                    {direction : "sw60",   totalEnergyPerM2 : 1018098},
                    {direction : "w60",    totalEnergyPerM2 : 898920}
                ]},
            {id : "15", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 960833},
                    {direction : "e30",    totalEnergyPerM2 : 941579},
                    {direction : "se30",   totalEnergyPerM2 : 1024384},
                    {direction : "s30",    totalEnergyPerM2 : 1050649},
                    {direction : "sw30",   totalEnergyPerM2 : 1005232},
                    {direction : "w30",    totalEnergyPerM2 : 915369},
                    {direction : "e45",    totalEnergyPerM2 : 918595},
                    {direction : "se45",   totalEnergyPerM2 : 1025106},
                    {direction : "s45",    totalEnergyPerM2 : 1057270},
                    {direction : "sw45",   totalEnergyPerM2 : 1000137},
                    {direction : "w45",    totalEnergyPerM2 : 885706},
                    {direction : "e60",    totalEnergyPerM2 : 889423},
                    {direction : "se60",   totalEnergyPerM2 : 1005557},
                    {direction : "s60",    totalEnergyPerM2 : 1038060},
                    {direction : "sw60",   totalEnergyPerM2 : 977153},
                    {direction : "w60",    totalEnergyPerM2 : 853906}
                ]},
            {id : "10", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 1051335},
                    {direction : "e30",    totalEnergyPerM2 : 1019392},
                    {direction : "se30",   totalEnergyPerM2 : 1114411},
                    {direction : "s30",    totalEnergyPerM2 : 1149068},
                    {direction : "sw30",   totalEnergyPerM2 : 1102960},
                    {direction : "w30",    totalEnergyPerM2 : 1003863},
                    {direction : "e45",    totalEnergyPerM2 : 990465},
                    {direction : "se45",   totalEnergyPerM2 : 1111158},
                    {direction : "s45",    totalEnergyPerM2 : 1151570},
                    {direction : "sw45",   totalEnergyPerM2 : 1095179},
                    {direction : "w45",    totalEnergyPerM2 : 970925},
                    {direction : "e60",    totalEnergyPerM2 : 954287},
                    {direction : "se60",   totalEnergyPerM2 : 1083717},
                    {direction : "s60",    totalEnergyPerM2 : 1122216},
                    {direction : "sw60",   totalEnergyPerM2 : 1065084},
                    {direction : "w60",    totalEnergyPerM2 : 933145}
                ]},
            {id : "2", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 1019689},
                    {direction : "e30",    totalEnergyPerM2 : 997450},
                    {direction : "se30",   totalEnergyPerM2 : 1075554},
                    {direction : "s30",    totalEnergyPerM2 : 1099337},
                    {direction : "sw30",   totalEnergyPerM2 : 1057453},
                    {direction : "w30",    totalEnergyPerM2 : 973123},
                    {direction : "e45",    totalEnergyPerM2 : 973921},
                    {direction : "se45",   totalEnergyPerM2 : 1072392},
                    {direction : "s45",    totalEnergyPerM2 : 1098351},
                    {direction : "sw45",   totalEnergyPerM2 : 1048544},
                    {direction : "w45",    totalEnergyPerM2 : 943742},
                    {direction : "e60",    totalEnergyPerM2 : 943390},
                    {direction : "se60",   totalEnergyPerM2 : 1048137},
                    {direction : "s60",    totalEnergyPerM2 : 1070262},
                    {direction : "sw60",   totalEnergyPerM2 : 1020916},
                    {direction : "w60",    totalEnergyPerM2 : 910789}
                ]},
            {id : "8", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 977921},
                    {direction : "e30",    totalEnergyPerM2 : 956446},
                    {direction : "se30",   totalEnergyPerM2 : 1031150},
                    {direction : "s30",    totalEnergyPerM2 : 1054464},
                    {direction : "sw30",   totalEnergyPerM2 : 1013543},
                    {direction : "w30",    totalEnergyPerM2 : 932362},
                    {direction : "e45",    totalEnergyPerM2 : 932271},
                    {direction : "se45",   totalEnergyPerM2 : 1027795},
                    {direction : "s45",    totalEnergyPerM2 : 1055311},
                    {direction : "sw45",   totalEnergyPerM2 : 1004030},
                    {direction : "w45",    totalEnergyPerM2 : 901920},
                    {direction : "e60",    totalEnergyPerM2 : 901239},
                    {direction : "se60",   totalEnergyPerM2 : 1004407},
                    {direction : "s60",    totalEnergyPerM2 : 1030690},
                    {direction : "sw60",   totalEnergyPerM2 : 976987},
                    {direction : "w60",    totalEnergyPerM2 : 868828}
                ]},
            {id : "7", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 830315},
                    {direction : "e30",    totalEnergyPerM2 : 818278},
                    {direction : "se30",   totalEnergyPerM2 : 873195},
                    {direction : "s30",    totalEnergyPerM2 : 889035},
                    {direction : "sw30",   totalEnergyPerM2 : 857092},
                    {direction : "w30",    totalEnergyPerM2 : 796475},
                    {direction : "e45",    totalEnergyPerM2 : 802021},
                    {direction : "se45",   totalEnergyPerM2 : 873035},
                    {direction : "s45",    totalEnergyPerM2 : 891918},
                    {direction : "sw45",   totalEnergyPerM2 : 851781},
                    {direction : "w45",    totalEnergyPerM2 : 774927},
                    {direction : "e60",    totalEnergyPerM2 : 780981},
                    {direction : "se60",   totalEnergyPerM2 : 858629},
                    {direction : "s60",    totalEnergyPerM2 : 877252},
                    {direction : "sw60",   totalEnergyPerM2 : 834416},
                    {direction : "w60",    totalEnergyPerM2 : 752349}
                ]},
            {id : "3", energy : [
                    {direction : "grunt",  totalEnergyPerM2 : 992862},
                    {direction : "e30",    totalEnergyPerM2 : 973827},
                    {direction : "se30",   totalEnergyPerM2 : 1057951},
                    {direction : "s30",    totalEnergyPerM2 : 1082477},
                    {direction : "sw30",   totalEnergyPerM2 : 1034708},
                    {direction : "w30",    totalEnergyPerM2 : 942240},
                    {direction : "e45",    totalEnergyPerM2 : 949046},
                    {direction : "se45",   totalEnergyPerM2 : 1057439},
                    {direction : "s45",    totalEnergyPerM2 : 1086114},
                    {direction : "sw45",   totalEnergyPerM2 : 1027153},
                    {direction : "w45",    totalEnergyPerM2 : 909877},
                    {direction : "e60",    totalEnergyPerM2 : 917065},
                    {direction : "se60",   totalEnergyPerM2 : 1035040},
                    {direction : "s60",    totalEnergyPerM2 : 1062610},
                    {direction : "sw60",   totalEnergyPerM2 : 1000568},
                    {direction : "w60",    totalEnergyPerM2 : 875233}
                ]}
        ]
    };
});

// angular.bootstrap(document, ['pvSlcTool']);