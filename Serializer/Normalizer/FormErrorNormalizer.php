<?php

namespace RT\SymfonyFormAddons\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Form\FormError;

/**
 * @author Vladimir Butov
 */
class FormErrorNormalizer implements ContextAwareNormalizerInterface {
    
    public function normalize($object, string $format = null, array $context = []) {

        return $object->getMessage();
    }

    public function supportsNormalization($data, string $format = null, array $context = []) {

        return $data instanceof FormError;
    }

}
