var tables = document.querySelectorAll('.clickable_table');
var btns = document.querySelectorAll('.openform');

var overlay = document.querySelector('.overlay')
var overlayBtn = document.querySelector('.overlay .close');

function ready() {
  tables.forEach(function (table) {
    table.addEventListener('click', function(e) {
      console.log(e.target);
      var parent = e.target.parentNode;
      if (parent.dataset.rentid) location.assign('../cars/rented.php?rent=' + parent.dataset.rentid);
      else if (parent.className === 'message_row') {
        openOverlay('message_template', openMessage, parent);
      }
    });
  });
  btns.forEach(function(btn) {
    btn.addEventListener('click', function (e) {
      openOverlay('form_template', openForm, e)
    })
  })
}

function openOverlay(template, custom, e) {
  overlay.children[0].appendChild(document.importNode(document.querySelector('#' + template).content, true));

  if (typeof custom === 'function') custom(e);

  overlay.style.display = 'block';
  document.body.style.overflow = 'hidden';
  setTimeout(function() {
    overlay.classList.add('visible');
    overlayBtn.addEventListener('click', closeOverlay);
  }, 200);
}

function closeOverlay() {
  overlay.classList.remove('visible');
  overlay.children[0].removeChild(overlay.children[0].lastElementChild);
  setTimeout(function () {
    overlay.style.display = 'none';
    document.body.style.overflow = 'auto';
    overlayBtn.removeEventListener('click', closeOverlay);
  }, 200);
}

function openMessage(tr) {
  var container = document.querySelector('.message_container');
  container.querySelector('h3').textContent = 'Message from: ' + tr.dataset.subject;
  container.querySelector('p').textContent = tr.children[0].innerHTML.trim();
  container.querySelector('a').href = '.?markcomplete=' + tr.dataset.id;

}

function openForm(e) {
  var s = e.target.dataset.form;
  var form = document.querySelector('.create_record');
  form.children[0].className = '';
  form.querySelector('button[type=submit]').value = s;
  
  var template = document.importNode(document.querySelector('#' + s).content, true);
  form.children[0].appendChild(template);
  form.children[0].classList.add(s);
}