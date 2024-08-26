/* Когда пользователь нажимает на кнопку,
переключение между скрытием и отображением раскрывающегося содержимого */
function myFunction() {
    
    let btnMenu = document.querySelector('#myDropdown');
    //btnMenu.classList.toggle("show");
    if (btnMenu.classList.contains('show')) {
        btnMenu.classList.remove('show');
    } else {
        btnMenu.classList.toggle("show");
    }
}
// Закройте выпадающее меню, если пользователь щелкает за его пределами

window.onclick = function (event) {
    if (!event.target.matches('.barbtn')) {
        let btnMenu = document.querySelector('#myDropdown');
        if (btnMenu.classList.contains('show')) {
            btnMenu.classList.remove('show');
        }
    }
}

document.querySelector('#btnLink').addEventListener('click', myFunction);