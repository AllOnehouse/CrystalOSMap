/* ==============================================
Add JS element on window load
=============================================== */
jQuery(window).load(function(){
	'use strict';
	// jQuery(".frmSearch input").addClass('search-box');
	// jQuery('.search-box').after('<div id="suggesstion-box"></div>');
	// jQuery('#in-product_cat-50').prop('checked', true);
	//
	// jQuery(function() {
	// 	if ( document.location.href.indexOf( 'post-new.php?post_type=product' ) !== -1 ) {
	// 		// If we have a page of an initially created product(an auto draft)
	// 		// Force the default product type to 'variable'
	// 		jQuery( '#product-type' ).val( 'variable' ).trigger( 'change' );
	// 	}
	// });
});
/* ==============================================
Custom JS
=============================================== */
// jQuery(document).ready(function(){
// 	jQuery("#acf-field_5eb986f8a0fe1").keyup(function(){
// 		var keyword = jQuery('#acf-field_5eb986f8a0fe1').val();
// 		if(keyword.length >= 3){
//
// 			jQuery.ajax({
// 				url: ajaxurl,
// 				data: {
// 					'action':'my_ajax_request',
// 					'post_type': 'POST',
// 					'keyword' : keyword
// 				},
// 				success:function(data) {
// 					jQuery("#suggesstion-box").show();
// 					jQuery("#suggesstion-box").html(data);
// 					jQuery("#acf-field_5eb986f8a0fe1").css("background","#CfCfCf");
// 				},
// 				error: function(errorThrown){
// 					console.log(errorThrown);
// 				}
// 			});
// 		}
// 	});
// });
jQuery(document).ready(function(){
	jQuery(document).on('click','.search-btn',function(e) {
		event.preventDefault();
		var value = jQuery('.search-txt').val();
		alert(value);
		if(value){
			//jQuery('#search-fm').submit();
			window.location.href = "http://localhost:8080/crystalOsMap/?page_id=582&search="+value;
		}else{
			return false;
		}
	});
});