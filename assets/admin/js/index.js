jQuery(document).ready(function($) {
    $( '.zh-edit-installation_history' ).on( 'click', function() {

        let self = $( this );
        let parent = self.parents( 'tr' );
        let postID = parent.find( '.installation_id span' ).attr( 'data-post-id' );

        let data = {
            'installation_id' : postID,
        }

        $.ajax({
            type: "GET",
            url: "/wp-json/hewalex-zones/v2/history_installation",
            data: data,
            beforeSend: function() {
                $("#loading-image").show();
            },
            success: function(data) {
                $("#loading-image").hide();

                $( '.edit-post-number-kit' ).attr( 'post_id', data.installation_id );
                data.installation_kit_nr !== null ? $( '.edit-post-number-kit' ).text( data.installation_kit_nr ) : $( '.edit-post-number-kit' ).text( 'brak' );
                data.installation_pump_nr !== null ? $( '.edit-post-number-pump' ).text( data.installation_pump_nr ) : $( '.edit-post-number-pump' ).text( 'brak' );
                $( '.edit-post-mail' ).text( data.installation_email );
                $( '.edit-post-name' ).text( data.installation_name + ' ' + data.installation_surname );
                $( '.edit-post-address' ).text( data.installation_zip + ' ' + data.installation_city + ', ' + data.installation_address);
                $( '.edit-post-phone' ).text( data.installation_phone );
                $( '.edit-post-date-ins' ).text( data.instalation_date_ins );
                $( '.edit-post-number-podgrzewacza' ).text( data.installation_heater );
                $( '.edit-post-number-zespolu-pompowego' ).text( data.installation_zps );
                // $( '.edit-post-number-collectors' ).text( data.installation_email );
                $( '.edit-post-type-set' ).text( data.kit_type_nazwa );
                $( '.edit-post-id-installator' ).text( data.installers_id );
                $( '.edit-post-email-installator' ).text( data.installers_email );
                $( '.edit-post-installator' ).text( data.installers_name );
                $( '.edit-post-installator-nip' ).text( data.installation_installator_nip );
                $( '.edit-post-installator-phone' ).text( data.installers_phone );
                $( '.edit-post-installator-address' ).text( data.installers_zip + ' ' + data.installers_city + ' ' + data.installers_address );
            }
        });
    } );


    $( '.zh-update-history-installation' ).on( 'click', function() {

        let postID = $( '.edit-post-number-kit' ).attr( 'post_id' );
        let comment = $( '.edit-post-comment' ).val();

        let ajaxurl = custom_scripts.ajax_url;
        let data = {
            'action' : 'edit_update_history_installation',
            'installation_id' : postID,
            'comment': comment,
        }

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: data,
        });


        jQuery.post( ajaxurl, data, function( responce ) {
            location.reload( true );
        } );

    } );
} );