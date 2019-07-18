button = document.querySelector('#form-update'); // button formulaire
confirmPassword = document.querySelector('#confirmPassword'); // input paswword

buttonUsername = document.querySelector('#modif-username'); // notif user
buttonEmail = document.querySelector('#modif-email'); // notif email
buttonPassword = document.querySelector('#modif-password');
usernameUp = document.querySelector('#usernameUp'); 
emailUp = document.querySelector('#emailUp');

confirmPasswordUp = document.querySelector('passwordUp2');

changePassword = document.querySelector('#change');
newPassword = document.querySelector('.container-new-mdp');

changePassword.addEventListener('click', function() {
    newPassword.style.display = "block";
})

buttonUsername.addEventListener('click', function(){
    usernameUp.disabled = false;
    buttonUsername.style.display = "none";
});

buttonEmail.addEventListener('click', function(){
    emailUp.disabled = false;
    buttonEmail.style.display = "none";
});



confirmPassword.addEventListener('keyup', function(){
 
if(confirmPassword.value == "") {
    button.disabled = true;
}
else 
{
    button.disabled = false;
}
});

button.addEventListener('click', function() {
    usernameUp.disabled = false;
    emailUp.disabled = false;
});
