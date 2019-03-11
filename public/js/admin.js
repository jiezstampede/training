var notify;
function showNotify(title, message, timer) {
	var message = (_.isUndefined(message) ? '' : message);
	var timer = (_.isUndefined(timer) ? 3000 : timer);
	if (! _.isUndefined(notify)) {
		notify.close();
	}
	notify = $.notify({
		icon: '',
		title: title,
		message: message,
	}, {
		type: "primary",
		animate: {
			enter: 'animated fadeInUp',
			exit: 'animated fadeOutDown'
		},
		placement: {
			from: "bottom",
			align: "right"
		},
		timer: timer
	});
};
function hideLoader(hideIt) {
	var loader = $('#page-loader');
	loader.toggleClass('hide', hideIt);
};
function toSlug(str) {
	return str.toString().toLowerCase()
    .replace(/\s+/g, '-')
    .replace(/[^\w\-]+/g, '')
    .replace(/\-\-+/g, '-')
    .replace(/^-+/, '');
};
function boxElementFromWidth() {
	$('.box-container').each(function(e) {
		$(this).height($(this).width());
	});
}
function guid() {
	function s4() {
	    return Math.floor((1 + Math.random()) * 0x10000)
			.toString(16)
			.substring(1);
	}
	return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
	    s4() + '-' + s4() + s4() + s4();
};

