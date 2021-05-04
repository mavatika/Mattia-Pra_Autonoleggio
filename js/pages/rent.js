var car_name = document.querySelector('#car_name');
var car_select = document.querySelector('#which');
var car_figure = document.querySelector('#car_image');

var selectListenerInitialized = false;

function ready() {
	useForm();
	setMinDate();
	var query = parseQueryString();
	if (!query.m) initSelectListener();
}

function initSelectListener() {
	selectListenerInitialized = true;
	car_select.addEventListener('change', function (e) {
		var el = e.target.options[e.target.selectedIndex];
		carChange(el.text, el.dataset.image);
	})
}

function useForm() {
	var form = document.querySelector('#rent_form');
	form.addEventListener('reset', function () {
		car_select.disabled = false;
		var el = car_select.options[0];
		carChange(el.text, el.dataset.image);
		if (!selectListenerInitialized) initSelectListener();
	});
}

function carChange(name, img) {
	car_name.innerHTML = name;
	car_figure.style.backgroundImage = 'url("' + img + '")';
	car_figure.children[0].innerHTML = name;
}

function setMinDate() {
	var t = new Date();
	document.querySelector('#when').min = t.toISOString().slice(0, 10)
}
