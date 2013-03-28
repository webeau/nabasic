jQuery(document).ready(function($) {	
$(".nadate").datepicker({
    dateFormat: 'D, M d, yy',
    showOn: 'button',
    buttonImage: theme_data.template_url+'/img/glyphicons-halflings-icon-calendar.png',
    buttonImageOnly: true,
    numberOfMonths: 3
    });
});