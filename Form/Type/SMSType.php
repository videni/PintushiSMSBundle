<?php

namespace Pintushi\Bundle\SMSBundle\Form\Type;

use Pintushi\Bundle\SMSBundle\Form\DataTransformer\ArrayToStringTransformer;
use Pintushi\Bundle\SMSBundle\Validator\SMSValidator;
use Pintushi\Bundle\SMSBundle\Verification\PhoneNumberVerificationInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @author Vidy Videni<videni@foxmail.com>
 */
class SMSType extends AbstractType
{
    /**
     * @var PhoneNumberVerificationInterface
     */
    protected $phoneNumberVerification;

    /**
     * @var array
     */
    protected $options;


    public function __construct(PhoneNumberVerificationInterface $phoneNumberVerification,  $options = array())
    {
        $this->phoneNumberVerification=$phoneNumberVerification;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $validator=new SMSValidator($this->phoneNumberVerification);

        $builder
            ->add('phoneNumber', 'text', array(
                'label' => 'pintushi.form.sms.phone_number',
                'mapped' => true,
            ))
            ->add('verificationCode', 'text', array(
                'label' => 'pintushi.form.sms.verification_code',
                'mapped' => false,
                'constraints'=>[
                    new NotBlank(['message'=>'pintushi.sms.verification_code.not_blank'])
                ]
            ))
            ->addEventListener(FormEvents::POST_SUBMIT, array($validator, 'validate'))
            ->addModelTransformer(new ArrayToStringTransformer())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, array(
              'verification_code_route' => $options['verificationCodeRoute'],
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'verificationCodeRoute'=>'pintushi_sms_send_verification_code'
        ]);
    }

    public function getParent()
    {
        return 'form';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sms';
    }
}
