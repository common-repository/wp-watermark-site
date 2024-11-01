jQuery(document).ready(function($){
	
	$('#upload-btn').click(function(e) {
		e.preventDefault();
		var image = wp.media({ 
			title: 'Upload Image',
			// mutiple: true if you want to upload multiple files at once
			multiple: false
		}).open()
		.on('select', function(e){
			// This will return the selected image from the Media Uploader, the result is an object
			var uploaded_image = image.state().get('selection').first();
			// We convert uploaded_image to a JSON object to make accessing it easier
			// Output to the console uploaded_image
			console.log(uploaded_image);
			var wp_watermark_site_image_url = uploaded_image.toJSON().url;
			// Let's assign the url value to the input field
			$('#wp_watermark_site_image_url').val(wp_watermark_site_image_url);
		});
	});
	
	if(document.getElementById('wp_watermark_site_watermark_on')){
		
		var firstrunvalue = document.getElementById('wp_watermark_site_watermark_on').value;
		var textvalue = document.getElementById('wp_watermark_site_text_on').value;
		
		if ((firstrunvalue=='null')||(firstrunvalue=="")||(firstrunvalue=="0")){
			document.getElementById('watermark-radio-off').checked = true;
			checkradio();
		} else if (textvalue=='1'){
			document.getElementById('watermark-radio-text').checked = true;
			checkradio();
		} else {
			document.getElementById('watermark-radio-image').checked = true;
			checkradio();
		}
		
	}

	
});



// radio switcher
	function checkradio(){
		
		if (document.getElementById('watermark-radio-off').checked) {
			document.getElementById('wp_watermark_site_watermark_on').value=0;
			document.getElementById('wp_watermark_site_text_on').value=0;
			document.getElementById('wp_watermark_site_image_on').value=0;
			document.getElementById('watermark-form').style.display="none";
		} else if (document.getElementById('watermark-radio-text').checked) {
			document.getElementById('wp_watermark_site_watermark_on').value=1;
			document.getElementById('wp_watermark_site_text_on').value=1;
			document.getElementById('wp_watermark_site_image_on').value=0;
			document.getElementById('watermark-form').style.display="inline-block";
			document.getElementById('watermark-image-section').style.display="none";
			document.getElementById('watermark-text-section').style.display="inline-block";
		} else if (document.getElementById('watermark-radio-image').checked) {
			document.getElementById('wp_watermark_site_watermark_on').value=1;
			document.getElementById('wp_watermark_site_text_on').value=0;
			document.getElementById('wp_watermark_site_image_on').value=1;
			document.getElementById('watermark-form').style.display="inline-block";
			document.getElementById('watermark-image-section').style.display="inline-block";
			document.getElementById('watermark-text-section').style.display="none";
		}
	}
	

// settings not saved message
function wp_watermark_site_options_not_saved(){
	document.getElementById('notsaved').style.display="inline-block";
}

function wp_watermark_site_options_saved(){
	document.getElementById('notsaved').style.display="none";
}
