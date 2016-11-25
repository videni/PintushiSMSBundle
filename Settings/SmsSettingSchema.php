<?php

namespace Pintushi\Bundle\SMSBundle\Settings;

use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * sms settings schema.
 *
 * @author Vidy Videni <videni@foxmail.com>
 */
class SmsSettingSchema implements SchemaInterface
{
    /**
     * @var array
     */
    protected $defaults;

    /**
     * @param array $defaults
     */
    public function __construct(array $defaults = [])
    {
        $this->defaults = $defaults;
    }

    /**
     * {@inheritdoc}
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults(array_merge([
                'account_id' => '',
                'auth_token' => '',
                'phone_verification_template_id' => '',
                'service_code_template_id' => '',
                'app_id' => '',
            ], $this->defaults))
            ->setAllowedTypes([
                'account_id' => ['string'],
                'auth_token' => ['string'],
                'phone_verification_template_id' => ['string'],
                'service_code_template_id' => ['string'],
                'app_id' => ['string'],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('account_id', 'text', [
                'label' => 'pintushi.form.settings.sms.account_id',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('auth_token', 'text', [
                'label' => 'pintushi.form.settings.sms.auth_token',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('phone_verification_template_id', 'text', [
                'label' => 'pintushi.form.settings.sms.phone_verification_template_id.label',
                'help' => 'pintushi.form.settings.sms.phone_verification_template_id.help',
                'constraints' => [
                    new NotBlank(),
                ],
            ])  ->add('service_code_template_id', 'text', [
                'label' => 'pintushi.form.settings.sms.service_code_template_id.label',
                'help' => 'pintushi.form.settings.sms.service_code_template_id.help',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('app_id', 'text', [
                'label' => 'pintushi.form.settings.sms.app_id',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;
    }
}
