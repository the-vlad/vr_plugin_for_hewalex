var installerOrder = function()
{
    return {
        initialize: function() 
        {
            this.main = $('#orderContainer');
            this.mainContainer = $('#orderContainer .content');
            this.cart = $('#cartContainer');
            this.points = $('#pointsContainer');
            this.useShipping = false;
            this.id = null;
            
            this.prepareForm();
        },
        
        prepareForm: function()
        {
            this.mainContainer.find('input[name="zip"]').mask('99-999');
            this.mainContainer.find('input[name="shipping_zip"]').mask('99-999');
            this.mainContainer.find('input[name="nip"]').mask('9999999999');
        },
        
        toggleShipping: function(button, value)
        {
            if (this.useShipping === value) {
                return;
            }
            
            $(button).closest('.btn-group')
                .find('.btn-primary')
                .removeClass('btn-primary')
                .addClass('btn-default')
                .prop("disabled", false);
            $(button).removeClass('btn-default')
                .addClass('btn-primary')
                .prop("disabled", true);
            (this.useShipping = value) ? $('#shippingData').show() : $('#shippingData').hide();
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
                url: '/instalator/zamowienie/',
                dataType: 'json',
                timeout: 10000,
                data: installerOrder.getDataToSubmit(),
                success: function(response) {
                    installerOrder.id = response.id;
                    installerOrder.removeCart();
                    installerOrder.createSubmitSuccessView(response);
                },
                error: function(xhr) {
                    var response = JSON.parse(xhr.responseText);
                    switch (JSON.parse(xhr.status)) {
                        case 422:
                            installerOrder.handleValidationErrors(response.errors);
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
                    submitButton.html('Zamawiam!').attr('disabled', false);
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
            var form = this.mainContainer.find('form[name="orderForm"]').serializeArray(),
                billing = _.filter(form, function(item) {
                    return !_.startsWith(item.name, 'shipping_');
                }),
                shipping = !this.useShipping ? null : _.filter(form, function(item) {
                    return _.startsWith(item.name, 'shipping_');
                });      
                
            return {
                category: 'avard',
                billing: JSON.stringify(billing),
                shipping: JSON.stringify(shipping),
                payment: this.mainContainer.find('input[name="payment_choice"]').val()
            }; 
        },
        
        handleValidationErrors: function(errors)
        {
            this.mainContainer.find('.has-error')
                .removeClass('has-error')
                .find('label.error')
                .remove();
            
            _.each(errors, function(message, key) {
                var element = installerOrder.mainContainer.find('[name^='+ key +']');
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
        
        removeCart: function()
        {
            this.cart.remove();
            this.points.remove();
        },
        
        createSubmitSuccessView: function(response)
        {
            var html = '\n\
                <h2 class="heading-primary">Gratulacje!</h2>\n\
                <p class="lead">Właśnie dokonałeś zamówienia w Programie Lojalnościowym "Instalator Plus"!</p>\n\
                <p>Aby dokończyć zamówienie, należy <span class="alternative-font">wydrukować</span> znajdujący się pod poniższym linkiem formularz zamówienia, podpisać i <span class="alternative-font">wysłać</span> na adres: \n\
                    <strong>ul. Słowackiego 33, 43-502 Czechowice-Dziedzice</strong> lub <span class="alternative-font">przesłać skan</span> formularza na adres marketing@hewalex.pl</strong>\n\
                </p>\n\
                <p>Dopiero po otrzymaniu podpisanego formularza, zamówienie będzie realizowane.</p>\n\
                <p>Zamówienie jest także dostępne w zakładce "Historia zamówień"</p>\n\
                <p><span class="label label-info">UWAGA</span> Wszelkie niezgodności towaru lub jego uszkodzenia powinny być zgłaszane telefonicznie lub mailowo do Działu Marketingu Hewalex w teminie do 3 dni od daty otrzymania towaru. Po tym czasie koszty transportu towaru do producenta pokrywa nabywca.</p>';
            
            if (response.orderPaid === false) {
                html += '\n\
                <div class="alert alert-danger text-center mt-sm">\n\
                    <strong>Zamówienie nie zostało opłacone, skontaktuj się z nami.</strong>\n\
                </div> ';
            }
            
            if (response.id) {
                html += '\n\
                <br />\n\
                <div class="center">\n\
                    <button \n\
                        type="button" \n\
                        onclick="installerOrder.download()" \n\
                        class="btn btn-lg btn-primary mr-xlg">\n\
                        <i class="fa fa-print"></i> Pobierz zamówienie\n\
                    </button>\n\
                </div>';
            }
            
            this.mainContainer.html(html);
        },
        
        download: function()
        {
            window.open(
                location.protocol +'//'+ location.hostname +':'+ location.port +'/instalator/zamowienie/'+ this.id +'?format=pdf',
                'Zamówienie',
                'width=600,height=600,scrollbars,status'
            );
        }
    };
}();   

