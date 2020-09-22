<?php

namespace RT\SymfonyFormAddons\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;

/**
 * @author Vladimir Butov
 */
class FormErrorIteratorNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface {

    use NormalizerAwareTrait;

    public function normalize($object, string $format = null, array $context = []) {

        $result = [];

        foreach ($object as $key => $item) {
            if ($item instanceof self) {
                $result[$key] = $this->normalize($item, $format, $context);
            } else {
                $result[$key] = $this->normalizer->normalize($item, $format, $context);
            }
        }

        return $result;
    }

    public function supportsNormalization($data, string $format = null, array $context = []) {

        return $data instanceof FormErrorIterator;
    }

}
