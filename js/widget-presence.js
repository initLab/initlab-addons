jQuery(function($) {
	var containers = $('.initlab_widget_presence_container');

	function getGravatarResized(url, size) {
		url = new URL(url);
		url.searchParams.set('s', size.toString());
		return url.toString();
	}

	function formatUser(user, avatarSize) {
		return $('<div />').addClass('row').append(
			$('<img />').attr({
				width: avatarSize,
				height: avatarSize,
				src: getGravatarResized(user.picture, avatarSize)
			})
		).append(
			$('<div />').addClass('username').text(user.username)
		);
	}

	function updateContainer(container, users, avatarSize) {
		if (users.length === 0) {
			var lang = ($('html').prop('lang') || 'en').substring(0, 2);
			var goneText;

			switch (lang) {
				case 'bg':
					goneText = 'Всички ги е хванала липсата :(';
					break;
				default:
					goneText = 'Everyone is gone :(';
			}

			container.text(goneText);
			return;
		}

		container.empty();
		$.each(users, function(idx, user) {
			container.append(formatUser(user, avatarSize));
		});
	}

	function getUsers() {
		return $.get('https://fauna.initlab.org/api/users/present.json');
	}

	if (containers.length === 0) {
		return;
	}

	getUsers().then(function(users) {
		containers.each(function() {
			var container = $(this);
			var avatarSize = container.data('avatarSize');
			var refreshTime = container.data('refreshTime');

			updateContainer(container, users, avatarSize);

			if (refreshTime) {
				setInterval((function(avatarSize) {
					return function() {
						getUsers().then(function(users) {
							updateContainer(container, users, avatarSize);
						});
					}
				})(avatarSize), refreshTime * 1000);
			}
		});
	});
});
