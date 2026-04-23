<?php

declare(strict_types=1);

namespace MauticPlugin\MtcJsAlternateBundle\EventListener;

use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Serves the same response as /mtc.js on a configurable path (e.g. /analytics.js).
 */
class AlternateMtcJsRequestSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private CoreParametersHelper $coreParametersHelper,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        // Must run before RouterListener (priority 32) so we can set _controller first.
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 33],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        if ($request->attributes->has('_controller')) {
            return;
        }

        $configured = $this->coreParametersHelper->get('alternate_mtc_js_filename');
        if (!is_string($configured) || '' === trim($configured)) {
            return;
        }

        $filename = trim($configured);
        $path     = $request->getPathInfo();

        if ('/'.$filename !== $path && '/'.$filename.'/' !== $path) {
            return;
        }

        $request->attributes->set('_controller', 'Mautic\CoreBundle\Controller\JsController::indexAction');
    }
}
