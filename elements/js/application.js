// Some general UI pack related JS
// Extend JS String with repeat method
String.prototype.repeat = function(num) {
    return new Array(num + 1).join(this);
};

(function($) {

    // Add segments to a slider
    $.fn.addSliderSegments = function(amount, orientation) {
        return this.each(function() {
            if (orientation == "vertical") {
                var output = ''
                        , i;
                for (i = 1; i <= amount - 2; i++) {
                    output += '<div class="ui-slider-segment" style="top:' + 100 / (amount - 1) * i + '%;"></div>';
                }
                ;
                $(this).prepend(output);
            } else {
                var segmentGap = 100 / (amount - 1) + "%"
                        , segment = '<div class="ui-slider-segment" style="margin-left: ' + segmentGap + ';"></div>';
                $(this).prepend(segment.repeat(amount - 2));
            }
        });
    };

    $(function() {

        // Custom Selects
        $("select[name='huge']").selectpicker({style: 'btn-hg btn-primary', menuStyle: 'dropdown-inverse'});
        $("select[name='large']").selectpicker({style: 'btn-lg btn-danger'});
        $("select[name='info']").selectpicker({style: 'btn-info'});
        $("select[name='small']").selectpicker({style: 'btn-sm btn-warning'});

        // Tabs
        $(".nav-tabs a").on('click', function(e) {
            e.preventDefault();
            $(this).tab("show");
        })

        // Tooltips
        $("[data-toggle=tooltip]").tooltip("show");

        // Tags Input
        $(".tagsinput").tagsInput();

        // jQuery UI Sliders
        var $slider = $("#slider");
        if ($slider.length > 0) {
            $slider.slider({
                min: 1,
                max: 5,
                value: 3,
                orientation: "horizontal",
                range: "min"
            }).addSliderSegments($slider.slider("option").max);
        }

        var $slider2 = $("#slider2");
        if ($slider2.length > 0) {
            $slider2.slider({
                min: 1,
                max: 5,
                values: [3, 4],
                orientation: "horizontal",
                range: true
            }).addSliderSegments($slider2.slider("option").max);
        }

        var $slider3 = $("#slider3")
                , slider3ValueMultiplier = 100
                , slider3Options;

        if ($slider3.length > 0) {
            $slider3.slider({
                min: 1,
                max: 5,
                values: [3, 4],
                orientation: "horizontal",
                range: true,
                slide: function(event, ui) {
                    $slider3.find(".ui-slider-value:first")
                            .text("$" + ui.values[0] * slider3ValueMultiplier)
                            .end()
                            .find(".ui-slider-value:last")
                            .text("$" + ui.values[1] * slider3ValueMultiplier);
                }
            });

            slider3Options = $slider3.slider("option");
            $slider3.addSliderSegments(slider3Options.max)
                    .find(".ui-slider-value:first")
                    .text("$" + slider3Options.values[0] * slider3ValueMultiplier)
                    .end()
                    .find(".ui-slider-value:last")
                    .text("$" + slider3Options.values[1] * slider3ValueMultiplier);
        }

        var $verticalSlider = $("#vertical-slider");
        if ($verticalSlider.length) {
            $verticalSlider.slider({
                min: 1,
                max: 5,
                value: 3,
                orientation: "vertical",
                range: "min"
            }).addSliderSegments($verticalSlider.slider("option").max, "vertical");
        }

        // Add style class name to a tooltips
        $(".tooltip").addClass(function() {
            if ($(this).prev().attr("data-tooltip-style")) {
                return "tooltip-" + $(this).prev().attr("data-tooltip-style");
            }
        });

        // Placeholders for input/textarea
        $(":text, textarea").placeholder();

        // Make pagination demo work
        $(".pagination").on('click', "a", function() {
            $(this).parent().siblings("li").removeClass("active").end().addClass("active");
        });

        $(".btn-group").on('click', "a", function() {
            $(this).siblings().removeClass("active").end().addClass("active");
        });

        // Disable link clicks to prevent page scrolling
        $(document).on('click', 'a[href="#fakelink"]', function(e) {
            e.preventDefault();
        });

        // jQuery UI Spinner
        $.widget("ui.customspinner", $.ui.spinner, {
            widgetEventPrefix: $.ui.spinner.prototype.widgetEventPrefix,
            _buttonHtml: function() { // Remove arrows on the buttons
                return "" +
                        "<a class='ui-spinner-button ui-spinner-up ui-corner-tr'>" +
                        "<span class='ui-icon " + this.options.icons.up + "'></span>" +
                        "</a>" +
                        "<a class='ui-spinner-button ui-spinner-down ui-corner-br'>" +
                        "<span class='ui-icon " + this.options.icons.down + "'></span>" +
                        "</a>";
            }
        });

        $('#spinner-01, #spinner-02, #spinner-03, #spinner-04, #spinner-05').customspinner({
            min: -99,
            max: 99
        }).on('focus', function() {
            $(this).closest('.ui-spinner').addClass('focus');
        }).on('blur', function() {
            $(this).closest('.ui-spinner').removeClass('focus');
        });


        // Focus state for append/prepend inputs
        $('.input-group').on('focus', '.form-control', function() {
            $(this).closest('.input-group, .form-group').addClass('focus');
        }).on('blur', '.form-control', function() {
            $(this).closest('.input-group, .form-group').removeClass('focus');
        });

        // Table: Toggle all checkboxes
        $('.table .toggle-all').on('click', function() {
            var ch = $(this).find(':checkbox').prop('checked');
            $(this).closest('.table').find('tbody :checkbox').checkbox(!ch ? 'check' : 'uncheck');
        });

        // Table: Add class row selected
        $('.table tbody :checkbox').on('check uncheck toggle', function(e) {
            var $this = $(this)
                    , check = $this.prop('checked')
                    , toggle = e.type == 'toggle'
                    , checkboxes = $('.table tbody :checkbox')
                    , checkAll = checkboxes.length == checkboxes.filter(':checked').length

            $this.closest('tr')[check ? 'addClass' : 'removeClass']('selected-row');
            if (toggle)
                $this.closest('.table').find('.toggle-all :checkbox').checkbox(checkAll ? 'check' : 'uncheck');
        });

        // jQuery UI Datepicker
        var datepickerSelector = '#datepicker-01';
        $(datepickerSelector).datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: "d MM, yy",
            yearRange: '-1:+1'
        }).prev('.btn').on('click', function(e) {
            e && e.preventDefault();
            $(datepickerSelector).focus();
        });
        $.extend($.datepicker, {_checkOffset: function(inst, offset, isFixed) {
                return offset
            }});

        // Now let's align datepicker with the prepend button
        $(datepickerSelector).datepicker('widget').css({'margin-left': -$(datepickerSelector).prev('.input-group-btn').find('.btn').outerWidth()});

        // Switch
        $("[data-toggle='switch']").wrap('<div class="switch" />').parent().bootstrapSwitch();

        // Typeahead
        /*$('#typeahead-demo-01').typeahead({
         name: 'states',
         limit: 4,
         local: ["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut",
         "Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky",
         "Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri",
         "Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota",
         "North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina",
         "South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]
         });*/

        // make code pretty
        window.prettyPrint && prettyPrint();
    });

    var counter_url = $('#counter-url').data("content");
    var site_url = $('#site-url').data("content");
    var contact_url = $('#contact-url').data("content");
    var page_id = $('#page-id').data("content");
    var page_url = $('#page-url').data("content");
    var phoneno = /^\+?([0-9]{0,2})\)?([0-9]{10})$/;
    $('.error').hide();
    $(".submit").click(function() {
        // Check Which form is trying to be submit and do according process.

        // get parent element.
        frm = $(this).parent('form');

        var formname = $(this).attr("id");
        var formdata = "";
        if (formname == "contact1") {
            formdata = frm.serialize() + "&formname=" + formname;
            // validate and process form here
            var name = frm.find("input#name").val();
            if (name == "") {
                frm.find('.error').show();
                frm.find('#name_error').show();
                frm.find('input#name').focus();
                return false;
            }
            var email = frm.find("input#email").val();
            var emailReg = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            if (!emailReg.test(email)) {
                frm.find('.error').show();
                frm.find("#email_error").show();
                frm.find("input#email").focus();
                return false;
            }
            var phone = frm.find("input#phone").val();

            if (!(phone.match(phoneno))) {
                frm.find('.error').show();
                frm.find("#phone_error").show();
                frm.find("input#phone").focus();
                return false;
            }

        }
        else if (formname == "contact2") {
            formdata = frm.serialize() + "&formname=" + formname
            // validate and process form here
            var name = frm.find("input#name").val();
            if (name == "") {
                frm.find('.error').show();
                frm.find("#name_error").show();
                frm.find("input#name").focus();
                return false;
            }
            var email = frm.find("input#email").val();
            var emailReg = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            if (!emailReg.test(email)) {
                frm.find('.error').show();
                frm.find("#email_error").show();
                frm.find("input#email").focus();
                return false;
            }
        }
        else if (formname == "contact3") {
            formdata = frm.serialize() + "&formname=" + formname
            // validate and process form here
            var name = frm.find("input#name").val();
            if (name == "") {
                frm.find('.error').show();
                frm.find("#name_error").show();
                frm.find("input#name").focus();
                return false;
            }
            var email = frm.find("input#email").val();
            var emailReg = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            if (!emailReg.test(email)) {
                frm.find('.error').show();
                frm.find("#email_error").show();
                frm.find("input#email").focus();
                return false;
            }
            var phone = frm.find("input#phone").val();
            if (!(phone.match(phoneno))) {
                frm.find('.error').show();
                frm.find("#phone_error").show();
                frm.find("input#phone").focus();
                return false;
            }
        }
        else if (formname == "header10") {
            formdata = frm.serialize() + "&formname=" + formname
            // validate and process form here
            var first = frm.find("input#firstname").val();
            if (first == "") {
                frm.find('.error').show();
                frm.find("#firstname_error").show();
                frm.find("input#firstname").focus();
                return false;
            }
            var last = frm.find("input#lastname").val();
            if (last == "") {
                frm.find('.error').show();
                frm.find("#lastname_error").show();
                frm.find("input#lastname").focus();
                return false;
            }
            var email = frm.find("input#email").val();
            var emailReg = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            if (!emailReg.test(email)) {
                frm.find('.error').show();
                frm.find("#email_error").show();
                frm.find("input#email").focus();
                return false;
            }
        }
        $.ajax({
            type: "POST",
            url: contact_url,
            method: "POST",
            data: formdata,
            crossDomain: true,
            success: function(data) {
                var json = JSON.parse(data);
                if (json.status == "success") {
                    frm.find("input,textarea").val("");
                    frm.html("<div id='message'></div>");
                    frm.find('#message').html(json.message)
                            .fadeIn(300, function() {
                                frm.find('#message').append("<img id='checkmark' src='" + site_url + "/images/icons/check.png' width=26 />");
                            });
                }
                else if (json.status == "error") {
                    frm.html("<div id='message'></div>");
                    frm.find('#message').html(json.message)
                            .fadeIn(300, function() {
                                frm.find('#message').append("<img id='checkmark' src='" + site_url + "/images/icons/abort.png' width=26 />");
                            });
                }
            },
            error: function() {
                alert("error on form");
                $('#contact_form').html("<div id='message'></div>");
                $('#message').html("<h2>There is some issue!</h2>")
                        .append("<p>Please try again.</p>")
                        .hide()
                        .fadeIn(300, function() {
                            $('#message').append("<img id='crossmark' src='" + site_url + "/images/icons/abort.png' width=26 />");
                        });
            }
        });
        return false;
    });
    $.getJSON("http://jsonip.com?callback=?", function(data) {
        var ip = data.ip;
        if (counter_url && page_url) {
            $.post(counter_url, {ip: ip, page_id: page_id, page_url: page_url}, function(data)
            {
                //console.log(data);
            });
        }
    });
})(jQuery);
