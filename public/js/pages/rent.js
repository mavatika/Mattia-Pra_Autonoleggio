var car_name = document.querySelector('#car_name');
var car_select = document.querySelector('#which');
var car_figure = document.querySelector('#car_image');

var selectListenerInitialized = false;

function ready() {
	useForm();
	setMinDate();
	initSelectListener();
}

function initSelectListener() {
	selectListenerInitialized = true;
	if (!car_select.disabled) {
		carChange(car_select, car_select.selectedIndex);
	}
	car_select.addEventListener('change', function (e) {
		carChange(car_select, car_select.selectedIndex);
	})
}

function useForm() {
	var form = document.querySelector('#rent_form');
	form.addEventListener('reset', function () {
		car_select.disabled = false;
		setTimeout(function() {
			carChange(car_select, car_select.selectedIndex)
		}, 0);
	});
}

function carChange(e, index) {
	console.log('E', e, 'index', index);
	var el = e.options[index];
	var name = el.text;
	var img = el.dataset.image;
	car_name.innerHTML = name;
	car_figure.style.backgroundImage = 'url("' + img + '")';
	car_figure.children[0].innerHTML = name;
}

function setMinDate() {
	var t = new Date();
	document.querySelector('#when').min = t.toISOString().slice(0, 10)
}
