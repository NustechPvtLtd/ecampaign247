$(function() {

    //sites filter by user
    $('select#userDropDown').change(function() {

        if ($(this).val() == 'All' || $(this).val() == '') {

            $('#sites .site').hide().fadeIn(500);

        } else {

            $('#sites .site').hide();

            $('#sites').find('[data-name="' + $(this).val() + '"]').fadeIn(500);

        }

    });


    //sites sorting
    $('select#sortDropDown').change(function() {

        if ($(this).val() == 'NoOfPages') {

            sites = $('#sites .site');

            sites.sort(function(a, b) {

                an = a.getAttribute('data-pages');
                bn = b.getAttribute('data-pages');

                if (an > bn) {
                    return 1;
                }

                if (an < bn) {
                    return -1;
                }

                return 0;

            });

            sites.detach().appendTo($('#sites'));

        } else if ($(this).val() == 'CreationDate') {

            sites = $('#sites .site');

            sites.sort(function(a, b) {

                an = a.getAttribute('data-created').replace("-", "");
                bn = b.getAttribute('data-created').replace("-", "");

                if (an > bn) {
                    return 1;
                }

                if (an < bn) {
                    return -1;
                }

                return 0;

            });

            sites.detach().appendTo($('#sites'));

        } else if ($(this).val() == 'LastUpdate') {

            sites = $('#sites .site');

            sites.sort(function(a, b) {

                an = a.getAttribute('data-update').replace("-", "");
                bn = b.getAttribute('data-update').replace("-", "");

                if (an > bn) {
                    return 1;
                }

                if (an < bn) {
                    return -1;
                }

                return 0;

            });

            sites.detach().appendTo($('#sites'));

        }
        var i=1
        $('.site').each(function(){
            if(i%3==0){
                $('<div class="clearfix"></div>').insertAfter($(this));
            }
            i++;
        });
    });


    /* END SITES */

});
