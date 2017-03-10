var admin = admin || {};

admin.utils = {

	genRandomPassword: function(length) {
		if (!length) {
			length = 8;
		}

		return Math.random().toString(36).slice('-' + length);
	},

	notification: {
		flash: function(type, message, timeOut) {
			var options = {
				timeOut: (timeOut ? timeOut : 2300),
				showDuration: 300,
				hideDuration: 300,
				showMethod: 'slideDown',
				hideMethod: 'slideUp'
			};

			switch (type) {
				case 'info':
					toastr.info(message, null, options);
					break;

				case 'success':
					toastr.success(message, null, options);
					break;

				case 'error':
					toastr.error(message, null, options);
					break;

				case 'warning':
					toastr.warning(message, null, options);
					break;

				default:
					toastr.info(message, null, options);
			}
		}
	}
};
