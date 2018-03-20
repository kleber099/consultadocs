<?php
require_once realpath(dirname(__FILE__) . '/../factory/Conexao.php');

class DocBusiness
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function getDocs()
    {
        $query = "select * from docs";
        $result = pg_query($this->conexao, $query);
        return pg_fetch_all($result);
    }

    function getDadosDocs($data)
    {
        $query = "select * from index inner join docs on docs.id = index.docs_id  where docs_id = $1";
        $dataConsulta[] = $data['docs_id'];

        unset($data['docs_id']);

        $seq = 2;
        $chaves = array_keys($data);
        foreach ( $chaves as $chave) {
            if (isset($data[$chave])) {
                $query .= " and ${chave} ilike \${$seq}";
                $dataConsulta[] = "%{$data[$chave]}%";
                $seq++;
            }
        }

        $result = pg_prepare($this->conexao, "query", $query);
        $result = pg_execute($this->conexao, "query", $dataConsulta);

        return pg_fetch_all($result);
    }

    public function __destruct()
    {
        pg_close($this->conexao);
    }
}