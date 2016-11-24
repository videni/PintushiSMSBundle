<?php

namespace Pintushi\Bundle\SMSBundle\Controller;

use Huying\Sms\MessageStatus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @author Vidy Videni<videni@foxmail.com>
 */
class SMSController extends FOSRestController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendVerificationCodeAction(Request $request)
    {
        $data = $this->get('pintushi.phone_number_verification')->send($request->get('phone'));

        return new JsonResponse($data, $data['status'] == MessageStatus::STATUS_FAILED ? 400 : 200);
    }
}



