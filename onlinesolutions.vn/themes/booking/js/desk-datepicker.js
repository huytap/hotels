$(function(){
    if(jQuery('#check-in-date').length){
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var checkin = $('#check-in-date').datepicker({
            format: 'dd M yyyy',
            startDate: now,
            beforeShowDay: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            if (ev.date.valueOf() > checkout.viewDate.valueOf()){
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setDate(newDate);      
            }else {
                checkout.setDate(ev.date + 1);
            }            
            checkin.hide();
            $('#check-out-date')[0].focus();
        }).data('datepicker');

        if (typeof fromDate !== 'undefined') {
            jQuery('#check-in-date').val(fromDate);
            var fromDateArray = fromDate.split('-');
            jQuery('#check-in-date').datepicker('setMinDate', new Date());
        }
        if (typeof toDate !== 'undefined') {
            jQuery('#check-out-date').val(toDate);
        }

        var checkout = $('#check-out-date').datepicker({
            format: 'dd M yyyy',
            beforeShowDay: function(date) {
                return date.valueOf() <= checkin.viewDate.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            checkout.hide();
        }).data('datepicker');        
    }

    if(typeof pickup_date !== 'undefined' && jQuery('#arrival-date').length){
        jQuery('#arrival-date').val(pickup_date);        
        var pk = pickup_date.split('-');
        var pdate = new Date(pk[2],pk[1],pk[0]);
        $('#arrival-date').datepicker({
            format: 'dd-mm-yyyy',
            startDate: pdate,
            autoclose:true,
            beforeShowDay: function(date){
                return date.valueOf() < pickup_date.valueOf() ? 'disabled' : '';
            }
        })
        jQuery('#departure-date').val(dropoff_date);
        $('#departure-date').datepicker({
            format: 'dd-mm-yyyy',
            startDate: pdate,
            autoclose:true,
            beforeShowDay: function(data){
            }
        })
    }
})