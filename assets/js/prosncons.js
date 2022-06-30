$ = $ || jQuery;

var Product = {
	postForm: $(),
	itemTemplate: '<tr><td><span>%s</span><input type="hidden" name="%s" value="%s" /></td><td><button data-target="%s" class="button button-secondary remove" onclick="event.preventDefault(); Product.removeItem($(this));"><i class="fa fa-minus-circle"></i></button></td></tr>',
	prosPlaceholder: '<tr class="itemPlaceholder"><td>There are no pros registered.</td></tr>',
	consPlaceholder: '<tr class="itemPlaceholder"><td>There are no cons registered.</td></tr>',
	pros: $(),
	cons: $(),
	init: function(){
		var self = this;
		self.postForm = $('#post').attr('enctype', 'multipart/form-data');
	},
	addItem: function(target, valueInput){
		var self = this;
		var value = valueInput.val();
		var targetTBody = $('#' + target).children('tbody');

		function mostradora (chain){
			var visible  = chain.indexOf("@");
			var output;
			if (visible >= 1){
				var slice = chain.split("@");
				output = slice[0]+": "+slice[1];
			}
			else{
				output = chain;
			}
			return output;
		}

		if($.trim(value).length > 0){
			var newItem = $(self.itemTemplate)
			.find('span')
			.text(mostradora(value))
			.end()
			.find('input')
			.prop('name', target + 'Arr[]')
			.val(value)
			.end()
			targetTBody.append(newItem);
			valueInput.val('');
			targetTBody.find('.itemPlaceholder').remove();
		}
	},
	removeItem: function(button){
		var self = this;
		var target = button.data('target');
		var row = button.closest('tr');
		var tbody = row.closest('tbody');
		row.remove();
		if(tbody.children('tr').length == 0){
			tbody.append(self[target + 'Placeholder']);
		}
	}
};

$(document).ready(Product.init.bind(Product));