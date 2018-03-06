<div class="infotravel-form infotravel-form-pacote-dinamico">
    <div class="info-overlay">
        <div class="info-overlay-container">
            <div class="flex">
                <div class="loader"></div>
            </div>
            <div class="load-text">
                Buscando Melhores Ofertas...
            </div>
        </div>
    </div>
    <form action="javascript:motorDeBuscaPacoteDinamico.enviaForm();" class="form-pacote-dinamico">
        <style>
            .infotravel-form-pacote-dinamico .info-input-style input[type="text"]#autocomplete-destino.ui-autocomplete-loading {
                background: white url(<?php echo plugin_dir_url( __FILE__ ) . '/css/images/loading.gif'; ?>) right center no-repeat;
            }
        </style>
        <div class="info-row">
            <div id="inputOrigem">
                <div class="info-column info-column-6">
                    <div class="info-input-style">
                        <label>Origem:</label>
                        <input id="autocomplete-origem" name="origem" placeholder="Informe uma Origem" required="" type="text" >
                        <input id="stProprio" name="eTP" type="hidden" value="<?php echo get_option('pacote_dinamico_exibir_tr'); ?>"> <input id="stProprio" name="urlDominio" type="hidden" value="<?php echo get_option('pacote_dinamico_dominio'); ?>">
                        <input id="stProprio" name="stProprio" type="hidden" value="false">
                        <input id="idunidade" name="idunidade" type="hidden">
                        <input id="data-val" name="data-val" type="hidden">
                    </div>
                </div>
            </div>

            <div class="info-column info-column-6">
                <div class="info-input-style">
                    <label>Destino:</label>
                        <input id="autocomplete-destino" name="destino" placeholder="Informe um Destino" required="" type="text" >
                        <input id="stProprio" name="eTP" type="hidden" value="<?php echo get_option('pacote-dinamico_exibir_tr'); ?>"> <input id="stProprio" name="urlDominio" type="hidden" value="<?php echo get_option('pacote_dinamico_dominio'); ?>">
                        <input id="stProprio" name="stProprio" type="hidden" value="false">
                        <input id="idunidade" name="idunidade" type="hidden">
                        <input id="data-val2" name="data-val2" type="hidden">
                </div>
            </div>
        </div>
        <div class="info-row">
            <div class="info-column info-column-4">
                <div class="info-input-style">
                    <label>Entrada:</label> <input id="info-data-entradaPD" readonly="true" name="destino" required="" type="text">
                </div>
            </div>
            <div class="info-column info-column-4" id="dtSaida">
                <div class="info-input-style">
                    <label>Saida:</label> <input id="info-data-saidaPD" readonly="true" name="destino" required="" type="text">
                </div>
            </div>
            <div class="info-column info-column-4">
                <div class="info-column info-column-12">
                    <div class="info-column info-column-6">
                        <div class="info-input-style info-input-quartos">
                            <label>Quartos:</label> <input aria-describedby="basic-quartos" autocomplete="off" id="quartos" name="quartos" placeholder="Informe o pacote ou destino" readonly="true" type="text" value="1">
                        </div>
                    </div>
                    <div class="info-column info-column-6">
                        <div class="info-input-style info-input-quartos">
                            <label>Pessoas:</label> <input aria-describedby="basic-pessoas" autocomplete="off" id="pessoas" name="pessoas" placeholder="Informe o pacote ou destino" readonly="true" type="text" value="2">
                        </div>
                    </div>
                </div>
                <div class="info-column info-column-12">
                    <div class="info-quartos-div" style="padding-bottom: 10px;">
                        <div class="info-column info-column-12">
                            <div id="info-quartos-article">
                                <article>
                                    <div class="info-quarto-header">
                                        Quarto 1
                                    </div>
                                    <div class="info-quartos">
                                        <label>Adultos:</label>
                                        <div class="info-btns info-adultospacote">
                                            <div class="info-btn-menos" onclick="motorDeBuscaPacoteDinamico.subAdulto(this);">
                                                <i class="fa fa-minus"></i>
                                            </div><input disabled name="adultospacote" style="border-bottom: none;border-top: none;" type="text" value="2">
                                            <div class="info-btn-mais" onclick="motorDeBuscaPacoteDinamico.addAdulto(this);">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-quartos" style="height: 49px;">
                                        <label>Crianças:</label> <span>(entre 2 e 11 anos)</span>
                                        <div class="info-btns info-criancapacote">
                                            <div class="info-btn-menos" onclick="motorDeBuscaPacoteDinamico.subCrianca(this);">
                                                <i class="fa fa-minus"></i>
                                            </div><input disabled name="criancapacote" style="border-bottom: none;border-top: none;" type="text" value="0">
                                            <div class="info-btn-mais" onclick="motorDeBuscaPacoteDinamico.addCrianca(this);">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div><span class="info-erro info-hidden" id="msgerroidade" style="color: red;margin-top: 39px;"></span>
                                    </div>
                                    <div class="info-criancas-idades"></div>
                                </article>
                            </div>
                        </div>

                        <div class="info-column info-column-12">
                            <div class="info-quartos-footer">
                                <a href="javascript:void(0)" id="btn-add-quarto">Adicionar quarto</a> <a href="javascript:void(0)" id="btn-aplicar">Aplicar</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="column-12">
                <button class="info-btn-pesquisar" type="submit">PESQUISAR</button>
            </div>
        </div>
    </form>
</div>