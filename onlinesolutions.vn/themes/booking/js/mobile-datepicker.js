var numberFormat="#,##0.00";
var jNumberFormat={format:numberFormat};
function convertMonth(month){
    var m = ['01','02','03','04','05','06','07','08','09','10','11','12'];
    return m[month]
}
jQuery(function(){
    if(jQuery('#check-in-date').length){
        var checkin = jQuery('#check-in-date').bootstrapMaterialDatePicker({
            minDate : new Date(), 
            time: false, 
            format:'DD-MM-YYYY'
        }).on('change', function(e, date){
            var newDate = new Date(date);
            newDate.setDate(newDate.getDate() + 1);
            //jQuery('#check-out-date').val('');
            jQuery('#check-out-date').bootstrapMaterialDatePicker('setDate', newDate);
            jQuery('#check-out-date').bootstrapMaterialDatePicker('setMinDate', newDate);
            var day = newDate.getDate();
            if(day < 10){
                day = '0'+day;
            }
            var month = newDate.getMonth();
            var year = newDate.getFullYear();
            jQuery('#check-out-date').val(day+'-'+ (month+1)+ '-' + year);
            //$('#check-out-date')[0].focus();
        });

        if (typeof fromDate !== 'undefined') {
            jQuery('#check-in-date').val(fromDate);
            var fromDateArray = fromDate.split(' ');
            /*
                var setDateTo = new Date(fromDateArray[2],fromDateArray[1]-1,fromDateArray[0]);
                setDateTo.setDate(setDateTo.getDate() + 1);
                jQuery('#check-out-date').bootstrapMaterialDatePicker('setMinDate', setDateTo);
            */
            jQuery('#check-in-date').bootstrapMaterialDatePicker('setMinDate', new Date());
        }
        if (typeof toDate !== 'undefined') {
            jQuery('#check-out-date').val(toDate);
        }
        var checkout = jQuery('#check-out-date').bootstrapMaterialDatePicker({
            time: false, 
            format:'DD-MM-YYYY',
            minDate: new Date()
        });
    }
    if($('#arrival-date').length){
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var pickup_date = $('#arrival-date').datepicker({
            format: 'dd-mm-yyyy',
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            if (ev.date.valueOf() > dropoff_date.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                dropoff_date.setValue(newDate);
            }
            pickup_date.hide();
        }).data('datepicker');
    }
    if($('#departure-date').length){
        var dropoff_date = $('#departure-date').datepicker({
            format: 'dd-mm-yyyy',
            onRender: function(date) {
                return date.valueOf() <= pickup_date.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            dropoff_date.hide();
        }).data('datepicker');

        //$('.date-flight').datepicker({format:'dd-mm-yyyy'});
        //$('.time-flight').timepicker({defaultTime: false});
    }  
})