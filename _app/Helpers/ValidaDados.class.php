<?php
/**
 * ValidaCPFCNPJ valida e formata CPF e CNPJ
 *
 * Exemplo de uso:
 * $cpf_cnpj  = new ValidaCPFCNPJ('71569042000196');
 * $formatado = $cpf_cnpj->formata('31738940000106'); 
 * $valida    = $cpf_cnpj->valida('31.738.940/0001-06'); 
 *
 * @package  valida-cpf-cnpj
 * @author   Ivanildo Fereira <contato@mrinformatica.net.br>
 * @version  v1.3
 * @access   public
 * @see      http://www.mrinformatica.net.br
 */
class ValidaDados
{
	/**
	 *
	 
	 *
	 * @param string $valor - O CPF ou CNPJ
	 */
    
    private static $CpfCnpj;

    public static function verifica_cpf_cnpj ($valor) {
		/* Remove caracteres inválidos do CPF ou CNPJ*/
        self::$CpfCnpj = preg_replace( '/[^0-9]/', '', $valor );

		// Verifica quantidade digito CPF
		if (strlen(self::$CpfCnpj) === 11) {
			return 'CPF';
		}
		// Verifica quantidade digito CNPJ
		elseif (strlen(self::$CpfCnpj) === 14 ) {
			return 'CNPJ';
		}
		// Não retorna nada
		else {
			return false;
		}
	}

    /**
	 * Multiplica dígitos vezes posições
	 *
	 * @access protected
	 * @param  string    $digitos      Os digitos desejados
	 * @param  int       $posicoes     A posição que vai iniciar a regressão
	 * @param  int       $soma_digitos A soma das multiplicações entre posições e dígitos
	 * @return int                     Os dígitos enviados concatenados com o último dígito
	 */
	protected static function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
		// Faz a soma dos dígitos com a posição
		// Ex. para 10 posições:
		//   0    2    5    4    6    2    8    8   4
		// x10   x9   x8   x7   x6   x5   x4   x3  x2
		//   0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
		for ( $i = 0; $i < strlen( $digitos ); $i++  ) {
			// Preenche a soma com o dígito vezes a posição
			$soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );

			// Subtrai 1 da posição
			$posicoes--;

