var imageForGallery = Handlebars.compile($("#asset-image-for-gallery-template").html());
var assetGetUrl = $('#adminAssetsGetUrl').val();
$('#adminAssetsGetUrl').remove();

function loadAssetImages() {
	$('.sumo-asset-image-gallery').each(function(){
		var gallery = $(this);
		var galleryData = gallery.data();
		var getAssetUrl = assetGetUrl;
		var images = [];

		gallery.removeAttr('data-image');

		_.each(galleryData.image, function(image){
			$.ajax({
				type : 'GET',
				url: getAssetUrl,
				header: 'assetManager',
				data : {id: image.asset_id},
				dataType : 'json',
				success : function(data) {
					images.push(data.absolute_path);
					if (images.length == galleryData.image.length) {
						return updateImageGalleries(images, gallery);
					};
				},
				error : function(data, text, error) {

				}
			});
		});
	});
};

loadAssetImages();

function updateImageGalleries(images, gallery = null) {
	var html = imageForGallery({images: images});
	gallery.append(html);
	return html;
};

function generateImageHtml(dataImage) {
	var images = generateImageThumbnailPath(dataImage);
	var html = imageForGallery({images: images});
	return html;
};

function generateImageThumbnailPath(dataImage){
	var images = _.filter(dataImage, function(image) {
		return image.asset.type == 'image';
	});
	images = _.pluck(_.pluck(images, 'asset'), 'small_thumbnail');
	return images;
};