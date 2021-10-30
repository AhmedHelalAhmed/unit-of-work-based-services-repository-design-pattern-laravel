<?php

namespace App\DataAccessLayer;

use Illuminate\Support\Facades\DB;

class UnitOfWork
{
    private static $runningTransactions = 0;
    private $inTransaction = false;

    function __destruct()
    {
        // rollback if not committed
        if ($this->inTransaction) {
            $this->rollback();
        }
    }

    /**
     * @throws \Throwable
     */
    protected function rollback()
    {
        if (!$this->inTransaction) {
            return $this;
        }
        // TODO investigate on this
        static::$runningTransactions--;
        $this->inTransaction = false;
        throw_if(!$this->inTransaction, 'Rollback');// to force rollback
        // DB::rollBack();// Illuminate\Contracts\Container\BindingResolutionException

        return $this;
    }

    protected function begin()
    {
        if (static::$runningTransactions > 0) {
            return $this;
        }
        // nothing to do, will not start nested transaction

        $this->inTransaction = true;
        static::$runningTransactions++;
        DB::beginTransaction();

        return $this;
    }

    protected function commit()
    {
        if (!$this->inTransaction) {
            return $this;
        }

        DB::commit();
        $this->inTransaction = false;
        static::$runningTransactions--;

        return $this;
    }
}
