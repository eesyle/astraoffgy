"use strict"

function addSwitcher() {
    var dlabSwitcher = '<div class="sidebar-right"><div class="bg-overlay"></div><a class="sidebar-right-trigger wave-effect wave-effect-x"href="javascript:void(0);"data-bs-toggle="tooltip"data-original-title="Change Layout"data-placement="right"><span><i class="fa fa-cog fa-spin"></i></span> </a><a class="sidebar-close-trigger"href="javascript:void(0);"><span><i class="la-times las"></i></span></a><div class="sidebar-right-inner"><h4>Pick your style<a class="btn btn-primary btn-sm pull-right"href="javascript:void(0);"onclick="deleteAllCookie()">Clear Preference</a></h4><div class="card-tabs"><ul class="nav nav-tabs"role="tablist"><li class="nav-item"><a class="active nav-link"href="#tab2"data-bs-toggle="tab">Header</a><li class="nav-item"><a class="nav-link"href="#tab3"data-bs-toggle="tab">Content</a></ul></div><div class="tab-content tab-content-default tabcontent-border"><div class="active fade show tab-pane"id="tab2"><div class="admin-settings"><div class="row"><div class="col-sm-6"><p>Layout</p><select class="default-select form-control wide"id="theme_layout"name="theme_layout"><option value="Choose Layout">Choose Layout<option value="vertical">Vertical<option value="horizontal">Horizontal</select></div><div class="col-sm-6"><p>Header position</p><select class="default-select form-control wide"id="header_position"name="header_position"><option value="Choose Header Positon">Choose Header Positon<option value="static">Static<option value="fixed">Fixed</select></div><div class="col-sm-6"><p>Sidebar</p><select class="default-select form-control wide"id="sidebar_style"name="sidebar_style"><option value="Choose Sidebar">Choose Sidebar<option value="full">Full<option value="mini">Mini<option value="compact">Compact<option value="modern">Modern<option value="overlay">Overlay<option value="icon-hover">Icon-hover</select></div><div class="col-sm-6"><p>Sidebar position</p><select class="default-select form-control wide"id="sidebar_position"name="sidebar_position"><option value="Choose Sidebar Position">Choose Sidebar Position<option value="static">Static<option value="fixed">Fixed</select></div></div></div></div><div class="fade tab-pane"id="tab3"><div class="admin-settings"><div class="row"><div class="col-sm-6"><p>Container</p><select class="default-select form-control wide"id="container_layout"name="container_layout"><option value="Choose Container">Choose Container<option value="wide">Wide<option value="boxed">Boxed<option value="wide-boxed">Wide Boxed</select></div><div class="col-sm-6"><p>Body Font</p><select class="default-select form-control wide"id="typography"name="typography"><option value="Choose Font">Choose Font<option value="roboto">Roboto<option value="poppins">Poppins<option value="opensans">Open Sans<option value="HelveticaNeue">HelveticaNeue</select></div></div></div></div></div></div></div>';
    var demoPanel = '<div class="dz-demo-panel"><div class="bg-close"></div><a class="dz-demo-trigger" data-toggle="tooltip" data-placement="right" data-original-title="Check out more demos" href="javascript:void(0)"><span><i class="las la-tint"></i></span></a><div class="dz-demo-inner"><a href="javascript:void(0);" class="btn btn-primary btn-sm px-2 py-1 mb-3" onclick="deleteAllCookie()">Delete All Cookie</a><div class="dz-demo-header"><h4>Select A Demo</h4><a class="dz-demo-close" href="javascript:void(0)"><span><i class="las la-times"></i></span></a></div><div class="dz-demo-content"><div class="dz-wrapper"><div class="overlay-bx dz-demo-bx demo-active"><div class="overlay-wrapper"><img src="images/demo/pic1.jpg" alt="" class="w-100"></div><div class="overlay-layer"><a href="javascript:void(0);" data-theme="1" class="btn dlab_theme_demo btn-secondary btn-sm mr-2">Demo 1</a></div></div><h5 class="text-white mb-3">Demo 1</h5><hr><div class="overlay-bx dz-demo-bx"><div class="overlay-wrapper"><img src="images/demo/pic2.jpg" alt="" class="w-100"></div><div class="overlay-layer"><a href="javascript:void(0);" data-theme="2" class="btn dlab_theme_demo btn-secondary btn-sm mr-2">Demo 2</a></div></div><h5 class="text-white mb-3">Demo 2</h5></div></div><div class="fs-12 pt-3"><span class="text-danger">*Note :</span>This theme switcher is not part of product. It is only for demo. you will get all guideline in documentation. please check<a href="https://dolab.dexignlab.com/doc/" class="text-primary">documentation.</a></div></div></div>';

    if ($("#dlabSwitcher").length == 0) {
        // jQuery('body').append(dlabSwitcher+demoPanel);
        jQuery('body').append(dlabSwitcher);
        $('.sidebar-right-trigger').on('click', function() {
            $('.sidebar-right').toggleClass('show');
        });
        $('.sidebar-right-trigger-alt').on('click', function() {
            $('.sidebar-right').toggleClass('show');
        });
        $('.sidebar-close-trigger,.bg-overlay').on('click', function() {
            $('.sidebar-right').removeClass('show');
        });
    }
}

