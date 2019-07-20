btnModifUsername = document.querySelector('#modif-username');
inputUsername = document.querySelector('#input-username');
btnModifEmail = document.querySelector('#modif-email');
inputEmail = document.querySelector('#input-email');
btnUpdate = document.querySelector('#btn-update');
inputPasswordVerif = document.querySelector('#password-verif');
btnChangeMdp = document.querySelector('#change-mdp');
containerInputMdp = document.querySelector('#container-new-mdp');
btnChangePp = document.querySelector('#btn-change-pp');
popUpChangePp = document.querySelector('#pop-change-pp');
btnPopClose = document.querySelector('#btn-pop-close');
main = document.querySelector('main');
sidebar = document.querySelector('.nav-dashboard');


btnModifUsername.addEventListener('click', function () {
    inputUsername.disabled = false;
    btnModifUsername.style.display = "none";
});

btnModifEmail.addEventListener('click', function () {
    inputEmail.disabled = false;
    btnModifEmail.style.display = "none";
});


inputPasswordVerif.addEventListener('keyup', function () {

    if (inputPasswordVerif.value == "") {
        btnUpdate.disabled = true;
    } else {
        btnUpdate.disabled = false;
    }
});

btnUpdate.addEventListener('click', function () {

    inputUsername.disabled = false;
    inputEmail.disabled = false;
});

btnChangeMdp.addEventListener('click', function () {

    containerInputMdp.style.display = "block";
});

btnPopClose.addEventListener('click', function () {
    
        main.classList.remove("blur");
        sidebar.classList.remove("blur");
        popUpChangePp.classList.remove("pop-up-open");

    });

btnChangePp.addEventListener('click', function () {
    console.log('gg');
    popUpChangePp.classList.add("pop-up-open");
    // main.classList.add("blur");
    // sidebar.classList.add("blur");


});
function changeImage(a) {
    document.getElementById("pp-view").src=a;
}

document.addEventListener('DOMContentLoaded', function () {
	allPp = popUpChangePp.querySelectorAll('.select-pp-picture');
    console.log(allPp);
	for (x = 0; x < allPp.length; x++) {
		allPp[x].addEventListener('click', function () {
			changeImage('assets/img/profil_img/' + this.value);
		})

    }
});