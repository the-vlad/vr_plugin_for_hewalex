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

var installerOrderCredits = function()
{
    return {
        initialize: function()
        {
            this.mainContainer = $('#orderCreditsContainer');
            this.credits = $("#formAddCredit input[name='credits']");
            this.id = null;
            this.permalink = null;

            this.prepareForm();
        },

        prepareForm: function()
        {
            this.mainContainer.find('#credits').mask('#0 zł', {reverse: true});
        },

        submit: function(button)
        {
            var validated = this.validateForm();
            if (!validated) {
                return;
            }

            var submitButton = $(button);
            submitButton.html('Składanie zamówienia...').attr('disabled', true);

            $.ajax({
                type: 'POST',
                url: credits.ajax,
                // action: 'addCredit',
                //url: '/strefa-instalatora/zasilenie-karty/',
                dataType: 'json',
                timeout: 10000,
                data: installerOrderCredits.getDataToSubmit(),
                success: function(response) {
                    installerOrderCredits.id = response.id;
                    installerOrderCredits.permalink = response.permalink;
                    installerOrderCredits.createSubmitSuccessView(response);
                },
                error: function(xhr) {
                    var response = JSON.parse(xhr.responseText);
                    switch (JSON.parse(xhr.status)) {
                        case 422:
                            installerOrderCredits.handleValidationErrors(response.errors);
                            installerOrderCredits.notifyError(response);
                            break;
                        case 500:
                        default:
                            new PNotify({
                                title: 'Błąd',
                                text: 'Nie udało się złożyć zamówienia.',
                                hide: true,
                                buttons: {
                                    sticker: false
                                }
                            });
                    }
                    submitButton.html('Generuj formularz zasilenia').attr('disabled', false);
                }
            });
        },

        validateForm: function()
        {
            var error = false;
            this.mainContainer.find('.has-error')
                .removeClass('has-error')
                .find('label.error')
                .remove();
            this.mainContainer.find('input,textarea,select').filter('[required]:visible').each(function() {
                if (!$(this).val()) {
                    $(this).closest('.form-control')
                        .after('<label class="error error-notify notification-alert">Pole wymagane</label>')
                        .closest('.form-group')
                        .addClass('has-error');
                    error = true;
                }
            });
            return !error;
        },

        getDataToSubmit: function()
        {
            return {
                action: 'addCredit',
                credits: _.parseInt(this.mainContainer.find('#credits').val()),
                submit: 'add'
            };
        },

        handleValidationErrors: function(errors)
        {
            this.mainContainer.find('.has-error')
                .removeClass('has-error')
                .find('label.error')
                .remove();

            _.each(errors, function(message, key) {
                var element = installerOrderCredits.mainContainer.find('[name^='+ key +']');
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

        notifyError: function(response)
        {
            if (_.has(response, 'message')) {
                // new PNotify({
                //     title: 'Błąd',
                //     text: response.message,
                //     type: "error",
                //     icon: false,
                //     hide: true,
                //     buttons: {
                //         sticker: false
                //     }
                // });
                new AWN().warning(response.message, options);
            }
        },

        createSubmitSuccessView: function(response)
        {
            var html = '\n' +
                '<div class="featured-box featured-box-primary align-left">' +
                '<div class="box-content content">' +
                '<p>Dziękujemy za wykorzystanie premii programu Instalator OZE i potwierdzamy przyjęcie dyspozycji ' +
                'dla przekazania zadeklarowanych środków na kartę premiową.</p>' +
                '<p> Zgodnie z regulaminem programu wnioski ' +
                'złożone do końca miesiąca, zostaną przekazane na kartę do 10 dnia roboczego kolejnego miesiąca. </p>' +
                '<p>Dla bieżącej obsługi karty premiowej i monitorowania stanu środków prosimy korzystać ' +
                'z aplikacji mobilnej operatora karty Edenred.</p>';


            if (response.id) {
                html += '\n\
                <br />\n\
                <div class="center">\n\
                    <button \n\
                        type="button" \n\
                        onclick="installerOrderCredits.download()" \n\
                        class="btn btn-lg btn-primary mr-xlg">\n\
                        <i class="fa fa-print"></i> Pobierz formularz\n\
                    </button>\n\
                </div>';
            }

            html += '\n</div></div>';

            this.mainContainer.html(html);
        },

        download: function()
        {
            window.open(
                this.permalink,
                // location.protocol +'//'+ location.hostname +':'+ location.port +'/instalator/zamowienie/'+ this.id +'?format=pdf',
                'Zamówienie',
                'width=600,height=600,scrollbars,status'
            );
        }
    };
}();
