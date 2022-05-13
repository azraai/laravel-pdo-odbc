<?php

namespace LaravelPdoOdbc;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Processors\Processor as Processor;

class ODBCConnection extends Connection
{
    public function getDefaultQueryGrammar()
    {
        $queryGrammar = $this->getConfig('options.grammar.query');
        $queryGrammar = $queryGrammar ? new $queryGrammar() : parent::getDefaultQueryGrammar();
        return $this->withTablePrefix($queryGrammar);
    }

    public function getDefaultSchemaGrammar()
    {
        $schemaGrammar = $this->getConfig('options.grammar.schema');
        $schemaGrammar = $schemaGrammar ? new $schemaGrammar() : parent::getDefaultSchemaGrammar();
        return $this->withTablePrefix($schemaGrammar);
    }

    /**
     * Get current fetch mode from the connection.
     * Default should be: PDO::FETCH_OBJ.
     */
    public function getFetchMode(): int
    {
        return $this->fetchMode;
    }

    /**
     * Get the default post processor instance.
     *
     * @return ODBCProcessor
     */
    protected function getDefaultPostProcessor()
    {
        $processor = $this->getConfig('options.processor');

        if ($processor) {
            return new $processor();
        }

        return new Processor();
    }
}
