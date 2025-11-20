# Plugin Infotravel Motor para WordPress

## Versão 3.6 - Motor Unificado

Este plugin WordPress fornece integração com os motores de busca do Infotravel para hotéis, voos, pacotes e serviços através de uma interface única e unificada.

## Download

**Última Versão:** [v3.6](https://github.com/ygor-infotera/b2c-motor-wp/releases/tag/v3.6)

**Download Direto:** [Baixar v3.6](https://github.com/ygor-infotera/b2c-motor-wp/archive/refs/tags/v3.6.zip)

## Funcionalidades

### Shortcode do Motor Unificado

O shortcode `[infotravel_motor_unified]` fornece uma interface completa com abas que inclui todos os motores de busca em um só lugar:

- **Busca de Hotel** - Busca de hospedagem
- **Busca de Serviços** - Busca de serviços
- **Busca de Voo** - Busca de passagens aéreas
- **Pacote Dinâmico** - Monte seu próprio pacote
- **Pacote Aéreo** - Pacotes de voo + hotel
- **Pacote Hotel** - Pacotes de hotel
- **Pacote Rodoviário + Hotel** - Pacotes de ônibus + hotel
- **Pacote Rodoviário + Serviços** - Pacotes de ônibus + serviços

### Opções de Configuração

O plugin inclui opções configuráveis para:

- **Carregamento do jQuery** - Carregar jQuery automaticamente
- **Carregamento do jQuery UI** - Carregar jQuery UI automaticamente
- **Carregamento do CSS** - Carregar CSS do motor automaticamente
- **Carregamento das Abas** - Ativar/desativar funcionalidade de abas

## Instalação

1. Faça upload do plugin para o diretório de plugins do WordPress
2. Ative o plugin
3. Configure suas credenciais do Infotravel no painel administrativo
4. Use o shortcode em seus posts ou páginas

## Uso

### Shortcode Único

```php
<?php do_shortcode("[infotravel_motor_unified]"); ?>
```

Ou simplesmente:

```
[infotravel_motor_unified]
```

## Configuração

1. Vá para **Configurações > Infotravel** no seu painel administrativo do WordPress
2. Digite suas credenciais do Infotravel:

   - **Domínio** - Seu domínio B2C do Infotravel
   - **Chave** - Sua chave de API
   - **Empresa** - Seu identificador de empresa

3. Configure a **URL Base do Motor** (padrão: `https://motorv2.infotravel.com.br`)

   - URL base para o motor de busca

4. Configure a **URL Base da API**

   - URL base para as APIs, URL do seu Infotravel

5. Configure as **Opções Avançadas do Motor**:

   - **WhiteLabel** - Ativar white label no motor
   - **Iframe** - Ativar iframe no motor
   - **Target** - Ativar target no motor

6. Configure as **Opções de Carregamento de Dependências**:

   - **Carregar CSS** - Carregar CSS do motor automaticamente
   - **Carregar Abas** - Carregar funcionalidade de abas automaticamente

7. Configure a **Ativação dos Motores** (ativar/desativar motores de busca específicos):

   - **Hotel** - Motor de busca de hotel
   - **Serviços** - Motor de busca de serviços
   - **Voo** - Motor de busca de voo
   - **Pacote Dinâmico** - Construtor de pacotes dinâmicos
   - **Pacote Aéreo** - Pacotes de voo + hotel
   - **Pacote Hotel** - Pacotes de hotel
   - **Pacote Rodoviário + Hotel** - Pacotes de ônibus + hotel
   - **Pacote Rodoviário + Serviços** - Pacotes de ônibus + serviços

8. Salve as alterações

## Requisitos

- WordPress 3.7 ou superior
- PHP 7.0 ou superior
- Conta B2C do Infotravel

## Suporte

Para suporte, entre em contato com a Infotera Tecnologia em suporte@infotera.com.br
