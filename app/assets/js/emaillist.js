  // SHOW POPUP EMAIL SUBSCRIPTION
  function subscriptionPopup()
  {
    // get the mPopup
    var mpopup = $('#mpopupBox');
    
    // open the mPopup
    mpopup.show();
    
    // close the mPopup once close element is clicked
    $(".close").on('click',function(){
        mpopup.hide();
    });
    
    // close the mPopup when user clicks outside of the box
    $(window).on('click', function(e) {
        if(e.target == mpopup[0]){
            mpopup.hide();
        }
    });
  }

  $(document).ready(function() 
  {
    var popDisplayed = $.cookie('popDisplayed');
    if(popDisplayed == '1')
    {
        return false;
    }else
    {
			setTimeout( function() 
			{
					subscriptionPopup();
			},8000);
			$.cookie('popDisplayed', '1', { expires: 3 });
    }
  });
