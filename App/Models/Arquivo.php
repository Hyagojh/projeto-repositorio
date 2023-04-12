<?php

namespace App\Models;

use MF\Model\Model;

class Arquivo extends Model {

    private $id;
    private $id_usuario;
    private $nome_arquivo;
    private $descricao;
    private $tipo;
    private $tamanho;
    private $conteudo;
    private $data;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function salvar() {

		$query = "insert into arquivos(id_usuario, nome_arquivo, descricao, tipo, tamanho, conteudo)values(:id_usuario, :nome_arquivo, :descricao, :tipo, :tamanho, :conteudo)";
		$stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':nome_arquivo', $this->__get('nome_arquivo'));
		$stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':tipo', $this->__get('tipo'));
        $stmt->bindValue(':tamanho', $this->__get('tamanho'));
		$stmt->bindValue(':conteudo', $this->__get('conteudo'));

        if($stmt->execute()) {

            $nome_arquivo = $this->__get('nome_arquivo');
            
            $diretorio = '..\public\arquivos\\';
            
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0755);
            }
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.'\\'.$nome_arquivo);
        }
	}

    public function pesquisarArquivos($limit, $offset) {

        $query = "select 
                    u.nome, a.id, a.id_usuario, a.nome_arquivo, a.descricao, a.tipo, a.tamanho, data 
                from
                    arquivos as a
                        left join usuarios as u on (a.id_usuario = u.id) 
                where 
                    u.nome like :nome_arquivo
                limit 
                    :limit 
                offset 
                    :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome_arquivo', $this->__get('nome_arquivo'));
        $stmt->bindValue(':limit', $limit, $type = (\PDO::PARAM_INT));
        $stmt->bindValue(':offset', $offset, $type = (\PDO::PARAM_INT));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function contaTodosRegistrosPesquisa() {

        $query = "select 
                    count(*) as total 
                from 
                    arquivos as a
                        left join usuarios as u on (a.id_usuario = u.id)
                where 
                    u.nome like :nome_arquivo";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome_arquivo', $this->__get('nome_arquivo'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }
    
    public function contaTodosRegistros() {

        $query = "select count(*) as total from arquivos";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function listarTodos($limit, $offset) {

        $query = "select 
                    u.nome, a.id, a.id_usuario, a.nome_arquivo, a.descricao, a.tipo, a.tamanho, data 
                from
                    arquivos as a
                        left join usuarios as u on (a.id_usuario = u.id) 
                limit 
                    :limit 
                offset 
                    :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', $limit, $type = (\PDO::PARAM_INT));
        $stmt->bindValue(':offset', $offset, $type = (\PDO::PARAM_INT));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function verArquivo() {
        
        $query = "select nome_arquivo, tipo, conteudo from arquivos where id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();

        $result = $stmt->fetchAll();

        $pasta = '..\public\arquivos\\'.$result[0]['nome_arquivo'];

        if(file_exists($pasta)) {

            header('Content-Type:'.$result[0]['tipo']);
            header('Content-Disposition: inline; filename='.$result[0]['nome_arquivo']);
            header('Content-Transfer-Encoding: binary');
            readfile($pasta);

        }
    }

    public function baixarArquivo() {

        $query = "select nome_arquivo, tipo, tamanho, conteudo from arquivos where id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();

        $retorno = $stmt->fetchAll();

        $pasta = '..\public\arquivos\\'.$retorno[0]['nome_arquivo'];

        if(file_exists($pasta)) {

            header('Content-type:'.$retorno[0]['tipo']);
            header('Content-Disposition: attachment; filename='.$retorno[0]['nome_arquivo']);
            header('Content-Transfer-Encoding: binary');
            readfile($pasta);
        }       

    }    
}

?>