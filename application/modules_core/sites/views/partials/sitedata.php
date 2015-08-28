<style>
    .disabled {
        cursor: not-allowed;
    }

</style>

<div id="siteSettingsWrapper" class="siteSettingsWrapper">
    <div class="col-lg-10">
        <div class="panel panel-default" id="freeUrlOptionPane">
            <div class="panel-heading">Free Url</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="siteSettingsForm">
                    <input type="hidden" name="siteID" id="siteID" value="<?php echo $data['site']->sites_id; ?>">
                    <div class="form-group">
                        <label class="col-sm-3">Set Free URL</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="siteSettings_domain" name="siteSettings_domain" placeholder="<?php echo $this->lang->line('sitedata_label_domain_placeholder') ?>" value="<?php echo ($data['site']->url_option == 'freeUrl') ? $data['site']->domain : ''; ?>" <?php echo ($data['site']->url_option == 'freeUrl') ? 'readonly=""' : ''; ?>>
                            <div class="clearfix"><!--Clear Div--></div>
                            <span id="publicURL"><?php echo ($data['site']->url_option == 'freeUrl') ? 'Your web site url: http://' . $_SERVER['HTTP_HOST'] . '/' . $data['site']->domain : ''; ?></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-footer pull-right">
                <button type="button" class="btn btn-primary btn-embossed" id="saveSiteSettingsButton"><span class="fui-check"></span> <?php echo $this->lang->line('sitesettings_button_savesettings') ?></button>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <input type="radio" name="radio1" <?php echo (($data['site']->url_option == 'freeUrl') || empty($data['site']->url_option)) ? 'checked' : ''; ?> class="switch-radio1" value="freeUrl">
    </div>

    <div class="clearfix"><!--clear Div--></div>
    <div class="col-lg-10">
        <div class="panel panel-default" id="addDomainOptionPane">
            <div class="panel-heading">Add Your Personal Domain</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="addDomainForm" action="<?php echo site_url('domain/add_domain/' . $data['site']->sites_id); ?>">
                    <div class="form-group">
                        <label class="col-sm-3">Personal Domain</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="siteSettings_adddomain" name="siteSettings_adddomain" placeholder="example.com" value="<?php echo ($data['site']->url_option == 'addonDomain') ? $data['site']->domain : ''; ?>" <?php echo ($data['site']->url_option == 'addonDomain') ? 'readonly=""' : ''; ?>>
                            <div class="clearfix"><!--Clear Div--></div>
                            <span id="addonDomainURL"><?php echo ($data['site']->url_option == 'addonDomain') ? 'Your web site url: http://' . $data['site']->domain : ''; ?></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-footer pull-right">
                <button type="button" class="btn btn-primary btn-embossed" id="addDomainButton"><span class="fui-check"></span> <?php echo 'Add your domain' ?></button>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <input type="radio" name="radio1" <?php echo ($data['site']->url_option == 'addonDomain') ? 'checked' : ''; ?> class="switch-radio1" value="addonDomain">
    </div>

    <div class="clearfix"><!--clear Div--></div>
    <div class="col-lg-10">
        <div class="panel panel-default" id="premiumDomainOptionPane">
            <div class="panel-heading">Purchase Premium Domain</div>
            <div class="panel-body">
                <div class="product-purchased" id="domain-name">
                    <form method="POST" name="quickbuy_domain" id="select-product" novalidate="novalidate">
                        <input type="hidden" name="siteID" id="siteID" value="<?php echo $data['site']->sites_id; ?>">
                        <input type="hidden" value="check_availability" name="action">
                        <div class="dca-search form-group">
                            <label class="col-sm-3">Premium Domain</label>
                            <div class="col-sm-7">
                                <input type="text" required="" placeholder="Enter Keywords or Domain Names" id="domainname" name="domainname" autocomplete="off" class="form-control" value="<?php echo ($data['site']->url_option == 'premiumDomain') ? $data['site']->domain : ''; ?>" <?php echo ($data['site']->url_option == 'premiumDomain') ? 'readonly=""' : ''; ?>>
                                <span id="remoteURL"><?php echo ($data['site']->url_option == 'premiumDomain') ? 'Your web site url: http://' . $data['site']->domain : ''; ?></span>
                            </div>
                            <button type="button" class="btn btn-primary btn-embossed col-sm-2" name="btn_check_availability" id="btn_check_availability">
                                Search
                            </button>
                            <div class="clearfix"></div>

                            <div class="tld-container">
                                <div class="tld-container-primary" >
                                    <span class="inline-block col-1"><input type="checkbox" value="info" id="info" name="tlds[]" ><label class="inline-block" for="info">info</label></span>
                                    <span class="inline-block col-1"><input type="checkbox" value="co.in" id="co.in" name="tlds[]" ><label class="inline-block" for="co.in">co.in</label></span>
                                    <span class="inline-block col-1"><input type="checkbox" value="net" id="net" name="tlds[]" ><label class="inline-block" for="net">net</label></span>
                                    <span class="inline-block col-1"><input type="checkbox" value="in" id="in" name="tlds[]" ><label class="inline-block" for="in">in</label></span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="domain_result" class="results-wrapper" style="display: none">
                        <h6>Search Results <span id="plan_error" class="error hide">Please select a domain name</span></h6>
                        <form method="POST" name="buy_domain" id="book-domain-form" novalidate="novalidate" action="<?php echo site_url('domain/bookDomain/' . $data['site']->sites_id); ?>">
                            <div class="search-results-container table-responsive">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel-footer pull-right">
                <button type="button" class="btn btn-primary btn-embossed" id="domainSubmittButton" disabled="disabled"><span class="fui-check"></span> <?php echo $this->lang->line('domainSubmittButton') ?></button>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <input type="radio" name="radio1" <?php echo ($data['site']->url_option == 'premiumDomain') ? 'checked' : ''; ?> class="switch-radio1" value="premiumDomain">
    </div>
    <div class="clearfix"><!--clear Div--></div>
