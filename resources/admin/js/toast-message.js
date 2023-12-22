import Swal from 'sweetalert2';

$(document).ready(function(){
  // Show toast message after the action
  toast = toast();
  showToastMessageAfterAction(toast);
});

// function init toast message
function toast() 
{
  return Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });
}

function fire(toast, type, message) 
{
  let background;
  let icon;
  if (type == 'success') {
    background = 'rgba(40,167,69,.85)';
    icon = 'success';
  } else if (type == 'error') {
    background = 'rgba(220,53,69,.85)';
    icon = 'error';
  }
  toast.fire({
    icon: icon,
    title: message,
    background: background,
    color: '#fff',
  })
}

// Show toast message after the action
function showToastMessageAfterAction(toast)
{
  let type = $('#toast__js').attr('type') ?? "";
  let message = $('#toast__js').attr('message') ?? "";
  
  if (message != "") {
    //Show success toast message
    fire(toast, type, message)
  }
}
