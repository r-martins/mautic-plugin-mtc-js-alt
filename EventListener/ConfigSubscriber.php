<?php

declare(strict_types=1);

namespace MauticPlugin\MtcJsAlternateBundle\EventListener;

use Mautic\ConfigBundle\ConfigEvents;
use Mautic\ConfigBundle\Event\ConfigBuilderEvent;
use Mautic\ConfigBundle\Event\ConfigEvent;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use MauticPlugin\MtcJsAlternateBundle\Helper\AlternateMtcJsFilenameHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConfigSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private CoreParametersHelper $coreParametersHelper,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConfigEvents::CONFIG_ON_GENERATE => ['onConfigGenerate', -10],
            ConfigEvents::CONFIG_PRE_SAVE    => ['onConfigPreSave', 0],
        ];
    }

    public function onConfigGenerate(ConfigBuilderEvent $event): void
    {
        $forms = $event->getForms();
        if (!isset($forms['trackingconfig']['parameters']) || !is_array($forms['trackingconfig']['parameters'])) {
            return;
        }

        $default = $this->coreParametersHelper->get('alternate_mtc_js_filename');
        if (null === $default) {
            $default = '';
        }

        $forms['trackingconfig']['parameters']['alternate_mtc_js_filename'] = $default;
        // Core template only whitelists known fields; use our copy that also renders alternate_mtc_js_filename.
        $forms['trackingconfig']['formTheme'] = '@MtcJsAlternateBundle/FormTheme/Config/_config_trackingconfig_widget.html.twig';
    }

    public function onConfigPreSave(ConfigEvent $event): void
    {
        $config = $event->getConfig();
        if (empty($config['trackingconfig']) || !is_array($config['trackingconfig'])) {
            return;
        }

        $value = $config['trackingconfig']['alternate_mtc_js_filename'] ?? '';
        $value = is_string($value) ? trim($value) : '';

        $errorKey = AlternateMtcJsFilenameHelper::validate($value);
        if (null !== $errorKey) {
            $event->setError($errorKey, [], 'trackingconfig', 'alternate_mtc_js_filename');

            return;
        }

        $config['trackingconfig']['alternate_mtc_js_filename'] = $value;
        $event->setConfig($config);
    }
}