(function($) {
    "use strict"
    addSwitcher();


    const body = $('body');
    const html = $('html');

    //get the DOM elements from right sidebar
    const typographySelect = $('#typography');
    //const versionSelect = $('#theme_version');
    const themeSelect = $('#theme_data');
    const layoutSelect = $('#theme_layout');
    const sidebarStyleSelect = $('#sidebar_style');
    const sidebarPositionSelect = $('#sidebar_position');
    const headerPositionSelect = $('#header_position');
    const containerLayoutSelect = $('#container_layout');
    const themeDirectionSelect = $('#theme_direction');

    //change the theme typography controller
    typographySelect.on('change', function() {
        body.attr('data-typography', this.value);

        setCookie('typography', this.value);
    });


    //change the sidebar position controller
    sidebarPositionSelect.on('change', function() {
        this.value === "fixed" && body.attr('data-sidebar-style') === "modern" && body.attr('data-layout') === "vertical" ?
            alert("Sorry, Modern sidebar layout dosen't support fixed position!") :
            body.attr('data-sidebar-position', this.value);
        setCookie('sidebarPosition', this.value);
    });

    //change the header position controller
    headerPositionSelect.on('change', function() {
        body.attr('data-header-position', this.value);
        setCookie('headerPosition', this.value);
    });

    //change the theme direction (rtl, ltr) controller
    themeDirectionSelect.on('change', function() {
        html.attr('dir', this.value);
        html.attr('class', '');
        html.addClass(this.value);
        body.attr('direction', this.value);
        setCookie('direction', this.value);
    });

    //change the theme layout controller
    layoutSelect.on('change', function() {
        if (body.attr('data-sidebar-style') === 'overlay') {
            body.attr('data-sidebar-style', 'full');
            body.attr('data-layout', this.value);
            return;
        }

        body.attr('data-layout', this.value);
        setCookie('layout', this.value);
    });

    //change the container layout controller
    containerLayoutSelect.on('change', function() {
        if (this.value === "boxed") {

            if (body.attr('data-layout') === "vertical" && body.attr('data-sidebar-style') === "full") {
                body.attr('data-sidebar-style', 'overlay');
                body.attr('data-container', this.value);

                setTimeout(function() {
                    $(window).trigger('resize');
                }, 200);

                return;
            }


        }

        body.attr('data-container', this.value);


        setTimeout(function() {
            window.dispatchEvent(new Event('resize'));
        }, 500)

        setCookie('containerLayout', this.value);
    });

    //change the sidebar style controller
    sidebarStyleSelect.on('change', function() {
        if (body.attr('data-layout') === "horizontal") {
            if (this.value === "overlay") {
                alert("Sorry! Overlay is not possible in Horizontal layout.");
                return;
            }
        }

        if (body.attr('data-layout') === "vertical") {
            if (body.attr('data-container') === "boxed" && this.value === "full") {
                alert("Sorry! Full menu is not available in Vertical Boxed layout.");
                return;
            }

            if (this.value === "modern" && body.attr('data-sidebar-position') === "fixed") {
                alert("Sorry! Modern sidebar layout is not available in the fixed position. Please change the sidebar position into Static.");
                return;
            }
        }

        body.attr('data-sidebar-style', this.value);

        if (body.attr('data-sidebar-style') === 'icon-hover') {
            $('.dlabnav').hover(function() {
                $('#main-wrapper').addClass('iconhover-toggle');
            }, function() {
                $('#main-wrapper').removeClass('iconhover-toggle');
            });
        }

        setCookie('sidebarStyle', this.value);
    });

    //change the nav-header background controller
    $('input[name="navigation_header"]').on('click', function() {
        body.attr('data-nav-headerbg', this.value);
        setCookie('navheaderBg', this.value);
    });

    //change the header background controller
    $('input[name="header_bg"]').on('click', function() {
        body.attr('data-headerbg', this.value);
        setCookie('headerBg', this.value);
    });

    //change the primary color controller
    $('input[name="primary_bg"]').on('click', function() {
        body.attr('data-primary', this.value);
        setCookie('primary', this.value);
    });

    //change the primary color controller
    $('input[name="sidebar_img_bg"]').on('click', function() {
        var sidebarBgImg = this.value;
        $('.dlabnav').css('background-image', 'url(' + sidebarBgImg + ')');
        $('.nav-header').css('background-image', 'url(' + sidebarBgImg + ')');
        $('body').attr('data-navigationbarimg', sidebarBgImg);
        $('.nav-header').addClass('nav-header-brand');
        $('.dlabnav').addClass('dz-bg');

        setCookie('navigationBarImg', this.value);
    });

    //change the theme color controller
    $('input[name="themecolor_bg"]').on('click', function() {
        body.attr('data-theme', this.value);
        setCookie('themeBg', this.value);
    });


    //remove the sidebar image 
    $('.remove-img').on('click', function() {

        $('.dlabnav, .nav-header').removeAttr('style');
        $('body').attr('data-navigationbarimg', '');
        jQuery('.chk-col-primary').prop('checked', false);
        setCookie('navigationBarImg', '');
    });


})(jQuery);