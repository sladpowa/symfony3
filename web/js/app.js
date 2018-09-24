function JS() {
    cookieBar();
    activeLeftMenu();
}

function cookieBar() {
    $('.cookie-message').cookieBar({ closeButton : '.my-close-button' });
}

function activeLeftMenu() {

    $('.nav-list a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active')
    $('.nav-list a').click(function(){
        $(this).parent().addClass('active').siblings().removeClass('active')
    });

}