			// Parte específica para CNPJ
			// Ex.: 5-4-3-2-9-8-7-6-5-4-3-2
			if ( $posicoes < 2 ) {
				// Retorno a posição para 9
				$posicoes = 9;
			}
		}

		// Captura o resto da divisão entre $soma_digitos dividido por 11
		// Ex.: 196 % 11 = 9
		$soma_digitos = $soma_digitos % 11;

		// Verifica se $soma_digitos é menor que 2
		if ( $soma_digitos < 2 ) {
			// $soma_digitos agora será zero
			$soma_digitos = 0;
		} else {
			// Se for maior que 2, o resultado é 11 menos $soma_digitos
			// Ex.: 11 - 9 = 2
			// Nosso dígito procurado é 2
			$soma_digitos = 11 - $soma_digitos;
		}

		// Concatena mais um dígito aos primeiro nove dígitos
		// Ex.: 025462884 + 2 = 0254628842
		$cpf = $digitos . $soma_digitos;

		// Retorna
		return $cpf;
	}


    	/**
	 * Valida CPF
	 *
	 * @author Ivanildo Ferreira <ivanildo@mrinformatica.net.br>
	 * @access protected
	 * @param  string    $cpf O CPF com ou sem pontos e traço
	 * @return bool      True para CPF correto - False para CPF incorreto
	 */
    protected static function valida_cpf() {
		// Captura os 9 primeiros dígitos do CPF
		// Ex.: 02546288423 = 025462884
		$digitos = substr(self::$CpfCnpj, 0, 9);

		// Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
		$novo_cpf = self::calc_digitos_posicoes($digitos);

		// Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
		$novo_cpf = self::calc_digitos_posicoes( $novo_cpf, 11 );

		// Verifica se o novo CPF gerado é idêntico ao CPF enviado
		if ( $novo_cpf === self::$CpfCnpj ) {
			// CPF válido
			return true;
		} else {
			// CPF inválido
			return false;
		}
	}

    /**
	 * Valida CNPJ
	 *
	 * @author Ivanildo Ferreira <ivanildo@mrinformatica.net.br>
	 * @access protected
	 * @param  string     $cnpj
	 * @return bool             true para CNPJ correto
	 */
	protected static function valida_cnpj() {
		// O valor original
		$cnpj_original = self::$CpfCnpj;

		// Captura os primeiros 12 números do CNPJ
		$primeiros_numeros_cnpj = substr( self::$CpfCnpj, 0, 12 );

		// Faz o primeiro cálculo
		$primeiro_calculo = self::calc_digitos_posicoes( $primeiros_numeros_cnpj, 5 );

		// O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
		$segundo_calculo = self::calc_digitos_posicoes( $primeiro_calculo, 6 );

		// Concatena o segundo dígito ao CNPJ
		$cnpj = $segundo_calculo;

		// Verifica se o CNPJ gerado é idêntico ao enviado
		if ( $cnpj === $cnpj_original ) {
			return true;
		}
	}

    	/**
	 * Valida
	 *
	 * Valida o CPF ou CNPJ
	 *
	 * @access public
	 * @return bool      True para válido, false para inválido
	 */
	public static function valida ($valor) {
		// Valida CPF
		if ( self::verifica_cpf_cnpj($valor) === 'CPF' ) {
			// Retorna true para cpf válido
			return self::valida_cpf() && self::verifica_sequencia(11);
		}
		// Valida CNPJ
		elseif ( self::verifica_cpf_cnpj($valor) === 'CNPJ' ) {
			// Retorna true para CNPJ válido
			return self::valida_cnpj() && self::verifica_sequencia(14);
		}
		// Não retorna nada
		else {
			return false;
		}
	}



    	/**
	 * Formata CPF ou CNPJ
	 *
	 * @access public
	 * @return string  CPF ou CNPJ formatado
	 */
	public static function formata() {
		// O valor formatado
		$formatado = false;

		// Valida CPF
		if ( self::verifica_cpf_cnpj(self::$CpfCnpj) === 'CPF' ) {
			// Verifica se o CPF é válido
			if ( self::valida_cpf() ) {
				// Formata o CPF ###.###.###-##
				$formatado  = substr( self::$CpfCnpj, 0, 3 ) . '.';
				$formatado .= substr( self::$CpfCnpj, 3, 3 ) . '.';
				$formatado .= substr( self::$CpfCnpj, 6, 3 ) . '-';
				$formatado .= substr( self::$CpfCnpj, 9, 2 ) . '';
			}
		}
		// Valida CNPJ
		elseif ( self::verifica_cpf_cnpj(self::$CpfCnpj) === 'CNPJ' ) {
			// Verifica se o CPF é válido
			if ( self::valida_cnpj() ) {
				// Formata o CNPJ ##.###.###/####-##
				$formatado  = substr( self::$CpfCnpj,  0,  2 ) . '.';
				$formatado .= substr( self::$CpfCnpj,  2,  3 ) . '.';
				$formatado .= substr( self::$CpfCnpj,  5,  3 ) . '/';
				$formatado .= substr( self::$CpfCnpj,  8,  4 ) . '-';
				$formatado .= substr( self::$CpfCnpj, 12, 14 ) . '';
			}
		}

		// Retorna o valor
		return $formatado;
	}

    	/**
	 * Método para verifica sequencia de números
	 * @param  integer $multiplos Quantos números devem ser verificados
	 * @return boolean
	 */
	public static function verifica_sequencia($multiplos)
	{
		// cpf
		for($i=0; $i<10; $i++) {
			if (str_repeat($i, $multiplos) == self::$CpfCnpj) {
				return false;
			}
		}

		return true;
	}

}
?>