<?php

namespace RT\SymfonyFormAddons\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Form\ChoiceView;

/**
 * @author Vladimir Butov
 */
class ChoiceViewNormalizer implements ContextAwareNormalizerInterface {

    public function normalize($object, string $format = null, array $context = []) {

        return [
            'label' => $object->label,
            'value' => $object->value,
            'attr' => $object->attr,
        ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []) {

        return $data instanceof ChoiceView;
    }

}
