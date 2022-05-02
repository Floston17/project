<?php

namespace App;

class Validation
{
    /**
     * Validates user's name, email, city and password.
     * If validation is not passed, returns array of errors.
     */
    public static function validate(string $name, string $email, string $city, string $password)
    {
        $nameValidation = Validation::validateName($name);
        $emailValidation = Validation::validateEmail($email);
        $cityValidation = Validation::validateCity($city);
        $passwordValidation = Validation::validatePassword($password);

        $errors['nameError'] = !$nameValidation ? 'Name can\'t contain numbers and special characters.' : null;
        $errors['emailError'] = !$emailValidation ? 'Email address is considered invalid.' : null;
        $errors['cityError'] = !$cityValidation ? 'City name can\'t contain numbers and special characters.' : null;
        $errors['passwordError'] = !$passwordValidation ?
            'Password must be at least 8 characters and contain at least one upper case letter, one number and special character.' :
            null;

        if ($nameValidation && $emailValidation && $cityValidation && $passwordValidation) {
            return true;
        } else {
            return $errors;
        }
    }

    /**
     * Validates name.
     */
    public static function validateName($name)
    {
        return (!preg_match('@[0-9]@', $name) && !preg_match('@[^\w]@', $name));
    }

    /**
     * Validates Email.
     */
    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
    }

    /**
     * Validates city name.
     */
    public static function validateCity($city)
    {
        return (!preg_match('@[0-9]@', $city) && !preg_match('@[^\w]@', $city));
    }

    /**
     * Validates password.
     */
    public static function validatePassword($password)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        return ($uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8);
    }
}