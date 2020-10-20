document.addEventListener('DOMContentLoaded', function() {
    
    M.AutoInit();

    var elems = document.querySelectorAll('.slider');
    var instances = M.Slider.init(elems, {"height":725});
    // var sideNav = document.querySelectorAll('.sidenav');
    // var instances = M.Sidenav.init(sideNav);


});