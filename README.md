# 介绍

Sylius短信发送模块，目前仅实现了云之讯的短信接口，但你可以轻松的添加其他提供商。

# 功能

1. 通过云之讯发送短信验证码

2. 以短信认证登陆系统


# 安装

```
composer require "pintushi-sms-bundle"

```

# 如何使用？


1. 启用PintushiSMSBundle

2. 在app/config.yml中添加
```
imports:
    - { resource: "@PintushiCoreBundle/Resources/config/app/config.yml" }
```

## 发送短信
1.  在你的Form中添加SMSType
```
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->add('phoneNumber', SMSType::class, [
                'label' => false,
            ])
        ;
    }
```

2. 渲染你的Form表单，在输入手机号码旁边会出现`发送验证码`链接。


Note: 当前，短信接口参数，我是通过SyliusSettingBundle来处理的， 让管理员在后台通过界面配置。你可以使用代码中提供的SmsSettingSchema结合SyliusSettingBundle来实现。这个项目中，我没有提供后台的设置相关代码。


##  以短信认证登陆系统

```
security:
	shop:
	    sms:
		login_path: pintushi_shop_phone_login
		check_path: pintushi_shop_sms_login_check
		failure_path: pintushi_shop_phone_login
		provider: sylius_shop_user_provider
```

添加以下路由

```
pintushi_shop_phone_login:
    path: /sms/login
    methods: [GET]
    defaults:
        _controller: sylius.controller.security:loginAction
        _sylius:
            template: PintushiShopBundle:Security:phoneLogin.html.twig
            form: Pintushi\Bundle\SMSBundle\Form\Type\SMSType

pintushi_shop_sms_login_check:
    path: /sms/login-check
    defaults:
        _controller: sylius.controller.security:checkAction
```


# Todo

1. 以配置的方式配置短信参数

2. 删除SyliusSettingBudle依赖，因为SyliusSettingBundle官方不提供升级了。
