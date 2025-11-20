<?php

/**
 * Exemplo de uso do Plugin Infotravel Motor WordPress
 *
 * Este arquivo demonstra como usar o shortcode unificado do plugin
 */

// Certifique-se de que o plugin está ativo
if (!function_exists('do_shortcode')) {
    echo 'WordPress não está carregado.';
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo - Infotravel Motor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h1 {
            color: #0073aa;
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #0073aa;
            padding-bottom: 10px;
        }

        .shortcode-example {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
            font-family: monospace;
            font-size: 14px;
        }

        .description {
            color: #666;
            margin-bottom: 10px;
        }

        .note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
            color: #856404;
        }
    </style>
</head>

<body>
    <h1>🚀 Infotravel Motor WordPress Plugin - Exemplo de Uso</h1>

    <div class="container">
        <h2>📋 Motor Unificado</h2>
        <div class="description">
            O shortcode unificado carrega todos os motores em uma interface com tabs,
            proporcionando uma experiência mais integrada e profissional.
        </div>
        <div class="shortcode-example">
            [infotravel_motor_unified]
        </div>
        <div class="note">
            <strong>Nota:</strong> Este shortcode inclui automaticamente todos os motores
            (hotel, voo, pacotes, serviços) em uma interface unificada com navegação por tabs.
        </div>

        <!-- Aqui o motor unificado será exibido -->
        <?php echo do_shortcode('[infotravel_motor_unified]'); ?>
    </div>

    <div class="container">
        <h2>⚙️ Configuração</h2>
        <div class="description">
            Antes de usar o shortcode, certifique-se de configurar o plugin no painel administrativo:
        </div>
        <ol>
            <li>Acesse <strong>Configurações > Infotravel</strong> no painel admin</li>
            <li>Configure seu domínio B2C, chave API e empresa</li>
            <li>Defina as opções de carregamento (jQuery, CSS, Tabs)</li>
            <li>Salve as configurações</li>
        </ol>

        <div class="note">
            <strong>Importante:</strong> O plugin requer credenciais válidas do Infotravel
            para funcionar corretamente.
        </div>
    </div>

    <div class="container">
        <h2>📱 Responsividade</h2>
        <div class="description">
            O motor unificado é totalmente responsivo e funciona bem em dispositivos móveis,
            tablets e desktops.
        </div>
    </div>

    <div class="container">
        <h2>🔒 Segurança</h2>
        <div class="description">
            O plugin implementa as melhores práticas de segurança do WordPress:
        </div>
        <ul>
            <li>Sanitização de dados de entrada</li>
            <li>Escape de saída</li>
            <li>Verificação de permissões</li>
            <li>Nonces para formulários</li>
        </ul>
    </div>

    <div class="container">
        <h2>📞 Suporte</h2>
        <div class="description">
            Para suporte técnico ou dúvidas sobre o plugin, entre em contato com:
        </div>
        <p><strong>Infotera Tecnologia</strong><br>
            Email: suporte@infotera.com.br<br>
            Website: <a href="http://www.infotera.com.br" target="_blank">www.infotera.com.br</a></p>
    </div>

    <div class="container">
        <h2>📝 Notas de Versão</h2>
        <div class="description">
            <strong>Versão 3.0:</strong> Motor unificado com interface de tabs, opções configuráveis
            para CSS e funcionalidade de tabs. Versão completamente reescrita para melhor usabilidade.
        </div>
    </div>
</body>

</html>
