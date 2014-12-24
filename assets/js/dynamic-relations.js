// http://stackoverflow.com/questions/9659265/check-if-javascript-script-exists-on-page
function scriptLoaded(url) {
    var scripts = document.getElementsByTagName('script');
    for (var i = scripts.length; i--;) {
        if (scripts[i].src == url) return true;
    }
    return false;
}

jQuery(document).ready(function () {

	var removeFn = function(sel){
		jQuery('.remove-dynamic-relation').on('click', function(event){
			event.preventDefault();
			var me = this;
			var myLi = jQuery(me).closest('li');
			removeRoute = jQuery(this).parent().find("[data-dynamic-relation-remove-route]").attr("data-dynamic-relation-remove-route");
			if(removeRoute)
			{
				jQuery.post(removeRoute, function(result){
					myLi.remove()
				});
			}
			else
			{
				myLi.remove();
			}
		});
	};

	jQuery('.add-dynamic-relation').on('click', function(event){
		event.preventDefault();
		var me = this;
		view = jQuery(me).closest('[data-related-view]').attr('data-related-view') + "&t=" + ( new Date().getTime() );
		jQuery.get(view, function(result){
			$result = jQuery(result);
			li = jQuery(me).closest('li').clone().empty(); ul = jQuery(me).closest('ul');
			ul.append( li );
			li.append( $result.filter("#root") );
			$result.filter('script').each(function(k,scriptNode){
				if(!scriptNode.src || !scriptLoaded( scriptNode.src ) )
				{
					jQuery("body").append( scriptNode); 
				}
			});
			removeFn( li.find('.remove-dynamic-relation') );
		});
	});
	removeFn('.remove-dynamic-relation');
});
