<?php
namespace alura\mvc\Helper;

trait FlashMessageTrait
{
    private function addErrorMessage(string $errorMessage): void
    {
        $_SESSION['error_message'] = $errorMessage;
    }
    private function addSuccessMessage(string $successMessage): void
    {
        $_SESSION['success_message'] = $successMessage;
    }
}