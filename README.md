# mautic-plugin-mtc-js-alt

Plugin para [Mautic](https://www.mautic.org/) 7.x que expõe **uma segunda URL** com o **mesmo conteúdo** de `/mtc.js`, com **nome de arquivo configurável** nas definições de rastreamento.

## Requisitos

- PHP >= 8.2
- Mautic 7.x (`mautic/core-lib` ^7.0)

## Instalação (Composer)

Na raiz do projeto Mautic:

```bash
composer require r-martins/mautic-plugin-mtc-js-alt
php bin/console mautic:plugins:reload
php bin/console cache:clear
```

Em **Configurações → Plugins**, instale/ative **MtcJsAlternate** se necessário.

## Uso

1. Aceda a **Configurações → Configuração → Rastreamento** (Tracking settings).
2. Preencha **Nome alternativo do script de rastreamento** (ex.: `analytics.js`).
3. Guarde. O script ficará disponível em `https://seu-mautic.example.org/analytics.js` (além de `/mtc.js`).

Deixe o campo vazio para desativar a rota extra.

## Licença

GPL-3.0-or-later (alinhado ao Mautic).
