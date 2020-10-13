<?php

namespace RT\SymfonyFormAddons\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use RT\SymfonyFormAddons\Serializer\Normalizer\ChoiceViewNormalizer;

/**
 * @author Vladimir Butov
 */
class FormViewNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface {

    use NormalizerAwareTrait;

    public function normalize($object, string $format = null, array $context = []) {

        static $varKeys = [
            'attr',
            'action',
            'block_prefixes',
            'disabled',
            'help',
            'help_attr',
            'help_html',
            'id',
            'label',
            'label_attr',
            'label_html',
            'method',
            'required',
            'row_attr',
            'unique_block_prefix',
            'value',
        ];

        $vars = $object->vars;

        $result = [
            'name' => $vars['full_name'],
        ];

        if (isset($vars['errors'])) {
            $result['errors'] = $this->normalizer->normalize($vars['errors']);
        }

        foreach ($varKeys as $key) {

            if (!empty($vars[$key])) {
                $result[$key] = $vars[$key];
            }
        }

        if (isset($vars['choices'])) {
            $result['choices'] = \array_map(fn($choice) => $this->normalizer->normalize($choice, $format, $context), $vars['choices']);
        }

        foreach ($object->children as $name => $child) {
            $result['children'][$name] = $this->normalizer->normalize($child, $format, $context);
        }

        return $result;
    }

    public function supportsNormalization($data, string $format = null, array $context = []) {

        return $data instanceof FormView;
    }

}
