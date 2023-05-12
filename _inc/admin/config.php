<div id="infotravel-plugin-container">
    <div class="infotravel-masthead">
        <div class="infotravel-masthead__inside-container">
            <div class="infotravel-masthead__logo-container">
                <img class="infotravel-masthead__logo"
                     src="<?php echo esc_url(plugins_url('../../_inc/img/logo.png', __FILE__)); ?>" alt="Infotravel"/>
            </div>
        </div>
    </div>
    <div class="infotravel-lower">
        <div class="infotravel-card">
            <div class="infotravel-section-header">
                <div class="infotravel-section-header__label">
                    <span><?php esc_html_e('Instalação', 'infotravel-motor'); ?></span>
                </div>
            </div>
            <div class="infotravel-new-snapshot">
                <p>Para instalar os motores basta adicionar o shortcode no seu código: </p>
                <span style="font-weight: bold">Hospedagem:</span><br/>
                <code>&lt;?php do_shortcode("[infotravel_motor_hotel]"); ?&gt;</code>

                <br/><br/><span style="font-weight: bold">Pacote aéreo:</span><br/>
                <code>&lt;?php do_shortcode("[infotravel_motor_pacote_aereo]"); ?&gt;</code>

                <br/><br/><span style="font-weight: bold">Monte seu pacote:</span><br/>
                <code>&lt;?php do_shortcode("[infotravel_motor_pacote_dinamico]"); ?&gt;</code>

                <br/><br/><span style="font-weight: bold">Monte rodo + hotel:</span><br/>
                <code>&lt;?php do_shortcode("[infotravel_motor_pacote_rodo_hotel]"); ?&gt;</code>

                <br/><br/><span style="font-weight: bold">Monte rodo + servico:</span><br/>
                <code>&lt;?php do_shortcode("[infotravel_motor_pacote_rodo_servico]"); ?&gt;</code>

                <br/><br/>
                <p>O plugin funciona com a utilização do jQuery e jQuery-ui, se você não utiliza em seu site por favor
                    adicione no seu código: </p>
                <div style="width: 97.2%;background: #ededed;padding: 10px;word-break: break-word;">

                    <strong>Css:</strong>
                    <br/>
                    <?= htmlspecialchars('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">'); ?>

                    <br/>
                    <br/>

                    <strong>Js:</strong>
                    <br/>
                    <?= htmlspecialchars('<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>'); ?>
                    <br/>
                    <?= htmlspecialchars('<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>'); ?>
                </div>

                <p style="font-weight: bold;color: red;">Apos adicionar o script do jQuery, é necessário adicionar o
                    seguinte shorcode para carregar as funções do Motor de Busca:</p>
                <code>&lt;?php do_shortcode("[infotravel_motor_assets]"); ?&gt;</code>
                <br/>
                <br/>
                <small>O shortcode acima deve ser adicionado apos o código do jQuery &lt;script src="...jquery.min.js"
                    ...&gt;&lt;/&gt;</small>
            </div>
        </div>
        <div class="infotravel-card">
            <div class="infotravel-section-header">
                <div class="infotravel-section-header__label">
                    <span><?php esc_html_e('Configurações', 'infotravel-motor'); ?></span>
                </div>
            </div>

            <div class="infotravel-menu">
                <ul class="infotravel-menu__tabs">
                    <li><a class="active" href="#tab-hospedagem"><i class="fa fa-star"></i> Configurações</a></li>
                </ul>
                <section class="infotravel-menu__wrapper">
                    <article id="tab-hospedagem" class="infotravel-menu__item item-active">
                        <div class="inside">
                            <form action="javascript:saveConfig()" method="POST">
                                <table cellspacing="0" class="infotravel-settings">
                                    <tbody>
                                    <tr>
                                        <th class="infotravel-url-autocomplete-hospedagem" width="20%" align="left"
                                            scope="row">Domínio do b2c (http ou https)
                                        </th>
                                        <td width="5%"/>
                                        <td align="left">
                                            <span class="api-key"><input id="dominio" name="dominio" type="text"
                                                                         pattern="(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})"
                                                                         size="15"
                                                                         value="<?php echo get_option('b2c_dominio'); ?>"
                                                                         placeholder="http://reservas.dominio.com.br/b2c"
                                                                         class="regular-text code"
                                                                         autocomplete="off"><span id="info-dominio-span"
                                                                                                  style="color: red; display: none;">Url inválida</span></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                            Chave
                                        </th>
                                        <td width="5%"/>
                                        <td align="left">
                                            <span class="infotravel-url-b2c-hospedagem">
                                                <input id="chave" name="chave"
                                                   type="text" size="15"
                                                   value="<?php echo get_option('b2c_chave'); ?>"
                                                   placeholder="chave MD5"
                                                   class="regular-text code"
                                                   autocomplete="off">
                                            </span>
                                        </td>
                                    </tr><tr>
                                        <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                            Sg Empresa
                                        </th>
                                        <td width="5%"/>
                                        <td align="left">
                                            <span class="infotravel-url-b2c-hospedagem">
                                                <input id="empresa" name="empresa"
                                                   type="text" size="15"
                                                   value="<?php echo get_option('b2c_empresa'); ?>"
                                                   placeholder="sgEmpresa"
                                                   class="regular-text code"
                                                   autocomplete="off">
                                            </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="infotravel-card-actions">
                                    <div id="publishing-action">
                                        <input type="submit" name="submit" id="submit"
                                               class="infotravel-button infotravel-is-primary"
                                               value="Salvar alterações">
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
                <a href="http://www.infotera.com.br">v: <?php echo INFOTRAVEL_VERSION; ?></a>
            </div>
        </div>
    </div>
</div>