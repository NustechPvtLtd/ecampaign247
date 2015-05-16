<div id="user_grid1"></div>
<!--  Custom buttons html -->
<div id="custom_html" class="hide">
  <div class="row" style="margin-bottom: 10px">
    <div class="col-xs-12 col-sm-6">
      <button id="take_snapshot" class="btn btn-primary">Take Snapshot</button>
    </div>
    <div class="col-xs-12 col-sm-6">
      <button id="restore_snapshot" class="btn btn-primary" disabled="disabled">Restore Snapshot</button>
    </div>
  </div>
</div>
<div id="site-url" data-content="<?php echo site_url();?>"></div>
<script>
    /**
    * Convert local timezone date string to UTC timestamp
    *
    * Alternative syntax using jquery (instead of moment.js):
    *     var date = $.datepicker.parseDateTime(dateformat, timeformat, date_str);
    *
    * @see http://stackoverflow.com/questions/948532/how-do-you-convert-a-javascript-date-to-utc
    * @param {String} date_str
    * @param {String} dateformat
    * @return {String}
    */
   function local_datetime_to_UTC_timestamp(date_str, dateformat) {

       // avoid date overflow in user input (moment("14/14/2005", "DD/MM/YYYY") => Tue Feb 14 2006)
       if(moment(date_str, dateformat).isValid() == false) {
           throw new Error("Invalid date");
       }

       // parse date string using given dateformat and create a javascript date object
       var date = moment(date_str, dateformat).toDate();

       // use javascript getUTC* functions to conv ert to UTC
       return  date.getUTCFullYear() +
           PadDigits(date.getUTCMonth() + 1, 2) +
           PadDigits(date.getUTCDate(), 2) +
           PadDigits(date.getUTCHours(), 2) +
           PadDigits(date.getUTCMinutes(), 2) +
           PadDigits(date.getUTCSeconds(), 2);

   }

   /**
    * Add leading zeros
    * @param {Number} n
    * @param {Number} totalDigits
    * @return {String}
    */
   function PadDigits(n, totalDigits) {
       n = n.toString();
       var pd = '';
       if(totalDigits > n.length) {
           for(i = 0; i < (totalDigits - n.length); i++) {
               pd += '0';
           }
       }
       return pd + n.toString();
   }
   var grid_status;
 
    $(document).on("click", "#take_snapshot", function() {
      grid_status = $("#user_grid1").bs_grid("takeSnapshot");
      $("#restore_snapshot").prop("disabled", false);
    });


    $(document).on("click", "#restore_snapshot", function() {
      $("#restore_snapshot").prop("disabled", true);
      $("#user_grid1").bs_grid("restoreSnapshot", grid_status);
    });
</script>