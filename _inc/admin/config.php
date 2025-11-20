<div id="infotravel-plugin-container">
    <div class="infotravel-masthead">
        <div class="infotravel-masthead__inside-container">
            <div class="infotravel-masthead__logo-container">
                <img class="infotravel-masthead__logo"
                    src="<?php echo esc_url(plugins_url('../../_inc/img/logo.png', __FILE__)); ?>" alt="Infotravel" />
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
                <p>Para instalar o motor unificado, adicione o shortcode no seu código: </p>

                <span style="font-weight: bold; color: #0073aa;">Motor Unificado:</span><br />
                <code>&lt;?php do_shortcode("[infotravel_motor_unified]"); ?&gt;</code>
            </div>
        </div>
        <div class="infotravel-card">
            <div class="infotravel-section-header">
                <div class="infotravel-section-header__label">
                    <span><?php esc_html_e('Configurações', 'infotravel-motor'); ?></span>
                </div>
            </div>

            <div class="infotravel-menu">
                <?php if (isset($_GET['updated']) && $_GET['updated'] === 'true'): ?>
                    <div class="notice notice-success is-dismissible">
                        <p><?php _e('Configuration saved successfully!', 'infotravel-motor'); ?></p>
                    </div>
                <?php endif; ?>

                <ul class="infotravel-menu__tabs">
                    <li><a class="active" href="#tab-hospedagem"><i class="fa fa-star"></i> Configurações</a></li>
                </ul>
                <section class="infotravel-menu__wrapper">
                    <article id="tab-hospedagem" class="infotravel-menu__item item-active">
                        <div class="inside">
                            <form method="POST" action="">
                                <input type="hidden" name="action" value="infotravel_saveConfig">
                                <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('infotravel_saveConfig'); ?>">
                                <table cellspacing="0" class="infotravel-settings">
                                    <tbody>
                                        <tr>
                                            <th class="infotravel-url-autocomplete-hospedagem" width="20%" align="left"
                                                scope="row">Domínio do b2c (http ou https)
                                            </th>
                                            <td width="5%" />
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
                                            <td width="5%" />
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
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Sg Empresa
                                            </th>
                                            <td width="5%" />
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
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Engine Base URL
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="engine_base_url" name="engine_base_url"
                                                        type="text" size="30"
                                                        value="<?php echo get_option('b2c_engine_base_url'); ?>"
                                                        placeholder="https://motorv2.infotravel.com.br"
                                                        class="regular-text code"
                                                        autocomplete="off">
                                                </span>
                                                <br><small>URL base para o motor de busca por padrão: (https://motorv2.infotravel.com.br)</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Base URL API
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="base_url_api" name="base_url_api"
                                                        type="text" size="30"
                                                        value="<?php echo get_option('b2c_base_url_api'); ?>"
                                                        placeholder="https://demo.infotravel.com.br"
                                                        class="regular-text code"
                                                        autocomplete="off">
                                                </span>
                                                <br><small>URL base para as APIs, url do seu infotravel</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Carregar CSS
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="load_css" name="load_css" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_load_css', '1') === '1') ? 'checked' : ''; ?>>
                                                    <label for="load_css">Carregar CSS do motor automaticamente</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Carregar Tabs
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="load_tabs" name="load_tabs" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_load_tabs', '1') === '1') ? 'checked' : ''; ?>>
                                                    <label for="load_tabs">Carregar funcionalidade de tabs automaticamente</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                WhiteLabel
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="whiteLabel" name="white_label" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_white_label', '0') === '1') ? 'checked' : ''; ?>>
                                                    <label for="whiteLabel">Ativar white label no motor</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Iframe
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="iframe" name="iframe" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_iframe', '0') === '1') ? 'checked' : ''; ?>>
                                                    <label for="iframe">Ativar iframe no motor</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Target
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="target" name="target" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_target', '0') === '1') ? 'checked' : ''; ?>>
                                                    <label for="target">Ativar target no motor</label>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <h3>Ativação de Motores</h3>
                                <table cellspacing="0" class="infotravel-settings">
                                    <tbody>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Hotel
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="enable_hotel" name="enable_hotel" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_enable_hotel', '1') === '1') ? 'checked' : ''; ?>>
                                                    <label for="enable_hotel">Ativar motor de hotel</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Serviços
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="enable_service" name="enable_service" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_enable_service', '1') === '1') ? 'checked' : ''; ?>>
                                                    <label for="enable_service">Ativar motor de serviços</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Voo
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="enable_flight" name="enable_flight" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_enable_flight', '1') === '1') ? 'checked' : ''; ?>>
                                                    <label for="enable_flight">Ativar motor de voo</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Pacote Dinâmico
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="enable_dynamic_package" name="enable_dynamic_package" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_enable_dynamic_package', '1') === '1') ? 'checked' : ''; ?>>
                                                    <label for="enable_dynamic_package">Ativar motor de pacote dinâmico</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Pacote Aéreo
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="enable_flight_package" name="enable_flight_package" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_enable_flight_package', '1') === '1') ? 'checked' : ''; ?>>
                                                    <label for="enable_flight_package">Ativar motor de pacote aéreo</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Pacote Hotel
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="enable_hotel_package" name="enable_hotel_package" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_enable_hotel_package', '1') === '1') ? 'checked' : ''; ?>>
                                                    <label for="enable_hotel_package">Ativar motor de pacote hotel</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Pacote Rodoviário + Hotel
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="enable_bus_hotel_package" name="enable_bus_hotel_package" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_enable_bus_hotel_package', '1') === '1') ? 'checked' : ''; ?>>
                                                    <label for="enable_bus_hotel_package">Ativar motor de pacote rodoviário + hotel</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="infotravel-url-b2c-hospedagem" width="20%" align="left" scope="row">
                                                Pacote Rodoviário + Serviços
                                            </th>
                                            <td width="5%" />
                                            <td align="left">
                                                <span class="infotravel-url-b2c-hospedagem">
                                                    <input id="enable_bus_services_package" name="enable_bus_services_package" type="checkbox"
                                                        value="1" <?php echo (get_option('b2c_enable_bus_services_package', '1') === '1') ? 'checked' : ''; ?>>
                                                    <label for="enable_bus_services_package">Ativar motor de pacote rodoviário + serviços</label>
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
