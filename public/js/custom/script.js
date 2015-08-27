function extractor(query) {
	var result = /([^,]+)$/.exec(query);
	if ( result && result[1] ) {
		return result[1].trim();
	}
	return '';
}

$(document).ready(function(){
	var $input = $('.js-typeahead');
	$input.typeahead(
		{
			source : window.tags,
			updater : function (item) {
				return this.$element.val().replace(/[^,]*$/,'')+item+',';
			},
			matcher : function (item) {
				var tquery = extractor(this.query);
				if ( !tquery ) return false;
				return ~item.toLocaleLowerCase().indexOf(tquery.toLocaleLowerCase())
			},
			highlighter: function (item) {
				var query = extractor(this.query).replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
				return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
					return '<strong>' + match + '</strong>'
				})
			}
		}
	);
});