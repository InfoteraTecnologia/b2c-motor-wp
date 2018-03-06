var motorDeBuscaHotel = (function() {
    var urlB2C = '';
    var Crianca = {};
    var show = false;
    var stProprio = false;
    var qtIdadeMaxChd = 0;
    var qtAdt = 0;
    var qtChd = 0;

    Crianca.add = function(i, campo){
        while (i--) {
            setTimeout(function() {
                Crianca.container = jQuery(campo);
                var qnt = Crianca.container.find('.info-idades').length;
                var html = '<div class="info-quartos info-idades">'
                    + '<label>Idade '+(qnt + 1)+'ª criança:</label>'
                    + '<div class="info-btns">'
                    +'<select name="idadecrianca" id="idadecrianca" required>'
                    + '    <option value="-1" disabled="disabled" selected="selected">Idade</option>';
                        for(var iq = 0; iq < qtIdadeMaxChd; iq++){
                            html += '<option value="'+(iq + 1)+'">'+(iq + 1)+'</option>';
                        }
                    html += + '</select>'
                    + '</div>'
                    + '</div>';
                Crianca.container.append(html);
            }, 100);
        }
    };
    Crianca.remove = function(i, campo){
        while (i--) {
            Crianca.container = jQuery(campo);
            Crianca.container.find('.info-idades:last').remove();
        }
    };
    
    var config = function(){

        var data = {
            'action': 'infotravel_hotel_autocomplete'
        };

        var urlPost = window.location.href + "wp-admin/admin-ajax.php";

        jQuery.post(urlPost, data, function(data){
            data = JSON.parse(data);
            
            var config = data.config;
            var origem = data.origem;
            
            if(data.config){
                stProprio = data.config.stProprio;
                qtIdadeMaxChd = config.qtIdadeMaxChd;
                qtAdt = config.qtAdt;
                qtChd = config.qtChd;
            }
            
        });
    };
    
    var isJson = function (str) {
        if(jQuery.isEmptyObject(str)) {
            return false;
        } else {
            return true;
        }
    }
    var somaPassageiros = function(){
        var adultos = 0;
        var criancas = 0;
        var quartos = jQuery(".infotravel-form-hospedagem .info-quartos-div #info-quartos-article").find("article").length;
        var pessoas = 0;
        jQuery(".infotravel-form-hospedagem .info-quartos-div #info-quartos-article").find("article").each(function(index, val){
            adultos += Number(jQuery(val).find("input[name='adultosHotel']").val());
            criancas += Number(jQuery(val).find("input[name='criancaHotel']").val());
        });
        pessoas = adultos + criancas;
        jQuery(".infotravel-form-hospedagem .info-input-quartos input[name='quartos']").val(quartos);
        jQuery(".infotravel-form-hospedagem .info-input-quartos input[name='pessoas']").val(pessoas);
    };

    return {
        init: function(){
            config();
            
            jQuery.widget("custom.catcomplete", jQuery.ui.autocomplete, {
                _create: function () {
                    this._super();
                    this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
                },
                _renderMenu: function (ul, items) {
                    var that = this,
                        currentCategory = "";
                    jQuery.each(items, function (index, item) {
                        var li;
                        if (item.category != currentCategory) {
                            ul.append("<li class='ui-autocomplete-category ui-menu-item'>" + item.category + "</li>");
                            currentCategory = item.category;
                        }
                        li = that._renderItemData(ul, item);
                        if (item.category) {
                            li.attr("aria-label", item.category + " : " + item.label);
                        }
                    });
                }
            });

            jQuery(".infotravel-form-hospedagem #autocomplete-destino").catcomplete({
                delay: 0,
                source: function( request, response ) {
                    jQuery(".infotravel-form-hospedagem .info-input-style input[type='text']#autocomplete-destino").addClass("ui-autocomplete-loading");
                    if(request.term.length >= 3){
                        var data = {
                            'action': 'infotravel_hotel_autocomplete',
                            'valor': request.term
                        };

                        var urlPost = window.location.href + "wp-admin/admin-ajax.php";

                        jQuery.post(urlPost, data, function (json) {
                            if(isJson(json)){
                                json = JSON.parse(json);

                                if(json.config){
                                    jQuery("#idunidade").val(json.config.idUnidade);
                                    stProprio = json.config.stProprio;
                                }

                                if (json.destino) {

                                    var hoteis = [];
                                    var municipios = [];

                                    for (var i = 0; i < json.destino.length; i++) {
                                        var obj = json.destino[i];
                                        switch (obj.tp) {
                                            case "H":
                                                hoteis.push(obj);
                                                break;
                                            case "M":
                                                municipios.push(obj);
                                                break;
                                            default:
                                                console.log("Nenhum tipo encontrado");
                                        }
                                    }
                                    var dados1 = "";
                                    var dados2 = "";
                                    for (var i = 0; i < hoteis.length; i++) {
                                        dados1 += '{' +
                                            '"label": "' + hoteis[i].nm + '",' +
                                            '"category": "Hotéis",' +
                                            '"value": "' + hoteis[i].nm + '",' +
                                            '"tp": "' + hoteis[i].tp + '",' +
                                            '"am": "' + hoteis[i].am + '",' +
                                            '"sg": "' + hoteis[i].sg + '",' +
                                            '"sq": "' + hoteis[i].sq + '",' +
                                            '"id": "' + hoteis[i].id + '",' +
                                            '"nm": "' + hoteis[i].nm + '"' +
                                            '},';
                                    }

                                    for (var i = 0; i < municipios.length; i++) {
                                        dados2 += '{' +
                                            '"label": "' + municipios[i].nm + '",' +
                                            '"category": "Municípios",' +
                                            '"value": "' + municipios[i].nm + '",' +
                                            '"tp": "' + municipios[i].tp + '",' +
                                            '"am": "' + municipios[i].am + '",' +
                                            '"sg": "' + municipios[i].sg + '",' +
                                            '"sq": "' + municipios[i].sq + '",' +
                                            '"id": "' + municipios[i].id + '",' +
                                            '"nm": "' + municipios[i].nm + '"' +
                                            '},';
                                    }

                                    if (dados1 != "" && dados2 != "") {
                                        dados2 = "," + dados2.substring(0, (dados2.length - 1));
                                    } else if (dados1 == "" && dados2 != "") {
                                        dados2 = dados2.substring(0, (dados2.length - 1));
                                    }

                                    var data = "[" + dados1.substring(0, (dados1.length - 1)) + dados2 + "]";

                                    response(JSON.parse(data));
                                } else {
                                    var data = [
                                        {
                                            label: "Nenhum resultado encontrado.",
                                            category: ""
                                        }
                                    ];
                                    response(data);
                                }
                            }
                        });
                    }else{
                        var data = [
                            {
                                label: "Digite no mínimo 3 letras",
                                category: ""
                            }
                        ];
                        response( data );
                    }
                    // jQuery(".infotravel-form-hospedagem .info-input-style input[type=\"text\"]").removeClass("ui-autocomplete-loading");
                },
                select: function (event, ui) {
                    jQuery(".infotravel-form-hospedagem input#info-data-entrada").focus();
                    jQuery(".infotravel-form-hospedagem #id").val(ui.item.id);
                    jQuery(".infotravel-form-hospedagem #tp").val(ui.item.tp);
                    jQuery(".infotravel-form-hospedagem #am").val(ui.item.am);
                    jQuery('.infotravel-form-hospedagem input#autocomplete-destino').val(ui.item.nome);
                }
            });

            //Not the best solution but will solve the problem
            jQuery(document).on('click', '.ui-autocomplete-category', function () {
                jQuery(".infotravel-form-hospedagem #search").val(jQuery(this).html());
                jQuery(".infotravel-form-hospedagem #search").catcomplete("close");
            });

            jQuery(".infotravel-form-hospedagem #autocomplete-destino").on('click', function(){
                if(jQuery(this).val().length > 0){
                    this.select();
                    return true;
                }
            });

            var dataSaida = new Date();
            dataSaida.setDate(dataSaida.getDate() + 1)
            jQuery('.infotravel-form-hospedagem #info-data-entrada').datepicker({
                dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
                dayNamesMin: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
                dayNamesShort: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
                monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro","Dezembro" ],
                monthNamesShort: [ "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Decz" ],
                dateFormat: "dd/mm/yy",
                minDate:  new Date().toLocaleDateString(),
                onClose: function(selectedDate) {
                    jQuery(".infotravel-form-hospedagem #info-data-saida").datepicker("option", "minDate", selectedDate);
                    jQuery(this).parents('.column').next().children().find('#info-data-saida').focus();
                }
            });
            jQuery('.infotravel-form-hospedagem #info-data-saida').datepicker({
                dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
                dayNamesMin: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
                dayNamesShort: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
                monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro","Dezembro" ],
                monthNamesShort: [ "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Decz" ],
                dateFormat: "dd/mm/yy",
                minDate:  dataSaida
            });

            var quantidadeQuartos = 1;
            var maxQuartos = 4;
            jQuery(".infotravel-form-hospedagem #btn-add-quarto").click(function(){

                var wrapper = jQuery(".infotravel-form-hospedagem #info-quartos-article");

                if (quantidadeQuartos < maxQuartos) {
                    quantidadeQuartos++;

                    jQuery(wrapper).append("<article>\n" +
                        "                                <div class=\"info-quarto-header\">\n" +
                        "                                    Quarto " + (quantidadeQuartos) + "\n" +
                        "                                    <span><a href=\"javascript:void(0)\" style=\"display:none;\" id=\"btn-eliminar\">Eliminar</a></span>\n" +
                        "                                </div>\n" +
                        "                                <div class=\"info-quartos\">\n" +
                        "                                    <label>Adultos:</label>\n" +
                        "                                    <div class=\"info-btns info-adultosHotel\">\n" +
                        "                                        <div class=\"info-btn-menos\" onclick=\"motorDeBuscaHotel.subAdulto(this);\"><i class=\"fa fa-minus\"></i></div>\n" +
                        "                                        <input type=\"text\" name=\"adultosHotel\" style=\"border-bottom: none;border-top: none;\" value=\"1\" disabled>\n" +
                        "                                        <div class=\"info-btn-mais\" onclick=\"motorDeBuscaHotel.addAdulto(this);\"><i class=\"fa fa-plus\"></i></div>\n" +
                        "                                    </div>\n" +
                        "                                </div>\n" +
                        "                                <div class=\"info-quartos\" style=\"height: 49px;\">\n" +
                        "                                    <label>Crianças:</label>\n" +
                        "                                    <span>(entre 2 e 11 anos)</span>\n" +
                        "                                    <div class=\"info-btns info-criancaHotel\">\n" +
                        "                                        <div class=\"info-btn-menos\"onclick=\"motorDeBuscaHotel.subCrianca(this);\"><i class=\"fa fa-minus\"></i></div>\n" +
                        "                                        <input type=\"text\" name=\"criancaHotel\" style=\"border-bottom: none;border-top: none;\" value=\"0\" disabled>\n" +
                        "                                        <div class=\"info-btn-mais\" onclick=\"motorDeBuscaHotel.addCrianca(this);\"><i class=\"fa fa-plus\"></i></div>\n" +
                        "                                    </div>\n" +
                        "                                    <span class=\"info-erro info-hidden\" id=\"msgerroidade\" style=\"color: red;margin-top: 39px;\"></span>\n" +
                        "                                </div>\n" +
                        "                                <div class=\"info-criancas-idades\">\n" +
                        "                                </div>\n" +
                        "                            </article>");
                }

                jQuery(".infotravel-form-hospedagem #info-quartos-article article").each(function () {
                    jQuery(this).find("#btn-eliminar").css("display", "none");
                });

                if (quantidadeQuartos == maxQuartos) {
                    jQuery(".infotravel-form-hospedagem #btn-add-quarto").css("display", "none");
                }

                somaPassageiros();
                jQuery(".infotravel-form-hospedagem #info-quartos-article article:last-child").find("#btn-eliminar").css("display", "block");
            });

            jQuery(".infotravel-form-hospedagem .info-quartos-div").on("click", "#btn-eliminar", function(e) {
                e.stopPropagation();
                jQuery(".infotravel-form-hospedagem #info-quartos-article article:last-child").remove();
                jQuery(".infotravel-form-hospedagem #info-quartos-article article:last-child").find("#btn-eliminar").css("display", "block");
                quantidadeQuartos--;
                if (quantidadeQuartos < maxQuartos) {
                    jQuery(".infotravel-form-hospedagem #btn-add-quarto").css("display", "inline-block");
                }
                somaPassageiros();
            });

            jQuery(".infotravel-form-hospedagem .info-input-quartos input").on('click', function(){
                setTimeout(function() {
                    jQuery(".infotravel-form-hospedagem .info-quartos-div").toggle(255);
                }, 200);
            });

            var divNome = document.querySelector(".infotravel-form-hospedagem .info-quartos-div");
            jQuery(document).on("click", function(e) {
                var fora = !divNome.contains(e.target);
                if (fora) jQuery(divNome).slideUp("fast/100/slow");
            });

            jQuery(divNome).on("click", function(e) {
                jQuery(this).slideDown("fast/100/slow");
            });

            jQuery(".infotravel-form-hospedagem .info-quartos-div #btn-aplicar").on('click', function(){
                setTimeout(function() {
                    jQuery(".infotravel-form-hospedagem .info-quartos-div").toggle(255);
                }, 200);
            });

            jQuery(".infotravel-form-hospedagem .info-overlay").css({
                'height': Number(jQuery(".infotravel-form-hospedagem").height()) + 5,
                'width': Number(jQuery(".infotravel-form-hospedagem").width()) + 5
            });

            jQuery(".infotravel-form-hospedagem .info-overlay .info-overlay-container").css({
                'margin-top': (jQuery(".infotravel-form-hospedagem").height() / 2 - 60)
            });

            jQuery(window).resize(function(){
                jQuery(".infotravel-form-hospedagem .info-overlay").css({
                    'height': Number(jQuery(".infotravel-form-hospedagem").height()) + 5,
                    'width': Number(jQuery(".infotravel-form-hospedagem").width()) + 5
                });

                jQuery(".infotravel-form-hospedagem .info-overlay .info-overlay-container").css({
                    'margin-top': (jQuery(".infotravel-form-hospedagem").height() / 2 - 60)
                });
            });

            var data = {
                'action': 'infotravel_b2c_hospedagem'
            };

            var urlPost = window.location.href + "wp-admin/admin-ajax.php";

            jQuery.post(urlPost, data, function (resposta) {
                urlB2C = resposta;
            });

        },
        addAdulto: function(campo) {
            var campo = jQuery(campo);
            var input = jQuery(campo).parent().find('input');
            var valor = input.val();
            if(valor == qtAdt || (Number(valor) + 1) == qtAdt){
                campo.addClass('disabled');
                input.val(qtAdt);
                somaPassageiros();
            }else{
                campo.removeClass('disabled');
                campo.parent().parent().find('.info-adultoHotel .info-btn-menos').removeClass('disabled');
                input.val((Number(valor) + 1));
                somaPassageiros();
            }
        },
        subAdulto: function(campo) {
            var campo = jQuery(campo);
            var input = jQuery(campo).parent().find('input');
            var valor = input.val();

            if(valor == 1 || (Number(valor) - 1) == 1){
                campo.addClass('disabled');
                input.val(1);
                somaPassageiros();
            }else{
                campo.removeClass('disabled');
                campo.parent().parent().find('.info-adultoHotel .info-btn-mais').removeClass('disabled');
                input.val(valor - 1);
                somaPassageiros();
            }
        },
        addCrianca: function(campo) {
            var campo = jQuery(campo);
            var input = jQuery(campo).parent().find('input');
            var valor = input.val();

            var campo_crianca = jQuery(campo).parent().parent().parent().find('.info-criancas-idades');
            var qnt = campo_crianca.find('.info-idades').length;
            if(valor == qtChd || (Number(valor) + 1) == qtChd){
                campo.addClass('disabled');
                input.val(qtChd);
                Crianca.add((qtChd - qnt), campo_crianca);
                somaPassageiros();
            }else{
                campo.removeClass('disabled');
                campo.parent().parent().find('.info-criancaHotel .info-btn-menos').removeClass('disabled');
                input.val((Number(valor) + 1));
                Crianca.add((Number(input.val()) - qnt), campo_crianca);
                somaPassageiros();
            }
        },
        subCrianca: function(campo) {
            var campo = jQuery(campo);
            var input = jQuery(campo).parent().find('input');
            var valor = input.val();

            var campo_crianca = jQuery(campo).parent().parent().parent().find('.info-criancas-idades');
            var qnt = campo_crianca.find('.info-idades').length;
            if(valor == 0 || (Number(valor) - 1) == 0){
                campo.addClass('disabled');
                input.val(0);
                Crianca.remove((qnt), campo_crianca);
                somaPassageiros();
            }else{
                campo.removeClass('disabled');
                campo.parent().parent().find('.info-criancaHotel .info-btn-mais').removeClass('disabled');
                input.val(valor - 1);
                Crianca.remove((qnt - Number(input.val())), campo_crianca);
                somaPassageiros();
            }
        },
        enviaForm: function(){
            var infos = {};
            var pessoas = ".infotravel-form-hospedagem .info-quartos-div #info-quartos-article";
            var div = ".infotravel-form-hospedagem .form-hotel";

            infos.checkIn = jQuery(div).find("input#info-data-entrada").val();
            infos.checkOut = jQuery(div).find("input#info-data-saida").val();
            infos.tipo = jQuery(".infotravel-form-hospedagem #tp").val();
            infos.am = jQuery(".infotravel-form-hospedagem #am").val();
            infos.hotel = jQuery(".infotravel-form-hospedagem #id").val();
            infos.quartos = jQuery(pessoas).find("article").length;
            infos.idunidade = jQuery(".infotravel-form-hospedagem #idunidade").val();
            infos.qtdQuartos = jQuery(pessoas).find("article").length;
            infos.eTP = jQuery("input[name='eTP']").val();

            var configQuarto = [];

            jQuery(pessoas).find("article").each(function(index, val){
                var configq = [];
                configq.push(jQuery(val).find("input[name='adultosHotel']").val());
                if(jQuery(val).find(".info-criancas-idades").find("select[name='idadecrianca']").length > 0){

                    jQuery(val).find(".info-criancas-idades").find("select[name='idadecrianca']").each(function(index, val){
                        configq.push(jQuery(val).val());
                    });
                }
                configQuarto.push(configq.join('-'));
            });

            var url = urlB2C;

            if(stProprio == true ){
                if(infos.eTP == "true"){
                    url += "/" + infos.tipo + infos.hotel;
                }
                else{
                    url += "/U" + infos.idunidade + "I/" + infos.tipo + infos.hotel;
                }
            }else{
                if(infos.eTP == "true"){
                    url += "/U" + infos.idunidade + "/" + infos.tipo + infos.hotel;
                }
                else{
                    url += "/U" + infos.idunidade + "I/" + infos.tipo + infos.hotel;
                }

            }

            url += "/" + infos.am.replace(' ', '-');
            url += "/" + infos.checkIn.replace(/\//g, '-');
            url += "/" + infos.checkOut.replace(/\//g, '-');
            url += "/" + configQuarto.join('!');

            if(jQuery(".infotravel-form-hospedagem #id").val() == ""){
                jQuery(".infotravel-form-hospedagem input#autocomplete-destino").focus();
                jQuery(".infotravel-form-hospedagem input#autocomplete-destino").val("");
                jQuery(".infotravel-form-hospedagem input#autocomplete-destino").attr("placeholder", "Escolha um destino");
            }else{
                jQuery(".infotravel-form-hospedagem .info-overlay").toggle();

                window.location = url;
            }

        },
        setShow: function(data){
            if(data == true){
                show = true;
            }
        }
    }
})();