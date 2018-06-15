var motorDeBuscaPacote = (function() {
    var urlB2C = '';
    var Crianca = {};
    var show = false;
    var stProprio = false;
    var autocomplete = false;
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
        var quartos = jQuery(".infotravel-form-pacote .info-quartos-div #info-quartos-article").find("article").length;
        var pessoas = 0;
        jQuery(".infotravel-form-pacote .info-quartos-div #info-quartos-article").find("article").each(function(index, val){
            adultos += Number(jQuery(val).find("input[name='adultospacote']").val());
            criancas += Number(jQuery(val).find("input[name='criancapacote']").val());
        });
        pessoas = adultos + criancas;
        jQuery(".infotravel-form-pacote .info-input-quartos input[name='quartos']").val(quartos);
        jQuery(".infotravel-form-pacote .info-input-quartos input[name='pessoas']").val(pessoas);
    };


    var config = function(){

        var data = {
            'action': 'infotravel_pacote_autocomplete'
        };

        var urlPost = window.location.href + "wp-admin/admin-ajax.php";

        jQuery.post(urlPost, data, function(data){

            data = JSON.parse(data);

            var config = data.config;
            var origem = data.origem;

            if(data.config){
                jQuery(".infotravel-form-pacote #idunidade").val(data.config.idUnidade);
                stProprio = data.config.stProprio;
                qtIdadeMaxChd = config.qtIdadeMaxChd;
                qtAdt = config.qtAdt;
                qtChd = config.qtChd;
            }

            if(config.stAutocompletarOrigem == null || config.stAutocompletarOrigem == "N"){
                jQuery(".infotravel-form-pacote #inputOrigem").css('display', 'block');
                jQuery(".infotravel-form-pacote #selectOrigem").remove();
                autocomplete = true;
            }else if(config.stAutocompletarOrigem == "S"){
                jQuery(".infotravel-form-pacote #inputOrigem").remove();
                autocomplete = false;
                var select = jQuery(".infotravel-form-pacote #selectOrigem select[name='autocomplete-origemSelect']");
                var html = '<option selected="selected" value="-1" disabled="disabled">Selecione uma Origem</option>';
                for (var i = 0; i < origem.length; i++) {
                    html += '<option onclick="motorPacoteFechado.selecionaOpcaoLi(this);" value="' + origem[i].tp + origem[i].id + '/' + origem[i].nm + '">' + origem[i].nm + '</option>';
                }
                select.empty();
                select.append(html);
            }
            
        });
    };


    var gerarUtilizacao = function () {
        var id = jQuery("#pacotes-tab #pacoteF-dtPartida");

        if(autocomplete == true){
            var idOrigem = jQuery(".infotravel-form-pacote input#data-val").val().split('/')[0];
        }else{
            var idOrigem = jQuery(".infotravel-form-pacote select[name='autocomplete-origemSelect']").val().split('/')[0];
        }

        if (idOrigem && jQuery(".infotravel-form-pacote select[name='autocomplete-destinoSelect']").val().split('/')[0].substring(1)) {

            id.attr('placeholder', 'carregando...');

            var idDestino = jQuery(".infotravel-form-pacote select[name='autocomplete-destinoSelect']").val().split('/')[0].split('/')[0].substr(1);

            var data = {
                'action': 'infotravel_pacote_autocomplete',
                'param': '&idOrigem=' + idOrigem + '&idDestino=' + jQuery(".infotravel-form-pacote select[name='autocomplete-destinoSelect']").val().split('/')[0].substring(1)
            };
            var urlPost = window.location.href + "wp-admin/admin-ajax.php";

            jQuery.post(urlPost, data, function (data) {

                data = JSON.parse(data);

                if (data && data.periodo && data.periodo.dtPeriodo) {
                    data = data.periodo.dtPeriodo;
                    var dtLast = data[data.length - 1];
                    var yyLast = dtLast.substr(0, 4);
                    var mmLast = parseInt(dtLast.substr(4, 2)) - 1;
                    var ddLast = dtLast.substr(6, 2);
                    if (ddLast.indexOf('0') === 0) {
                        ddLast = ddLast.substr(1);
                    }
                    var maxDate = new Date(yyLast, mmLast, ddLast, 1, 0, 0);
                    var dtMin = data[0];
                    var yyMin = dtMin.substr(0, 4);
                    var mmMin = parseInt(dtMin.substr(4, 2)) - 1;
                    var ddMin = 1;
                    var minDate = new Date(yyMin, mmMin, ddMin, 1, 0, 0);

                    jQuery(".infotravel-form-pacote #info-data-entradaP").datepicker();
                    jQuery(".infotravel-form-pacote #info-data-entradaP").datepicker('option', {
                        minDate: minDate,
                        maxDate: maxDate,
                        dateFormat: "dd/mm/yy",
                        beforeShowDay: function (date) {
                            var list = data;
                            for (var i = 0; i < list.length; i++) {
                                var dateTmp = list[i];
                                var yy = dateTmp.substr(0, 4);
                                var mm = parseInt(dateTmp.substr(4, 2)) - 1;
                                var dd = dateTmp.substr(6, 2);
                                if (date.getDate() == dd && date.getMonth() == mm && date.getFullYear() == yy) {
                                    return [true, 'calendario destacado'];
                                }
                            }
                            return [false, ''];
                        }
                    });
                    jQuery(".infotravel-form-pacote #info-data-entradaP").attr('readonly', 'readonly').datepicker('enable').attr('placeholder', 'Selecione uma data');
                }

                if (data && data.periodoList) {

                    jQuery(".infotravel-form-pacote #dtSaida").css('display', 'none');

                    var partida = [];
                    var retorno = [];

                    jQuery.each(data.periodoList, function(index, val){
                        partida.push(val.dtPartida);
                        jQuery.each(val.dtRetorno, function(index, val){
                            retorno.push(val);
                        });
                    });


                    if(partida.length != 0){
                        var id = jQuery(".infotravel-form-pacote #info-data-entradaP");
                        id.attr('placeholder', 'carregando...');

                        data = partida;
                        var dtLast = data[data.length - 1];
                        var yyLast = dtLast.substr(0, 4);
                        var mmLast = parseInt(dtLast.substr(4, 2)) - 1;
                        var ddLast = dtLast.substr(6, 2);
                        if (ddLast.indexOf('0') === 0) {
                            ddLast = ddLast.substr(1);
                        }
                        var maxDate = new Date(yyLast, mmLast, ddLast, 1, 0, 0);
                        var dtMin = data[0];
                        var yyMin = dtMin.substr(0, 4);
                        var mmMin = parseInt(dtMin.substr(4, 2)) - 1;
                        var ddMin = 1;
                        var minDate = new Date(yyMin, mmMin, ddMin, 1, 0, 0);

                        jQuery(".infotravel-form-pacote #info-data-entradaP").datepicker();
                        jQuery(".infotravel-form-pacote #info-data-entradaP").datepicker('option', {
                            minDate: minDate,
                            maxDate: maxDate,
                            dateFormat: "dd/mm/yy",
                            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
                            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                            nextText: 'Próximo',
                            prevText: 'Anterior',
                            beforeShowDay: function (date) {
                                var list = data;
                                for (var i = 0; i < list.length; i++) {
                                    var dateTmp = list[i];
                                    var yy = dateTmp.substr(0, 4);
                                    var mm = parseInt(dateTmp.substr(4, 2)) - 1;
                                    var dd = dateTmp.substr(6, 2);
                                    if (date.getDate() == dd && date.getMonth() == mm && date.getFullYear() == yy) {
                                        return [true, 'calendario destacado'];
                                    }
                                }
                                return [false, ''];
                            },
                            onSelect: function(data){
                                var data = data.split('/')[2] + "/" + data.split('/')[1] + "/" + data.split('/')[0];
                                var dataRetorno = adicionarDiasData(7, data).split("/");
                                if(dataRetorno[1].length == 1){
                                    var dataTotal = dataRetorno[0] + "/0" + dataRetorno[1] + "/" + dataRetorno[2];
                                }else{
                                    var dataTotal = dataRetorno[0] + "/"  + dataRetorno[1] + "/" + dataRetorno[2];
                                }
                                jQuery(".infotravel-form-pacote #info-data-saidaP").val(dataTotal);

                                jQuery(".infotravel-form-pacote #info-data-saidaP").datepicker('option', {
                                    beforeShowDay: function (date) {

                                        return [true, 'calendario destacado'];

                                        return [false, ''];
                                    }
                                });

                            }
                        });
                        id.attr('readonly', 'readonly').datepicker('enable').attr('placeholder', 'Selecione uma data');
                    }

                    if(retorno.length != 0){
                        jQuery(".infotravel-form-pacote #dtSaida").css('display', 'block');

                        var id = jQuery(".infotravel-form-pacote #info-data-saidaP");
                        id.attr('placeholder', 'carregando...');

                        data = partida;
                        var dtLast = data[data.length - 1];
                        var yyLast = dtLast.substr(0, 4);
                        var mmLast = parseInt(dtLast.substr(4, 2)) - 1;
                        var ddLast = dtLast.substr(6, 2);
                        if (ddLast.indexOf('0') === 0) {
                            ddLast = ddLast.substr(1);
                        }
                        var maxDate = new Date(yyLast, mmLast, ddLast, 1, 0, 0);
                        var dtMin = data[0];
                        var yyMin = dtMin.substr(0, 4);
                        var mmMin = parseInt(dtMin.substr(4, 2)) - 1;
                        var ddMin = 1;
                        var minDate = new Date(yyMin, mmMin, ddMin, 1, 0, 0);

                        jQuery(".infotravel-form-pacote #info-data-saidaP").datepicker();
                        jQuery(".infotravel-form-pacote #info-data-saidaP").datepicker('option', {
                            minDate: minDate,
                            maxDate: maxDate,
                            dateFormat: "dd/mm/yy",
                            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
                            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                            nextText: 'Próximo',
                            prevText: 'Anterior',
                            beforeShowDay: function (date) {
                                var list = data;
                                for (var i = 0; i < list.length; i++) {
                                    var dateTmp = list[i];
                                    var yy = dateTmp.substr(0, 4);
                                    var mm = parseInt(dateTmp.substr(4, 2)) - 1;
                                    var dd = dateTmp.substr(6, 2);
                                    if (date.getDate() == dd && date.getMonth() == mm && date.getFullYear() == yy) {
                                        return [true, 'calendario destacado'];
                                    }
                                }
                                return [false, ''];
                            }
                        });
                        id.attr('readonly', 'readonly').datepicker('enable').attr('placeholder', 'Selecione uma data');
                    }
                }
            });
        } else {
            jQuery(".infotravel-form-pacote #info-data-entradaP").attr('readonly', 'readonly').datepicker('disable').attr('placeholder', 'NÃ£o disponÃ­vel');
        }
    };


    return {
        init: function(){

            config();

            jQuery(".infotravel-form-pacote #dtSaida").css('display', 'none');

            jQuery(".infotravel-form-pacote #selectOrigem select[name='autocomplete-origemSelect']").on('change', function(event){
                event.preventDefault();

                var data = {
                    'action': 'infotravel_pacote_autocomplete',
                    'param': '&idOrigem=' + jQuery(this).val().split('/')[0].substring(1)
                };
                var urlPost = window.location.href + "wp-admin/admin-ajax.php";
                jQuery.post(urlPost, data, function(data){

                    data = JSON.parse(data);
                    var destino = data.destino;

                    var select = jQuery(".infotravel-form-pacote select[name='autocomplete-destinoSelect']");
                    var html = '<option selected="selected" value="-1" disabled="disabled">Selecione um Destino</option>';
                    for (var i = 0; i < destino.length; i++) {
                        html += '<option value="' + destino[i].tp + destino[i].id + '/' + destino[i].nm + '">' + destino[i].nm + '</option>';
                    }

                    select.empty();
                    select.append(html);
                });
            });

            jQuery(".infotravel-form-pacote select[name='autocomplete-destinoSelect']").on('change', function(event){
                event.preventDefault();
                gerarUtilizacao();
            });

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

            jQuery(".infotravel-form-pacote #autocomplete-origem").catcomplete({
                delay: 0,
                source: function( request, response ) {
                    jQuery(".infotravel-form-pacote #autocomplete-origem").addClass("ui-autocomplete-loading");
                    if(request.term.length >= 3){
                        var data = {
                            'action': 'infotravel_pacote_autocomplete',
                            'param': '&nmOrigem=' + request.term
                        };

                        var urlPost = window.location.href + "wp-admin/admin-ajax.php";

                        jQuery.post(urlPost, data, function (json) {
                            if(isJson(json)){
                                json = JSON.parse(json);

                                if(json.config){
                                    jQuery(".infotravel-form-pacote #idunidade").val(json.config.idUnidade);
                                    stProprio = json.config.stProprio;
                                }

                                if (json.origem) {

                                    var hoteis = [];
                                    var municipios = [];

                                    var dados1 = "";

                                    for (var i = 0; i < json.origem.length; i++) {
                                        dados1 += '{' +
                                            '"label": "' + json.origem[i].nm + '",' +
                                            '"category": "'+( (json.origem[i].tp == 'H') ? "Hotéis" : "Destinos"  )+'",' +
                                            '"value": "'+ json.origem[i].nm +'",'+
                                            '"data_val": "' + json.origem[i].tp + json.origem[i].id + "/" + json.origem[i].nm + '"' +
                                            '},';
                                    }

                                    var data = "[" + dados1.substring(0, (dados1.length - 1)) + "]";

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
                    // jQuery(".infotravel-form-pacote .info-input-style input[type=\"text\"]").removeClass("ui-autocomplete-loading");
                },
                select: function (event, ui) {
                    jQuery(".infotravel-form-pacote input#data-val").val(ui.item.data_val);
                    jQuery('.infotravel-form-pacote input#autocomplete-origem').val(ui.item.nome);

                    if(autocomplete == true){
                        var idOrigem = jQuery(".infotravel-form-pacote input#data-val").val().split('/')[0];
                    }else{
                        var idOrigem = jQuery(".infotravel-form-pacote select[name='autocomplete-origemSelect']").val().split('/')[0];
                    }

                    var data = {
                        'action': 'infotravel_pacote_autocomplete',
                        'param': '&idOrigem=' + idOrigem
                    };
                    var urlPost = window.location.href + "wp-admin/admin-ajax.php";
                    jQuery.post(urlPost, data, function(data){

                        data = JSON.parse(data);
                        var destino = data.destino;

                        var select = jQuery(".infotravel-form-pacote select[name='autocomplete-destinoSelect']");
                        var html = '<option selected="selected" value="-1" disabled="disabled">Selecione um Destino</option>';
                        for (var i = 0; i < destino.length; i++) {
                            html += '<option value="' + destino[i].tp + destino[i].id + '/' + destino[i].nm + '">' + destino[i].nm + '</option>';
                        }

                        select.empty();
                        select.append(html);
                    });
                }
            });

            //Not the best solution but will solve the problem
            jQuery(document).on('click', '.ui-autocomplete-category', function () {
                jQuery(".infotravel-form-pacote #search").val(jQuery(this).html());
                jQuery(".infotravel-form-pacote #search").catcomplete("close");
            });

            jQuery(".infotravel-form-pacote #autocomplete-destino").on('click', function(){
                if(jQuery(this).val().length > 0){
                    this.select();
                    return true;
                }
            });

            // var dataSaida = new Date();
            // dataSaida.setDate(dataSaida.getDate() + 1)
            // jQuery('.infotravel-form-pacote #info-data-entradaP').datepicker({
            //     dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            //     dayNamesMin: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
            //     dayNamesShort: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
            //     monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro","Dezembro" ],
            //     monthNamesShort: [ "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Decz" ],
            //     dateFormat: "dd/mm/yy",
            //     minDate:  new Date().toLocaleDateString(),
            //     onClose: function(selectedDate) {
            //         jQuery("#info-data-saidaP").datepicker("option", "minDate", selectedDate);
            //         jQuery(this).parents('.column').next().children().find('#info-data-saidaP').focus();
            //     }
            // });
            // jQuery('.infotravel-form-pacote #info-data-saidaP').datepicker({
            //     dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            //     dayNamesMin: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
            //     dayNamesShort: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
            //     monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro","Dezembro" ],
            //     monthNamesShort: [ "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Decz" ],
            //     dateFormat: "dd/mm/yy",
            //     minDate:  dataSaida
            // });

            var quantidadeQuartos = 1;
            var maxQuartos = 4;
            jQuery(".infotravel-form-pacote #btn-add-quarto").click(function(){

                var wrapper = jQuery(".infotravel-form-pacote #info-quartos-article");

                if (quantidadeQuartos < maxQuartos) {
                    quantidadeQuartos++;

                    jQuery(wrapper).append("<article>\n" +
                        "                                <div class=\"info-quarto-header\">\n" +
                        "                                    Quarto " + (quantidadeQuartos) + "\n" +
                        "                                    <span><a href=\"javascript:void(0)\" style=\"display:none;\" id=\"btn-eliminar\">Eliminar</a></span>\n" +
                        "                                </div>\n" +
                        "                                <div class=\"info-quartos\">\n" +
                        "                                    <label>Adultos:</label>\n" +
                        "                                    <div class=\"info-btns info-adultospacote\">\n" +
                        "                                        <div class=\"info-btn-menos\" onclick=\"motorDeBuscaPacote.subAdulto(this);\"><i class=\"fa fa-minus\"></i></div>\n" +
                        "                                        <input type=\"text\" name=\"adultospacote\" style=\"border-bottom: none;border-top: none;\" value=\"2\" disabled>\n" +
                        "                                        <div class=\"info-btn-mais\" onclick=\"motorDeBuscaPacote.addAdulto(this);\"><i class=\"fa fa-plus\"></i></div>\n" +
                        "                                    </div>\n" +
                        "                                </div>\n" +
                        "                                <div class=\"info-quartos\" style=\"height: 49px;\">\n" +
                        "                                    <label>Crianças:</label>\n" +
                        "                                    <span>(entre 2 e 11 anos)</span>\n" +
                        "                                    <div class=\"info-btns info-criancapacote\">\n" +
                        "                                        <div class=\"info-btn-menos\"onclick=\"motorDeBuscaPacote.subCrianca(this);\"><i class=\"fa fa-minus\"></i></div>\n" +
                        "                                        <input type=\"text\" name=\"criancapacote\" style=\"border-bottom: none;border-top: none;\" value=\"0\" disabled>\n" +
                        "                                        <div class=\"info-btn-mais\" onclick=\"motorDeBuscaPacote.addCrianca(this);\"><i class=\"fa fa-plus\"></i></div>\n" +
                        "                                    </div>\n" +
                        "                                    <span class=\"info-erro info-hidden\" id=\"msgerroidade\" style=\"color: red;margin-top: 39px;\"></span>\n" +
                        "                                </div>\n" +
                        "                                <div class=\"info-criancas-idades\">\n" +
                        "                                </div>\n" +
                        "                            </article>");
                }

                jQuery(".infotravel-form-pacote #info-quartos-article article").each(function () {
                    jQuery(this).find("#btn-eliminar").css("display", "none");
                });

                if (quantidadeQuartos == maxQuartos) {
                    jQuery(".infotravel-form-pacote #btn-add-quarto").css("display", "none");
                }

                somaPassageiros();
                jQuery(".infotravel-form-pacote #info-quartos-article article:last-child").find("#btn-eliminar").css("display", "block");
            });

            jQuery(".infotravel-form-pacote .info-quartos-div").on("click", "#btn-eliminar", function(e) {
                e.stopPropagation();
                jQuery("#info-quartos-article article:last-child").remove();
                jQuery("#info-quartos-article article:last-child").find("#btn-eliminar").css("display", "block");
                quantidadeQuartos--;
                if (quantidadeQuartos < maxQuartos) {
                    jQuery(".infotravel-form-pacote #btn-add-quarto").css("display", "inline-block");
                }
                somaPassageiros();
            });

            jQuery(".infotravel-form-pacote .info-input-quartos input").on('click', function(){
                setTimeout(function() {
                    jQuery(".infotravel-form-pacote .info-quartos-div").toggle(255);
                }, 200);
            });

            var divNome = document.querySelector(".infotravel-form-pacote .info-quartos-div");
            jQuery(document).on("click", function(e) {
                var fora = !divNome.contains(e.target);
                if (fora) jQuery(divNome).slideUp("fast/100/slow");
            });

            jQuery(divNome).on("click", function(e) {
                jQuery(this).slideDown("fast/100/slow");
            });

            jQuery(".infotravel-form-pacote .info-quartos-div #btn-aplicar").on('click', function(){
                setTimeout(function() {
                    jQuery(".infotravel-form-pacote .info-quartos-div").toggle(255);
                }, 200);
            });

            jQuery(".infotravel-form-pacote .info-overlay").css({
                'height': Number(jQuery(".infotravel-form-pacote").height()) + 5,
                'width': Number(jQuery(".infotravel-form-pacote").width()) + 5
            });

            jQuery(".infotravel-form-pacote .info-overlay .info-overlay-container").css({
                'margin-top': (jQuery(".infotravel-form-pacote").height() / 2 - 60)
            });

            jQuery(window).resize(function(){
                jQuery(".infotravel-form-pacote .info-overlay").css({
                    'height': Number(jQuery(".infotravel-form-pacote").height()) + 5,
                    'width': Number(jQuery(".infotravel-form-pacote").width()) + 5
                });

                jQuery(".infotravel-form-pacote .info-overlay .info-overlay-container").css({
                    'margin-top': (jQuery(".infotravel-form-pacote").height() / 2 - 60)
                });
            });

            var data = {
                'action': 'infotravel_b2c_pacote'
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
                campo.parent().parent().find('.info-adultopacote .info-btn-menos').removeClass('disabled');
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
                campo.parent().parent().find('.info-adultopacote .info-btn-mais').removeClass('disabled');
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
                campo.parent().parent().find('.info-criancapacote .info-btn-menos').removeClass('disabled');
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
                campo.parent().parent().find('.info-criancapacote .info-btn-mais').removeClass('disabled');
                input.val(valor - 1);
                Crianca.remove((qnt - Number(input.val())), campo_crianca);
                somaPassageiros();
            }
        },
        enviaForm: function(){
            if(autocomplete == true){
                var idOrigem = jQuery(".infotravel-form-pacote input#data-val").val().split('/')[0], nmOrigem = jQuery(".infotravel-form-pacote input#data-val").val().split('/')[1];
            }else{
                var idOrigem = jQuery(".infotravel-form-pacote select[name='autocomplete-origemSelect']").val().split('/')[0], nmOrigem = jQuery(".infotravel-form-pacote select[name='autocomplete-origemSelect']").val().split('/')[1];
            }

            var idDestino = jQuery(".infotravel-form-pacote select[name='autocomplete-destinoSelect']").val().split('/')[0], nmDestino = jQuery(".infotravel-form-pacote select[name='autocomplete-destinoSelect']").val().split('/')[1];
            var dtPartida = jQuery(".infotravel-form-pacote #info-data-entradaP").val().replace(/\//g, "-");
            var dtChegada = jQuery(".infotravel-form-pacote #info-data-saidaP").val().replace(/\//g, "-");

            var pessoas = ".infotravel-form-pacote .info-quartos-div #info-quartos-article";
            var div = ".infotravel-form-pacote .form-pacote";

            var configQuarto = [];

            jQuery(pessoas).find("article").each(function(index, val){
                var configq = [];
                configq.push(jQuery(val).find("input[name='adultospacote']").val());
                if(jQuery(val).find(".info-criancas-idades").find("select[name='idadecrianca']").length > 0){

                    jQuery(val).find(".info-criancas-idades").find("select[name='idadecrianca']").each(function(index, val){
                        configq.push(jQuery(val).val());
                    });
                }
                configQuarto.push(configq.join('-'));
            });

            var url = urlB2C;

            if(dtChegada == ""){
                dtChegada = dtPartida;
            }

            var pessoas = ".infotravel-form-pacote .info-quartos-div #info-quartos-article";
            var div = ".infotravel-form-pacote .form-pacote";

            var idunidade = jQuery(".infotravel-form-pacote #idunidade").val();
            var eTP = jQuery(".infotravel-form-pacote input[name='eTP']").val();

            var configQuarto = [];

            jQuery(pessoas).find("article").each(function(index, val){
                var configq = [];
                configq.push(jQuery(val).find("input[name='adultospacote']").val());
                if(jQuery(val).find(".info-criancas-idades").find("select[name='idadecrianca']").length > 0){

                    jQuery(val).find(".info-criancas-idades").find("select[name='idadecrianca']").each(function(index, val){
                        configq.push(jQuery(val).val());
                    });
                }
                configQuarto.push(configq.join('-'));
            });

            var url = urlB2C;

            if(stProprio == true ){
                if(eTP == "true"){
                    url += "/" + idOrigem + "/" + nmOrigem + "/" + idDestino + "/" + nmDestino;
                }
                else{
                    url += "/U" + idunidade + "I/" + idOrigem + "/" + nmOrigem + "/" + idDestino + "/" + nmDestino;
                }
            }else{
                if(eTP == "true"){
                    url += "/U" + idunidade + "/" + idOrigem + "/" + nmOrigem + "/" + idDestino + "/" + nmDestino
                }
                else{
                    url += "/U" + idunidade + "I/" + idOrigem + "/" + nmOrigem + "/" + idDestino + "/" + nmDestino;
                }
            }

            url += "/" + dtPartida;
            url += "/" + dtChegada;
            url += "/" + configQuarto.join('!');

            if(jQuery(".infotravel-form-pacote #id").val() == ""){
                jQuery(".infotravel-form-pacote input#autocomplete-destino").focus();
                jQuery(".infotravel-form-pacote input#autocomplete-destino").val("");
                jQuery(".infotravel-form-pacote input#autocomplete-destino").attr("placeholder", "Escolha um destino");
            }else{
                jQuery(".infotravel-form-pacote .info-overlay").toggle();

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