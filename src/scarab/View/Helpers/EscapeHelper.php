<?php declare(strict_types = 1);

namespace Scarab\View\Helpers;

/**
 * HTML特殊文字をHTMLエンティティに変換するビューヘルパー
 */
class EscapeHelper
{
    /**
     * HTML特殊文字をHTMLエンティティに変換するビューヘルパー
     * @param string $value
     * @return string
     */
    public function escape(?string $value): string
    {
        return is_null($value) ? '' : htmlspecialchars($value, ENT_QUOTES | ENT_HTML5);
    }
}
