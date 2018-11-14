(function($){
    $.fn.unloadpagevalidator = function(param){
	    return this.each(function(index, element){
        	if($(this).prop("tagName") == 'FORM'){
				var target = {targetForm: $(this).prop("tagName").toLowerCase() + '.unload-validation'};
	        	var options = $.extend(param, target);
	        	$(this).addClass('unload-validation');
		        unloadpagevalidator(options);
        	}else{
        		console.log($(this));
        		console.log('Object selected valid is not a form.');
        	}
	    });
    }
})(jQuery);

function unloadpagevalidator(param) {
    var defaults = {  
        customizeWarning: true, // default enabled function customizeWarningOnClickOfLink
        customizeTitle: "Do you want to reload this site?",// default title of custom alert
        customizeText: "Changes you made may not be saved.",// default text of custom alert
        customizeType: "warning", // default type of custom alert
	    customizeTextStay: "Stay on this page", // default text of button stay
	    customizeTextLeave: "Leave this page", // default text of button leave
        customizeBtnColorLeave: "#2ac3f2", // default color of leave page button
        sweetalertCustomClass: 'sweetalert', // default customClass for sweetalert
        targetForm: 'form', // default all form when not set on call
        targetInputs: 'input, textarea', // default inputs to validate inside targetForm
        targetButtons: 'button,input,a[role=button]', // default buttons to disable
		classUnloadvalidation: 'unloadvalidation', // default class that will add on keydown/change of targetInputs inside targetForm
        warningForAjax: true, // default enabled function warningDuringAjaxCall
        disablingDuringAjax: true // default enabled function disablingButtonOnAjaxCall
    };

	var options = $.extend(defaults, param);

	// ------------- inputs to validate
	var inputs = options.targetInputs;
	// ------------- buttons to disable
	var buttons = options.targetButtons;
	// ------------- add class classUnloadvalidation on inputs to validate
	var classUnloadvalidation = options.classUnloadvalidation;

	// ------------- add validation class classUnloadvalidation on keydown and on change to validation textarea with redactor on unload
	$('.redactor-editor').on('keydown change',function(){
		$(this).next('textarea').addClass(classUnloadvalidation);
	});

	// ------------- add validation class classUnloadvalidation on keydown and on change to validation inputs on unload
	$(options.targetForm).find(inputs).on('keydown change',function(){
		$(this).addClass(classUnloadvalidation);
	});

	// ------------- set unLoadWarning = false on submit of any forms even not selected to prevent unnecessary alert
	$('form').submit(function() {
		unLoadWarning = false;
	});

	// ------------- to set var finder to true onload only
	var unLoadWarning = true;

	// ------------- native on unload pop up message
	window.onbeforeunload = function (){
		var finder = unLoadWarning;
		unLoadWarning = false;
		$(options.targetForm).find(inputs).each(function(){
			if($(this).hasClass(classUnloadvalidation) && $(this).attr('name') !== '_token'){
				var val = $(this).val();
				if(finder){
					if (val.length == 0) {
						unLoadWarning = false;
					}else{
						unLoadWarning = true;
						finder = false;
					};
				};
			};
		});
		if (unLoadWarning == true) {
	    	return false;
		}
	};

	function customizeWarningOnClickOfLink(){
		$('a').click(function(e){
			var href = $(this).attr('href');
			// var regexp for checking of href if its valid or not
	      	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

			if(regexp.test(href)){
				var finder = true;
				unLoadWarning = false;
				$(options.targetForm).find(inputs).each(function(){
					if($(this).hasClass(classUnloadvalidation) && $(this).attr('name') !== '_token'){
						var val = $(this).val();
						if(finder){
							if (val.length == 0) {
								unLoadWarning = false;
							}else{
								unLoadWarning = true;
								finder = false;
							};
						};
					};
				});

				if (unLoadWarning == true) {
					// ------------- Sweetalert when anchor links is click and if customizeWarningOnClickOfLink is enabled
					swal({
					  title: options.customizeTitle,
					  text: options.customizeText,
					  type: options.customizeType,
					  showCancelButton: true,
					  cancelButtonText: options.customizeTextStay,
					  confirmButtonText: options.customizeTextLeave,
					  confirmButtonColor: options.customizeBtnColorLeave,
					  confirmButtonColor: options.customizeBtnColorLeave,
					  customClass: options.sweetalertCustomClass,
					  closeOnConfirm: false,
					  closeOnCancel: true
					},
					function(isConfirm){
					  if (isConfirm) {
						unLoadWarning = false;
						window.location = href;
					  } else {

					  }
					});
					e.preventDefault();
				}
			}
		});
	}

	function warningDuringAjaxCall(){
		$(document).ajaxSend(function(event, jqXHR, ajaxOptions) {
			unLoadWarning = true;
		});

		$(document).ajaxComplete(function(event, jqXHR, ajaxOptions) {
	    	var isIgnore = (typeof ajaxOptions.header !== 'undefined' && typeof ajaxOptions.header.unLoadWarningIgnore !== 'undefined' ? ajaxOptions.header.unLoadWarningIgnore : true);
	    	if(jqXHR.status == 200 && !isIgnore){
				$(options.targetForm).find(inputs).removeClass(classUnloadvalidation);
				unLoadWarning = false;
	    	};
		});
	}

	function disablingButtonOnAjaxCall(){
		$(document).ajaxStart(function() {
			// ------------- disable all buttons of any forms even not selected to prevent unnecessary alert if disablingButtonOnAjaxCall function is enabled
			$('body').find(buttons).attr('disabled','disabled');
		});

		$(document).ajaxStop(function(e) {
			// ------------- disable all buttons of any forms even not selected to prevent unnecessary alert if disablingButtonOnAjaxCall function is enabled
			$('body').find(buttons).removeAttr('disabled');
		});
	}

	if(options.customizeWarning){
		customizeWarningOnClickOfLink();
	}
	if(options.warningForAjax){
		warningDuringAjaxCall();
	}
	if(options.disablingDuringAjax){
		disablingButtonOnAjaxCall();
	}
}