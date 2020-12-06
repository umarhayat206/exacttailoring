$.fn.digits = function(){ 
    return this.each(function(){ 
        
		if ( $(this).is(':text'))
		{
			$(this).val( $(this).val().replace(/[^0-9.\-]/g, "").replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
		}
		else
		{
			$(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );	
		}
		
		
		
    })
}
