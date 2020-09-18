<?php

namespace RT\SymfonyFormAddons\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

/**
 * @author Vladimir Butov
 */
class FormViewNormalizer implements ContextAwareNormalizerInterface {

    protected function serializeChoice(ChoiceView $choice) {

        return [
            'label' => $choice->label,
            'value' => $choice->value,
            'attr' => $choice->attr,
        ];
    }

    protected function serializeForm(FormView $view) {
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
            'unique_block_prefix'
        ];

        //var_dump(array_keys((array)$view->vars));

        $vars = $view->vars;

        $result = [
            'name' => $vars['full_name'],
        ];

        foreach ($varKeys as $key) {

            if (!empty($vars[$key])) {
                $result[$key] = $vars[$key];
            }
        }

        if (isset($vars['choices'])) {
            $result['choices'] = array_map(fn($choice) => $this->serializeChoice($choice), $vars['choices']);
        }

        if (count($view->children) === 0) {
            return $result;
        }

        $result['children'] = [];
        foreach ($view->children as $name => $child) {
            $result['children'][$name] = $this->serializeForm($child);
        }

        return $result;
    }

    public function normalize($object, string $format = null, array $context = array()) {
        return array_keys((array) $object->children['test']->vars);
        return $this->serializeForm($object);
    }

    public function supportsNormalization($data, $format = null, array $context = array()) {

        return $data instanceof FormView;
    }

}
