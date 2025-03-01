<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;

abstract class ControllerWithHtml implements ControllerInterface
{
    private const TEMPLATE_PATH = __DIR__ .'/../../views/';
    protected function renderTemplate(string $templateName, array $context = []): void 
    {
        extract($context);
        require_once self::TEMPLATE_PATH . $templateName . '.php';
    }
}