</div>
<!---->


<script>
    $(document).ready(function() {
        $("[name='radio1']").bootstrapSwitch();

        $('#siteSettings_domain').keyup(function(e) {
            if ($(this).prop("readonly")) {
                e.preventDefault();
                return false;
            }
            if (/^[a-z0-9]{3,}$/i.test($(this).val())) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('sites/checkDomain') ?>",
                    data: {domain: $(this).val().toLowerCase()},
                    success: function(res) {
                        if (res.error == 0) {
                            $('#publicURL').text(res.errorMessage).css('color', 'green');
                        }
                        if (res.error == 1) {
                            $('#publicURL').text(res.errorMessage).css('color', 'red');
                        }
                    },
                    dataType: "JSON",
                    async: false
                });
            } else {
                $('#publicURL').text('Domain names can only contain letters and numbers').css('color', 'red');
            }
        });

        jQuery.validator.addMethod("regx", function(value, element, regexpr) {
            return regexpr.test(value);
        }, "Please enter a valid domain name.");

        $('#select-product').validate({
            rules: {
                domainname: {
                    required: true,
                    minlength: 3,
                    regx: /^[a-z0-9]+[a-z0-9-]+[a-z0-9]+$/
                }
            },
            messages: {
                domainname: {
                    required: "Please enter domain name to search!",
                    minlength: "At least {0} characters required!",
                    regx: "Only alphanumeric and hyphons(-) are allowed. Hyphons should not be on first or end place!"
                }
            }
        });

        $('#btn_check_availability').click(function() {
            var checked = false;
            if ($("#select-product").valid()) {
                $('.tld-container input[type=checkbox]').each(function() {
                    if ($(this).is(":checked")) {
                        checked = true;
                    }
                });
                if (!checked) {
                    $('.tld-container-primary input[type=checkbox]').each(function() {
                        $(this).prop("checked", true);
                    });
                }
                $.ajax({
                    url: "<?php echo site_url('domain/checkDomainAvalability') ?>",
                    type: 'post',
                    data: $('#select-product').serialize(),
                    success: function(ret) {
                        $('.search-results-container').html(ret);
                        $('#domain_result').show();
                        $('#domainSubmittButton').removeAttr('disabled');
                    }
                });
            }
        });
        $('input[name="radio1"]').on('switchChange.bootstrapSwitch', function(event, state) {
            disable($(this).val());
        });

        $('#addDomainButton').on('click', function() {
            //show loader, hide rest
            $('#siteSettingsWrapper .loader').show();
            $('#siteSettingsWrapper > *:not(.loader)').hide();

            $.ajax({
                url: $('#addDomainForm').attr('action'),
                type: 'POST',
                data: $('#addDomainForm').serialize(),
                dataType: 'json',
                success: function(res) {
                    $('#siteSettings .loader').fadeOut(500, function() {
                        $('#siteSettings .modal-body-content > *').each(function() {
                            $(this).remove();
                        });
                        $('#siteSettings .modal-body-content').append($(res.responseHTML));
                    });
                }
            });
        });

        //site name input field
        $('button#saveSiteSettingsButton').click(function() {
            if (/^[a-z0-9]{3,}$/i.test($('#siteSettings_domain').val())) {
                //destroy all alerts
                $('#siteSettings .alert').fadeOut(500, function() {
                    $(this).remove();
                });

                //disable button
                $('#saveSiteSettingsButton').addClass('disabled');

                //hide form data
                $('#siteSettings .modal-body-content > *').hide();

                //show loader
                $('#siteSettings .loader').show();

                $.ajax({
                    url: '<?php echo site_url('sites/siteAjaxUpdate') ?>',
                    type: 'post',
                    dataType: 'json',
                    data: $('form#siteSettingsForm').serializeArray()
                }).done(function(ret) {

                    if (ret.responseCode == 0) {//error

                        $('#siteSettings .loader').fadeOut(500, function() {

                            $('#siteSettings .modal-alerts').append(ret.responseHTML);

                            //show form data
                            $('#siteSettings .modal-body-content > *').show();

                            //enable button
                            $('#saveSiteSettingsButton').removeClass('disabled');

                        });

                    } else if (ret.responseCode == 1) {//all is well

                        $('#siteSettings .loader').fadeOut(500, function() {

                            //update site name in top menu
                            //$('#siteTitle').text( ret.siteName );

                            $('#siteSettings .modal-alerts').append(ret.responseHTML);

                            //hide form data
                            $('#siteSettings .modal-body-content > *').remove();
                            $('#siteSettings .modal-body-content').append(ret.responseHTML2);

                            //enable button
                            $('#saveSiteSettingsButton').removeClass('disabled');

                            //is the FTP stuff all good?

                            if (ret.domainOk == 1) {//yes, all good

                                $('#publishPage').removeAttr('data-toggle');
                                $('#publishPage span.text-danger').hide();

                                $('#publishPage').tooltip('destroy')

                            } else {//nope, can't use FTP

                                $('#publishPage').attr('data-toggle', 'tooltip');
                                $('#publishPage span.text-danger').show();

                                $('#publishPage').tooltip('show')

                            }

                            if ($("input:radio[name='domain']").is(':checked')) {
                                $.ajax({
                                    url: $('form#book-domain-form').attr('action'),
                                    type: 'post',
                                    data: $('form#book-domain-form').serialize()
                                }).done(function(ret) {
                                    $('.search-results-container').html(' ');
                                    $('.search-results-container').html(ret);
                                    $('#domain_result').show();
                                });
                            }
                        });

                    }

                });
            } else {
                $('#publicURL').text('Domain names can only contain letters and numbers').css('color', 'red');
            }
        });

    });
    disable('<?php echo (!empty($data['site']->url_option)) ? $data['site']->url_option : 'freeUrl'; ?>');
    function disable(url_option) {
        if (url_option == 'freeUrl') {
            $("#freeUrlOptionPane :input").attr("disabled", false);
            $("#addDomainOptionPane :input").attr("disabled", true);
            $("#premiumDomainOptionPane :input").attr("disabled", true);
            $("#freeUrlOptionPane").removeClass('disabled');
            $("#addDomainOptionPane").addClass('disabled');
            $("#premiumDomainOptionPane").addClass('disabled');
        } else if (url_option == 'addonDomain') {
            $("#freeUrlOptionPane :input").attr("disabled", true);
            $("#addDomainOptionPane :input").attr("disabled", false);
            $("#premiumDomainOptionPane :input").attr("disabled", true);
            $("#freeUrlOptionPane").addClass('disabled');
            $("#addDomainOptionPane").removeClass('disabled');
            $("#premiumDomainOptionPane").addClass('disabled');
        } else {
            $("#freeUrlOptionPane :input").attr("disabled", true);
            $("#addDomainOptionPane :input").attr("disabled", true);
            $("#premiumDomainOptionPane :input").attr("disabled", false);
            $("#freeUrlOptionPane").addClass('disabled');
            $("#addDomainOptionPane").addClass('disabled');
            $("#premiumDomainOptionPane").removeClass('disabled');
        }
    }
</script>
