<?php
/**
 * Validator - Provides methods to validate the fields of the request body
 */
class Validator
{  
  /**
   * validateUserId - Retrieves User ID and performs validations
   *
   * @param  int $userId - The User ID
   * @return string - Returns error string or empty string
   */
  public static function validateUserId(int $userId): string
  {
      if (empty($userId)) {
          return 'O campo \'userId\' não pode ser vazio, nulo ou inexistente';
      }

      if (! is_int($userId) or $userId < 1) {
          return 'O campo \'userId\' deve ser um número inteiro maior que zero';
      }
      
      return '';
  }

  /**
   * validateTitle - Retrieves Prayer Request Title and performs validations
   *
   * @param  int $title - The prayer request title
   * @return string - Returns error string or empty string
   */
  public static function validateTitle(string $title): string
  {
      if (empty($title)) {
          return 'O campo \'title\' não pode ser vazio, nulo ou inexistente';
      }

      if (! is_string($title)) {
          return 'O campo \'title\' deve ser uma string';
      }

      if (strlen($title) > 80) {
          return 'O campo \'title\' não pode ter mais de 80 caracteres';
      }

      return '';
  }
  
  /**
   * validateDescription - Retrieves Prayer Request Description and performs validations
   *
   * @param  string $description - The prayer request description
   * @return string - Returns error string or empty string
   */
  public static function validateDescription(string $description): string
  {
    if (empty($description)) {
      return 'O campo \'description\' não pode ser vazio, nulo ou inexistente';
    }

    elseif (! is_string($description)) {
      return 'Tipo inválido para o campo \'description\'';
    }

    elseif (strlen($description) == 80) {
      return 'Quantidade de caracteres excedida no campo \'description\'';
    }

    return '';
  }
  
  /**
   * validateStatus - Retrieves Prayer Request Status and performs validations
   *
   * @param  string $status - The prayer request status
   * @return string - Returns error string or empty string
   */
  public static function validateStatus(string $status): string
  {
    if (! is_bool($status)) {
      return 'Tipo inválido para o campo \'status\'/campo vazio ou nulo';
    }

    return '';
  }
  
  /**
   * validateCreatedAt - Retrieves Prayer Request CreatedAt and performs validations
   *
   * @param  string $createdAt - The prayer request createdAt
   * @return string - Returns error string or empty string
   */
  public static function validateCreatedAt(string $createdAt): string
  {
    if (empty($createdAt)) {
      return 'O campo \'createdAt\' não pode ser vazio, nulo ou inexistente';
    }

    if (! DateTime::createFromFormat('Y-m-d', $createdAt)) {
      return 'Formato de data inválida para o campo \'createdAt\'';
    }

    return '';
  }

  /**
   * validateUpdateddAt - Retrieves Prayer Request updatedAt and performs validations
   *
   * @param  string $updatedAt - The prayer request updatedAt
   * @return string - Returns error string or empty string
   */
  public static function validateUpdatedAt(string $updatedAt): string
  {
    if (empty($updatedAt)) {
      return 'O campo \'updatedAt\' Não pode ser vazio, nulo ou inexistente';
    }

    if (! DateTime::createFromFormat('Y-m-d', $updatedAt)) {
      return 'Formato de data inválida para o campo \'updatedAt\'';
    }

    return '';
  }
}
