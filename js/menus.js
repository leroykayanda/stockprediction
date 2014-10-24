$(document).ready(function()
				  {
					  $('#open').hover(
						  function()
						  {
							  $('.open').css("color","white");
							  $('#open').css("background-color","rgb(91, 96, 100)");
							  $('.gn-menu-wrapper').css("width","250px");
							  $('.gn-submenu li').css("height","60px");
						  },
						  function()
						  {
							  $('.open').css("color","black");
							  $('#open').css("background-color","#DADADA");
						  }
					  );
					  
						  
					  $('body').on('click','#dev-menu li',function(){
						  $('.gn-menu-wrapper').css("width","55px");                             
					      $('.gn-submenu li').css("height","0");
						  $('.mymenu').poshytip('hide')
					  });

					  $('.gn-trigger li').hover(
						  function()
						  {
							  $('.gn-menu-wrapper').css("width","250px");
							  $('.gn-submenu li').css("height","60px");
						  },
						  function()
						  {
							  $('.gn-menu-wrapper').css("width","55px");                             
							  $('.gn-submenu li').css("height","0");
						  }
					  );

					  $('.gn-trigger li').click(
						  function()
						  {
							  $('.gn-menu-wrapper').css("width","55px");                             
							  $('.gn-submenu li').css("height","0");
						  });


				  });//end document.ready