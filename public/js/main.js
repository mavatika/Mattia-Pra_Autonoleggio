function init() {
	try {
		ready();
	} catch (e) {
		console.warn('Ready function not called', e);
	}
	cookies();
	hamburger();
	handleSpaceOrEnter();
}

function cookies() {
	var hasCookieBannerAppeared = document.cookie.includes('cookie_banner');
	console.log('Cookies appeared', hasCookieBannerAppeared);
	if (!hasCookieBannerAppeared) {
		var bannerBtn = document.querySelector('.cookies .close');
		bannerBtn.parentElement.style.display = 'block';

		bannerBtn.addEventListener('click', function () {
			bannerBtn.parentElement.classList.add('hiding');
			setTimeout(function () {
				document.cookie = "cookie_banner=seen"
				bannerBtn.parentElement.style.display = 'none';
				bannerBtn.parentElement.classList.remove('hiding');
			}, 200);
		})
	}
}

function hamburger() {
	var hamburger = document.querySelector('.hamburger');
	hamburger.addEventListener('click', function () {
		hamburger.classList.toggle('hamburger_active');
	});
}

function handleSpaceOrEnter() {
	document.querySelectorAll('[role=button]').forEach(function (el) {
		el.addEventListener('keypress', handle);
	})

	function handle(e) {
		var keycode = e.keyCode ? e.keyCode : e.which;
		if (keycode === 13 || keycode === 32) document.activeElement.click();
	}
}

function parseQueryString() {
	var qString = location.search.substring(1).split('&');
	var q = {};
	qString.forEach(function (s) {
		var d = s.split('=');
		console.log(d)
		if (d[1]) q[d[0]] = decodeURIComponent(d[1].replace(/\+/g, '%20'));
	})
	return q;
}

function makeRequestWithLoading(target) {
	target.classList.add('isLoading');
	setTimeout(function() {
		target.classList.remove('isLoading');
	}, 5000);
}

document.addEventListener('DOMContentLoaded', init);
