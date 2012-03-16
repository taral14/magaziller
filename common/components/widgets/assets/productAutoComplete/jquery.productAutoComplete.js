jQuery(function($){
	$.widget( "custom.productAutoComplete", $.ui.autocomplete, {
		_renderMenu: function( ul, items ) {
			var self = this,
				currentCategory = "";
			$.each( items, function( index, item ) {
				if ( item.category != currentCategory ) {
					ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
					currentCategory = item.category;
				}
				self._renderItem( ul, item );
			});
		},
        _renderItem: function( ul, item ) {
            var label=(item.icon)?"<img src='" + item.icon + "' />" + item.label:item.label;
            return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a>" + label + "</a>" )
				.appendTo( ul );
		}
	});
}(jQuery))