$(document).ready(function() {
	boxElementFromWidth();

	var navbar = $('.navbar');
	var parselyForm = $('.form-parsley');
	var seoForm = $('.form-seo');

	//===== SIDEBAR MANAGEMENT
	$('aside>ul>li>a').on('click', function() {
		$('aside>ul>li').removeClass('open');
		var link = $(this);
		var list = link.closest('li');
		if (list.hasClass('has-list')) {
			list.toggleClass('open');
		}
	});
	navbar.find('.menu-btn').on('click', function() {
		$('body').toggleClass('hide-menu');
	});
	$(window).resize(function() {
		// checkWindowWidth();
		boxElementFromWidth();
	});
	function checkWindowWidth() {
		if ($(window).width() < 768) {
			hideMenu();
		} else {
			showMenu();
		}
	}
	function showMenu() {
		$('body').removeClass('hide-menu');
	}
	function hideMenu() {
		$('body').addClass('hide-menu');
	}

	//===== ADMIN INIT
	checkWindowWidth();
	$('.datatable').dataTable({
		oLanguage: {
	      	sLengthMenu: "_MENU_",
	      	oPaginate: {
		      	"sPrevious": "«",
				"sNext": "»"
	      	}
	    }
	});
	$(".select2").select2();
	$('[data-toggle="popover"]').popover();
	$('[data-toggle="tooltip"]').tooltip(); 
	$('aside [data-toggle="collapse"]').click(function(e){
		$(this).siblings('ul').collapse('toggle');
	}); 

	$('.toggle-delete-all').on('click', function() {
		var checkbox = $(this);
		var toggle = (checkbox.is(':checked')) ? true : false;
		$('input[name="ids[]"]').prop('checked', toggle);
	});
	$('#delete-modal .btn-delete').on('click', function() {
		$('.form-delete').submit();
	});

	//===== CRUD AJAX 
	if (parselyForm.length > 0) {
		$.each(parselyForm, function () {
			var pForm = $(this);
			pForm.submit(function (e) {
				e.preventDefault();
			});
			var url = pForm.attr('action');
			var method = pForm.attr('method');
			pForm.parsley().on('form:submit', function () {
				hideLoader(false);
				showNotify('Saving data.');
				var type = (_.isUndefined(method) ? 'POST' : method);
				var data = pForm.serialize();
				submitForm(url, data, type);
				return false;
			});
		});
	}
	function submitForm(url, data, type) {
		$.ajax({
			type : type,
			url: url,
			data : data,
			dataType : 'json',
			processData: false,
			success : function(data) {
				hideLoader(true);
				var title = data.notifTitle;
				var message = (_.isUndefined(data.notifMessage) ? '' : data.notifMessage);
				showNotify(title, message);

				if (data.resetForm) {
					resetForm(parselyForm);
				}

				if (! _.isUndefined(data.redirect)) {
					setTimeout(function() {
						window.location = data.redirect;
					}, 1000);
				}
			},
			error : function(data, text, error) {
				hideLoader(true);
				var message = '';
				_.each(data.responseJSON, function(val) {
					message += val + ' ';
				});
				showNotify('Error saving.', message);
			}
		});
	};
	function resetForm(form) {
		form.find('input').val('');
		form.find('textarea').val('');
	}

	//===== CRUD SLUG
	if ($('.to-slug').length > 0) {
		var slug = $('.to-slug');
		var form = $('.form');
		slug.attr('readonly', 'true');

		if (form.hasClass('form-create')) {
			var input = $('.form-create .to-slug').data('from');
			$('#'+input).keyup(function() {
				slug.val(toSlug($(this).val()))
			});
		} else if (form.hasClass('form-edit')) {
			slug.parent().append('<a class="edit-slug" href="#">Edit</a>');
			$('.edit-slug').on('click', function() {
				slug.removeAttr('readonly').focus();
				$(slug).keyup(function() {
					slug.val(toSlug($(this).val()))
				});
			});
		}
	}

	//===== SEO AJAX
	seoForm.submit(function(e) {
		e.preventDefault();
		var container = seoForm.closest('.seo-url');
		var url = container.data('url');
		var data = seoForm.serialize();
		submitSeoFrom(url, data);
	});
	function submitSeoFrom(url, data) {
		hideLoader(false);
		showNotify('Saving SEO.');
		$.ajax({
			type : 'POST',
			url: url,
			data : data,
			dataType : 'json',
			processData: false,
			success : function(data) {
				hideLoader(true);
				var title = data.notifTitle;
				var message = (_.isUndefined(data.notifMessage) ? '' : data.notifMessage);
				showNotify(title, message);
			},
			error : function(data, text, error) {
				hideLoader(true);
				var message = '';
				_.each(data.responseJSON, function(val) {
					message += val + ' ';
				});
				showNotify('Error saving.', message);
			}
		});
	}

	//===== CROPPING IMAGES
	var formCrop = $('.form-crop');
	var cropTarget = formCrop.find('#crop-target');
	var cropDimensions = {
		'width': formCrop.find('input[name="target_width"]').val(),
		'height': formCrop.find('input[name="target_height"]').val()
	}
	cropTarget.Jcrop({
		onSelect: changeCoords,
		onChange: changeCoords,
		aspectRatio: cropDimensions.width / cropDimensions.height
	});
	function changeCoords(c) {
		formCrop.find('input[name="crop_width"]').val(c.w);
		formCrop.find('input[name="crop_height"]').val(c.h);
		formCrop.find('input[name="x"]').val(c.x);
		formCrop.find('input[name="y"]').val(c.y);
		// showPreview(c);
	}
	// function showPreview(c) {
	// 	var rx = 100 / c.w;
	// 	var ry = 100 / c.h;
	// 	$('#crop-preview').css({
	// 		width: Math.round(rx * 500) + 'px',
	// 		height: Math.round(ry * 370) + 'px',
	// 		marginLeft: '-' + Math.round(rx * c.x) + 'px',
	// 		marginTop: '-' + Math.round(ry * c.y) + 'px'
	// 	});
	// }

	//===== REDACTOR
	var redactor = $('.redactor');
	if (redactor.length > 0) {
		var redactorUpload = redactor.data('redactor-upload');
		var token = redactor.closest('form').find('input[name="_token"]').val();
		redactor.redactor({
			minHeight: '200px',
			fileUpload: redactorUpload + '?_token=' + token,
			imageUpload: redactorUpload + '?_token=' + token,
			imageResizable: true,
			plugins: ['table', 'fontcolor', 'fontsize', 'alignment', 'counter']
		});
	}
	
	//===== OPTIONS
	var optionsForm = $('.options-form');
	var optionsTypeInput = optionsForm.find('#option-type');
	optionsTypeInput.change(function() {
		showOptionType(optionsTypeInput.val());
	});
	showOptionType(optionsTypeInput.val());
	function showOptionType(type) {
		optionsForm.find('.option-type').addClass('hide');
		optionsForm.find('.option-type-'+type).removeClass('hide');
	}

	//===== SORTABLE for TABLES
	 $( ".sortable" ).sortable({
      placeholder: ".sortable tr",
      cursor: "move",
      update: function( event, ui ) {
      	//puts the sortable ID in an array
      	var order = $(this).sortable('serialize', {
                attribute: 'sortable-id',//this will look up this attribute
                // key: 'order',//this manually sets the key
			});
      	//foreach list of array in order
      	var routeURL= $(this).attr('sortable-data-url');
      	//console.log(order);
      		updateSortableTable(routeURL,order);
      		// console.log(order);
	    }
    });
	 
	//AJAX for Sortable Tables
	function updateSortableTable(url, data) {
		$.ajax({
			type : 'get',
			url: url,
			data : data,
			dataType : 'json',
			processData: false,
			success : function(data) {
				var title = data.notifTitle;
				var message = (_.isUndefined(data.notifMessage) ? '' : data.notifMessage);
				showNotify(title, message);

				if (data.resetForm) {
					resetForm(parselyForm);
				}

				if (! _.isUndefined(data.redirect)) {
					setTimeout(function() {
						window.location = data.redirect;
					}, 2500);
				}
			},
			error : function(data, text, error) {
				var message = '';
				_.each(data.responseJSON, function(val) {
					message += val + ' ';
				});
				showNotify('Error saving.', message);
			}
		});
	};

	//SUMO DATE INITIALIZATION
	$(".sumodate").each(function(e) {
		$(this).sumodate({
            monthFormat: 'mmmm', // m – One-digit month,mm – Two-digit month,mmm – Three-letter abbreviation for month, mmmm – Month spelled out in full, e.g. April
            dayFormat: 'dd', //d – One-digit day for days below 10, dd – Two-digit day
            yearFormat: 'yyyy', //yy – Two-digit year,yyyy – Four-digit year
            defaultDate: 'current',//yyyy-mm-dd format or current
            maxYear: 'current',//exact year or current
            minYear:'1990', //exact year or current
            dayClass: 'form-control', //class added to day dropdown
            monthClass: 'form-control', //class added to month dropdown
            yearClass: 'form-control' //class added to year dropdown
	    });
    });

	
    $('input[data-toggle="toggle"]').each(function(){
	    	$(this).change(function() {
	    		var hiddenCheckbox= $(this).parent().siblings('input[type="checkbox"]');
	 		if($(this).prop('checked') === true) {
	    		hiddenCheckbox.attr('disabled','disabled');
	    	}
	    	else {
	    		hiddenCheckbox.removeAttr('disabled');
	    	}
	    });
    });

    $('form.unloadpagevalidator').each(function(){
		$(this).unloadpagevalidator({ 
		    customizeWarning: true, // enabled function customizeWarningOnClickOfLink when true
		    customizeTitle: "Do you want to reload this site?",// title of custom alert
		    customizeText: "Changes you made may not be saved.",// text of custom alert
		    customizeType: "warning", // type of custom alert (warning, success, info, error)
		    customizeTextStay: "Stay on this page", // text of button stay
		    customizeTextLeave: "Leave this page", // text of button leave
		    customizeBtnColorLeave: "#2ac3f2", // color of leave page button
        	customClass: 'sweetalert', // customClass for sweetalert
		    targetForm: 'form', // target form to be only set if not use in jquery chaining *this value will be ignored when use chaining method 
		    targetInputs: 'input, textarea', // inputs to validate inside targetForm
			classUnloadvalidation: 'unloadvalidation', // default class that will add on keydown/change of targetInputs inside targetForm
		    warningForAjax: true, // enabled function warningDuringAjaxCall when true
		    disablingDuringAjax: true // enabled function disablingButtonOnAjaxCall when true
		});
	});
	

    $('select.select2-allow-creation').select2({
        tags: true
  	});

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

});
//===== ASSET MANAGER
(function(){
	var assetModal = $('#assets-modal');
	var assetForm = $('#file-upload-form');
	var fileDropzone = document.getElementById('assets-modal');
	var fileDropzoneJquery = $('#file-dropzone');
	var fileLibrary = $('#file-library .files');
	var assetInput = assetModal.find('.input-file');
	var assetDetailForm = $('#asset-detail-form');
	var assetDetail = assetModal.find('.asset-details');
	var assetSelect = $('.sumo-asset-select');
	var assetMultiSelect = $('.sumo-asset-select-multi');
	var assetSelected = {
		container: '',
		id: '',
		path: ''
	};
	var assetDisplay = $('.sumo-asset-display');
	var assetInitLoad = false;
	var assetLoadMoreBtn = assetModal.find('.btn-more');
	var loaderModal = $('.loader-asset');
	var loaderDetails = assetModal.find('.loader-detail');
	var photos, notify;

	var openModalBySB = true;
	var ajaxActiveCounter = 0;

	var numberOfSelected = 0;
	var numberOfCreatedMultiple = 0;

	// handlebars Templates
	var assetImageHTML = Handlebars.compile($("#asset-image-template").html());
	var assetMultipleImageHTML = Handlebars.compile($("#asset-multiple-image-template").html());

	// added karlob for asset tagging
	var assetTagger = assetModal.find('.sumo-asset-tagger');
	var tagHolder = assetModal.find('.sumo-tag-holder');
	function initializeTagger(){
		$.ajax({ // make the request for the selected data object
		  type: 'GET',
		  url: assetTagger.data('url'),
		  header: 'assetManager',
		  dataType: 'json',
			beforeSend : function() {
				ajaxActiveCounter += 1;
			},
			complete : function() {
				ajaxActiveCounter -= 1;
			},
			success : function(data) {
				assetTagger.html('');
				tagHolder.html('');
				for (i in data) {
					assetTagger.append('<option value="'+data[i].name+'">'+data[i].name+'</option>');
					tagHolder.append('<div class="sumo-tag" data-tag="'+data[i].name+'"><span class="fa fa-tag"></span> '+data[i].name+'</div>')
				}
				assetTagger.select2({
					tags: true,
					placeholder: 'Select a tag',
					allow_clear: 'true',
				});
				initializeTagLink();
			 	assetTagger.trigger('change'); // notify JavaScript components of possible changes
			}
		});
	}
	function getSelectedTags() {
		//get all active tags
		var tags = $('.sumo-tag.active').map(function(e){
			return $(this).data('tag');
		}).get().join();

		return tags;
	}

	function initializeTagLink(){
		assetModal.find('.sumo-tag').click(function(e){
			$(".file[data-id!='']").remove();
			$(this).toggleClass('active');
			getAssetList(0);
		});
	}
	// end add karlob

	//===== INITIALIZE MODAL AND ASSETS
	assetModal.on('shown.bs.modal', function () {
		if (!assetInitLoad) {
			getAssetList(0);
			if (openModalBySB){	
				initializeTagger(); // call tagger initialization
			}
		}
	});
	assetModal.on('hidden.bs.modal', function () {
		fileLibrary.find('.file').removeClass('active').removeAttr('order');
		numberOfSelected = 0;
	});
	function getAssetList(count) {
		var searchInput = typeof $('input[name="searchInput"]').val() != 'undefined' ? $('input[name="searchInput"]').val() : '';
		var sortBy = getSortBy();
		var filterBy = getFilterBy();
		var tags = getSelectedTags();
		var url = fileLibrary.data('url');
		assetLoadMoreBtn.attr('disabled', 'disabled');
		$.ajax({
			type : 'GET',
			url: url,
			header: 'assetManager',
			data : {
				'count': count,
				'tags': tags,
				'searchInput': searchInput,
				sortBy,
				filterBy
			},
			dataType: 'json',
			success : function(data) {
				assetInitLoad = true;
				fileLibrary.append(data.view);
				assetModal.find('.loader-asset').addClass('hide');
				assetModal.find('.row-asset').removeClass('hide');
				assetLoadMoreBtn.removeAttr('disabled');
				bindFiles();
				findActiveAsset();
				if (! data.next) {
					assetLoadMoreBtn.addClass('hide');
				}else{
					assetLoadMoreBtn.removeClass('hide');
				}
			},
			error : function(data, text, error) {
				var count = fileLibrary.find('.file').length - 1;
				getAssetList(count);
				console.log(data);
				console.log(text);
				console.log(error);
			}
		});
	};
	function findActiveAsset() {
		fileLibrary.find('.file').removeClass('active');
		// fileLibrary.find('.file[data-id="' + assetSelected.id + '"]').addClass('active');
	}
	function bindFiles() {
		fileLibrary.find('.file').each(function() {
			var file = $(this);
			file.unbind();
			file.on('click', function() {
				var clicked = $(this);
				if(!assetModal.find('.modal-footer .multi-select').hasClass('multi-select')){
					fileLibrary.find('.file').removeClass('active');
				}
				if (! clicked.hasClass('active')) {
					loaderDetails.removeClass('hide');
					assetDetail.addClass('hide');
					clicked.addClass('active');
					var id = clicked.data('id');
					getAssetDetails(id);

					numberOfSelected ++;
					clicked.attr('order',numberOfSelected);
				} else {
					$('.asset-details').addClass('hide');
					clicked.removeClass('active');

					numberOfSelected --;
					clicked.siblings('.file.active').each(function(){
						if($(this).attr('order') > clicked.attr('order')){
							$(this).attr('order',$(this).attr('order') - 1);
						};
					});
					clicked.removeAttr('order');
				}
			})
		})
	};
	function getAssetDetails(id) {
		var url = assetDetail.data('url');
		$.ajax({
			type : 'GET',
			url: url,
			header: 'assetManager',
			data : {id: id},
			dataType : 'json',
			beforeSend : function() {
				ajaxActiveCounter += 1;
			},
			complete : function() {
				ajaxActiveCounter -= 1;
			},
			success : function(asset) {
				displayDetailsToForm(asset);
				loaderDetails.addClass('hide');
				assetDetail.removeClass('hide');
			},
			error : function(data, text, error) {
			}
		});
	}
	assetLoadMoreBtn.on('click', function() {
		// -1 because of clone file
		var count = fileLibrary.find('.file').length - 1;
		getAssetList(count);
	});

	//====== SELECTING ASSET
	assetModal.find('.btn-select').on('click', function() {
		if (!$(this).hasClass('multi-select')) {
			displaySelectedAsset();
		}else if ($(this).hasClass('multi-select')){
			displayMultiSelectedAsset();
		}
	});

	/*
		Selected Multiple Asset 
		Function expects selected assets to be added into a group of assets
		Function is coordinated with the Asset Facade

		@Authors:
			2017-09-01 | Jiez | Object Optimization
	*/
	function displayMultiSelectedAsset() {
		var groupId = assetSelected.container[0].dataset.id;
		if (groupId == 0 || groupId == '0') {
			groupId = guid();
			assetSelected.container.attr('data-id', groupId);
		};

		//prototype multi select added here
		var groupAssetData = {
			id : groupId,
			name: assetSelected.container.data('name'),
			assets: []
		};

		try {
			var tmpAssetData = JSON.parse(assetSelected.container.find('input').val());
			if (tmpAssetData.assets.length) {
				groupAssetData.assets = tmpAssetData.assets;
			};
		} catch(e) {};
		var selectedAssets = [];
		
		// first loop to get all unsort selected assets
		fileLibrary.find('.file.active').each(function(){ 
			if($(this).attr('data-id')){
				var id = $(this).attr('data-id');
				var order = $(this).attr('order') - 1 + groupAssetData.assets.length;
				var image = $(this).css('background-image').replace('url(','').replace(')','').replace(/\"/gi, "");
				
				try {
					if (!(_.where(groupAssetData.assets, {asset_id: parseInt(id)}).length > 0)) {
						selectedAssets.push({
							asset_id: parseInt(id),
							order: order,
							image: image,
						});
					};
				} catch(e) {};
			};
		});

		if (selectedAssets.length > 0) {
			var selectedAssets = _.sortBy(selectedAssets, 'order');
			groupAssetData.assets = groupAssetData.assets.concat(selectedAssets);

			assetSelected.container.find('.empty-bg').addClass('hide');

			for (var i = 0; i < selectedAssets.length; i++) {
				var context = { visibility: '', src: selectedAssets[i].image , id: selectedAssets[i].asset_id};
				var html = assetImageHTML(context);
				var col = assetSelected.container.find('.images-container').append('<div class="col col-xs-4 col-sm-3 box-container sumo-asset-select">'+html+'</div>');
			};
		} else if(groupAssetData.assets.length == 0){
			assetSelected.container.find('.empty-bg').removeClass('hide');
		}

		try {
			assetSelected.container.find('input').val(JSON.stringify(groupAssetData));		
		} catch(e) {};

		boxElementFromWidth();
	};

	function displaySelectedAsset() {
		fileLibrary.find('.file.active').each(function(){ 
			if($(this).attr('data-id')){
				var id = $(this).attr('data-id');
				var image = $(this).css('background-image').replace('url(','').replace(')','').replace(/\"/gi, "");

				assetSelected.path = image;
				assetSelected.id = id;
			};
		});
		assetSelected.container.find('.sumo-asset-img-container').removeClass('hide').attr('data-id', assetSelected.id);
		assetSelected.container.find('img').attr('src',assetSelected.path);
		assetSelected.container.find('.sumo-asset').val(assetSelected.id).addClass('unloadvalidation');
	};

	//====== DRAG AND DROP FUNCTIONS
	fileDropzoneJquery.on('click', function() {
		assetInput.click();
	});
	function addEventHandler(obj, evt, handler) {
		if(obj.addEventListener) {
			obj.addEventListener(evt, handler, false);
		} else if(obj.attachEvent) {
			obj.attachEvent('on'+evt, handler);
		} else {
			obj['on'+evt] = handler;
		}
	}
	addEventHandler(fileDropzone, 'drop', function(e) {
	  	e = e || window.event;
	  	if (e.preventDefault) { e.preventDefault(); }
	  	files = event.target.files;
	  	uploadFiles(e.dataTransfer.files);
  		return false;
	});
	addEventHandler(fileDropzone, 'dragenter', function(e) {
		e.preventDefault();
		// console.log('dragenter');
	});
	addEventHandler(fileDropzone, 'dragover', function(e) {
		e.preventDefault();
		// console.log('dragover');
	});

	//===== UPLOAD ASSETS
	assetInput.change(function(e) {
		files = event.target.files;
		uploadFiles(files);
	});
	function uploadFiles(files) {
		assetModal.find('a[href="#file-library"]').tab('show');
		var route = assetForm.attr('action');
		var request = [];
		var formdata = [];
		var types = [];
		var randomID;

		if (files && files[0]) {
			for (i = 0; i < files.length; i++) {
				if (files[i].type.match(/image.*/)) {
					types[i] = 'image';
				} else if (files[i].type.match(/video.*/)) {
					types[i] = 'video';
				} else if (files[i].type.match(/audio.*/)) {
					types[i] = 'audio';
				} else {
					types[i] = 'file';
				}

				// set max size (10mb)
				if (files[0].size <= 10240000) {
					request[i] = new XMLHttpRequest();
					formdata[i] = new FormData();

					randomID = 'asst_' + Math.floor(Math.random() * 1000000000000);
					formdata[i].append('photo', files[i]);
					formdata[i].append('type', types[i]);
					formdata[i].append('_token', assetForm.find('input[name="_token"]').val());

					// added karlob for tagging
					var assetTagger = assetModal.find('.sumo-asset-tagger');
					if (assetTagger.val().length > 0) {
						formdata[i].append('tags', assetTagger.val());
					}
					// end add karlob

					request[i].open('post', route, true);

					processPhoto(request[i], types[i], randomID);
					request[i].send(formdata[i]);
				}
			}
		}
	}
	function processPhoto(request, type, id) {
		var asset = $('.'+id);
		fileLibrary.find('.clone').clone().prependTo(fileLibrary).removeClass('clone hide').addClass(id);
		request.upload.onprogress = function (e) {
			if (e.lengthComputable) {
				var ratio = Math.floor((e.loaded / e.total) * 100);
				$('.'+id).find('.progress').attr('aria-valuenow', ratio);
				$('.'+id).find('.progress-bar').width(ratio + '%');
			}
		}
		request.addEventListener('load', function(e) {
			// reinitialize tags
			initializeTagger();
			var data = JSON.parse(request.responseText);
			$('.'+id).attr('data-id', data.id);
			$('.'+id).find('.progress').hide();
			$('.'+id).css({
				'background-image': 'url(' + data.filepath + ')'
			});
			$('.'+id).append('<span class="name">'+data.name+'</span>');
		}, false);
		bindFiles();
	}

	function displayDetailsToForm(asset) {
		assetSelected.id = asset.id;
		assetSelected.path = asset.absolute_path;
		assetDetailForm.find('.photo img').attr('src', asset.absolute_path);
		assetDetailForm.find('[name="id"]').val(asset.id);
		assetDetailForm.find('[name="name"]').val(asset.name);
		assetDetailForm.find('[name="caption"]').val(asset.caption);
		assetDetailForm.find('[name="alt"]').val(asset.alt);

		// added karlob to load the tags
		var tagger = assetDetailForm.find('[name="tags"]');
		if (asset.tags) {
			var tags = asset.tags.map(function(item){
				return item.name;
			})
			tagger.val(tags).trigger('change');
		}
		// end karlob
	}

	assetDetailForm.submit(function(e) {
		e.preventDefault();
		var url = assetDetailForm.attr('action');

		// add fix for tag upload
		var data = {};
		data._token = assetForm.find('input[name="_token"]').val();
		data.id = assetDetailForm.find('[name="id"]').val();
		data.name = assetDetailForm.find('[name="name"]').val();
		data.caption = assetDetailForm.find('[name="caption"]').val();
		data.alt = assetDetailForm.find('[name="alt"]').val();
		data.tags = assetDetailForm.find('[name="tags"]').val().join(",");
		// upload da tags

		$.ajax({
			type : 'POST',
			url: url,
			header: 'assetManager',
			data : data,
			dataType : 'json',
			success : function(data) {
				showNotify(data.notifTitle);
				assetDetailForm.find('input, textarea').removeClass('check-on-unload');
			},
			error : function(data, text, error) {
				showNotify('An error occurred.');
			}
		});
	});

	//====== DOWNLOAD FILE
	assetModal.find('.download-btn').on('click', function(e) {
		e.preventDefault();
		var id = assetDetailForm.find('[name="id"]').val();
		var url = $(this).find('a').attr('href');
		window.open(url+'?id='+id, '_blank');
	});

	//===== DELETE FUNCTIONS
	assetDetail.find('.delete-btn').on('click', function() {
		assetDetail.find('.delete-btn').addClass('hide');
		assetDetail.find('.confirm-btn').removeClass('hide');
	});
	assetDetail.find('.confirm-btn a').on('click', function(e) {
		e.preventDefault();
		resetDeleteBtns();
	});
	assetDetail.find('.confirm-btn .confirm-delete-btn').on('click', function(e) {
		var id = assetDetailForm.find('[name="id"]').val();
		var url = $(this).attr('href');
		$.ajax({
			type : 'POST',
			url: url,
			header: 'assetManager',
			data : assetDetailForm.serialize(),
			dataType : 'json',
			success : function(asset) {
				fileLibrary.find('.file').removeClass('active');
				fileLibrary.find('.file[data-id="' + id + '"]').remove();
				assetDetail.addClass('hide');
				

				//find the original form then deletes the old value if the id of deleted asset equals to the value..
				$(document).find('.form-parsley .sumo-asset').each(function(){
					var value = $(this).val();
					if (value == id ) {
						$(this).val('');
						$(this).next().attr('src','');
					}
				});

			},
			error : function(data, text, error) {

			}
		});
	});
	function resetDeleteBtns() {
		assetDetail.find('.delete-btn').removeClass('hide');
		assetDetail.find('.confirm-btn').addClass('hide');
	}

	//===== INITIALIZE IMAGE SELECTOR FROM FORM
	assetSelectInit();
	function assetSelectInit() {
		assetSelect.each(function() {
			var asset = $(this);
			var assetInput = asset.find('.sumo-asset');
			asset.find('label').append('<a class="select" data-toggle="modal" data-target="#assets-modal" href="#">Select</a>');
			if (! _.isUndefined(assetInput.data('thumbnail')) && ! _.isUndefined(assetInput.data('id'))) {
				asset.find('label').append('<a class="crop" href="#">Crop</a>');
			}
			// asset.find('label').append('<a class="remove" href="#">Remove</a>');
			var context = { visibility: 'hide', src: '' };
			var html = assetImageHTML(context);

			asset.append(html);
			asset.append('<div class="loader loader-asset"><div class="spinner"></div></div>');
			
			checkSelectedAsset(asset);
		});
	}
	assetMultipleSelectInit();
	function assetMultipleSelectInit() {
		assetMultiSelect.each(function() {
			var asset = $(this);
			var assetInput = asset.find('.sumo-asset-multiple');
			var assetImages = JSON.parse(assetInput.val());
			var assetAssets = (assetImages) ? assetImages.assets : '';

			asset.find('.header').append('<div class="pull-right"> <a class="multi-select" data-toggle="modal" data-target="#assets-modal" href="#">Select Images</a> </div>');

			var context = { visibility: 'hide', images: assetAssets };
			var html = assetMultipleImageHTML(context);

			asset.append(html);

			asset.find('.empty-bg').removeClass('hide');
			if(assetImages){
				asset.find('.empty-bg').addClass('hide');
			}

			var url = assetDetail.data('url');
			for (var i = assetAssets.length - 1; i >= 0; i--) {
				$.ajax({
					type : 'GET',
					url: url,
					header: 'assetManager',
					data : {id: assetAssets[i].asset_id},
					dataType : 'json',
					beforeSend : function() {
						ajaxActiveCounter += 1;
					},
					complete : function() {
						ajaxActiveCounter -= 1;
						console.log(ajaxActiveCounter);
					},
					success : function(data) {
						console.log(data.absolute_path);
						asset.find('.sumo-asset-img-container[data-id='+data.id+'] img').attr('src',data.absolute_path);
					},
					error : function(data, text, error) {
					}
				});
			}
			
		});
	}
	bindSelectBtns();
	function bindSelectBtns() {
		console.log('Bind');
		assetMultiSelect.find('.multi-select').on('click',function(e){
			e.preventDefault();
			var btn = $(this);
			assetModal.find('.modal-footer .btn-select').addClass('multi-select');
			assetSelected.container = btn.closest('.sumo-asset-select-multi');

			btn.closest('.sumo-asset-select-multi').find('input.assets-id').each(function(){
				var id = $(this).val();
				var order = $(this).next('.assets-order').val();
				// fileLibrary.find('.file[data-id="' + id + '"]').attr('order',order).addClass('active');
			});

			assetDetail.closest('.col-xs-3').addClass('hide');
		});
		assetSelect.find('.select').on('click', function(e) {
			e.preventDefault();
			var btn = $(this);
			assetModal.find('.modal-footer .btn-select').removeClass('multi-select');
			openModalBySB = false;
			assetSelected.container = btn.closest('.sumo-asset-select');
			assetSelected.id = assetSelected.container.find('.sumo-asset').val();
			if (!openModalBySB && !assetInitLoad){	
				initializeTagger(); // call tagger initialization
			};
			if (assetSelected.id) {
				getAssetDetails(assetSelected.id);
				findActiveAsset();
			};
			
			assetDetail.closest('.col-xs-3').removeClass('hide');
		});
		assetSelect.find('.crop').on('click', function(e) {
			e.preventDefault();
			hideLoader(false);
			showNotify('Retrieving URL.');

			var btn = $(this);
			var input = btn.closest('.sumo-asset-select').find('input');
			assetSelected.container = btn.closest('.sumo-asset-select');
			var url = btn.closest('.sumo-asset-select').data('crop-url');
			var data = {
				'id': input.data('id'),
				'column': input.data('thumbnail'),
				'asset_id': assetSelected.container.find('.sumo-asset').val()
			}
			$.ajax({
				type : 'GET',
				url: url,
				header: 'assetManager',
				data : data,
				dataType : 'json',
				success : function(data) {
					showNotify('Redirecting.');
					setTimeout(function() {
						window.location = data.redirect;
					}, 1000);
				},
				error : function(data, text, error) {

				}
			});
		});
		assetSelect.find('.remove').on('click', function(e) {
			e.preventDefault();
			var btn = $(this);
			var asset = btn.closest('.sumo-asset-select');
			asset.find('.sumo-asset-img-container').addClass('hide');
			asset.find('.sumo-asset').val('');
			asset.find('img').attr('src', '');
		});
		assetSelect.find('.preview').on('click', function(e) {
			e.preventDefault();
			if (!$(this).closest('.sumo-asset-select-multi').length) {
				var btn = $(this);
				var selectedImage = btn.closest('.sumo-asset-img-container').find('img').attr('src');
				$.fancybox.open([{src: selectedImage}], { loop : false });
			}
		})

		assetMultiSelect.on('click', '.remove', function(e) {
			e.preventDefault();
			// console.log('remove');
			var assetGroup = $(this).closest('.sumo-asset-select-multi');
			var asset = $(this).closest('.sumo-asset-img-container ');
			var assetId = asset.data('id');

			var groupId = assetGroup[0].dataset.id;
			if (groupId == 0 || groupId == '0') {
				groupId = guid();
				assetSelected.container.attr('data-id', groupId);
			};

			var groupAssetData = {
				id : groupId,
				name: assetGroup.data('name'),
				assets: []
			};

			try {
				var tmpAssetData = JSON.parse(assetGroup.find('input').val());
				if (tmpAssetData.assets.length) {
					groupAssetData.assets = tmpAssetData.assets;
				};
			} catch(e) {};

			var tmpAssets = []
			_.each(groupAssetData.assets, function(asset){
				if (asset.asset_id != assetId) {
					asset.order = tmpAssets.length;
					tmpAssets.push(asset);
				};  
			}); 

			groupAssetData.assets = tmpAssets;
			asset.closest('.sumo-asset-select').remove();

			try {
				assetGroup.find('input').val(JSON.stringify(groupAssetData));		
			} catch(e) {};

			if (groupAssetData.assets.length > 0) {
				assetGroup.find('.empty-bg').addClass('hide');
			} else {
				assetGroup.find('.empty-bg').removeClass('hide');
			};
		});
		assetMultiSelect.on('click', '.preview', function(e) {
			e.preventDefault();
			var btn = $(this);
			var selectedImage = btn.closest('.sumo-asset-img-container').find('img').attr('src');
			$.fancybox.open([{src: selectedImage}], { loop : false });
		})
	}
	function checkSelectedAsset(asset) {
		var container = asset;
		var id = container.find('.sumo-asset').val();
		if (!id) {
			container.find('.loader').remove();
			return false;
		};
		var url = assetDetail.data('url');
		$.ajax({
			type : 'GET',
			url: url,
			header: 'assetManager',
			data : {id: id},
			dataType : 'json',
			success : function(asset) {
				assetSelected.container = container;
				assetSelected.id = asset.id;
				assetSelected.path = asset.absolute_path;
				displaySelectedAsset();
			},
			error : function(data, text, error) {

			},
			complete: function(event,xhr,options) {
				container.find('.loader').remove();
			}
		});
	}

	//===== INITIALIZE IMAGE FOR VIEWING
	assetDisplay.each(function() {
		var container = $(this);
		var id = container.data('id');
		var url = container.data('url');
		container.append('<div class="loader loader-asset"><div class="spinner"></div></div>');

		$.ajax({
			type : 'GET',
			url: url,
			header: 'assetManager',
			data : {id: id},
			dataType : 'json',
			success : function(asset) {
				var img = new Image();
				img.src = asset.absolute_path;
				img.alt = asset.alt;
				container.append(img);
			},
			error : function(data, text, error) {

			},
			complete: function(event,xhr,options) {
				container.find('.loader').remove();
			}
		});
	});


	assetModal.on("hidden.bs.modal", function () {

		var finder = true;
		var assetUnLoadWarning = false;
		$('#asset-detail-form').find('input.check-on-unload, textarea.check-on-unload').each(function(){
			if($(this).attr('name') !== '_token' && $(this).attr('name') !== 'id'){
				var val = $(this).val();
				if(finder){
					if (val.length == 0) {
						assetUnLoadWarning = false;
					}else{
						assetUnLoadWarning = true;
						finder = false;
					};
				};
			};
		});

		if (assetUnLoadWarning == true) {
			// ------------- Sweetalert when anchor links is click and if customizeWarningOnClickOfLink is enabled
			swal({
			  title: "Do you want to close modal asset?",
			  text: "Your changes on asset information not yet saved.",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#2ac3f2",
			  confirmButtonText: "Yes",
			  cancelButtonText: "No",
			  closeOnConfirm: true,
			  closeOnCancel: true
			},
			function(isConfirm){
			  if (isConfirm) {
				assetModal.find('.modal-footer .btn-select').show();
				assetModal.find('input, textarea').removeClass('check-on-unload');
			  } else {
			  	assetModal.modal("show");
			  }
			});
		}else {
			assetModal.find('.modal-footer .btn-select').show();
		}
		
	});
	
	$('.asset-sidebar-link').click(function(){
		$('#assets-modal').find('.modal-footer .btn-select').hide();
	});

	$('.filter-container').find('.select-filter-type').on('change',function(){
		filterProcessor($(this).val());
	});

	function filterProcessor(filterType) {
		if(filterType == 'file_type'){
			$('.select-file-type').show();
			$('.date-range').hide();
		}else if(filterType == 'created_at' || filterType == 'updated_at'){
			$('.date-range').show();
			$('.select-file-type').hide();
		}
	}

	function getFilterBy() {
		var filterType = $('.select-filter-type').val();
		var filterData;

		if(filterType == 'file_type'){
			filterData = {fileType: $('select[name="filterByFileType"]').val()};
		}else if(filterType == 'created_at' || filterType == 'updated_at'){
			filterData = {date: filterType,
							from: $('input[name="filterByDateFrom"]').val(),
							to: $('input[name="filterByDateTo"]').val()
							};
		}

		return filterData;
	}

	function getSortBy() {
		var sortType = $('select[name="sortBy"]').val();
		var sortBy;
		var sortOrderBy;

		if(sortType == 'oldest' || sortType == 'latest'){
			sortBy = 'created_at';
		}else if(sortType == 'az' || sortType == 'za'){
			sortBy = 'name';
		}

		if(sortType == 'oldest' || sortType == 'az'){
			sortOrderBy = 'ASC';
		}else if(sortType == 'latest' || sortType == 'za'){
			sortOrderBy = 'DESC';
		}

		return {order: sortBy,
				by: sortOrderBy};
	}

	$('select[name="sortBy"], select[name="filterBy"], select[name="filterByFileType"], input[name="searchInput"]').on('change',function(){
		$(".file[data-id!='']").remove();
		getAssetList(0);
	});

	$('button#filterByDateBtn').on('click',function(){
		$(".file[data-id!='']").remove();
		getAssetList(0);
	});

	assetDetailForm.find('input:text, select').on('change',function(){
		if(!ajaxActiveCounter){
			assetDetailForm.submit();
		}
	});

	assetDetailForm.find('input, textarea').on('keydown change',function(){
		$(this).addClass('check-on-unload');
	});

	$('.sumo-add-multi').click(function(e){
		e.preventDefault();
		var newForm = '<div class="form-group sumo-asset-select-multi"> <label for="assets"> <a href="#" class="remove-multi-select"><span class="fa fa-times-circle"></span></a> Name: <input count="'+numberOfCreatedMultiple+'" name="multiName['+numberOfCreatedMultiple+']" type="text" class="multi-name form-control" placeholder="Type Name"> <a class="multi-select" data-toggle="modal" data-target="#assets-modal" href="#">Select Assets</a> </label> <div class="images-container clearfix"></div></div>';
		$(newForm).insertBefore($(this).closest('.sumo-add-form'));
		assetMultiSelect = $('.sumo-asset-select-multi');
		bindSelectBtns();
		numberOfCreatedMultiple ++;
		imageContainer();

		$('.sumo-asset-select-multi .remove-multi-select').click(function(e){
			e.preventDefault();
			$(this).closest('.sumo-asset-select-multi').remove();
		});
	  
	});

	function imageContainer(){
	    $( ".images-container" ).sortable({
	      update: function( event, ui ) {
	        var newOrderID = $(this).sortable('toArray');
			for (var i = 1; i <= newOrderID.length - 1; i++) {
				var order = newOrderID[i];
 	       		var assetsOrder = $(this).closest('.sumo-asset-select-multi').find('.assets-order:eq('+(i-1)+')'); // order input on assetID above
 	       		assetsOrder.attr('value',order); // used .attr function on jquery because .val not working on changing of value
	        };
	      }
	    });
	}
	imageContainer();

})();

function sumoFormSuccessHandler(response) {
	if (response.group.id != response.group.header) {
		var target = $('.sumo-asset-select-multi[data-id="'+response.group.header+'"]')
				.attr('data-id', response.group.id);
		try {
			var groupAssetData = JSON.parse(target.find('input').val());
			groupAssetData.id = response.group.id;
			target.find('input').val(JSON.stringify(groupAssetData));	
		} catch(e) {};
	};
}
//# sourceMappingURL=admin.js.map
