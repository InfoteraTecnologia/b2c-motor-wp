var $ = jQuery;
(function(){$.simplyToast=function(e,t,n){function u(){$.simplyToast.remove(o)}n=$.extend(true,{},$.simplyToast.defaultOptions,n);var r='<div class="simply-toast alert alert-'+(t?t:n.type)+" "+(n.customClass?n.customClass:"")+'">';if(n.allowDismiss)r+='<span class="close" data-dismiss="alert">&times;</span>';r+=e;r+="</div>";var i=n.offset.amount;$(".simply-toast").each(function(){return i=Math.max(i,parseInt($(this).css(n.offset.from))+this.offsetHeight+n.spacing)});var s={position:n.appendTo==="body"?"fixed":"absolute",margin:0,"z-index":"9999",display:"none","min-width":n.minWidth,"max-width":n.maxWidth};s[n.offset.from]=i+"px";var o=$(r).css(s).appendTo(n.appendTo);switch(n.align){case"center":o.css({left:"50%","margin-left":"-"+o.outerWidth()/2+"px"});break;case"left":o.css("left","20px");break;default:o.css("right","20px")}if(o.fadeIn)o.fadeIn();else o.css({display:"block",opacity:1});if(n.delay>0){setTimeout(u,n.delay)}o.find('[data-dismiss="alert"]').removeAttr("data-dismiss").click(u);return o};$.simplyToast.remove=function(e){if(e.fadeOut){return e.fadeOut(function(){return e.remove()})}else{return e.remove()}};$.simplyToast.defaultOptions={appendTo:"body",customClass:false,type:"info",offset:{from:"top",amount:100},align:"right",minWidth:250,maxWidth:450,delay:4e3,allowDismiss:true,spacing:10}})()
function saveConfig(){
    var data = {
        'action': 'infotravel_saveConfig',
        'dominio': jQuery("#dominio").val(),
        'chave': jQuery("#chave").val(),
        'empresa': jQuery("#empresa").val(),

    };
    jQuery.post('./admin-ajax.php', data, function (datas) {
        var toast = $.simplyToast('Salvando configurações!', 'info', {delay: 500});
        setTimeout(function(){
            var toast = $.simplyToast('Configurações Salvas', 'success', {delay: 2000});
        }, 1000);
    });
}

$(function() {
    // Menu Tabular
    var $menu_tabs = $('.infotravel-menu__tabs li a');
    $menu_tabs.on('click', function(e) {
        e.preventDefault();
        $menu_tabs.removeClass('active');
        $(this).addClass('active');

        $('.infotravel-menu__item').fadeOut();
        $(this.hash).fadeIn();
    });

    $("#dominio").on('keyup', function(event){
        var strUrl = $(this).val();
        var objER = /^(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/g;

        if(objER.test(strUrl)){
            $(this).parent().find("#info-dominio-span").css('display', 'none');
        }else{
            $(this).parent().find("#info-dominio-span").css('display', 'block');
        }

        event.preventDefault();
    });

});