'use script';

window.onload = function() {
  let popup = document.getElementById('aokoke_popup');
  if(!popup) return;
  popup.classList.add('is_show');

  let blackBg = document.getElementById('black_background');
  let closeBtn = document.getElementById('close_btn');

  closePopUp(blackBg);
  closePopUp(closeBtn);
  
  function closePopUp(elem) {
    if(!elem) return;
    elem.addEventListener('click', function() {
      popup.classList.remove('is_show');
      popup.classList.add('is_hidden');
    })
  }
}
