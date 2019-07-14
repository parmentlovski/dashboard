var blockReponse = document.querySelector('#block-reponse');
var oui = document.querySelector('#oui');

oui.addEventListener('change', function(){
    if(oui.checked) {
        blockReponse.style.display = 'block'; 
    }
    else {
        blockReponse.style.display = 'none';
    }
        // blockReponse.display = 'none';
});