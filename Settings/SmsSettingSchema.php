<?php

namespace Pintushi\Bundle\SMSBundle\Settings;

use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilder;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
    public function buildSettings(SettingsBuilder $builder)
    {
        $builder
            ->setDefaults(array_merge([
                'account_id' => '',
                'auth_token' => '',
                'phone_verification_template_id' => '',
                'service_code_template_id' => '',
                'app_id' => '',
            ], $this->defaults))
            ->addAllowedTypes('account_id',['string'])
            ->addAllowedTypes('auth_token',['string'])
            ->addAllowedTypes('phone_verification_template_id',['string'])
            ->addAllowedTypes('service_code_template_id',['string'])
            ->addAllowedTypes('app_id',['string'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('account_id', TextType::class, [
                'label' => 'newstar.form.settings.sms.account_id',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('auth_token', TextType::class, [
                'label' => 'newstar.form.settings.sms.auth_token',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('phone_verification_template_id', TextType::class, [
                'label' => 'newstar.form.settings.sms.phone_verification_template_id.label',
                'constraints' => [
                    new NotBlank(),
                ],
            ])  ->add('service_code_template_id', TextType::class, [
                'label' => 'newstar.form.settings.sms.service_code_template_id.label',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('app_id', TextType::class, [
                'label' => 'newstar.form.settings.sms.app_id',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;
    }
}
