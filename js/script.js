function showError(message) {

    const errorAlert = document.getElementById('error-alert');
    
    errorAlert.innerHTML = `<p>${message}</p>`;
    
    errorAlert.classList.remove('hidden');
    errorAlert.classList.add('visible');

    setTimeout(() => {
        
        errorAlert.classList.remove('visible');
        errorAlert.classList.add('hidden');
    }, 5000);
}



window.addEventListener('beforeunload', () => {
    localStorage.setItem('scrollPosition', window.scrollY);
});

function scroll() {

    document.addEventListener('DOMContentLoaded', () => {
        const scrollPosition = localStorage.getItem('scrollPosition');
        if (scrollPosition) {
            window.scrollTo(0, parseInt(scrollPosition, 10));
        }
    });
}


function changeName(){
    const searchButton = document.querySelector('.section-search_button');

    searchButton.value = "Скасувати";
}

