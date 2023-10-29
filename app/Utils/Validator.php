<?php
class Validator
{
  public static function validateUserId($userId): string
  {
      if (empty($userId)) {
          return 'O campo \'userId\' não pode ser vazio, nulo ou inexistente';
      }

      if (! is_int($userId) or $userId < 1) {
          return 'O campo \'userId\' deve ser um número inteiro maior que zero';
      }
      
      return '';
  }

  public static function validateTitle($title): string
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

  public static function validateDescription($description): string
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

  public static function validateStatus($status): string
  {
    if (! is_bool($status)) {
      return 'Tipo inválido para o campo \'status\'/campo vazio ou nulo';
    }

    return '';
  }

  public static function validateCreatedAt($createdAt): string
  {
    if (empty($createdAt)) {
      return 'O campo \'createdAt\' não pode ser vazio, nulo ou inexistente';
    }

    if (! DateTime::createFromFormat('Y-m-d', $createdAt)) {
      return 'Formato de data inválida para o campo \'createdAt\'';
    }

    return '';
  }

  public static function validateUpdatedAt($updatedAt): string
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
