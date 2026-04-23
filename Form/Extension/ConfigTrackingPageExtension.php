<?php

declare(strict_types=1);

namespace MauticPlugin\MtcJsAlternateBundle\Form\Extension;

use Mautic\PageBundle\Form\Type\ConfigTrackingPageType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Adds alternate mtc.js filename to Settings → Configuration → Tracking settings.
 */
class ConfigTrackingPageExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'alternate_mtc_js_filename',
            TextType::class,
            [
                'label'      => 'plugin.mtcjsalt.config.filename',
                'required'   => false,
                'attr'       => [
                    'class'   => 'form-control',
                    'tooltip' => 'plugin.mtcjsalt.config.filename.tooltip',
                ],
                'constraints' => [
                    new Length(max: 191),
                ],
            ]
        );
    }

    public static function getExtendedTypes(): iterable
    {
        return [ConfigTrackingPageType::class];
    }
}
