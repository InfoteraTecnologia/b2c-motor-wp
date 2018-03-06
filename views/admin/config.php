<div id="infotravel-plugin-container">
    <div class="infotravel-masthead">
        <div class="infotravel-masthead__inside-container">
            <div class="infotravel-masthead__logo-container">
                <img class="infotravel-masthead__logo" src="<?php echo esc_url( plugins_url( '../../_inc/img/logo-full-2x.png', __FILE__ ) ); ?>" alt="Infotravel" />
            </div>
        </div>
    </div>
    <div class="infotravel-lower">
        <div class="infotravel-card">
            <div class="infotravel-section-header">
                <div class="infotravel-section-header__label">
                    <span><?php esc_html_e( 'Instalação' , 'infotravel-motor'); ?></span>
                </div>
            </div>
            <div class="infotravel-new-snapshot">
                <p>Para instalar o motor de hospedagem diretamente no código de seu tema basta adicionar o shortcode: </p>
                <code>&lt;?php do_shortcode("[infotravel_motor_hotel]"); ?&gt;</code>
                <p>Para instalar o motor de pacote aéreo diretamente no código de seu tema basta adicionar o shortcode: </p>
                <code>&lt;?php do_shortcode("[infotravel_motor_pacote"); ?&gt;</code>
                <p>Para instalar o motor de pacote dinâmico diretamente no código de seu tema basta adicionar o shortcode: </p>
                <code>&lt;?php do_shortcode("[infotravel_motor_dinamico"); ?&gt;</code>

            </div>
        </div>
        <div class="infotravel-card">
            <div class="infotravel-section-header">
                <div class="infotravel-section-header__label">
                    <span><?php esc_html_e( 'Configurações' , 'infotravel-motor'); ?></span>
                </div>
            </div>

            <div class="infotravel-menu">
                <ul class="infotravel-menu__tabs">
                    <li><a class="active" href="#tab-hospedagem"><i class="fa fa-star"></i> Hospedagem</a></li>
                    <li><a href="#tab-pacote"><i class="fa fa-star"></i> Pacote Aéreo</a></li>
                    <li><a href="#tab-pacote-dinamico"><i class="fa fa-star"></i> Pacote Dinâmico</a></li>
                </ul>
                <section class="infotravel-menu__wrapper">
                    <article id="tab-hospedagem" class="infotravel-menu__item item-active">
                        <div class="inside">
                            <form action="javascript:saveConfigHospedagem()" method="POST">
                            <table cellspacing="0" class="infotravel-settings">
                                <tbody>
                                <tr>
                                    <th align="left" scope="row">Motor hospedagem</th>
                                    <td></td>
                                    <td align="left">
                                        <p>
                                            <label for="infotravel_exibir_motor_hospedagem" title="Exibir motor de hospedagem">
                                                <input
                                                        name="infotravel_exibir_motor_hospedagem"
                                                        id="infotravel_exibir_motor_hospedagem"
                                                        value="1"
                                                        type="checkbox"

                                                    <?php
                                                    // If the option isn't set, or if it's enabled ('1'), or if it was enabled a long time ago ('true'), check the checkbox.
                                                    checked( true, ( in_array( get_option( 'hospedagem_exibir' ), array( false, '1', 'true' ), true ) ) );
                                                    ?>
                                                />
                                                Exibir motor de hospedagem
                                            </label>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="infotravel-url-autocomplete-hospedagem" width="20%" align="left" scope="row">Dominio (http ou https)</th>
                                    <td width="5%"/>
                                    <td align="left">
                                        <span class="api-key"><input id="url-dominio-hospedagem" pattern="(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})" name="url-dominio-hospedagem" type="text" size="15" value="<?php echo get_option( 'hospedagem_dominio' ); ?>" placeholder="http://reservas.dominio.com.br" class="regular-text code" autocomplete="off"><span id="info-dominio-span" style="color: red; display: none;">Url inválida</span></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">Chave</th>
                                    <td width="5%"/>
                                    <td align="left">
                                        <span class="infotravel-url-b2c-hospedagem"><input id="infotravel-chave-hospedagem" name="infotravel-chave-hospedagem" type="text" size="15" value="<?php echo get_option( 'hospedagem_chave' ); ?>" placeholder="0123456789" class="regular-text code" autocomplete="off"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th align="left" scope="row">Topo e rodapé</th>
                                    <td></td>
                                    <td align="left">
                                        <p>
                                            <label for="infotravel_exibir_tr_hospedagem" title="Exibir topo e rodapé">
                                                <input
                                                        name="infotravel_exibir_tr_hospedagem"
                                                        id="infotravel_exibir_tr_hospedagem"
                                                        value="1"
                                                        type="checkbox"

                                                    <?php
                                                    // If the option isn't set, or if it's enabled ('1'), or if it was enabled a long time ago ('true'), check the checkbox.
                                                    checked( true, ( in_array( get_option( 'hospedagem_exibir_tr' ), array( false, '1', 'true' ), true ) ) );
                                                    ?>
                                                />
                                                Exibir topo e rodapé
                                            </label>
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="infotravel-card-actions">
                                <div id="publishing-action">
                                    <input type="submit" name="submit" id="submit" class="infotravel-button infotravel-is-primary" value="Salvar alterações">
                                </div>
                                <div class="clear"></div>
                            </div>

                        </form>
                        </div>
                    </article>
                    
                    
                    <article class="infotravel-menu__item" id="tab-pacote" style="display: none;">
                        <div class="inside">
                            <form action="javascript:saveConfigPacote()" method="POST">
                                <table cellspacing="0" class="infotravel-settings">
                                    <tbody>
                                    <tr>
                                        <th align="left" scope="row">Motor Pacote Aéreo</th>
                                        <td></td>
                                        <td align="left">
                                            <p><label for="infotravel_exibir_motor_pacote" title="Exibir motor pacote aéreo"><input id="infotravel_exibir_motor_pacote" name="infotravel_exibir_motor_pacote" type="checkbox" value="1" <?php checked( true, ( in_array( get_option( 'pacote_exibir' ), array( false, '1', 'true' ), true ) ) ); ?>> Exibir motor pacote aéreo</label></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th align="left" class="infotravel-url-autocomplete-pacote" scope="row" width="20%">Dominio (http ou https)</th>
                                        <td width="5%"></td>
                                        <td align="left"><span class="api-key"><input class="regular-text code" id="url-dominio-pacote" name="url-dominio-pacote" pattern="(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})" placeholder="http://reservas.dominio.com.br"  size="15"type="text" value="<?php echo get_option( 'pacote_dominio' ); ?>" autocomplete="off"><span id="info-dominio-span" style="color: red; display: none;"">Url inválida</span></span></td>
                                    </tr>
                                    <tr>
                                        <th align="left" class="infotravel-url-b2c-pacote" scope="row" width="20%">Chave</th>
                                        <td width="5%"></td>
                                        <td align="left"><span class="infotravel-url-b2c-pacote"><input class="regular-text code" id="infotravel-chave-pacote" name="infotravel-chave-pacote" placeholder="0123456789" size="15" type="text" value="<?php echo get_option( 'pacote_chave' ); ?>"  autocomplete="off"></span></td>
                                    </tr>
                                    <tr>
                                        <th align="left" scope="row">Topo e rodapé</th>
                                        <td></td>
                                        <td align="left">
                                            <p><label for="infotravel_exibir_tr_pacote" title="Exibir topo e rodapé"><input id="infotravel_exibir_tr_pacote" name="infotravel_exibir_tr_pacote" type="checkbox" value="1" <?php checked( true, ( in_array( get_option( 'pacote_exibir_tr' ), array( false, '1', 'true' ), true ) ) ); ?>> Exibir topo e rodapé</label></p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="infotravel-card-actions">
                                    <div id="publishing-action">
                                        <input class="infotravel-button infotravel-is-primary" id="submit" name="submit" type="submit" value="Salvar alterações">
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </form>
                        </div>
                    </article>
                    
                    
                    <article class="infotravel-menu__item" id="tab-pacote-dinamico" style="display: none;">
                        <div class="inside">
                            <form action="javascript:saveConfigPacoteDinamico()" method="POST">
                                <table cellspacing="0" class="infotravel-settings">
                                    <tbody>
                                    <tr>
                                        <th align="left" scope="row">Motor Pacote Dinâmico</th>
                                        <td></td>
                                        <td align="left">
                                            <p><label for="infotravel_exibir_motor_pacote_dinamico" title="Exibir motor pacote dinâmico"><input id="infotravel_exibir_motor_pacote_dinamico" name="infotravel_exibir_motor_pacote_dinamico" type="checkbox" value="1" <?php checked( true, ( in_array( get_option( 'pacote_dinamico_exibir' ), array( false, '1', 'true' ), true ) ) ); ?>> Exibir motor pacote dinâmico</label></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th align="left" class="infotravel-url-autocomplete-pacote" scope="row" width="20%">Dominio (http ou https)</th>
                                        <td width="5%"></td>
                                        <td align="left"><span class="api-key"><input class="regular-text code" id="url-dominio-pacote-dinamico" name="url-dominio-pacote-dinamico" pattern="(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})" placeholder="http://reservas.dominio.com.br"  size="15"type="text" value="<?php echo get_option( 'pacote_dinamico_dominio' ); ?>" autocomplete="off"><span id="info-dominio-span" style="color: red; display: none;">Url inválida</span></span></td>
                                    </tr>
                                    <tr>
                                        <th align="left" class="infotravel-url-b2c-pacote-dinamico" scope="row" width="20%">Chave</th>
                                        <td width="5%"></td>
                                        <td align="left"><span class="infotravel-url-b2c-pacote-dinamico"><input class="regular-text code" id="infotravel-chave-pacote-dinamico" name="infotravel-chave-pacote-dinamico" placeholder="0123456789" size="15" type="text" value="<?php echo get_option( 'pacote_dinamico_chave' ); ?>"  autocomplete="off"></span></td>
                                    </tr>
                                    <tr>
                                        <th align="left" scope="row">Topo e rodapé</th>
                                        <td></td>
                                        <td align="left">
                                            <p><label for="infotravel_exibir_tr_pacote_dinamico" title="Exibir topo e rodapé"><input id="infotravel_exibir_tr_pacote_dinamico" name="infotravel_exibir_tr_pacote_dinamico" type="checkbox" value="1" <?php checked( true, ( in_array( get_option( 'pacote_dinamico_exibir_tr' ), array( false, '1', 'true' ), true ) ) ); ?>> Exibir topo e rodapé</label></p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="infotravel-card-actions">
                                    <div id="publishing-action">
                                        <input class="infotravel-button infotravel-is-primary" id="submit" name="submit" type="submit" value="Salvar alterações">
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </form>
                        </div>
                    </article>
                </section>
            </div>
        </div>
    </div>

    <div class="infotravel-plugin-footer">
        <div class="infotravel-section-header">
            <div class="infotravel-section-header__label">
                <span>© infotravel.com.br <?php echo date("Y"); ?>. InfoTravel - Todos os direitos reservados</span>
            </div>
            <div class="infotravel-section-header__actions">
                <a href="javascript:void(0)">v: <?php echo INFOTRAVEL_VERSION; ?></a>
            </div>
        </div>
    </div>
</div>
