jQuery(document).ready(function($) {

	var page_option = $(function(){
	  $('#cmtOptionsForm .single_page').click(function(){
		if ($('.single_page.checked').is(':checked'))
		{
		  //alert($(this).val());
		  $('.select_pages').prop('disabled', false);
		}
		else {
			$('.select_pages').prop('disabled', 'disabled');
		}
		}); 
	});

});