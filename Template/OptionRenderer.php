<?php

namespace DevPandi\Imprint\Template;

// imports
use XF;
use XF\Container;
use XF\Template\Templater;

class OptionRenderer
{
    public static function renderText(Templater $templater, string $text): string
    {
        // basic replacements
        $replacements['cookieHelpUrl'] = $templater->func('link', ['help/cookie']);
        $replacements['imprintHelpUrl'] = $templater->func('link', ['help/imprint']);
        $replacements['privacyHelpUrl'] = XF::app()->container('privacyPolicyUrl');
        $replacements['tosUrl'] = XF::app()->container('tosUrl');
        $replacements['contactUrl'] = XF::app()->container('contactUrl');
        $replacements['boardTitle'] = XF::app()->options['boardTitle'];
        $replacements['boardUrl'] = XF::app()->options['boardUrl'];
        $replacements['cookiePrefix'] = XF::app()->config('cookie')['prefix'];
        $replacements['age'] = XF::app()->options['registrationSetup']['minimumAge'] ?? 13;

        foreach ($replacements as $key => $value) {
            $text = str_replace('{' . $key . '}', $value, $text);
        }

        return $text;
    }

    public static function addToTemplater(Container $container, Templater $templater): void
    {
        $callBack = function (Templater $templater, $value, &$escape) {
            $escape = false;
            return static::renderText($templater, $value);
        };

        $templater->addFilter('dp_render', $callBack);
    }
}
